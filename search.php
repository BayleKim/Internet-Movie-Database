<!DOCTYPE html>
<html>
<body>


<form action="search.php" method="get">
<label for="actor">Input Actor Name:</label><br>
<input type="text" name="actor"><br>
<input type="submit"  value="Search Actor!">
</form>

<form action="search.php" method="get">
<label for="movie">Input Movie Name:</label><br>
<input type="text" name="movie"><br>
<input type="submit"  value="Search Movie!">
</form>

<?php 

echo "<h3> Matching actors are: </h3>";
echo "<table style ='width:100%' border='1'>
    <tr>
        <th>Name</th>
        <th>Date of Birth</th>
    </tr>";


$Aname= $_GET["actor"];
if (isset($Aname)){
    $Arr = explode(" ", $Aname);   // Convert string to array
    $Arr = array_filter($Arr);      //delete space in the array
    
foreach($Arr as $value)
    {
        $newArr[] = $value;
    }                                        //Cited from https://blog.csdn.net/stpeace/article/details/50742114

$newArr[2]=$newArr[0];
$newArr[0]=$newArr[1];
$newArr[1]='%';                   //  Replace first and last name order, and add '%' between them
$Aname_new=implode("",$newArr);    //  Convert array to string
$Aname=str_replace(" ","%","$Aname");    
$Aname1='%'.$Aname.'%';       
$Aname2='%'.$Aname_new.'%';      

$db = new mysqli('localhost', 'cs143', '', 'class_db');
if ($db->connect_errno > 0) { 
    die('Unable to connect to database [' . $db->connect_error . ']'); 
}    
$statement = $db->prepare("select * from (SELECT id, dob, CONCAT_WS(' ',first,last) AS name FROM Actor) AS T where name like '$Aname1' or name like '$Aname2'
");

$statement->execute();
$statement->bind_result( $returned_aid, $returned_dob,$returned_name);
while ($statement->fetch()) { 
     echo"<tr>";
     echo"<td>"."<a href=actor.php?id=$returned_aid> $returned_name </a>"."</td>";
     echo"<td>".$returned_dob."</td>";   
     echo"</tr>"; 
}
}
?>





<?php

echo "<h3> Matching movies are: </h3>";
echo "<table style ='width:100%' border='1'>
    <tr>
        <th>Title</th>
        <th>Year</th>
    </tr>";


$Mname= $_GET["movie"];
if (isset($Mname)){
    $Arr1 = explode(" ", $Mname);   // Convert string to array
    $Arr1 = array_filter($Arr1);      //delete space in the array
    
foreach($Arr1 as $value)
    {
        $newArr1[] = $value;
    }                                        

$Mname0=(string)$newArr1[0];
$Mname1=(string)$newArr1[1];
$Mname2=(string)$newArr1[2]  ;     

$Mname00='%'.$Mname0.'%';       
$Mname11='%'.$Mname1.'%';      
$Mname22='%'.$Mname2.'%';

$db = new mysqli('localhost', 'cs143', '', 'class_db');
if ($db->connect_errno > 0) { 
    die('Unable to connect to database [' . $db->connect_error . ']'); 
}    
$statement = $db->prepare("select id, title, year from Movie where title like '$Mname00' and title like '$Mname11' and title like '$Mname22'
");

$statement->execute();
$statement->bind_result( $returned_mid, $returned_title,$returned_year);
while ($statement->fetch()) { 
     echo"<tr>";
     echo"<td>"."<a href=movie.php?id=$returned_mid> $returned_title </a>"."</td>";
     echo"<td>".$returned_year."</td>";   
     echo"</tr>"; 
}
}
?>




</body>
</html>
