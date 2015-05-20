<!--
作者：youngyu2012@sina.com
时间：2015-05-18
描述：对话发起者在向服务器和对方发送完信息之后向此借口轮询数据库状态，以确认连接。
返回码：1.未连接
2.ram已失效
-->
<?php
require 'conMySql.php';
$res = mysql_query('select * from connection where `ID`=' . $_POST['ram']);
$flag1 = true;
if ($row = mysql_fetch_array($res)) {
	if ($row['IPB'] != '')
		$array = array('status' => 0, 'ip' => $row['IPB']);
	else
		$array = array('status' => 1);
} else
	$flag1 = false;
if (!$flag1)
	$array = array('status' => 2);
echo json_encode($array);
?>