<!--
作者：youngyu2012@sina.com
时间：2015-05-18
描述：用于处于通讯状态的双方进行轮询
轮询目标：1.修正自身IP	2.发送心跳包		3.确认对方IP
返回码：1.对方已离线 offline
		2.对话已关断 closed connection
-->
<?php
require 'conMySql.php';
$res = mysql_query('select * from connection where `ID`=' . $_POST['ram']);
if ($row = mysql_fetch_array($res)) {
	if ($_POST['role'] == 0)//发起者轮询
	{
		if ($_POST['ip'] != $row['IPA'])
			$res2 = mysql_query('update connection set `IPA`="' . $_POST['ip'] . '" where `ID`=' . $_POST['ram']);
		if ($row['IPB'] != '')
			$array = array('status' => 0, 'ip' => $row['IPB']);
		else
			$array = array('status' => 1);
	} else {//受邀者轮询
		if ($_POST['ip'] != $row['IPB'])
			$res2 = mysql_query('update connection set `IPB`="' . $_POST['ip'] . '" where `ID`=' . $_POST['ram']);
		if ($row['IPA'] != '')
			$array = array('status' => 0, 'ip' => $row['IPA']);
		else
			$array = array('status' => 1);
	}
}
else
	$array = array('status' => 2);
echo json_encode($array);
?>