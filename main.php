<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
  header("location: login.php");
  exit;
}
?>

<?php
// connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";
$insert = false;
$update = false;
$delete = false;
// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Die if connection was not successful
if (!$conn){
    die("Sorry, we failed to connect: ". mysqli_connect_error());
}
if(isset($_GET['delete'])){
  $sno = $_GET["delete"];
  // deleting the data
  $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
  $result = mysqli_query($conn, $sql);
  if($result){
    $delete = true;
}else{
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Failed!</strong> Unable to delete. Reason: " .   mysqli_error($conn) . " 
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
}
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['snoEdit'])){
    $sno = $_POST["snoEdit"];
    $title = $_POST["titleEdit"];
    $description = $_POST["descriptionEdit"];
    // updating the data
    $sql = "UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`sno` = '$sno'";
    $result = mysqli_query($conn, $sql);
    if($result){
      $update = true;
  }else{
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Failed!</strong> Unable to update. Reason: " .   mysqli_error($conn) . " 
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
  }
  }
  else{
    $title = $_POST["title"];
    $description = $_POST["description"];
    // inserting the data
    $sql = "INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
    $result = mysqli_query($conn, $sql);
    if($result){
        $insert = true;
    }else{
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Failed!</strong> Unable to add. Reason: " .   mysqli_error($conn) . " 
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
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
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>ToDo Notes, Welcome - <?php echo $_SESSION['username'] ?></title>
  </head>
  <body>
<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/LoginSystemWithApp/main.php" method="POST">
        <div class="modal-body">
              <input type="hidden" name="snoEdit" id="snoEdit">
              <div class="mb-3">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
              </div>
              <div class="mb-3">
                  <label for="description" class="form-label">Note Description</label>
                  <textarea class="form-control" name="descriptionEdit" id="descriptionEdit" rows="3"></textarea>
                </div>
        </div>
        <div class="modal-footer d-block mr-auto">
          <button type="submit" class="btn btn-primary">Save changes</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="/LoginSystemWithApp/main.php"> <img src="/LoginSystemWithApp/logo.png" height="45px" style="margin:auto; padding:0px" alt=""> </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/LoginSystemWithApp/main.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact us</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Operations
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="#">Add</a></li>
                  <li><a class="dropdown-item" href="#">Update</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#">Delete</a></li>
                </ul>
              </li>
            </ul>
            <form class="d-flex">
              <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <a class="nav-link" href="/LoginSystemWithApp/logout.php">Logout</a>
                </li>
              </ul>
            </form>
          </div>
        </div>
      </nav>
      <?php
      if($insert){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been added successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
      }
      ?>
      <?php
      if($update){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been updated successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
      }
      ?>
      <?php
      if($delete){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been deleted successfully.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
      </div>";
      echo "<script>
       del = setTimeout(function () {
         window.location.href= '/LoginSystemWithApp/main.php';
      }, 1800);
      </script>";
    }
      ?>
      <div class="container my-4">
          <h2>Add a Note</h2>
        <form action="/LoginSystemWithApp/main.php" method="POST">
            <div class="mb-3">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" name="title" class="form-control" id="title" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Note Description</label>
                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
              </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
          </form>
      </div>
      <div class="container my-4">
      <table class="table" id="myTable">
      <hr>
            <thead>
              <tr>
                <th scope="col">S.No</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT * FROM `notes`";
            $result = mysqli_query($conn, $sql);
            $sno = 0;
            while($row = mysqli_fetch_assoc($result)){
              $sno =  $sno+1;
             echo "<tr>
                <th scope='row'>" . $sno . "</th>
                <td>" . $row['title'] . "</td>
                <td>" . $row['description'] . "</td>
                <td> <button id=" . $row['sno'] . " class='edit btn btn-sm btn-primary'>Edit</button> <button id=d" . $row['sno'] . " class='delete btn btn-sm btn-primary'>Delete</button> </td>
              </tr>";
            }
            ?>
            </tbody>
            
          </table>
      </div>
      <hr>
    <!-- Optional JavaScript; choose one of the two! -->
    <script
    src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs="
    crossorigin="anonymous"></script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready( function () {
        $('#myTable').DataTable();
      } );
    </script>
    <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) =>{
      element.addEventListener("click", (e)=>{
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        desc = tr.getElementsByTagName("td")[1].innerText;
        titleEdit.value = title;
        descriptionEdit.value = desc;
        snoEdit.value = e.target.id;
        $('#editModal').modal('toggle');
      });
    })
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) =>{
      element.addEventListener("click", (e)=>{
        sno = e.target.id.substr(1,);
        if(confirm("Are you want to delete?")){
          window.location = `/LoginSystemWithApp/main.php?delete=${sno}`;
        }
      });
    })
    </script>
    <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script>
  </body>
</html>