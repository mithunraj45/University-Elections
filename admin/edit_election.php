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


  if(isset($_POST['submit'])){
    $ename=$_POST['ename'];
    $role=$_POST['erole'];
    $edate=$_POST['edate'];
    $stime=$_POST['estime'];
    $etime=$_POST['etime'];
    $edegree=$_POST['edegree'];
    $ebranch=$_POST['ebranch'];
  
    if($result_election['election_name']!=strtoupper($ename) OR $result_election['election_roles_responsibility']!=$role OR $result_election['election_date']!=$edate OR $result_election['election_start_time']!=$stime OR $result_election['election_end_time']!=$etime OR $result_election['degree_id']!=$edegree OR $result_election['branch_id']!=$ebranch){
        if($stime != $etime){
            $statement = $con->prepare("UPDATE election_info SET election_name = ?, election_roles_responsibility = ?,degree_id=?,branch_id=?,election_date=?,election_start_time=?,election_end_time=? WHERE election_id=?");
            $statement->execute(array($ename,$role,$edegree,$ebranch,$edate,$stime,$etime,$result_election['election_id']));
            
            echo "<script>alert(' ".$ename." election has been updated to be conducted on ".$edate." at ".$stime." to ".$etime." for ".$row_degree['degree_name']." ( ".$row_branch['branch_name']." ) ')</script>";
  

        }else{
            echo "<script>alert(' Start time and End time cannot be same ')</script>";
        }
    }
  }
?>

        <div class="container-fluid">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
              <li class="breadcrumb-item">
                <a class="nav-link" href="index.php"><span>Home</span></a>
              </li>
              <li class="breadcrumb-item active"><span>Edit Elections </span></li>
            </ol>
          </nav>

          <a href="view_elections.php" class="btn btn-success">View all</a>

        </div>
    </header>

    <div class="container-form">
        <form action="" method="POST" class="form" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md">
                        <div class="form name">
                            <label for="election name"><span class="required">* </span>Election Name :</label><br>
                            <input type="text" name="ename" placeholder="Enter the name..." value="<?php echo $result_election['election_name']; ?>" required>
                        </div>
                    </div>

                    <div class="col-md">
                        <div class="form role">
                            <label for="elecion role"><span class="required">* </span>Roles and Responsibilty :</label><br>
                            <textarea name="erole" cols=23 placeholder="<?php echo $result_election['election_roles_responsibility']; ?>" required></textarea>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm">
                        <div class="form date">
                            <label for="election date"><span class="required">* </span>Date :</label><br>
                            <input type="date" name="edate" value="<?php echo $result_election['election_date']; ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm">
                        <div class="form stime">
                            <label for="election stime"><span class="required">* </span>Start Time :</label><br>
                            <input type="time" name="estime" value="<?php echo $result_election['election_start_time']; ?>" required>
                        </div>
                    </div>

                    <div class="col-sm">
                        <div class="form date">
                            <label for="election time"><span class="required">* </span>End Time :</label><br>
                            <input type="time" name="etime" value="<?php echo $result_election['election_end_time']; ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md">
                        <div class="form degree">
                           <label for="election degree"><span class="required">* </span>Elligible Degree :</label><br>
                            <select name="edegree" id="country"  required>
                                 <option value="<?php echo $result_election['degree_id']; ?>"><?php echo $row_degree['degree_name']; ?></option>
                            </select>
                       </div>
                    </div>
                    <div class="col-md">
                        <div class="form branch">
                            <label for="election branch"><span class="required">* </span>Elligible Branches :</label><br>
                            <select name="ebranch" id="state" required>
                                <option value="<?php echo $result_election['branch_id']; ?>"><?php echo $row_branch['branch_name']; ?></option>   
                            </select>
                        </div>
                    </div>
                </div>


            <div class="form submit">
                <input type="submit" value="Update" name="submit">
            </div>
            
        </form>
    </div>

</div>


<script src="js/jquery.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
  	function loadData(type, category_id){
  		$.ajax({
  			url : "select_degree.php",
  			type : "POST",
  			data: {type : type, id : category_id},
  			success : function(data){
  				if(type == "stateData"){
  					$("#state").html(data);
  				}else{
  					$("#country").append(data);
  				}
  				
  			}
  		});
  	}

  	loadData();

  	$("#country").on("change",function(){
  		var country = $("#country").val();

  		if(country != ""){
  			loadData("stateData", country);
  		}else{
  			$("#state").html("");
  		}

  		
  	})
  });
</script>
<?php require_once("footer.php");?>