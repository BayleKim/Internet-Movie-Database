<!DOCTYPE html>
<html>
<body>

<form action="actor.php" method="get">
ActorID: <input type="text" name="id"><br>
<input type="submit" value="submit">
</form>


<?php
$db = new mysqli('localhost', 'cs143', '', 'class_db');
if ($db->connect_errno > 0) { 
    die('Unable to connect to database [' . $db->connect_error . ']'); 
}    

$statement = $db->prepare("SELECT last, first, sex, dob,dod FROM Actor WHERE id=?");

$aid= $_GET["id"];

$statement->bind_param('i', $aid);
$statement->execute();
$statement->bind_result( $returned_last,$returned_first,$returned_sex,$returned_dob,$returned_dod);
$statement->fetch();   

?>

<table style ="width:100%" border='1'>
    <tr>
        <th>Name</th>
        <th>Sex</th>
        <th>Date of Birth</th>
        <th>Date of Death</th>
    </tr>
    <tr>
        
        <td><?php echo $returned_first.' '. $returned_last ?></td>
        <td><?php echo $returned_sex ?></td>
        <td><?php echo $returned_dob ?></td>
        <td><?php echo $returned_dod ?></td>
    </tr>
</table> 

<?php
$db = new mysqli('localhost', 'cs143', '', 'class_db');
if ($db->connect_errno > 0) { 
    die('Unable to connect to database [' . $db->connect_error . ']'); 
}    

$statement = $db->prepare("SELECT role, title, mid FROM Movie M, MovieActor MA WHERE M.id=MA.mid AND aid=?");
$aid= $_GET["id"];

$statement->bind_param('i', $aid);
$statement->execute();
$statement->bind_result( $returned_role,$returned_title, $returned_mid);

?>

<table  style ="width:100%" border='1'>
    <tr>
        <th>Role</th>
        <th>Movie</th>
    </tr>


<?php 
while ($statement->fetch()) { 
     
     echo"<tr>";
     echo"<td>".$returned_role."</td>";
     echo"<td>"."<a href=movie.php?id=$returned_mid> $returned_title </a>"."</td>";
     echo"</tr>";

}
$statement->close();
$db->close();
?>



</table> 
</body>
</html >