<?php

/*
作者：youngyu2012@sina.com
时间：2015-05-18
描述：用于接受邀請方，通過上傳自身ip和連接隨機數ram來確定連接
返回值:{"status":0,"ip":"0.0.0.0"}
异常：1.RAM不存在
2.IPB已存在
错误码：
1 RAM不存在
2 IPb已存在
3 插入失败
4 查询失败
*/

require 'conMySql.php';

$flag1 = true;
$flag2 = true;

$res1 = mysql_query('select * from connection where `ID`=' . $_POST['ram']);

if ($row = mysql_fetch_array($res1))
{
	$ip = $row['IPA'];
	if($row['IPB'] != '')
		$flag2 = false;
}
else
	$flag1 = false;

if($flag2 && $flag1)
	$res2 = mysql_query('update connection set `IPB`="' . $_POST['ip'] . '" where `ID`=' . $_POST['ram']);

if (!$flag1)
	$array = array('status' => 1);
else if (!$flag2)
	$array = array('status' => 2);
else if (!$res1)
	$array = array('status' => 3);
else if (!$res2)
	$array = array('status' => 4);
else 
{
	$array = array('status' => 0, 'ip' => $ip);
	$time = date('Y-m-d H:i:s',time());
	$note = mysql_query('update state set `StateB`="'.$time.'" where `ID`='.$_POST["ram"].'');
}
echo json_encode($array);
?>