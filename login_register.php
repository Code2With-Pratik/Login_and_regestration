<?php 
  
  require('connection.php');

  if(isset($_POST['register']))
  {
    $user_exist_query = "SELECT * FROM `registered_users` WHERE `username`='$_POST[username]' OR `email`='$$_POST[email]'";
    $result = mysqli_query($con,$user_exist_query);

    if($result)
    {

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