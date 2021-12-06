<html>
<body>

<?php
echo "<h2>
Add a new comment  
</h2>";
?>


<?php 
$parameter=$_SERVER["QUERY_STRING"];
$url= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
parse_str(parse_url($url)['query'],$query_arr);
$mid0= $query_arr['id'];
$name0=$query_arr['name'];
$rating0=$query_arr['rating'];
$comment0=$query_arr['comment'];

if(isset($comment0)){
$db = new mysqli('localhost', 'cs143', '', 'class_db');
if ($db->connect_errno > 0) { 
    die('Unable to connect to database [' . $db->connect_error . ']'); 
}    

$statement = $db->prepare("INSERT INTO Review VALUES(?,now(), ?,?,?) ");
$statement->bind_param('siis', $name0,$mid0,$rating0,$comment0);
$statement->execute();
echo "Thanks for your comment! Your review has been successfully added.";
}
?>



















<?php $parameter=$_SERVER["QUERY_STRING"];
$url= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
parse_str(parse_url($url)['query'],$query_arr);
$mid1= $query_arr['id'];
?>

<form action="" method="post">

Your Name:<input type="text" name="name" ><br>
Rating:<SELECT name="rating">
    <OPTION>1</OPTION>
    <OPTION>2</OPTION>
    <OPTION>3</OPTION>
    <OPTION>4</OPTION>
    <OPTION>5</OPTION>
</SELECT><br>
Comment: <input type="text" name="comment" style="width:1000px;"><br>
<input type="submit" name="SubmitButton" value="submit">
<input type="hidden" name="mid" value=<?php echo "$mid" ?>>
</form>



<?php if(isset($_POST['SubmitButton'])){ 
     echo "Thanks for your comment! Your review has been successfully added.";
$db = new mysqli('localhost', 'cs143', '', 'class_db');
if ($db->connect_errno > 0) { 
    die('Unable to connect to database [' . $db->connect_error . ']'); 
}    

$webID=$_POST["mid1"];
$name1=$_POST["name"];
$rating1=$_POST["rating"];
$comment1=$_POST["comment"];
$statement = $db->prepare("INSERT INTO Review VALUES(?,now(), ?,?,?) ");
$statement->bind_param('siis', $name1,$webID,$rating1,$comment1);
$statement->execute();


} 
?>






</body>
</html>
