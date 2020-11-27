<?php
require_once "pdo.php";


session_start();
if ( ! isset($_SESSION['name']) ) {
    die("ACCESS DENIED");
}
if ( isset($_POST['Cancel']) ) {
    header('Location: index.php');
    return;
}
if ( isset($_POST['logout']) ) {
    header('Location: logout.php');
    return;
}
if ( isset($_POST['add']) ) {
    header('Location: add.php');
    return;
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Main Page</title>
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
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}
$stmt2 = $pdo->query("SELECT task, task_id FROM task");
$stmt3 = $pdo->query("SELECT COUNT(task_id) FROM task");
$row1 = $stmt3->fetch(PDO::FETCH_ASSOC);
$count = implode($row1);
if($count == 0)
{
    echo '<p style="color:red;"> No rows found </p>';
}
else
{
echo('<table border="2">'."\n"); 
echo("<tr><th>");
echo("task");
echo("</th><th>");
echo("Action");
echo("</th></tr>");
while ( $row = $stmt2->fetch(PDO::FETCH_ASSOC) ) {
    echo "<tr><td>";
    echo(htmlentities($row['task']));
    echo("</td><td>");
    echo('<a href="edit.php?task_id='.$row['task_id'].'">Edit</a> / ');
    echo('<a href="delete.php?task_id='.$row['task_id'].'">Delete</a>');
    echo("</td></tr>\n");
}
}

echo('</table>'."\n");
?>
<br>
<form method="POST">
<input type="submit" name="add" value="Add">
<input type="submit" name= "logout" value="logout">
<input type = "submit" name= "Cancel" value = "Cancel">
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
table, th, td{
  border: 1px solid black;
  border-collapse: separate;
  width: 50%;
  height: 10%;
}
</style>

</body>
</html>