<?php
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
  $loggedin = true;
}else{
  $loggedin = false;
}

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid py-2">
    <a class="navbar-brand" href="/LoginSystemWithApp/index.php">iSecure</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">';
      if(!$loggedin){
        echo '<li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/LoginSystemWithApp/main.php">ToDo App</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/LoginSystemWithApp/login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/LoginSystemWithApp/signup.php">Signup</a>
        </li>
       </ul>';
      }
      if($loggedin){
        echo'<form class="d-flex">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="/LoginSystemWithApp/logout.php">Logout</a>
          </li>
        </ul>
        </form>';
      }
    echo '</div>
  </div>
</nav>';

?>