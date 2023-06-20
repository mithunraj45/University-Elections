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

    <div class="container-fluid position-relative overflow-hidden mt-md-3 ml-md-3 " style="margin-left:20px;width:96%;background:white;height:300px;border-radius:20px 20px 20px 20px;">
            <h3 class="text-center my-md-3" style="color:green;"><<<<< <?php echo $result_election['election_name']; ?> >>>>></h3>
              
              <div class="row" style="margin-left:10%;">
                <div class="col-md-6 text-right ">
                  <p class="h4">Roles and Responsibilty : </p>
                </div>
                <div class="col-md text-left">
                  <p class="h4"><?php echo $result_election['election_roles_responsibility']; ?></p>
                </div>
              </div>

              <div class="row" style="margin-left:10%;">
                <div class="col-md-6 text-right ">
                  <p class="h4">Elligible Degree | Branch | Year : </p>
                </div>
                <div class="col-md text-left">
                  <p class="h4"><?php echo $row_degree['degree_name']." | ".$row_branch['branch_name']." | ".$result_election['eligible_year']; ?></p>
                </div>
              </div>

              <div class="row" style="margin-left:10%;">
                <div class="col-md-6 text-right ">
                  <p class="h4">Registration Date :</p>
                </div>
                <div class="col-md text-left">
                  <p class="h4"><?php echo $result_election['start_registration_date']." to ".$result_election['end_registration_date']."(".$result_election['end_registration_time'].")"; ?></p>
                </div>
              </div>

              <div class="row" style="margin-left:10%;">
                <div class="col-md-6 text-right ">
                  <p class="h4">Election Date : </p>
                </div>
                <div class="col-md text-left">
                  <p class="h4"><?php echo $result_election['election_date']; ?></p>
                </div>
              </div>

              <div class="row" style="margin-left:10%;">
                <div class="col-md-6 text-right ">
                  <p class="h4">Timings :</p>
                </div>
                <div class="col-md text-left">
                  <p class="h4"><?php echo $result_election['election_start_time']." to ".$result_election['election_end_time']; ?></p>
                </div>
              </div>
      </div>

      <div class="container-fluid my-md-5" >
                    <table class="table table-bordered table-hover table-fixed">
                        <thead  style="background-color:rgb(48,60,84);color:white;" >
                          <tr>							
                              <th width="100px">SL.No</th>

                              <?php if($result_election['voting']==1) {?>
                                <th width="150px">Contestent Color</th>
                              <?php } ?>

                              <th width="300px">Contestent Name</th>
                              <th width="250px">Degree | Branch |Year </th>

                              <?php if($result_election['voting']==1) {?>
                                <th width="80px">Votes</th>
                              <?php } ?>
                          </tr>

                        </thead>    
                        <tbody>
                            <?php 
                                $statement = $con->prepare("SELECT * FROM contesten_election_info WHERE election_id=? ORDER BY no_of_votes DESC ");
                                $statement->execute(array($result_election['election_id']));
                                $total=$statement->rowCount();
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                $i=1;
                                if($total>0){
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
                                    
                                    <?php if($result_election['voting']==1) {?>
                                      <td align="center"><div style="margin-top:10px;width:50px;height:50px;background:<?php echo $result_color['color_name']; ?>;border-radius:50%;"></div></td>
                                    <?php } ?>
                                    
                                    <td><?php echo $result_name['fname']; ?></td>
                                    
                                    <td><?php echo $row_name_degree['degree_name']." | ".$row_name_branch['branch_name']." | ".$result_name['year'];?></td>

                                    <?php if($result_election['voting']==1) {?>
                                      <td><?php echo $row['no_of_votes']; ?></td>
                                    <?php } ?>
                                </tr>

                            <?php }}else{?>

                                <tr>
                                  <td colspan="5" align="Center"><?php echo "No data available. . ."; ?></td>
                                </tr>

                            <?php } ?>
                        </tbody>
                    </table>
      </div>
</div>
<?php require_once("footer.php");?>