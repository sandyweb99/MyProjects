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
if ( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_REQUEST['user_id']))
    {

     if((strlen($_POST['make']) < 1) || (strlen($_POST['model']) < 1) || (strlen($_POST['year']) < 1) || (strlen($_POST['mileage']) < 1))
     {
        $_SESSION['error'] = "All fields are required";
        header("Location: edit.php?user_id=".htmlentities($_REQUEST['user_id']));
        return;
     }
     else if( !is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])){
          $_SESSION['error'] = "Mileage and year must be an integer";
          header("Location: edit.php?user_id=".htmlentities($_REQUEST['user_id']));
          return;
     } 
     else { 
        $make = htmlentities($_POST['make']);
        $model = htmlentities($_POST['model']);
        $year = htmlentities($_POST['year']);
        $mileage = htmlentities($_POST['mileage']); 
        $user_id= htmlentities($_REQUEST['user_id']);          
        $sql = "UPDATE users SET Make = :mk, Model = :md, Year = :yr, Mileage = :mi WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':mk' => $make,
            ':md' => $model,
            ':yr' => $year,
            ':mi' => $mileage,
            ':user_id' => $user_id));
         $_SESSION['success'] = 'Record updated';
         header( 'Location: index.php' ) ;
         return;
      }
  
}
// Guardian: Make sure that user_id is present
if ( ! isset($_GET['user_id']) ) {
  $_SESSION['error'] = "Missing user_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM users where user_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['user_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for user_id';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern


$m = htmlentities($row['make']);
$n = htmlentities($row['model']);
$y = htmlentities($row['year']);
$a = htmlentities($row['mileage']);
$user_id = $row['user_id'];
?>
<!DOCTYPE html>
<head><title>R Santhosh Kumar's Automobile Tracker</title></head>
<body>
<div class="container">
<h1>Editing Automobile</h1>
<?php
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
?>
<form method="post">
<p>Make:
<input type="text" name="make" value="<?= $m ?>"></p>
<p>Model:
<input type="text" name="model" value="<?= $n ?>"></p>
<p>Year:
<input type="text" name="year" value="<?= $y ?>"></p>
<p>Mileage:
<input type="text" name="mileage" value="<?= $a?>"></p>
<input type="hidden" name="user_id" value="<?= $user_id ?>">
<p><input type="submit" name="update" value="Save"/>
<input type="submit" name="Cancel" value="Cancel"></p>
</form>
</div>


</body>
</html>
