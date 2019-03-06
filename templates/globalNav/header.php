<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title><?php $title ?></title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

  <!-- Custom styles for this template -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="../assets/css/main.css" type="text/css" rel="stylesheet">
    <link href="css/scrolling-nav.css" rel="stylesheet">
</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">Good Day, <?php echo $_SESSION['username']?>!</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="events.php">Events</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="registrations.php">Registrations</a>
          </li>
            <?php
                if(isset($_SESSION['event_manager_loggedin']) && $_SESSION['event_manager_loggedin'] === true || isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] === true) {
                    echo "<li class='nav-item'>
                                <a class='nav-link js-scroll-trigger' href='admin.php'>Admin</a>
                               </li>";
                }
            ?>
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="../phpScripts/logout.php">Logout</a>
            </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <!-- Plugin JavaScript -->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom JavaScript for this theme -->
  <script src="js/scrolling-nav.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" src="../assets/js/ajaxHelpers.js"></script>

