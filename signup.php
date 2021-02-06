<?php
$showAlert = false;
$showError1 = false;
$showError2 = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
  
  require "com/dbconnect.php";
  $uname = $_POST["uname"];
  $pass = $_POST["password"];
  $cpass = $_POST["cpassword"];

  $existSql = "SELECT * FROM `users` WHERE `uname` ='$uname'";
  $result = mysqli_query($conn, $existSql);
  $numExistRows = mysqli_num_rows($result);

  if($numExistRows > 0){
    $showError2 = true;
  }else{
    if(($pass == $cpass)){
      $hashPass = password_hash($pass, PASSWORD_DEFAULT);
      $sql = "INSERT INTO `users` (`uname`, `password`, `date`) VALUES ('$uname', '$hashPass', current_timestamp())";
      $result = mysqli_query($conn, $sql);
      if($result){
        $showAlert = true;
      }
    }else{
      $showError1 = true;
    }
  }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>Signup</title>
  </head>
  <body>
    <?php
    require 'com/_nav.php';
    ?>
    <?php

    if($showAlert){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong> Your account has been created, now you can login.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if($showError1){
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error!</strong> Password do not match.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    if($showError2){
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error!</strong> User already exists.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    ?>
    <div class="container mt-4 col-md-3">
    <h1 class="text-center mb-4">Please Signup</h1>

    <form action="/LoginSystemWithApp/signup.php" method="POST">
        <div class="mb-3">
            <label for="uname" class="form-label">Username</label>
            <input type="text" maxlength="11" class="form-control" id="uname" name="uname" aria-describedby="emailHelp">
            
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" maxlength="24" name="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="mb-3">
            <label for="cpassword" class="form-label">Confirm Password</label>
            <input type="password" maxlength="24" class="form-control" name="cpassword" id="cpassword">
        </div>
        <button type="submit" class="btn btn-primary">Signup</button>
        </form>
    </div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
    -->
  </body>
</html>