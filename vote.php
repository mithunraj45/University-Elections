<?php
  require("header.php");
  require_once("Database/connection.php");
  connect_db();
  session_start();
  
  if(!isset($_SESSION['vote'])){
    echo "<script>window.location.href='election.php';</script>";
  }



  $election_id=$_REQUEST['reference_no'];
  $student_id=$_REQUEST['temp_no'];

  $date=date("Y-m-d");
  $time=date("H:i:s");

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

  if(isset($_POST['vote'])){
    $password=md5($_POST['pass']);
    $contestent=$_POST['vote_select'];

    $statement = $con->prepare("SELECT * FROM student_info WHERE register_no=? AND password=? ");
    $statement->execute(array($result_student['register_no'],$password));
    $total=$statement->rowCount();

    if($total==0){
        echo "<script>alert('".$password."Entered password does not matches with registered');</script>";
    }else{

        $statement = $con->prepare("SELECT * FROM voted_students_info WHERE election_id=? AND student_register_no=? ");
        $statement->execute(array($result_election['election_id'],$result_student['register_no']));
        $total=$statement->rowCount();

        if($total==0){

            $statement = $con->prepare(" INSERT INTO voted_students_info(election_id,student_register_no,contestent_id,date,time) VALUES(?,?,?,?,?)  ");
            $statement->execute(array($result_election['election_id'],$result_student['register_no'],$contestent,$date,$time));
            
            
            $statement = $con->prepare("SELECT * FROM contesten_election_info WHERE election_id=? AND contesten_reg_no=?"); 
            $statement->execute(array($result_election['election_id'],$contestent));
            $vote = $statement->fetch(PDO::FETCH_ASSOC);

            $no_of_votes=(int)$vote['no_of_votes'] + 1;

            $statement = $con->prepare("UPDATE contesten_election_info SET no_of_votes=? WHERE election_id=? AND contesten_reg_no=?"); 
            $statement->execute(array($no_of_votes,$result_election['election_id'],$contestent));

            echo "<script>alert('Your Vote has been casted . . . ');window.location.href='election.php';</script>";
            unset($_SESSION['contest']);


        }else{
            echo "<script>alert('Hello ".$result_student['fname'].", you have been already voted.You can not vote agagin ');window.location.href='election.php';</script>";
            unset($_SESSION['contest']);

        }

    }
  }

?>



    <div class="container-fluid position-relative overflow-hidden mt-md-3 ">
          <h3 class="text-center mb-md-3" style="color:green;"><<<<< <?php echo $result_election['election_name']; ?> >>>>></h3>
            
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
    </div>
    
    <div class="container-fluid my-md-5">
        <div class="row">
            <div class="col-lg-7">
                    <table class="table table-bordered table-hover table-fixed">
                        <thead  style="background-color:rgb(48,60,84);color:white;" >
                        <tr>							
                            <th width="100px">SL.No</th>
                            <th width="150px">Contestent Color</th>
                            <th width="300px">Contestent Name</th>
                            <th width="250px">Degree | Branch |Year </th>
                        </tr>
                        </thead>    
                        <tbody>
                            <?php 
                                $statement = $con->prepare("SELECT * FROM contesten_election_info WHERE election_id=? ");
                                $statement->execute(array($result_election['election_id']));
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                $i=1;
                                foreach ($result as $row) {

                                    $statement = $con->prepare("SELECT * FROM color_info WHERE color_id=? ");
                                    $statement->execute(array($row['contestent_color']));
                                    $result_color = $statement->fetch(PDO::FETCH_ASSOC);

                                    $statement = $con->prepare("SELECT * FROM student_info WHERE register_no=? ");
                                    $statement->execute(array($row['contesten_reg_no']));
                                    $result_name = $statement->fetch(PDO::FETCH_ASSOC);

                                    $statement = $con->prepare("SELECT * FROM degree_info WHERE degree_id=? ");
                                    $statement->execute(array($result_name['degree_id']));
                                    $row_name_degree = $statement->fetch(PDO::FETCH_ASSOC);
                                
                                    $statement = $con->prepare("SELECT * FROM branch_info WHERE branch_id=? ");
                                    $statement->execute(array($result_name['branch_id']));
                                    $row_name_branch = $statement->fetch(PDO::FETCH_ASSOC);
                            ?>

                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td align="center"><div style="margin-top:10px;width:50px;height:50px;background:<?php echo $result_color['color_name']; ?>;border-radius:50%;"></div></td>
                                    <td><?php echo $result_name['fname']; ?></td>
                                    <td><?php echo $row_name_degree['degree_name']." | ".$row_name_branch['branch_name']." | ".$result_name['year'];?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
            </div>
            <div class="col-md">
                <h3 class="text-center my-md-3 mx-md-0" style="color:green;"> Vote Now  . . . </h3>
                    <form action="" method="post">
                        <select name="vote_select" required>
                            <option value="">Select the Contestent</option>
                                <?php 
                                    $statement = $con->prepare("SELECT * FROM contesten_election_info WHERE election_id=? ");
                                    $statement->execute(array($result_election['election_id']));
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {

                                        $statement = $con->prepare("SELECT * FROM student_info WHERE register_no=? ");
                                        $statement->execute(array($row['contesten_reg_no']));
                                        $result_name = $statement->fetch(PDO::FETCH_ASSOC);

                                        $statement = $con->prepare("SELECT * FROM color_info WHERE color_id=? ");
                                        $statement->execute(array($row['contestent_color']));
                                        $res_color = $statement->fetch(PDO::FETCH_ASSOC);

                                ?>
                                <option value="<?php echo $result_name['register_no']; ?>"><?php echo $result_name['fname']." | ".strtoupper($res_color['color_name']); ?></option>
                                <?php } ?>
                        </select>
                        <input type="password" name="pass" palceholder="Enter the password . . ." required>
                        <input type="submit" class="btn btn-primary" name="vote" value="Vote">
                    </form>
            </div>
        </div>
    </div>
    
<?php 
  require("footer.php"); 
?>