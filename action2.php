<?php
	/*   �����Ŀ��ؿ���   �� */
	include("conn.php");
	if(isset($_POST['vv5']))
	{
		$sql="update data1 set info='0' where id='1'";
		mysql_query($sql);
		require_once("p5.php");//��ʾoff״̬
		echo "<font size='5'color='red'>open</font>";
	}
?>