<?php
/*   窗帘的开关控制   关 */
	require_once("p6.php");
	include("conn.php");
	if(isset($_POST['vv6']))
	{
		$sql="update data1 set info='1' where id='1'";
		mysql_query($sql);
		require_once("p6.php");//显示on状态
		echo "<font size='5' color='red'>close</font>";
	}
	else
	{
	//	echo "error2";
	}
?>
