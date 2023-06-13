<?php
  require("header.php");
  require_once("Database/connection.php");
  connect_db();

  date_default_timezone_set('Asia/Kolkata');

  $today=date("Y-m-d");
  $time=date("H:i:s");

  if(isset($_POST['search'])){

    $usn=strtoupper($_POST['usn']);

    $statement = $con->prepare("SELECT * FROM student_info WHERE register_no=?");
    $statement->execute(array($usn));
    $total=$statement->rowCount();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $filter = "";

    if($total!=0){
      $degree_id=$result['degree_id'];
      $branch_id=$result['branch_id'];
      $year=$result['year'];

      $filter= "SELECT * FROM election_info WHERE (all_degree=? AND all_branch=? AND degree_id=? AND branch_id=?) OR (all_degree=? AND all_branch=? AND degree_id=?) OR (all_degree=? AND all_branch=?) ";

      echo "<script>alert('Please follow below table for further information')</script>";
    
    }else{
      echo "<script>alert('".$usn." is not valid or not registered. Please contact office')</script>";
    }
  }

 ?>

</div>

    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-white text-center bg-light" style="background-image: linear-gradient(rgba(0,0,0,0.50),rgb(0,0,0,0.50)),url(Images/bg.jpg);background-position:center;background-size: cover;">
        <form action="" method="post">
            <div class="col-md-5 p-lg-5 mx-auto my-5">
                <h1 class="display-5 font-weight-normal">University Elections</h1>
                <p class="lead font-weight-normal">Voting is your right and duty</p>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Enter your USN . . . ( Ex: 21GACSD001)" aria-label="Recipient's username" aria-describedby="basic-addon2" style="background-color: transparent;color:white" name="usn" required>
                    <button type="submit" name="search" class="input-group-text btn btn-outline-primary" id="basic-addon2">Search</button>
                </div>
            </div>
        </form>
    </div>

    <div class="d-md-flex flex-md-equal w-100 my-md-3 pl-md-3 bg-light">
        <div class="grid text-center">
          <p class="lead font-weight-normal"><<<<< Election List >>>>></p>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Sl No.</th>
                  <th scope="col">Election Name</th>
                  <th scope="col">Election Date</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                      if(empty($filter)){
                ?>
                <tr>
                  <td colspan="4">No Data Available</td>
                </tr>
                <?php
                      }else{
                              $statement = $con->prepare($filter);
                              $statement->execute(array(0,0,$degree_id,$branch_id,0,1,$degree_id,1,1));
                              $result = $statement->fetchAll(PDO::FETCH_ASSOC);$i=1;
                              foreach($result as $row){
                ?>
                  <tr>
                    <th scope="row"><?php echo $i++; ?></th>
                    <td><?php echo $row['election_name']; ?></td>
                    <td><?php echo $row['election_date']; ?></td>
                    <td>
                      <?php 
                          if(($today<$row['end_registration_date']) OR ($today==$row['end_registration_date'] && $time<$row['end_registration_time'])){
                                echo "<a href='contest.php?reference_no=".md5($row['election_id'])."&temp_no=".md5($usn)."'><button type='button' class='btn btn-primary'>Contest</button></a>";
                          }else if($today==$row['election_date']){
                              if($time<$row['election_end_time']){
                                echo "<button type='submit' class='btn btn-success'>Vote Now</button>";
                              }else{
                                echo "Elections are over.";
                              }
                            }else{
                                echo "Registreations are done,Wait until Election starts. ";
                          }
                      ?>
                    </td>
                  </tr>
                <?php }} ?>
              </tbody>
            </table>
        </div>
    </div>



<?php
  require("footer.php");
 
 ?>