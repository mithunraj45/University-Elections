<?php 
  require_once("header.php");
  require_once("../Database/connection.php");
  connect_db();

  $ref_id=$_REQUEST['reference_no'];

  $statement = $con->prepare("SELECT * FROM  student_info ");
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
        if($ref_id==md5($row['register_no'])){
            $result_student=$row;
        }
  }

  $statement = $con->prepare("SELECT * FROM degree_info WHERE degree_id=? ");
  $statement->execute(array($result_student['degree_id']));
  $row_degree = $statement->fetch(PDO::FETCH_ASSOC);

  $statement = $con->prepare("SELECT * FROM branch_info WHERE branch_id=? ");
  $statement->execute(array($result_student['branch_id']));
  $row_branch = $statement->fetch(PDO::FETCH_ASSOC);


  if(isset($_POST['submit'])){
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $gender=$_POST['gender'];
    $address=$_POST['address'];
    $mobile=$_POST['mobile'];
    $email=$_POST['email'];
    $degree=$_POST['edegree'];
    $branch=$_POST['ebranch'];
    $register=$_POST['register'];
    $year=$_POST['year'];
    $password=md5($year.'@'. $register);

    $statement = $con->prepare("UPDATE student_info SET fname=?,lname=?,gender=?,address=?,mobile_no=?,email=?,degree_id=?,branch_id=?,register_no=?,year=?,password=? WHERE register_no=? ");
    $statement->execute(array($fname,$lname,$gender,$address,$mobile,$email,$degree,$branch,$register,$year,$password,$result_student['register_no']));
    echo "<script>alert('Student data has been updated . . .');window.location.href='load_student.php';</script>";



  }

?>

        <div class="container-fluid">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
              <li class="breadcrumb-item">
                <a class="nav-link" href="index.php"><span>Home</span></a>
              </li>
              <li class="breadcrumb-item active"><span>Edit Student Data</span></li>
            </ol>
          </nav>
          <a style="margin-left:-150px;" href="load_student.php" class="btn btn-success">View all</a>
        </div>
    </header>

    <div class="container-form" style="width:65%;margin-left:18%;border-radius:20px 20px 20px 20px;">
        <form action="" method="POST" class="form" enctype="multipart/form-data">
                <div class="row">
                    <label for="election stime" style="margin-left:25%;"><<<<< Student Details >>>>></label><br>
                    <div class="col-md">
                        <div class="form name">
                            <label for="election name"><span class="required">* </span>First Name :</label><br>
                            <input type="text" name="fname" placeholder="Enter the name..." value="<?php echo $result_student['fname']; ?>" required>
                        </div>
                    </div>

                    <div class="col-md">
                        <div class="form role">
                            <label for="elecion role"><span class="required">* </span>Last Name:</label><br>
                            <input type="text" name="lname" value="<?php echo $result_student['lname']; ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md">
                        <div class="form">
                            <label for="election degree"><span class="required">* </span>Gender :</label><br>
                            <select name="gender" required>
                                <option value="<?php echo $result_student['gender'];?>"><?php if($result_student['gender']=='M') echo "Male";else echo "Female"; ?></option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                                <option value="O">Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form">
                            <label for="election degree"><span class="required">* </span>Address :</label><br>
                            <input type="text" name="address" value="<?php echo $result_student['address']; ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md">
                        <div class="form name">
                            <label for="election name"><span class="required">* </span>Mobile No :</label><br>
                            <input type="text" name="mobile" placeholder="Enter the mobile no..." value="<?php echo $result_student['mobile_no']; ?>" required>
                        </div>
                    </div>

                    <div class="col-md">
                        <div class="form role">
                            <label for="elecion role"><span class="required">* </span>Email ID</label><br>
                            <input type="email" name="email" value="<?php echo $result_student['email']; ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md">
                        <div class="form degree edegree">
                           <label for="election degree"><span class="required">* </span>Degree :</label><br>
                            <select name="edegree" id="country" >
                                 <option value="<?php echo $row_degree['degree_id'] ?>"><?php echo $row_degree['degree_name']; ?></option>
                            </select>
                       </div>
                    </div>
                    <div class="col-md">
                        <div class="form branch edegree">
                            <label for="election branch"><span class="required">* </span>Elligible Branches :</label><br>
                            <select name="ebranch" id="state" >
                                <option value="<?php echo $row_branch['branch_id'] ?>"><?php echo $row_branch['branch_name']; ?></option>   
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md">
                        <div class="form name">
                            <label for="election name"><span class="required">* </span>Register No :</label><br>
                            <input type="text" name="register" placeholder="Enter the register no..." value="<?php echo $result_student['register_no']; ?>" required>
                        </div>
                    </div>

                    <div class="col-md">
                        <div class="form role">
                            <label for="election name"><span class="required">* </span>Year</label><br>
                            <select name="year" required>
                                <option value="<?php echo $result_student['year'];?>"><?php  echo $result_student['year']; ?></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>                                
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form submit" style="margin-left:35%;">
                    <input type="submit" value="Update" name="submit">
                </div>
        </form>
    </div>


</div>
<?php require("footer.php") ?>

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
