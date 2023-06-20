<?php
  require("header.php");
  require_once("Database/connection.php");
  connect_db();
  session_start();

  if(!isset($_SESSION['result'])){
    header("location:election.php");
  }


  date_default_timezone_set('Asia/Kolkata');

  $today=date("Y-m-d");
  $time=date("H:i:s");

  $election_id=$_REQUEST['reference_no'];

  $statement = $con->prepare("SELECT * FROM  election_info ");
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
        if($election_id==md5($row['election_id'])){
            $result_election=$row;
        }
  }

  $statement = $con->prepare(" SELECT * FROM contesten_election_info WHERE election_id=? AND no_of_votes = (SELECT MAX(no_of_votes) FROM contesten_election_info WHERE election_id=?) ");
  $statement->execute(array($result_election['election_id'],$result_election['election_id']));
  $result = $statement->fetch(PDO::FETCH_ASSOC);

  $statement = $con->prepare("SELECT * FROM election_results WHERE election_id=? ");
  $statement->execute(array($result_election['election_id']));
  $total = $statement->rowCount();

  if($total == 0){
    $statement = $con->prepare("INSERT INTO election_results(election_id,winning_reg_no) VALUES(?,?)");
    $statement->execute(array($result_election['election_id'],$result['contesten_reg_no']));    
  }

  $statement = $con->prepare("SELECT * FROM degree_info WHERE degree_id=? ");
  $statement->execute(array($result_election['degree_id']));
  $row_degree = $statement->fetch(PDO::FETCH_ASSOC);

  $statement = $con->prepare("SELECT * FROM branch_info WHERE branch_id=? ");
  $statement->execute(array($result_election['branch_id']));
  $row_branch = $statement->fetch(PDO::FETCH_ASSOC);

  if($result_election['eligible_year']==9999){
    $year="All Years";
  }else{
    $year=$result_election['eligible_year'];


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
                <p class="h4"><?php echo $row_degree['degree_name']." | ".$row_branch['branch_name']." | ".$year; ?></p>
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
    <table class="table table-bordered table-hover table-fixed">
                        <thead  style="background-color:rgb(48,60,84);color:white;" >
                        <tr align="center">							
                            <th width="100px">SL.No</th>
                            <th width="150px">Contestent Color</th>
                            <th width="150px">Contestent Name</th>
                            <th width="250px">Degree | Branch |Year </th>
                            <th width="100px">No of Votes</th>
                        </tr>
                        </thead>    
                        <tbody>
                            <?php 
                                $statement = $con->prepare("SELECT * FROM contesten_election_info WHERE election_id=? ORDER BY no_of_votes DESC ");
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

                                <tr style="background:<?php if($i==1) echo "lightgreen"; ?>">
                                    <td><?php echo $i++; ?></td>
                                    <td align="center"><div style="margin-top:10px;width:50px;height:50px;background:<?php echo $result_color['color_name']; ?>;border-radius:50%;"></div></td>
                                    <td><?php echo $result_name['fname']; ?></td>
                                    <td><?php echo $row_name_degree['degree_name']." | ".$row_name_branch['branch_name']." | ".$result_name['year'];?></td>
                                    <td><?php echo $row['no_of_votes']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
    </div>


<?php 
  require("footer.php"); 
  unset($_SESSION['result']);
  
?>