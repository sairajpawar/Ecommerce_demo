<?php
session_start();
include("../connection.php");
?>
<html>
<body>
<table align="center" width="750" border="2" bgcolor="orange">
	<tr>
		<td align="center"><b>Select College: </b></td>
		<td> 
		<select name="select_colg" onchange="location = this.options[this.selectedIndex].value;">
		<?php
		if(isset($_GET['col_id'])){
			$id = $_GET['col_id'];
			$_SESSION["colg"] = $id;
			$_SESSION['bran'] = "";
			$_SESSION['div'] = "";
		}
		if(isset($_GET['us'])){
			$_SESSION["colg"] = "";
			echo"<script>window.open('ddexample.php','_self')</script>";
		}
		?>
		<?php  
			$query = "SELECT * FROM colleges";
			$result = mysqli_query($con,$query);
			$cid = $_SESSION["colg"];
			echo "<option value='ddexample.php?us=1'>Select College</option>";
			while($rows = mysqli_fetch_assoc($result)){
				$colg_id = $rows['ID'];
				$colg_name = $rows['COLLEGE'];
				if($colg_id == $cid){
					$selected = "selected";
				}else{
					$selected = "";
				}
			   echo"<option value='ddexample.php?col_id=$colg_id' $selected >$colg_name</option>";
			}
		?>
		</select>
		</td>
	</tr>
	
	<tr>
		<td align="center"><b>Select Branch: </b></td>
		<td> 
		<select name="select_bran" onchange="location = this.options[this.selectedIndex].value;">
		<?php
		if(isset($_GET['bran_id'])){
			$id = $_GET['bran_id'];
			$_SESSION["bran"] = $id;
			$_SESSION['div'] = "";
		}
		if(isset($_GET['us'])){
			$_SESSION["bran"] = "";
			echo"<script>window.open('ddexample.php','_self')</script>";
		}
		?>
		<?php  
			$query = "SELECT * FROM branches WHERE COLLEGE=$cid";
			$result = mysqli_query($con,$query);
			$bid = $_SESSION["bran"];
			echo "<option value='ddexample.php?us=1'>Select Branch</option>";
			while($rows = mysqli_fetch_assoc($result)){
				$bran_id = $rows['ID'];
				$bran_name = $rows['BRANCH'];
				if($bran_id == $bid){
					$selected = "selected";
				}else{
					$selected = "";
				}
			   echo"<option value='ddexample.php?bran_id=$bran_id' $selected >$bran_name</option>";
			}
		?>
		</select>
		</td>
	</tr>
	
	<tr>
		<td align="center"><b>Select Division: </b></td>
		<td> 
		<select name="select_div" onchange="location = this.options[this.selectedIndex].value;">
		<?php
		if(isset($_GET['div_id'])){
			$id = $_GET['div_id'];
			$_SESSION["div"] = $id;
		}
		if(isset($_GET['us'])){
			$_SESSION["div"] = "";
			echo"<script>window.open('ddexample.php','_self')</script>";
		}
		?>
		<?php  
			$query = "SELECT * FROM division WHERE BRANCH=$bid";
			$result = mysqli_query($con,$query);
			$did = $_SESSION["div"];
			echo "<option value='ddexample.php?us=1'>Select Division</option>";
			while($rows = mysqli_fetch_assoc($result)){
				$div_id = $rows['ID'];
				$div_name = $rows['DIVISION'];
				if($div_id == $did){
					$selected = "selected";
				}else{
					$selected = "";
				}
			   echo"<option value='ddexample.php?div_id=$div_id' $selected >$div_name</option>";
			}
		?>
		</select>
		</td>
	</tr>
</table>
<?php

echo @$_SESSION['colg'];
echo "<br>";
echo @$_SESSION['bran'];
echo "<br>";
echo @$_SESSION['div'];
?>




</table>
</body>
</html>