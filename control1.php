<?php
/*   门的开关控制    */
	require_once("p4.php");
	include("conn.php");
	if(isset($_POST['vv4']))
	{
		$sql="update data1 set info='5' where id='1'";
		mysql_query($sql);
		require_once("p4.php");//显示on状态	
		echo "<font size='5' color='red'>close</font>";
	}
	else
	{
	//	echo "error2";
	}

?>
