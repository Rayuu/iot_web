<?php
/*   �����Ŀ��ؿ���   �� */
	require_once("p6.php");
	include("conn.php");
	if(isset($_POST['vv6']))
	{
		$sql="update data1 set info='1' where id='1'";
		mysql_query($sql);
		require_once("p6.php");//��ʾon״̬
		echo "<font size='5' color='red'>close</font>";
	}
	else
	{
	//	echo "error2";
	}
?>
