<?php
	
	include("conn.php");
	if(isset($_POST['vv1']))
	{
		$sql="update data1 set info='3' where id='1'";
		mysql_query($sql);
		require_once("p1.php");//ÏÔÊ¾off×´Ì¬
		echo "<font size='5'color='red'>open</font>";
	}
	else
	{
	//	echo "error1";
	}

?>