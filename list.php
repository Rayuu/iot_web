<?php
/*
 * Created on 2014-10-19
 * By xcy  QQ:291070726
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 include("head.php");
 $conn = @ mysql_connect("127.0.0.1", "root", "madong") or die("die");
 mysql_select_db("data", $conn);
$sql="select * from wendu limit 0,5";
//$sql="update haha SET info='$_POST[info]' WHERE id='1'";
$query=mysql_query($sql);
?>
<table width=600 border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#add3ef">
    <tr bgcolor="#eff3ff">
      <td>id</td><td>temperture</td><td>date</td>
    </tr>
<?php
while($row=mysql_fetch_array($query))
{
?>
<table width=600 border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#add3ef">
    <tr bgcolor="#0fffff">
      <td><?=$row[id]?></td><td><?=$row[wendu]?></td><td><?=$row[time]?></td>
    </tr>
  </table>
<?php
}
?>
<?php
	include("conn.php");
	if($_POST['s2'])
	{
		$sql="update data1 set info='$_POST[s2]' where id='2'";
		mysql_query($sql);
	}
?>
