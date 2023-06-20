<?php 
  require_once("header.php");
  require_once("../Database/connection.php");
  connect_db();

  $today=date("Y-m-d");
  $time=date("H:i:s");



  if(isset($_POST['delete_election'])){

    $degree_id=$_POST['delete_election'];
    $statement = $con->prepare("DELETE FROM election_info WHERE election_id = ?");
    $statement->execute(array($degree_id));

  }
?>

        <div class="container-fluid">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
              <li class="breadcrumb-item">
                <!-- if breadcrumb is single--><a class="nav-link" href="index.php"><span>Home</span></a>
              </li>
              <li class="breadcrumb-item active"><span>View Elections</span></li>
            </ol>
          </nav>
          <h4><span style="color:yellow;">Yellow</span>: Represents Voluteers List</h4>
          <a  style="margin-left:20px;" href="create_elections.php" class="btn btn-success">Create Election</a>
        </div>
    </header>

        <div class="container-fluid">
            <form action="" method="POST" enctype="multipart/form-data">
	            <table class="table table-bordered table-hover table-fixed">
                <thead  style="background-color:rgb(48,60,84);color:white;" >
                  <tr align="center">							
                    <th width="100px">SL.No</th>
                    <th width="150px">Election Name</th>
                    <th width="250px">Total Eligible Students</th>
                    <th width="250px">Registered Students</th>
                    <th width="150px">Status</th>
                    <th width="200px">Action</th>
                  </tr>
                </thead>
                <tbody>
                        <?php
                            $statement = $con->prepare("SELECT * FROM election_info");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            $i=1;
                            foreach ($result as $row) {


                        ?>
                            <tr align="center" style="background:<?php if($row['voting']==0) echo "yellow";?>">
                                
                                <td><?php echo $i++; ?></td>
                                
                                <td><a  style="text-decoration:none;color:black;"href="contestent_list.php?reference_no=<?php echo md5($row['election_id']); ?>"><?php echo $row['election_name']; ?></a></td>
                                
                                <?php 

                                  if($row['all_degree']==1 && $row['all_branch']==1){
                                    $filter="SELECT COUNT(register_no) AS total_count FROM student_info";
                                  }else if($row['all_degree']==0 && $row['all_branch']==1){
                                    $filter="SELECT COUNT(register_no) AS total_count FROM student_info WHERE degree_id=".$row['degree_id'].""; 
                                  }else if($row['all_degree']==0 && $row['all_branch']==0){
                                    $filter="SELECT COUNT(register_no) AS total_count FROM student_info WHERE degree_id=".$row['degree_id']." AND branch_id = ".$row['branch_id']." "; 
                                  }

                                  $statement = $con->prepare($filter);
                                  $statement->execute();
                                  $result = $statement->fetch(PDO::FETCH_ASSOC);

                                ?>
                                <td><?php echo $result['total_count']; ?></td>
                                
                                <?php 
                                    $statement = $con->prepare("SELECT COUNT(c.election_id) AS total_count FROM contesten_election_info AS c JOIN election_info AS e WHERE c.election_id=e.election_id AND c.election_id=".$row['election_id']." ");
                                    $statement->execute();
                                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                                ?>

                                <td><?php echo $result['total_count']; ?></td>

                                <?php 
                                    $filter="";
                                  if($today<$row['start_registration_date']){
                                      $filter="Registration will begin soon";

                                  }else if(($today<$row['end_registration_date'])OR($today==$row['end_registration_date'] && $time<$row['end_registration_time'])){
                                    $filter="Registration In Progress";

                                  }else if((($today>$row['end_registration_date']) OR ($today==$row['end_registration_date'] && $time>$row['end_registration_time'])) && $today<$row['election_date']){
                                    $filter="Elections will begins soon";
                                  }
                                  else if(($today==$row['election_date'] && $time<$row['election_end_time'])){
                                    $filter="Election Day";

                                  }else if($today>$row['election_date']){
                                    $filter="Elections are over";
                                  
                                  }

                                ?>

                                
                                <td><?php echo $filter; ?></td>
                                
                                <td>
                                    <a href="edit_election.php?reference_no=<?php echo md5($row['election_id']); ?>" class="btn btn-success">Edit</a>
                                    <button type="submit" class="btn btn-danger" name="delete_election" value="<?php echo $row['election_id']; ?>">Delete</button>
                                </td>
                            </tr>

                        <?php  } ?>
                </tbody>
              </table>
            </form>
        </div>

</div>
<?php require_once("footer.php");?>