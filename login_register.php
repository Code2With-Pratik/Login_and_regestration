<?php 
require('connection.php');
session_start();

# this is the section for login
if(isset($_POST['login']))
{
    $query = "SELECT * FROM `registered_users` WHERE `email`='$_POST[email_username]' OR `username`='$_POST[email_username]'";
    $result = mysqli_query($con,$query);

    if($result)
    {
      if(mysqli_num_rows($result)==1)
      {
         $result_fetch = mysqli_fetch_assoc($result);
         if(password_verify($_POST['password'],$result_fetch['password']))
         {
            #if password matched
           $_SESSION['logged_in']=true;
           $_SESSION['username']=$result_fetch['username'];
           header("location: index.php");
         }
         else
         {
            #if incorrect password
            echo "
                <script>
                    alert('Incorrect Password.');
                    window.location.href = 'index.php';
                </script>
            ";
         }
      }
      else
      {
        echo "
            <script>
                alert('Email or Username is not registered.');
                window.location.href = 'index.php';
            </script>
        ";
      }
    }
    else
    {
        echo "
            <script>
                alert('Failed to register. Please try again later.');
                window.location.href = 'index.php';
            </script>
        ";
    }
}

# this is the section for registration
if (isset($_POST['register'])) {
    // Sanitize user inputs to prevent SQL injection and other issues
    $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Check if the username or email already exists
    $user_exist_query = "SELECT * FROM `registered_users` WHERE `username` = '$username' OR `email` = '$email'";
    $result = mysqli_query($con, $user_exist_query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $result_fetch = mysqli_fetch_assoc($result);

            if ($result_fetch['username'] == $username) {
                // Username is already registered
                echo "
                    <script>
                        alert('Username \"$username\" is already taken.');
                        window.location.href = 'index.php';
                    </script>
                ";
            } elseif ($result_fetch['email'] == $email) {
                // Email is already registered
                echo "
                    <script>
                        alert('Email \"$email\" is already registered.');
                        window.location.href = 'index.php';
                    </script>
                ";
            }
        } else {
            // Hash the password for secure storage
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert user data into the database
            $query = "INSERT INTO `registered_users`(`full_name`, `username`, `email`, `password`) 
                      VALUES ('$fullname', '$username', '$email', '$hashed_password')";
            if (mysqli_query($con, $query)) {
                echo "
                    <script>
                        alert('Registration successful!');
                        window.location.href = 'index.php';
                    </script>
                ";
            } else {
                echo "
                    <script>
                        alert('Failed to register. Please try again later.');
                        window.location.href = 'index.php';
                    </script>
                ";
            }
        }
    } else {
        echo "
            <script>
                alert('Failed to execute query. Please try again later.');
                window.location.href = 'index.php';
            </script>
        ";
    }
}

?>
