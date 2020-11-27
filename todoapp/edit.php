<?php
require_once "pdo.php";
require_once "bootstrap.php";
session_start();
if ( ! isset($_SESSION['name']) ) {
    die("ACCESS DENIED");
}
if (isset($_POST['Cancel'])){
    header("Location:index.php");
    return;
}
if ( isset($_POST['task']))
    {

     if((strlen($_POST['task']) < 1))
     {
        $_SESSION['error'] =  "field is required";
        header("Location: edit.php?task_id=".htmlentities($_REQUEST['task_id']));
        return;
     }
     else if( is_numeric($_POST['task'])){
          $_SESSION['error'] = "task must not be an integer";
          header("Location: edit.php?task_id=".htmlentities($_REQUEST['task_id']));
          return;
     } 
     else { 
        $task = htmlentities($_POST['task']); 
        $task_id= htmlentities($_REQUEST['task_id']);          
        $sql = "UPDATE task SET task = :tk WHERE task_id = :task_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':tk' => $task,
            ':task_id' => $task_id));
         $_SESSION['success'] = 'task updated';
         header( 'Location: index.php' ) ;
         return;
      }
  
}
// Guardian: Make sure that user_id is present
if ( ! isset($_GET['task_id']) ) {
  $_SESSION['error'] = "Missing task_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT task, task_id FROM task where task_id = :tk");
$stmt->execute(array(":tk" => $_GET['task_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for task_id';
    header( 'Location: index.php' ) ;
    return;
}


$t = htmlentities($row['task']);
$task_id = $row['task_id'];
?>
<!DOCTYPE html>
<head><title>Edit Page</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" integrity="sha256-qM7QTJSlvtPSxVRjVWNM2OfTAz/3k5ovHOKmKXuYMO4=" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
<h1>Editing </h1>
<?php
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
?>
<form method="post">
<p>Task:
<input type="text" name="task" value="<?= $t ?>"></p>
<input type="hidden" name="task_id" value="<?= $task_id ?>">
<p><input type="submit" name="update" value="Save"/>
<input type="submit" name="Cancel" value="Cancel"></p>
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
