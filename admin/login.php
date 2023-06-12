<?php
  require_once("../Database/connection.php");
  connect_db();
  $error_message='';
  session_start(); 

  if(isset($_POST['form'])) {
        
      if(empty($_POST['email']) || empty($_POST['password'])) {
          $error_message = 'Email and/or Password can not be empty<br>';
      } else {
    
        $email = strip_tags($_POST['email']);
        $password = strip_tags($_POST['password']);
      
        $statement = $con->prepare("SELECT * FROM  login_info WHERE admin_email=? AND admin_status=?");
        $statement->execute(array($email,1));
        $total = $statement->rowCount();    
          $result = $statement->fetch(PDO::FETCH_ASSOC);    
          if($total==0) {
              $error_message .= 'Email Address does not match<br>';
          } else {       
                
              $row_password = $result['admin_password'];
          
              if( $row_password != md5($password) ) {
                  $error_message .= 'Password does not match<br>';
              } else {       
              
                $_SESSION['user'] = $result;

                  header("location: index.php");

              }
            }
        }
    }

?>


<html>

<head>
  <link rel="stylesheet" href="../css/style_login.css">
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
  <title>Log in</title>
</head>

<body>
  <div class="main">
    <p class="sign" align="center">Log in</p>
    <form class="form1" action="login.php" method="POST">
      <input class="un" name="email" type="text" align="center" placeholder="Username">
      <input class="pass" type="password" name="password" align="center" placeholder="Password">
      <input type="submit" class="submit" name="form" align="center" value="Submit">
      <p style="color:red;margin-left:15%;"><?php  if( (isset($error_message)) && ($error_message!='') ) echo $error_message;?></p>
            
                
    </div>
     
</body>

</html>