<?php
require_once "pdo.php";
require_once "bootstrap.php";
session_start();
if (!isset($_SESSION['name']))
{
echo '<html>';
echo '<head>';
echo "<title>R Santhosh Kumar's Index Page</title>";
echo'</head><body>';
echo '<div class="container">';
echo '<h1>Welcome to the Automobiles Database</h1>';
echo '<p><a href="login.php">Please log in</a></p>';
echo '<p>Attempt to <a href="add.php">add data</a> without logging in</p>';
echo '</div>';
}
else {
echo '<div class = "container">';
echo '<h1>Welcome to the Automobiles Database</h1>';
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}

$stmt2 = $pdo->query("SELECT make, model, year, mileage, user_id FROM users");
$stmt3 = $pdo->query("SELECT COUNT(user_id) FROM users");
$row1 = $stmt3->fetch(PDO::FETCH_ASSOC);
$count = implode($row1);
if($count == 0)
{
    echo "<p> No rows found </p>";
}
else
{
echo('<table border="1">'."\n"); 
echo("<tr><th>");
echo("Make");
echo("</th><th>");
echo("Model");
echo("</th><th>");
echo("Year");
echo("</th><th>");
echo("Mileage");
echo("</th><th>");
echo("Action");
echo("</th></tr>");
while ( $row = $stmt2->fetch(PDO::FETCH_ASSOC) ) {
    echo "<tr><td>";
    echo(htmlentities($row['make']));
    echo("</td><td>");
    echo(htmlentities($row['model']));
    echo("</td><td>");
    echo(htmlentities($row['year']));
    echo("</td><td>");
    echo(htmlentities($row['mileage']));
    echo("</td><td>");
    echo('<a href="edit.php?user_id='.$row['user_id'].'">Edit</a> / ');
    echo('<a href="delete.php?user_id='.$row['user_id'].'">Delete</a>');
    echo("</td></tr>\n");
}
}

echo('</table>'."\n");
echo '<p><a href="add.php">Add New Entry</a></p>';
echo '<p><a href="logout.php">Logout</a></p>';
echo '<p>';
echo '<b>Note:</b> Your implementation should retain data across multiple 
logout/login sessions.  This sample implementation clears all its
data on logout - which you should not do in your implementation.
</p>';

echo '</div>';
}


echo '</body>';
echo '</html>';

?>

