<?php
	/*   窗帘的开关控制   开 */
	include("conn.php");
	if(isset($_POST['vv5']))
	{
		$sql="update data1 set info='0' where id='1'";
		mysql_query($sql);
		require_once("p5.php");//显示off状态
		echo "<font size='5'color='red'>open</font>";
	}
?>