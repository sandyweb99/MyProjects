<?php
require_once "pdo.php";


session_start();
if ( ! isset($_SESSION['name']) ) {
    die("ACCESS DENIED");
}


if ( isset($_POST['Cancel']) ) {
    header('Location: proj.php');
    return;
}

if( isset($_POST['task']))
 {
     if((strlen($_POST['task']) < 1))
     {
        $_SESSION['error'] = "field is required";
        header("Location:add.php");
        return;
     }
     else if( is_numeric($_POST['task'])){
          $_SESSION['error'] = "Task must not be numeric";
          header("Location: add.php");
          return;
     } 
    else{
      $task = htmlentities($_POST['task']);
          if( isset($_POST['Add'])) {
                    $stmt = $pdo->prepare('INSERT INTO task(task) VALUES ( :tk)');
                    $rows = $stmt->execute(array(
                         ':tk' => $task,
                        ));
                  
                    $_SESSION['success'] = "task added";
                    header("Location: proj.php");
                    return;
        }      
    }     

}


?>
<!DOCTYPE html>
<html>
<head>
<title>Add Page</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" integrity="sha256-qM7QTJSlvtPSxVRjVWNM2OfTAz/3k5ovHOKmKXuYMO4=" crossorigin="anonymous"></script>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>
<?php
if ( isset($_SESSION['name']) ) {
    echo "<p>ToDo List for ";
    echo htmlentities($_SESSION['name']);
    echo "</p>\n";
}
?>
</h1>
<?php
if ( isset($_SESSION['error']) ) {
  echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
  unset($_SESSION['error']);
}
?>
<form method="post">
<p>ToDo Task:
<input type="text" name="task" size="60"/></p>
<input type="submit" name= "Add" value="Add">
<input type="submit" name="Cancel" value="Cancel">
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