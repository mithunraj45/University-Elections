<?php
  require("header.php");
  require_once("Database/connection.php");
  connect_db();
  session_start();

  if(!isset($_SESSION['contest'])){
    header("location:election.php");
  }


  $election_id=$_REQUEST['reference_no'];
  $student_id=$_REQUEST['temp_no'];

  $statement = $con->prepare("SELECT * FROM  election_info ");
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
        if($election_id==md5($row['election_id'])){
            $result_election=$row;
        }
  }

  $statement = $con->prepare("SELECT * FROM  student_info ");
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
        if($student_id==md5($row['register_no'])){
            $result_student=$row;
        }
  }

  $statement = $con->prepare("SELECT * FROM degree_info WHERE degree_id=? ");
  $statement->execute(array($result_election['degree_id']));
  $row_degree = $statement->fetch(PDO::FETCH_ASSOC);

  $statement = $con->prepare("SELECT * FROM branch_info WHERE branch_id=? ");
  $statement->execute(array($result_election['branch_id']));
  $row_branch = $statement->fetch(PDO::FETCH_ASSOC);

  if(isset($_POST['submit'])){
    if(empty($_POST['color'])){
      $color=9999;
    }else{
      $color=$_POST['color'];
    }
    $password=md5($_POST['password']);




    $statement = $con->prepare("SELECT * FROM contesten_election_info WHERE election_id=? AND contesten_reg_no=?");
    $statement->execute(array($result_election['election_id'],$result_student['register_no']));
    $total=$statement->rowCount();

    if($total==0){

      if($password==$result_student['password']){
        $statement = $con->prepare("INSERT INTO contesten_election_info(election_id,contesten_reg_no,contestent_color) VALUES (?,?,?)");
        $statement->execute(array($result_election['election_id'],$result_student['register_no'],$color));
  
        if($result_election['voting']==1){
          $temp="Elections";
        }else{
          $temp="Voluteers";
        }
        echo "<script>alert('Hello ".$result_student['fname'].", you will be contesting for ".$result_election['election_name']." ".$temp." ALL THE BEST . . . ');window.location.href='election.php';</script>";
        unset($_SESSION['contest']);

      }else{
        echo "<script>alert('Entered Password does not matches . . .')</script>";
      }


    }else{
      echo "<script>alert('Hello ".$result_student['fname'].", You are already being contested for ".$result_election['election_name']." Election ');window.location.href='election.php';</script>";

    }
    

  }

?>

<style type="text/css">
    .contest {
            display:none;
    }
</style>

<div class="container-fluid position-relative overflow-hidden mt-md-3 ">
        <form action="" method="post">
          <h3 class="text-center mb-md-3" style="color:green;"><<<<< <?php echo $result_election['election_name']; if($result_election['voting']==0) echo " Volunteers"; else echo " Elections"; ?> >>>>></h3>
            
            <div class="row">
              <div class="col-md-6 text-right ">
                <p class="h4">Roles and Responsibilty : </p>
              </div>
              <div class="col-md text-left">
                <p class="h4"><?php echo $result_election['election_roles_responsibility']; ?></p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 text-right ">
                <p class="h4">Elligible Degree | Branch | Year : </p>
              </div>
              <div class="col-md text-left">
                <p class="h4"><?php echo $row_degree['degree_name']." | ".$row_branch['branch_name']." | ".$result_election['eligible_year']; ?></p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 text-right ">
                <p class="h4">Registration Date :</p>
              </div>
              <div class="col-md text-left">
                <p class="h4"><?php echo $result_election['start_registration_date']." to ".$result_election['end_registration_date']."(".$result_election['end_registration_time'].")"; ?></p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 text-right ">
                <p class="h4">Election Date : </p>
              </div>
              <div class="col-md text-left">
                <p class="h4"><?php echo $result_election['election_date']; ?></p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 text-right ">
                <p class="h4">Timings :</p>
              </div>
              <div class="col-md text-left">
                <p class="h4"><?php echo $result_election['election_start_time']." to ".$result_election['election_end_time']; ?></p>
              </div>
            </div>

            <div class="text-center mb-md-3">
                  <div class="form-check form-switch">
                    <input class="form-check-input-lg" name="interest" type="checkbox" onchange="showhidden(this)" required>
                    <label class="form-check-label h4" style="color:red;" for="flexSwitchCheckDefault">Would you like to contest . . . </label>
                  </div>
            <div>

            <div class="contest text-center my-md-3" id="show">
                <?php if($result_election['voting']==1){ ?>
                  <select name="color" style="border-radius:20px 20px 20px 20px;border:2px solid black;color:black;" required>
                    <option value="">Select any one of the color</option>
                      <?php 


                            $statement = $con->prepare("SELECT * FROM color_info WHERE color_id NOT IN (SELECT contestent_color FROM contesten_election_info WHERE election_id=?)");
                            $statement->execute(array($result_election['election_id']));
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach($result as $row){
                      ?>
                    <option value="<?php echo $row['color_id']; ?>"><?php echo strtoupper($row['color_name']); ?></option>
                      <?php } ?>
                  </select>
                <?php } ?>

                  <div class="text-center mt-md-3"  id="show">
                        <input type="password" class="px-md-3" style="border-radius:20px 20px 20px;" name="password" placeholder="Enter the password . . ." required>
                  </div>
                
                  <div class="text-center mt-md-3" id="show">
                      <input class="btn btn-success" name="submit" type="submit" id="flexSwitchCheckDefault">
                  </div>
              
            </div>



        </form>
</div>

<script type="text/javascript">

function showhidden(answer) {
        console.log(answer.value);
        if(answer.value == "on"){
            document.getElementById('show').classList.remove('contest');
        }else{
            document.getElementById('show').classList.add('contest');
        }
    };

</script>


<?php 
  require("footer.php"); 
?>