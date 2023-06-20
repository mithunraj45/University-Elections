<?php 
  require_once("header.php");
  require_once("../Database/connection.php");
  connect_db();

  $error_message="";
  $success_message="";

  $email_id = $_SESSION['user']['admin_email'];


  if(isset($_POST['update_pass'])){

    $email = $_POST['email'];
    $current = $_POST['current_pass'];
    $new = $_POST['new_pass'];
    $reenter = $_POST['reenter_pass'];

    $statement = $con->prepare("SELECT * FROM login_info WHERE admin_email = ? ");
    $statement->execute(array($email));
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $db_pass = $result['admin_password'];


    $modified_current  = md5($current);

    if($modified_current == $db_pass){

        if($modified_current!=md5($new)){
            if($new == $reenter){
                $modified_new = md5($new);
                $statement = $con->prepare("UPDATE login_info SET admin_password = ? WHERE admin_email = ? ");
                $statement->execute(array($modified_new,$email));
    
                echo "<script>alert('Password has been updated...');</script>";
            }else{
               echo "<script>alert('New Password And Re-entered Password does not matches...');</script> ";
            }
        }else{
            echo "<script>alert('New Password And Old Password should  not be same ...');</script> ";
        }

    }else{
        echo "<script>alert('Password does not match with database');</script>";
    }

  }


  ?>

        <div class="container-fluid">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
              <li class="breadcrumb-item">
                <!-- if breadcrumb is single--><a class="nav-link" href="index.php"><span>Home</span></a>
              </li>
              <li class="breadcrumb-item active"><span>Change Password</span></li>
            </ol>
          </nav>
        </div>
    </header>

    <section class="add-form" style="margin-left:20px;background-color:white;">
        <div class="form-elements" style="margin-left:20px;margin-top:20px;"> 
            <form action="" method="post" enctype="multipart/form-data">


                <div class="each-input-element">
                    <label> Email ID :</label>
                    <div style="margin-top:-2.5%;margin-left:20%;">
                        <input type="text" name="email" value="<?php echo $email_id; ?>" readonly>
                    </div>    
                </div>      

                <br><br>

                <div class="each-input-element">
                    <label> Current Password :</label>
                    <div style="margin-top:-2.5%;margin-left:20%;">
                        <input type="text" name="current_pass" placeholder="Enter the store phone no....">
                    </div>    
                </div>

                <br><br>

                <div class="each-input-element">
                <label> New Password :</label>
                    <div style="margin-top:-2.5%;margin-left:20%;">
                        <input type="password" name="new_pass" placeholder="Enter the store phone no....">
                    </div>
                </div>

                <br><br>

                <div class="each-input-element">
                    <label>Re-enter New Password :</label>
                    <div style="margin-top:-2.5%;margin-left:20%;">
                        <input type="password" name="reenter_pass" placeholder="Enter the store phone no....">
                    </div>
                </div>

                <br><br>

                <button type="submit" class="mb-md-5 btn btn-success" value="<?php echo $email_id; ?>" name="update_pass" style="padding:10px 10px;border-radius:10px;" class="btn btn-success pull-left" >UPDATE</button>



            
            </form>

        </div>

    </section>

    <?php if ($error_message) : ?>
                <div class="callout callout-danger">

                    <p>
                    <?php echo $error_message; ?>
                    </p>
                </div>
                <?php endif; ?>

                <?php if ($success_message) : ?>
                <div class="callout callout-success">

                    <p><?php echo $success_message; ?></p>
                </div>
                <?php endif; ?>


</div>
<?php require_once("footer.php");?>