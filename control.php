<?php
/*   ��ƵĿ��ؿ���    */
	require_once("p2.php");
	include("conn.php");
	if(isset($_POST['vv2']))
	{
		$sql="update data1 set info='2' where id='1'";
		mysql_query($sql);
		require_once("p2.php");//��ʾon״̬
		echo "<font size='5' color='red'>close</font>";
	}
	else
	{
	//	echo "error2";
	}
?>
