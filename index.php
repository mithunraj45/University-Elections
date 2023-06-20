 <?php
  require("header.php");
  require_once("Database/connection.php");
  connect_db();
 
 ?>
 
    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-white text-center" style="background-image: linear-gradient(rgba(0,0,0,0.50),rgb(0,0,0,0.50)),url(Images/9.png);background-position:left;background-size: cover;">
      <div class="col-md-5 p-lg-5 mx-auto my-5">
        <h1 class="display-5 font-weight-normal">University Elections</h1>
        <p class="lead font-weight-normal">Voting is the most powerful right of every citizen and it is our duty to exercise our vote.</p>
        <a class="btn btn-outline-primary" href="election.php">Explore Now</a>
      </div>
      <!-- <div class="product-device box-shadow d-none d-md-block"></div> -->
      <!-- <div class="product-device product-device-2 box-shadow d-none d-md-block"></div> -->
    </div>



<?php
  require("footer.php"); 
 ?>