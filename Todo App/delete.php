<?php
require_once "pdo.php";
require_once "bootstrap.php";

session_start();
if ( isset($_POST['cancel']) ) {
    header('Location: proj.php');
    return;
}
if ( isset($_POST['delete']) && isset($_REQUEST['task_id']) ) {
    $sql = "DELETE FROM task WHERE task_id = :tk";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':tk' => $_POST['task_id']));
    $_SESSION['success'] = 'task deleted';
    header( 'Location: proj.php' ) ;
    return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['task_id']) ) {
  $_SESSION['error'] = "Missing task_id";
  header('Location: proj.php');
  return;
}

$stmt = $pdo->prepare("SELECT task, task_id FROM task where task_id = :tk");
$stmt->execute(array(":tk" => $_GET['task_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for task_id';
    header( 'Location: proj.php' ) ;
    return;
}

?>

<!DOCTYPE html>
<head><title>Deleting Page</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" integrity="sha256-qM7QTJSlvtPSxVRjVWNM2OfTAz/3k5ovHOKmKXuYMO4=" crossorigin="anonymous"></script>
</head>
<body>
<div class = "container">
<form method="post">
<input type="hidden" name="task_id" value="<?= $row['task_id'] ?>">
<p>Confirm: Deleting <?= htmlentities($row['task']) ?></p>
<input type="submit" value="Delete" name="delete">
<input type="submit" name="cancel" value ="Cancel">
</form>
</div>
<style>
body {
  background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
  background-size: 400% 400%;
  animation: gradient 15s ease infinite;
}
@keyframes gradient {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
}
.container{
  margin: 5% 50% 5% 30%;
  width: 700px;
  height: 300px;  
  padding: 50px;
  border: 3px solid red;
  box-sizing: border-box;
  background-color: orange;
}
</style>
</body>
</html>