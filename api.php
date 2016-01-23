

<?php
header('Access-Control-Allow-Origin: *');	
session_start();




$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ocl";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);
} 

// sql to create table

$request = $_GET['req'];


if($request==1){
$fname=$_GET['fname'];
$lname=$_GET['lname'];
$gender=$_GET['gender'];
$email=$_GET['email'];
$password=$_GET['password'];
$gender=$_GET['gender'];
//$sql="INSERT INTO details VALUES('".$fname."','".$lname."','".$gender"','".md5($password)."','".$email."')";

$sql="INSERT INTO details (f_name,l_name,gender,password,email_id) VALUES('$fname','$lname','$gender','$password','$email')";





if ($conn->query($sql) === TRUE) {
    echo "Record inserted successfully";
} else {
    echo "Error creating table: " . $conn->error;

$conn->close();
}


}else if($request==2){ //for logins

$emailid=$_GET['emailid'];
$password=$_GET['password'];
//echo 'alert("'.$emailid.'")';
//echo 'alert("'.$password.'")';


$data = "SELECT * FROM details WHERE details.email_id ='". $emailid. "' AND details.password='".$password."'";


$result = $conn->query($data);

$outp = "[";

if ($result->num_rows > 0 ) {

//echo 'YES USER EXISTS';



while ($row1 = $result->fetch_assoc()) {

//echo $row1['id'];


if ($outp != "[") {$outp .= ",";}
    $outp .= '{"id":"'  . $row1["id"] . '",';
    $outp .= '"f_name":"'   . $row1["f_name"]        . '",';
	$outp .= '"img":"'   . $row1["img"]        . '",';
    $outp .= '"email_id":"'. $row1["email_id"]     . '"}'; 


$_SESSION['id1']=$row1['id'];




}
$outp .="]";
echo($outp);




}
else
{
//echo 'NO USER DOES NOT EXIST';

echo "False"; //user doesnt exist


}


$conn->close();

}else if($request==10){ //checking if email id exists
	
	$mail=$_GET['email'];
	
	$data = "SELECT * FROM details WHERE details.email_id ='".$mail."'";


$result = $conn->query($data);





if ($result->num_rows > 0 ) {

//echo 'YES USER EXISTS';


	echo "1";
	
	
}else{
	
	echo "0";
}
	
	
	$conn->close();
	
	
}else if($request==3){ //for logins


$data = "SELECT * FROM post ";

$result = $conn->query($data);

if ($result->num_rows > 0 ) {


while ($row1 = $result->fetch_assoc()) {

$data1="SELECT * FROM ans WHERE id='".$row1['id']."'";

$result1 = $conn->query($data1);


echo " <div class='card'  style='width:50%;'>
<ul>
<li style='float:left;'><img src=".$row1['img']." style='height:5%;width:8%;margin-top:4%;'></img><h2 style='margin-left:15%;margin-top:-8%;'>".$row1['name']."</h2><h4>".$row1['dat_e']."</h4></li>

<br><br><br><li> <br><h3>".$row1['qwe']."</h3>  </li>
<br>
";
while ($row2 = $result1->fetch_assoc()) {

echo "<h4>".$row2['name']."</h4><p> ".$row2['result']."</p><br>";




}





echo "
<li> <a>comment</a>  <a style='margin-left:30%;'>Voteup</a>       </li></ul>
</div>";





}
}
else
{

echo "False"; //user doesnt exist

}


$conn->close();

}
?>


