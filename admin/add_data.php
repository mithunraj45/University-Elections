<?php 
  require_once("header.php");
  require_once("../Database/connection.php");
  connect_db();


  if(isset($_POST['submit_degree'])){
    $value=$_POST['add_degree'];

    $statement = $con->prepare("SELECT * FROM degree_info WHERE degree_name = ?");
    $statement->execute(array($value));
    $total=$statement->rowCount();

    if($total==0){
        $statement = $con->prepare("INSERT INTO degree_info(degree_name) VALUES(?) ");
        $statement->execute(array($value));
        echo "<script>alert('".$value." has been added successfully . . . ');</script>";
    }else{
        echo "<script>alert('Entered Degree already exists . . . ');</script>";
    }

  }

  if(isset($_POST['submit_branch'])){
    $value=$_POST['add_branch'];
    $degree=$_POST['degree_id'];

    $statement = $con->prepare("SELECT * FROM branch_info WHERE degree_id = ? AND branch_name=?");
    $statement->execute(array($degree,$value));
    $total=$statement->rowCount();

    if($total==0){
        $statement = $con->prepare("INSERT INTO branch_info(branch_name,degree_id) VALUES(?,?) ");
        $statement->execute(array($value,$degree));
        echo "<script>alert('".$value." has been added successfully . . . ');</script>";
    }else{
        echo "<script>alert('Entered branch already exists . . . ');</script>";
    }

  }
  
  if(isset($_POST['submit_color'])){
    $value=strtolower($_POST['add_color']);

    $statement = $con->prepare("SELECT * FROM color_info WHERE color_name=?");
    $statement->execute(array($value));
    $total=$statement->rowCount();

    if($total==0){
        $statement = $con->prepare("INSERT INTO color_info(color_name) VALUES(?) ");
        $statement->execute(array($value));
        echo "<script>alert('".$value." has been added successfully . . . ');</script>";
    }else{
        echo "<script>alert('Entered color already exists . . . ');</script>";
    }

  }

  if(isset($_POST['delete_degree'])){
    $value=$_POST['delete_degree'];

    $statement = $con->prepare("SELECT * FROM degree_info WHERE degree_id = ?");
    $statement->execute(array($value));
    $total=$statement->rowCount();

    if($total!=0){
        $statement = $con->prepare("DELETE FROM degree_info WHERE degree_id=? ");
        $statement->execute(array($value));
        echo "<script>alert('Branch has been successfully  deleted. . . ');</script>";
    }else{
        echo "<script>alert('Entered Degree does not exists . . . ');</script>";
    }

  }

  if(isset($_POST['delete_branch'])){
    $value=$_POST['delete_branch'];

    $statement = $con->prepare("SELECT * FROM branch_info WHERE branch_id = ?");
    $statement->execute(array($value));
    $total=$statement->rowCount();

    if($total!=0){
        $statement = $con->prepare("DELETE FROM branch_info WHERE branch_id=? ");
        $statement->execute(array($value));
        echo "<script>alert('Branch has been successfully  deleted. . . ');</script>";
    }else{
        echo "<script>alert('Entered branch does not exists . . . ');</script>";
    }

  }

  if(isset($_POST['delete_color'])){
    $value=$_POST['delete_color'];

    $statement = $con->prepare("SELECT * FROM color_info WHERE color_id = ?");
    $statement->execute(array($value));
    $total=$statement->rowCount();

    if($total!=0){
        $statement = $con->prepare("DELETE FROM color_info WHERE color_id=? ");
        $statement->execute(array($value));
        echo "<script>alert('Color has been successfully  deleted. . . ');</script>";
    }else{
        echo "<script>alert('Entered color does not exists . . . ');</script>";
    }

  }
?>

        <div class="container-fluid">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0 ms-2">
              <li class="breadcrumb-item">
                <a class="nav-link" href="index.php"><span>Home</span></a>
              </li>
              <li class="breadcrumb-item active"><span>Add Data </span></li>
            </ol>
          </nav>

          <a href="view_elections.php" class="btn btn-success">View all</a>

        </div>
    </header>

    <div class="container-form"  style="background:white;width:95%;margin-left:1%;border-radius:20px 20px 20px 20px;">
        <div class="box-shadow mx-md-1 my-md-3">
            <div class="row mx-md-3">
                <div class="col-md-3 mx-md-3 my-md-3">
                    <h3 class="text-center">Department</h3>
                    <form action="" method="post">
                        <table class="my-md-3 table table-striped table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th width="100px">Sl No.</th>
                                    <th width="250px">Department Name</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                        $statement = $con->prepare("SELECT * FROM degree_info");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        $i=1;
                                        foreach($result as $row){
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $row['degree_name']; ?></td>
                                    <td><button type="submit" name="delete_degree" value="<?php echo $row['degree_id']; ?>" class="btn btn-danger">Delete</button></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </form>

                    <form action="" method="post">
                            <input class="py-md-2 bg-light border border-less " style="width:165px;border-radius:20px 20px 20px 20px;" type="text" name="add_degree" placeholder="Add new Degree . . . " required>
                            <input type="submit" name="submit_degree" class="btn btn-success" value="Add">
                    </form>
                </div>


                <div class="col-md-4 mx-md-3 my-md-3">
                    <form action="" method="post" enctype="multipart/form-data">
                        <label for="branch" style="font-size:24px;">Branch</label>
                        <select name="degree_id" class="mx-md-4 py-md-2  border border-less" style="border-radius:20px 20px 20px 20px;" onchange="this.form.submit()">
                            <option value="">Select any degree</option>
                            <?php 
                                    $statement = $con->prepare("SELECT * FROM degree_info");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($result as $row){                            
                            ?>
                            <option value="<?php echo $row['degree_id']; ?>"><?php echo $row['degree_name']; ?></option>
                            <?php } ?>
                        </select>
                    </form>
                    <form action="" method="post">
                        <table class="my-md-3 table table-striped table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th width="100px">Sl No.</th>
                                    <th width="250px">Branch Name</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                      if(isset($_POST['degree_id'])){

                                        $statement = $con->prepare("SELECT * FROM branch_info WHERE degree_id=?");
                                        $statement->execute(array($_POST['degree_id']));
                                        $total=$statement->rowCount();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        $i=1;
                                        if($total>0){
                                        foreach($result as $row){
                                
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $row['branch_name']; ?></td>
                                    <td><button type="submit" name="delete_branch" value="<?php echo $row['branch_id']; ?>" class="btn btn-danger">Delete</button></td>
                                </tr>
                                <?php }} else{?>
                                <tr align="center">
                                    <td colspan="3"><?php echo "No data available . . ."; ?></td>
                                </tr>
                                <?php }
                                }else{ ?>
                                    <tr align="center">
                                        <td colspan="3">Select any particular degree</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </form>

                    <form action="" method="post">
                            <input class="py-md-2 bg-light border border-less w-50" style="border-radius:20px 20px 20px 20px;" type="text" name="add_branch" placeholder="Add new branch. . . " required>
                            <select name="degree_id" class="py-md-2  border border-less" style="border-radius:20px 20px 20px 20px;" required>
                                <option value="">Select any degree</option>
                                <?php 
                                        $statement = $con->prepare("SELECT * FROM degree_info");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach($result as $row){                            
                                ?>
                                <option value="<?php echo $row['degree_id']; ?>"><?php echo $row['degree_name']; ?></option>
                                <?php } ?>
                            </select>
                            <input type="submit" name="submit_branch" class="btn btn-success w-20 my-md-3" value="Add">
                    </form>
                    
                </div>


                <div class="col-md-3 mx-md-3 my-md-3">
                    <h3 class="text-center">Color</h3>

                    <form action="" method="post">
                        <table class="my-md-3 table table-striped table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th width="100px">Sl No.</th>
                                    <th width="250px">Name</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                        $statement = $con->prepare("SELECT * FROM color_info");
                                        $statement->execute();
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        $i=1;
                                        foreach($result as $row){
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo strtoupper($row['color_name']); ?></td>
                                    <td><button type="submit" name="delete_color" value="<?php echo $row['color_id']; ?>" class="btn btn-danger">Delete</button></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </form>

                    <form action="" method="post">
                            <input class="py-md-2 bg-light border border-less" style="border-radius:20px 20px 20px 20px;width:165px;" type="text" name="add_color" placeholder="Add new color . . . " required>
                            <input type="submit" name="submit_color" class="btn btn-success " value="Add">
                    </form>
                </div>
            </div>
        </div> 
    </div>
</div>

<?php require_once("footer.php");?>
