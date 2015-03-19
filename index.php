<?php
	include("head.php");
?>
<html>
	<head>
		<title>web</title>
		<script src="./style/jquery.min.js"></script>
		<script src="./style/ajax.js"></script>
		<script>
		
		</script>
	</head>
	<body>
		<a id="1" href="control.php">
		<font size="5" color="red">µÁµ∆</font></a>
		<iframe align="center" src="control.php" height="50%" width="40%" frameborder=0 scrolling=0></iframe><br>

		<a href="control1.php" >
		<font size="7" color="red">√≈</font></a>
		<iframe align="center" src="control1.php" height="50%" width="40%" frameborder=0 scrolling=0></iframe><br>

		<a href="control2.php" >
		<font size="5" color="red">¥∞¡±</font></a>
		<iframe align="center" src="control2.php" height="50%" width="40%" frameborder=0 scrolling=0></iframe><br>

	</body>
</html>
<?php
	include("conn.php");
	if($_POST['s1'])
	{
		$sql="update data1 set info='$_POST[s1]' where id='2'";
		mysql_query($sql);
		//if(mysql_query)
			//echo "<script>alert('succ')</script>";
	}
?>