<?php
	include("head.php");
	include("conn.php");
	if($_POST['s3'])
	{
		$sql="update data1 set info='$_POST[s3]' where id='2'";
		mysql_query($sql);
	}
?>
<HTML>  
 
    <body > 
        <img src='1.jpg' width="47%" height="381"/>  
	<HEAD>  
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
        <title>Web监视</title>  
        <META  http-equiv="refresh"  content="0.5">  
        <META  http-equiv="Expires"  content="0">     
        <META  http-equiv="Pragma"   content="no-cache">     
	</HEAD> 
    </body>  
</HTML> 
