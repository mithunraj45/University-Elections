<?php 
  require_once("header.php");
  require_once("../Database/connection.php");
  connect_db();

  $ref_id=$_REQUEST['reference_no'];

  $statement = $con->prepare("SELECT * FROM  election_info ");
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  $election_id="";
  foreach ($result as $row) {
        if($ref_id==md5($row['election_id'])){
            $result_election=$row;
        }
  }

  $statement = $con->prepare("SELECT * FROM degree_info WHERE degree_id=? ");
  $statement->execute(array($result_election['degree_id']));
  $row_degree = $statement->fetch(PDO::FETCH_ASSOC);

  $statement = $con->prepare("SELECT * FROM branch_info WHERE branch_id=? ");
  $statement->execute(array($result_election['branch_id']));
  $row_branch = $statement->fetch(PDO::FETCH_ASSOC);

?>

        <div class="container-fluid">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
              <li class="breadcrumb-item">
                <!-- if breadcrumb is single--><a class="nav-link" href="index.php"><span>Home</span></a>
              </li>
              <li class="breadcrumb-item active"><span>Contestent List</span></li>
            </ol>
          </nav>
          <a href="view_elections.php" class="btn btn-success">View all</a>        
        </div>
    </header>

    <div class="container-form">
        <div class="row">
          <div class="col-md">
              <<<<< <?php echo $result_election['election_name']; ?> Elections >>>>><br>
              Roles and Responsibilty : <?php echo $result_election['election_roles_responsibility']; ?><br>
              Elligible Degree : <?php echo $row_degree['degree_name']; ?> | <?php echo $row_branch['branch_name']; ?> | <?php echo $result_election['eligible_year']; ?> <br>
              Registration Date :<?php echo $result_election['start_registration_date']." , ".$result_election['start_registration_time']; ?> to <?php echo $result_election['end_registration_date']." , ".$result_election['end_registration_time']; ?> <br>
              Election Date : <?php echo $result_election['election_date']; ?> <br>
              Timings : <?php echo $result_election['election_start_time']; ?> to <?php echo $result_election['election_end_time']; ?>

          </div>
          <div class="col-md">
            <table class="table table-bordered table-hover table-fixed">
                <thead  style="background-color:rgb(48,60,84);color:white;" >
                  <tr>							
                    <th width="100px">SL.No</th>
                    <th width="250px">Student Name</th>
                    <th>Degree</th>
                    <th width="150px">Branch</th>
                    <th width="250px">Year</th>
                  </tr>
                </thead>
                <tbody>
                    <tr></tr>
                </tbody>
            </table>
          </div>
        </div>
    </div>
</div>
<?php require_once("footer.php");?>