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

if( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])) 
 {
     if((strlen($_POST['make']) < 1) || (strlen($_POST['model']) < 1) || (strlen($_POST['year']) < 1) || (strlen($_POST['mileage']) < 1))
     {
        $_SESSION['error'] = "All fields are required";
        header("Location:add.php");
        return;
     }
     else if( !is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])){
          $_SESSION['error'] = "Mileage and year must be numeric";
          header("Location: add.php");
          return;
     } 
    else{
      $make = htmlentities($_POST['make']);
      $model = htmlentities($_POST['model']);
      $year = htmlentities($_POST['year']);
      $mileage = htmlentities($_POST['mileage']);
          if( isset($_POST['Add'])) {
                    $stmt = $pdo->prepare('INSERT INTO users(make, model, year, mileage) VALUES ( :mk, :md, :yr, :mi)');
                    $rows = $stmt->execute(array(
                         ':mk' => $make,
                         ':md' => $model,
                         ':yr' => $year,
                         ':mi' => $mileage
                        ));
                  
                    $_SESSION['success'] = "Record added";
                    header("Location: index.php");
                    return;
        }      
    }     

}


?>
<!DOCTYPE html>
<html>
<head>
<title>R Santhosh Kumar's Automobile Tracking Database</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>
<?php
if ( isset($_SESSION['name']) ) {
    echo "<p>Tracking Autos for ";
    echo htmlentities($_SESSION['name']);
    echo "</p>\n";
}
?>
</h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( isset($_SESSION['error']) ) {
  echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
  unset($_SESSION['error']);
}
?>
<form method="post">
<p>Make:
<input type="text" name="make" size="60"/></p>
<p>Model:
<input type="text" name="model" size="60"/></p>
<p>Year:
<input type="text" name="year"/></p>
<p>Mileage:
<input type="text" name="mileage"/></p>
<input type="submit" name= "Add" value="Add">
<input type="submit" name="Cancel" value="Cancel">
</form>
</div>


</body>
</html>