<?php // Do not put any HTML above this line
require_once "bootstrap.php";
session_start();

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to game.php
    header("Location: login.php");
    $_SESSION['error'] = "Please Login";
    return;
}



  // If we have no POST data 

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email'])) {
    if ( strlen($_POST['email']) < 1) {
        $_SESSION['error'] = "Email is required";
        header("Location:login.php");
        return;
    } else{
      
        $email = htmlentities($_POST['email']);
        // we can also use strpos() function
       $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";  
       if (!preg_match ($pattern, $email) ){  
          $_SESSION['error'] = "Email must have an at-sign (@)";
          header("Location: login.php");
          return;
   
       }  
       else{
        
            error_log("Login success ".$_POST['email']);
            $_SESSION['name'] = $_POST['email'];
            header("Location: proj.php");
            return;
            
        
    
        }         
    
}

}

// Fall through into the View
?>
<!DOCTYPE html>
<head> 
<title>Login Page</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" integrity="sha256-qM7QTJSlvtPSxVRjVWNM2OfTAz/3k5ovHOKmKXuYMO4=" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<br>

<?php
// Note triple not equals and think how badly double
// not equals would work here...
if ( isset($_SESSION['error']) ) {
  echo('<p style="color: yellow;">'.htmlentities($_SESSION['error'])."</p>\n");
  unset($_SESSION['error']);
}
?>
<form method="POST">
<label for="nam">Email:</label>
<input type="text" name="email" id="nam">
<br>
<br>
<input type="submit" value="Log In">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type ="submit" value="Cancel" name ="cancel">
</form>

</div>
<style>
.container{
  text-align: center;
}
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

