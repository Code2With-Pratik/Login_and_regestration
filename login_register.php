<?php 
  
  require('connection.php');

  if(isset($_POST['register']))
  {
    $user_exist_query = "SELECT * FROM `registered_users` WHERE `username`='$_POST[username]' OR `email`='$$_POST[email]'";
    $result = mysqli_query($con,$user_exist_query);

    if($result)
    {
      if(mysqli_num_rows($result)>0)
      {
        $result_fetch=mysqli_fetch_assoc($result);
        if($result_fetch['username']==$_POST['username'])
        {
            # username is already regesterd
          echo"
            <script>
                alert('$result_fetch[username] - Username already taken');
                window.location.href='index.php';
            </script>
          "; 
        }
      }
      else
      {
        # error for email is  already registered
        echo"
            <script>
                alert('$result_fetch[email] - E-mail already registered');
                window.location.href='index.php';
            </script>
        ";
      }
      else
      {

      }
    }
    else
    {
      echo"
        <script>
            alert('Cannot Run Query');
            window.location.href='index.php';
        </script>
      ";
    }
  }

?>