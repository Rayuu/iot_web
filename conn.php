<?php
	$conn=@mysql_connect('localhost','root','madong')or die("fail");
	mysql_select_db("data",$conn);
	if(!$conn)
	{
		echo "die";
	}
?>
