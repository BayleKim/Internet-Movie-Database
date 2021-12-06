<!DOCTYPE html>
<html>
<body>


<form action="movie.php" method="get">
MovieID: <input type="text" name="id"><br>
<input type="submit" value="submit">
</form>


<?php
echo "<h3>
Movie Information
</h3>";

$db = new mysqli('localhost', 'cs143', '', 'class_db');
if ($db->connect_errno > 0) { 
    die('Unable to connect to database [' . $db->connect_error . ']'); 
}    

$statement = $db->prepare("SELECT title, year,rating, company, genre FROM Movie M, MovieGenre MG WHERE M.id=MG.mid AND id=?");

$mid= $_GET["id"];

$statement->bind_param('i', $mid);
$statement->execute();
$statement->bind_result( $returned_title,$returned_year,$returned_rating,$returned_company,$returned_genre);
$statement->fetch();   

?>

Title : <?php echo $returned_title; ?><br>
Year : <?php echo $returned_year; ?><br>
Producer : <?php echo $returned_company; ?><br>
MPAA Rating : <?php echo $returned_rating; ?><br>
Genre : <?php echo $returned_genre; ?>



<?php

echo "<h3>Actors:</h3>";
echo "<table style ='width:100%' border='1'>
    <tr>
        <th>Name</th>
        <th>Role</th>
    </tr>";
$db = new mysqli('localhost', 'cs143', '', 'class_db');
if ($db->connect_errno > 0) { 
    die('Unable to connect to database [' . $db->connect_error . ']'); 
}    

$statement = $db->prepare("SELECT last, first,role, id FROM Actor A, MovieActor MA WHERE A.id=MA.aid AND mid=?");

$mid= $_GET["id"];

$statement->bind_param('i', $mid);
$statement->execute();
$statement->bind_result( $returned_last,$returned_first,$returned_role, $returned_aid);
while ($statement->fetch()) { 
     echo"<tr>";
     echo"<td>"."<a href=actor.php?id=$returned_aid> $returned_first $returned_last </a>"."</td>";
     echo"<td>".$returned_role."</td>";      
     echo"</tr>"; 
}
echo "</table>";

$statement->close();
$db->close();
?>



<?php
echo "<h3>User Review Information:</h3>";
$db = new mysqli('localhost', 'cs143', '', 'class_db');
if ($db->connect_errno > 0) { 
    die('Unable to connect to database [' . $db->connect_error . ']'); 
}    

$statement = $db->prepare("SELECT AVG(rating), COUNT(time) FROM Review  WHERE  mid=?");

$mid= $_GET["id"];

$statement->bind_param('i', $mid);
$statement->execute();
$statement->bind_result( $returned_rating_avg, $returned_rating_num);
$statement->fetch();

echo "Average score for this movie is &nbsp;". $returned_rating_avg." &nbsp;(Total Score is 5) based on&nbsp;". $returned_rating_num. "&nbsp;people's reviews<br>";  
echo "<a href=review.php?id=$mid> Welcome to rate and comment!</a>";
$statement->close();
$db->close();
?>

<?php
echo "<h3>User comments are as follows:</h3>";

$db = new mysqli('localhost', 'cs143', '', 'class_db');
if ($db->connect_errno > 0) { 
    die('Unable to connect to database [' . $db->connect_error . ']'); 
}    

$statement = $db->prepare("SELECT name, time, rating, comment FROM Review  WHERE  mid=?");

$mid= $_GET["id"];

$statement->bind_param('i', $mid);
$statement->execute();
$statement->bind_result( $returned_name,$returned_time,$returned_rating,$returned_comment);
while ($statement->fetch()) { 
     echo "<br>";
     echo $returned_name. "&nbsp;rates this movie with score&nbsp;".$returned_rating."&nbsp;and left a comment at&nbsp;".$returned_time."<br>";
     echo "comment:<br>";
     echo $returned_comment;
     echo "<br>";
}
$statement->close();
$db->close();
?>




</body>
</html >



