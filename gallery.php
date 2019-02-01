<?php

session_start();
include('config/database.php');
include('config/functions.php');

function paginate($num){
  $counter = 1;
  $pages = intdiv($num, 5);
  if ($num % 5 > 0){
    $pages = $pages + 1;
  }
  while($counter <= $pages){
    echo '<li class="page-item"><a class="page-link" href="gallery.php?page='.$counter.'">'.$counter.'</a></li>';
    $counter = $counter + 1;
  }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Account</title>

    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Camagru</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
          <?php
            if(loggedIn()){
                echo '<li><a href="logout.php">Logout</a></li>';
                echo '<li><a href="myaccount.php">My Account</a></li>';
                echo '<li><a href="user_preferences.php">User Preferences</a></li>';
            }
            else {
                echo '<li><a href="index.php">Login</a></li>';
                echo '<li><a href="register.php">Register</a></li>';
            }
            ?>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">
        <div class="jumbotron">
            <h2>Welcome <?php
            if (loggedIn()){ 
                if(isset($_SESSION['user_email'])){
                    echo $_SESSION['user_email'];
                }
                else if(isset($_COOKIE['user_email'])){
                    echo $_COOKIE['user_email'];
                }
                else echo "Guest";
            }
            ?>
            </h2>
        </div>
    </div>
    <?php if(isset($_GET['success'])) { ?>

        <div class="alert alert-success"><?php echo $_GET['success']; ?></div>

    <?php } ?>

    <?php if(isset($_GET['err'])) { ?>

        <div class="alert alert-danger"><?php echo $_GET['err']; ?></div>

    <?php } ?>
    </br>
    <div position="relative">
        <?php
            try {
              $results = $conn->prepare("SELECT * FROM `gallery` ORDER by id DESC");
              $results->execute();
              $rows = $results->fetchAll();
              $count = $results->rowCount();
              foreach($rows as $key => $value){
                if (isset($_GET['page'])){
                  $page = $_GET['page'];
                }
                else $page = 1;
                if ($key <= ($page * 5) - 1 && $key >= ($page * 5 - 5)){
                  echo '<div style="position:relative;float:left;">
                          <a href="comments.php?id='.$value['id'].'"><img src="'.$value['photo'].'"/></a>
                          <h4><div style="position: absolute;width:400px;height:40px;bottom:0px;background-color:black;opacity:0.5;color:#f1f1f1;">'.$value['username'].'</h4></div>
                        </div>';
                }
              }
            }
            catch(PDOException $e)
            {
              echo "Error: " . $e->getMessage();
            }
        ?>
    </div>
    <div position="absolute">
        <nav aria-label="Page navigation example">
          <ul class="pagination">
          <?php
            paginate($count);
          ?>
          </ul>
        </nav>
    </div>

  </body>
</html>