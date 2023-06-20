<?php 
  require_once("header.php");
  require_once("../Database/connection.php");
  connect_db();

  $update=0;
  $insert=0;

  if(isset($_POST["import"])){
    $filename = $_FILES["load"]["tmp_name"];
    
    if($_FILES["load"]["size"] > 0){
        $file = fopen($filename, "r");

        while(($column = fgetcsv($file, 10000 , ",")) !== FALSE){
            $fname=$column[0];
            $lname=$column[1];
            $gender=$column[2];
            $address=$column[3];
            $mobile=$column[4];
            $email=$column[5];
            $degree=$column[6];
            $branch=$column[7];
            $register=$column[8];
            $year=$column[9];
            $password=md5($year.'@'. $register);


            $statement = $con->prepare("SELECT * FROM degree_info WHERE degree_name=? ");
            $statement->execute(array($degree));
            $row_degree = $statement->fetch(PDO::FETCH_ASSOC);

            $statement = $con->prepare("SELECT * FROM branch_info WHERE branch_name=? ");
            $statement->execute(array($branch));
            $row_branch = $statement->fetch(PDO::FETCH_ASSOC);

            $statement = $con->prepare("SELECT * FROM student_info WHERE register_no=? ");
            $statement->execute(array($register));
            $total = $statement->rowCount();
            
            if($total>0){
              $statement = $con->prepare("SELECT * FROM student_info WHERE register_no=? AND email=? ");
              $statement->execute(array($register,$email));
              $total = $statement->rowCount();

              if($total>0){
                
                $statement = $con->prepare("UPDATE student_info SET fname = ?,lname=?,gender=?,address=?,mobile_no=?,degree_id=?,branch_id=?,password=?,year=? WHERE register_no = ? AND email = ? ");
                $statement->execute(array($fname,$lname,$gender,$address,$mobile,$row_degree['degree_id'],$row_branch['branch_id'],$password,$year,$register,$email));

                $update++;

              }else{
                
                echo "alert('".$fname." with ".$register." seems to be not valid . . . ');";
              
              }

            }else{
              
              $statement = $con->prepare("INSERT INTO student_info(fname,lname,gender,address,mobile_no,email,degree_id,branch_id,register_no,password,year,image) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
              $statement->execute(array($fname,$lname,$gender,$address,$mobile,$email,$row_degree['degree_id'],$row_branch['branch_id'],$register,$password,$year,"image.png"));

              $insert++;

            
            }
        }

        echo "<script>alert('All the data has been loaded successfully Inserted:".$insert." Updated:".$update."');</script>";
    }
  }

if(isset($_POST['eyear'])){
    $degree_id=$_POST['degree'];
    $branch_id=$_POST['branch'];
 
    if($degree_id==9999 && $branch_id==9999 && $_POST['eyear']==9999){
      $filter="SELECT * from student_info ORDER BY degree_id";
    }else if($degree_id==9999 && $branch_id==9999 && $_POST['eyear']!=9999){
      $filter="SELECT * FROM student_info WHERE year=".$_POST['eyear']." ORDER BY degree_id";
    }else if($degree_id!=9999 && $branch_id==999 && $_POST['eyear']==9999){
      $filter="SELECT * FROM student_info WHERE degree_id=".$degree_id." ORDER BY degree_id";
    }else if($degree_id!=9999 && $branch_id==999 && $_POST['eyear']!=9999){
      $filter="SELECT * FROM student_info WHERE degree_id=".$degree_id." AND year=".$_POST['eyear']." ORDER BY degree_id";
    }else if($degree_id!=9999 && $branch_id!=9999 && $_POST['eyear']!=9999){
      $filter="SELECT * FROM student_info WHERE year=".$_POST['eyear']." AND degree_id=".$degree_id." AND branch_id=".$branch_id  ." ORDER BY degree_id";
    }else{
      $filter="SELECT * FROM student_info WHERE degree_id=".$degree_id." AND branch_id=".$branch_id  ." ";
    }
}else{
    $filter = "SELECT * FROM student_info ORDER BY degree_id ";
}

if(isset($_POST['delete'])){
  $register=$_POST['delete'];
  echo "<script>alert('Student data will be deleted ');</script>";
  $statement = $con->prepare("DELETE FROM student_info WHERE register_no=? ");
  $statement->execute(array($register));
}

  

?>

        <div class="container-fluid">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
              <li class="breadcrumb-item">
                <a class="nav-link" href="index.php"><span>Home</span></a>
              </li>
              <li class="breadcrumb-item active"><span>Load Student Data</span></li>
            </ol>
          </nav>
          <a  href="create_student.php" class="btn btn-success">Create</a>
        </div>
    </header>

    <div class="container-fluid" style="background:white;border-radius:20px 20px 20px 20px;marign-left:10px;width:95%;height:100px;">
        <form action="load_student.php" enctype="multipart/form-data" method="post" style="margin-top:10px;padding-top:20px;padding-left:20px;">
            <label for="election file">Select file to load :</label>
            <input type="file" name="load" class="mx-md-3" accept=".csv" required>
            <input type="submit" name="import" class="btn btn-success" value="Load" >
        </form>
    </div>

    <div class="container-fluid my-md-5" style="width:95%;">
        <form action="" enctype="multipart/form-data" method="post">
          <div class="row">
            <div class="col-md-5 mb-md-3">
              <h2>Student Information  . . .</h1>
            </div>
              <div class="col-md my-md-2" style="margin-left:10%;">
                
                <select name="degree" id="country">
                  <option value="">Select Any Degree</option>
                </select>
                
                <select name="branch" id="state">
                  <option value="">Select Any Branch</option>
                </select>

                <select name="eyear" onchange="this.form.submit()">
                  <option value="">Select any year</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="9999">All Years</option>
                </select>
            </div>
          </div>
        </form>
        
        <form action="" enctype="multipart/form-data" method="post">
            <table class="table" align="center" style="Overflow-y:scroll;height:10px;">
              <thead  style="background-color:rgb(48,60,84);color:white;" >
                <tr>
                  <th scope="col">Sl No.</th>
                  <th scope="col">Student Name</th>
                  <th scope="col">Degree | Branch | Year </th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                  <?php
                              $statement = $con->prepare($filter);
                              $statement->execute();
                              $total=$statement->rowCount();
                              $result = $statement->fetchAll(PDO::FETCH_ASSOC);$i=1;
                              if($total>0){
                                foreach($result as $row){

                                $statement = $con->prepare("SELECT * FROM degree_info WHERE degree_id=? ");
                                $statement->execute(array($row['degree_id']));
                                $row_degree = $statement->fetch(PDO::FETCH_ASSOC);

                                $statement = $con->prepare("SELECT * FROM branch_info WHERE branch_id=? ");
                                $statement->execute(array($row['branch_id']));
                                $row_branch = $statement->fetch(PDO::FETCH_ASSOC);
                                
                  ?>
                  <tr>
                    <td scope="row"><?php echo $i++; ?></td>
                    <td><?php echo $row['fname']." ".$row['lname']; ?></td>
                    <td><?php echo $row_degree['degree_name']." | ".$row_branch['branch_name']." | " .$row['year']; ?></td>
                    <td>
                      <a href="student_edit.php?reference_no=<?php echo md5($row['register_no']); ?>" class="btn btn-success">Edit</a>
                      <button type="submit" name="delete" value="<?php echo $row['register_no']; ?>" class="btn btn-danger">Delete</button>
                    </td>
                  </tr>
                
                  <?php         }
                      }else{ 
                  ?>
                  <tr align="center"><td colspan="4">No Data available . . .</td></tr>
                <?php }?>

              </tbody>
            </table>
        </form>

    </div>

</div>

<script src="js/jquery.js"></script>
<script type="text/javascript">

  $(document).ready(function(){
  	function loadData(type, category_id){
  		$.ajax({
  			url : "select.php",
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