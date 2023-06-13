<?php
  require("header.php");
  require_once("Database/connection.php");
  connect_db();

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

?>

        <form action="" method="post">
          <h3><<<<< <?php echo $result_election['election_name']; ?> >>>>></h3>
          <p>
            Roles and Responsibilty : <?php echo $result_election['election_roles_responsibility']; ?><br>
            Elligible Degree | Branch | Year : <?php echo $row_degree['degree_name']." | ".$row_branch['branch_name']." | ".$result_election['eligible_year']; ?><br>
            Registration Date : <?php echo $result_election['start_registration_date']." to ".$result_election['end_registration_date']."(".$result_election['end_registration_time'].")"; ?><br>
            Election Date : <?php echo $result_election['election_date']; ?><br>
            Timings : <?php echo $result_election['election_start_time']." to ".$result_election['election_end_time']; ?><br>
            <input type="checkbox" name="cache" required>Would you like to participate . . . <br>
            <input type="color" name="color"><br>
            <input type="submit" name="submit" value="Contest">
          </p>
        </form>


<?php
  require("footer.php");
 
 ?>