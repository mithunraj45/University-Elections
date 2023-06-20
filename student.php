<?php
  require("header.php");
  require_once("Database/connection.php");
  connect_db();
  session_start();

  $student=$_SESSION['user'];

  $statement = $con->prepare("SELECT * FROM degree_info WHERE degree_id=? ");
  $statement->execute(array($student['degree_id']));
  $row_degree = $statement->fetch(PDO::FETCH_ASSOC);

  $statement = $con->prepare("SELECT * FROM branch_info WHERE branch_id=? ");
  $statement->execute(array($student['branch_id']));
  $row_branch = $statement->fetch(PDO::FETCH_ASSOC);

  if(isset($_POST['submit_image'])){

    
    $file_name = $student['fname']."_".$_FILES['image']['name'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $destination="Images/Profile/".$file_name;

    move_uploaded_file($file_tmp,$destination);

    $statement = $con->prepare("UPDATE student_info SET image=? WHERE register_no=? ");
    $statement->execute(array($file_name,$student['register_no']));

    echo "<script> alert('Profile Image has been updated please login again. . . ');window.location.href='login.php';</script>";

  }

  if(isset($_POST['submit_info'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $mobile=$_POST['mobile'];
    $address=$_POST['address'];

    $statement = $con->prepare("UPDATE student_info SET fname=?,email=?,mobile_no=?,address=? WHERE register_no=? ");
    $statement->execute(array($name,$email,$mobile,$address,$student['register_no']));

    echo "<script> alert('Information has been updated please login again. . . ');window.location.href='login.php';</script>";
  }

  if(isset($_POST['submit_pass'])){
    $old=$_POST['old_pass'];
    $new=$_POST['new_pass'];
    $renew=$_POST['renew_pass'];

    if($old!=$new){
      if($student['password']==md5($old)){
        if($new==$renew){
  
          $statement = $con->prepare("UPDATE student_info SET password=? WHERE register_no=? ");
          $statement->execute(array(md5($new),$student['register_no']));

          echo "<script> alert('Password has been updated please login again. . . ');window.location.href='login.php';</script>";

      
        }else{
          echo "<script> alert('New password and re-entered password does not matches. . . ');</script>";
        }
      }else{
        echo "<script> alert('Entered password does not matches with registered. . . ');</script>";
      }
    }else{
      echo "<script> alert('Old password and New password should be different . . . ');</script>";
    }


  }

?>

<style rel="text/stylesheet">

.pass_show{position: relative} 

.pass_show .ptxt { 

position: absolute; 

top: 50%; 

right: 10px; 

z-index: 1; 

color: #f36c01; 

margin-top: -10px; 

cursor: pointer; 

transition: .3s ease all; 

} 

.pass_show .ptxt:hover{color: #333333;} 

</style>

<section style="background-color: #eee;">
  <div class="container py-5">

  <form action="" method="post" enctype="multipart/form-data">
    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <img src="Images/Profile/<?php echo $student['image']; ?>" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
            <h5 class="my-3"><?php echo $student['fname']." ".$student['lname']; ?></h5>
            <p class="text-muted mb-1"><?php echo $row_degree['degree_name']." | ".$row_branch['branch_name']." | ".$student['year']." Year"; ?></p>
            <div class="d-flex justify-content-center mb-2">
              <input type="file" class="ml-sm-3" name="image" accept="image/png, image/jgp, image/jpeg">
            </div>
            <div class="d-flex justify-content-center mb-2">
              <button type="submit" class="btn btn-outline-success ms-1" name="submit_image">Update</button>
            </div>
          </div>
        </div>
      </div>    

      <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Full Name :</p>
                    </div>
                    <div class="col-sm-9">
                        <input type="text" name="name" class="text-muted mb-0" value="<?php echo $student['fname']; ?>" style="background:transparent;border:none;">
                    </div>
                    </div>
                    <hr>
                    <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Email :</p>
                    </div>
                    <div class="col-sm-9">
                        <input type="email" name="email" class="text-muted mb-0"value="<?php echo $student['email']; ?>" style="background:transparent;border:none;">
                    </div>
                    </div>
                    <hr>
                    <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Mobile No :</p>
                    </div>
                    <div class="col-sm-9">
                        <input type="number" name="mobile" class="text-muted mb-0" value="<?php echo $student['mobile_no']; ?>" style="background:transparent;border:none;">
                    </div>
                    </div>
                    <hr>
                    <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Address :</p>
                    </div>
                    <div class="col-sm-9">
                        <input  type="text" name="address" class="text-muted mb-0" value="<?php echo $student['address'];?>" style="background:transparent;border:none;">
                    </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <button type="submit" name="submit_info" class="btn btn-success">Update</button>
                            <a href="logout.php" class=" btn btn-primary" style="margin-top:-65px;margin-left:100px;">Log out</a>
                        </div>
                    </div>
                </div>
            </div>
      </div>

    </div>
  </form>

  <form action="" method="post">
    <div class="row">
        <div class="col-lg-4">

        </div>    

        <div class="col-lg-8">
              <div class="card mb-4">
                  <div class="card-body">
                      <p>Change Password</p>
                      <div class="container">
                          <div class="row">
                            <div class="col-lg-8">
                                
                                <label>Current Password</label>
                                <div class="form-group pass_show w-100"> 
                                        <input type="password" name="old_pass" class="form-control" placeholder="Current Password"> 
                                    </div> 
                                  <label>New Password</label>
                                    <div class="form-group pass_show"> 
                                        <input type="password" name="new_pass" class="form-control" placeholder="New Password"> 
                                    </div> 
                                  <label>Confirm Password</label>
                                    <div class="form-group pass_show"> 
                                        <input type="password" name="renew_pass" class="form-control" placeholder="Confirm New Password"> 
                                    </div> 

                                    <button type="submit" name="submit_pass" class="btn btn-success">Update</button>
                                    
                            </div>  
                          </div>
                        </div>
                  </div>
              </div>
        </div>

      </div>
    </form>


  </div>
</section>

<?php require("footer.php"); ?>

<script type="text/javascript">
    
$(document).ready(function(){
$('.pass_show').append('<span class="ptxt">Show</span>');  
});
  

$(document).on('click','.pass_show .ptxt', function(){ 

$(this).text($(this).text() == "Show" ? "Hide" : "Show"); 

$(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; }); 

});  

</script>