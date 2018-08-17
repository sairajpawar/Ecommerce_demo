<?php
session_start();
if(!$_SESSION['logout_session']){
	header("location: index.php");
}
else{
include("../connection.php");

if(isset($_GET['del'])){
	$del_mem = mysqli_real_escape_string($con,$_GET['del']);
	$query = "delete FROM info WHERE ID = '$del_mem'";
	if(mysqli_query($conn,$query)){
		echo "<script>window.open('membersinfo.php','_self')</script>";
	}
}	
?>
<html>
<body>

<a href="adminpanel.php">back to home</a>
<h1 align='center'><font size='6' face='comic sans MS'><u>MEMBERS INFORMATION</u></font></h1><br/><br/><br/>

<table width='2000' align='center' border='5'>
     <tr bgcolor='red'>
	     <th>NO.</th>
		 <th>NAME </th>
		 <th>USERNAME</th>
		 <th>PASSWORD</th>
		 <th>HASH</th>
		 <th>SALT</th>
		 <th>CONTACT</th>
		 <th>DATE</th>
		 <th>DELETE</th>
	 </tr>
	
<?php

    $query = "SELECT * FROM info";
	$run=mysqli_query($con,$query);
	while ($row=mysqli_fetch_array($run)){
		
		$id=$row[0];
		$name=$row[1];
		$username=$row[4];
		$password=$row[5];
		$hash=$row[6];
		$salt=$row[7];
		$telephone=$row[2];
		$date=$row[9];

?>
     <tr align='center'>
     <td><?php echo $id; ?></td>
	 <td><?php echo $name; ?></td>
	
	 <td><?php echo $username; ?></td>
	 <td><?php echo $password; ?></td>
	 <td><?php echo $hash; ?></td>
	 <td><?php echo $salt; ?></td>
	 <td><?php echo $telephone; ?></td>
	 <td><?php echo $date; ?></td>
	 <td><a href='membersinfo.php?del=<?php echo $id; ?>'>DELETE</td>
	 </tr>
	<?php }
}	
	//session_destroy();
	?>

</table>
</body>
</html>

