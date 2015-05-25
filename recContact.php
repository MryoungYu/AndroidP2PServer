<?php
/*
 * 用以确认添加好友
 * 传输数据：己方手机号:num_rec,对方手机号num_apply,添加意见status:0同意，1拒绝
 * 返回数据：status:0成功，1异常（异常情况不明）
 */
require 'conMysql.php';
$k = 1;
$res = mysql_query('select * from relation');
while ($row = mysql_fetch_array($res))
	$k = $k + 1;
if($_POST['status'] == 0)
	$insert = mysql_query('insert into relation values(' . $k . ',"' . $_POST['num_rec'] . '","' . $_POST['num_apply'] . '")');
$res2 = mysql_query('select * from unack');
while ($row2 = mysql_fetch_array($res2))
	if (($row2['num1'] == $_POST['num_rec'] && $row2['num2'] == $_POST['num_apply']) || ($row2['num2'] == $_POST['num_rec'] && $row2['num1'] == $_POST['num_apply'])) {
		$id = $row2['ID'];
		break;
	}
if($_POST['status'] == 0)
	$res = 1;
else if($_POST['status'] == 1)
	$res =2;
$update = mysql_query('update unack set `state`='.$res.' where `ID`=' . $id . '');
if ($update && ((isset($insert)&&$insert) || !isset($insert)))
	$array = array('status' => 0);
else
	$array = array('status' => 1);
echo json_encode($array);
?>