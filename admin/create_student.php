<?php 
  require_once("header.php");
  require_once("../Database/connection.php");
  connect_db();


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

  $statement = $con->prepare("SELECT * FROM student_info WHERE register_no=? ");
  $statement->execute(array($register));
  $total=$statement->rowCount();

  if($total!=0){
    echo "<script>alert('Given register no already exists . . .');</script>";
  }else{
    $statement = $con->prepare("INSERT INTO student_info(fname,lname,gender,address,mobile_no,email,degree_id,branch_id,register_no,year,password,image) VALUES(?,?,?,?,?,?,?,?,?,?,?,?) ");
    $statement->execute(array($fname,$lname,$gender,$address,$mobile,$email,$degree,$branch,$register,$year,$password,"image.png"));
    echo "<script>alert('Student data has been inserted . . .');window.location.href='load_student.php';</script>";

  }
}



?>    


        <div class="container-fluid">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
              <li class="breadcrumb-item">
                <a class="nav-link" href="index.php"><span>Home</span></a>
              </li>
              <li class="breadcrumb-item active"><span>Create Student Data</span></li>
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
                            <input type="text" name="fname" placeholder="Enter the name..." required>
                        </div>
                    </div>

                    <div class="col-md">
                        <div class="form role">
                            <label for="elecion role"><span class="required">* </span>Last Name:</label><br>
                            <input type="text" name="lname" placeholder="Enter your last name  . . . "  required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md">
                        <div class="form">
                            <label for="election degree"><span class="required">* </span>Gender :</label><br>
                            <select name="gender" required>
                                <option value="">Select any gender</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                                <option value="O">Others</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form">
                            <label for="election degree"><span class="required">* </span>Address :</label><br>
                            <input type="text" name="address" placeholder="Enter your address  . . . "  required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md">
                        <div class="form name">
                            <label for="election name"><span class="required">* </span>Mobile No :</label><br>
                            <input type="number" name="mobile" placeholder="Enter the mobile no..."  required>
                        </div>
                    </div>

                    <div class="col-md">
                        <div class="form role">
                            <label for="elecion role"><span class="required">* </span>Email ID</label><br>
                            <input type="email" name="email" placeholder="Enter your email id  . . . "  required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md">
                        <div class="form degree edegree">
                           <label for="election degree"><span class="required">* </span>Degree :</label><br>
                            <select name="edegree" id="country" >
                                 <option value="">Select Any Degree</option>
                            </select>
                       </div>
                    </div>
                    <div class="col-md">
                        <div class="form branch edegree">
                            <label for="election branch"><span class="required">* </span>Elligible Branches :</label><br>
                            <select name="ebranch" id="state" >
                                <option value="">Select Any Branch</option>   
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md">
                        <div class="form name">
                            <label for="election name"><span class="required">* </span>Register No :</label><br>
                            <input type="text" name="register" placeholder="Enter the register no..." required>
                        </div>
                    </div>

                    <div class="col-md">
                        <div class="form role">
                            <label for="election name"><span class="required">* </span>Year</label><br>
                            <select name="year" required>
                                <option value="">Select any year</option>
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