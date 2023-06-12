<?php 
  require_once("header.php");
  require_once("../Database/connection.php");
  connect_db();

  if(isset($_POST['edate'])){
    $edate=$_POST['edate'];
    $filter="SELECT * FROM election_info WHERE election_date = '$edate'";
  }else{
    $filter="SELECT * FROM election_info";
  }

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

          <form action="" method="POST" enctype="multipart/form-data">
                <input type="date" name="edate" onchange="this.form.submit()">
                <a  style="margin-left:20px;" href="create_elections.php" class="btn btn-success">Create Election</a>
          </form>

        
        </div>
    </header>

        <div class="container-fluid">
            <form action="" method="POST" enctype="multipart/form-data">
	            <table class="table table-bordered table-hover table-fixed">
                <thead  style="background-color:rgb(48,60,84);color:white;" >
                  <tr>							
                    <th width="100px">SL.No</th>
                    <th width="150px">Election Name</th>
                    <th width="300px">Degree Name | Branch Name | Year</th>
                    <th width="250px">Registration Start | End Date </th>
                    <th width="150px">Election Date</th>
                    <th width="200px">Action</th>
                  </tr>
                </thead>
                <tbody>
                        <?php
                            $statement = $con->prepare($filter);
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            $i=1;
                            foreach ($result as $row) {

                            $statement = $con->prepare("SELECT * FROM  degree_info WHERE degree_id =? ");
                            $statement->execute(array($row['degree_id']));
                            $result_degree = $statement->fetch(PDO::FETCH_ASSOC);

                            $statement = $con->prepare("SELECT * FROM  branch_info WHERE branch_id =? ");
                            $statement->execute(array($row['branch_id']));
                            $result_branch = $statement->fetch(PDO::FETCH_ASSOC);
                        ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><a  style="text-decoration:none;color:black;"href="contestent_list.php?reference_no=<?php echo md5($row['election_id']); ?>"><?php echo $row['election_name']; ?></a></td>
                                <td><?php echo $result_degree['degree_name']." | ".$result_branch['branch_name']." | ".$row['eligible_year']; ?></td>
                                <td><?php echo $row['start_registration_date']." | ".$row['end_registration_date']?></td>
                                <td><?php echo $row['election_date']; ?></td>
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