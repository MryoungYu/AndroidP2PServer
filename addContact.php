<?php
/*
 * 添加好友功能
 * 数据要求: 'num_src':自己的用户名，'num_obj':对方的手机号.
 * 上传方式: post
 * 返回格式: json
 * 返回内容: 'status'
 * 返回值：    0	正常
 * 			1	对方手机号不存在，请邀请注册
 * 			2 	已经是好友，不予添加
 * 			3	已经提交添加申请，请等待对方接受
 */

require 'conMysql.php';
$res1 = mysql_query('select * from user where `num`="' . $_POST['num_obj'] . '"');
if ($row = mysql_fetch_array($res1)) {//验证目标手机号已经在数据库注册
	//计算unack ID
	$k = 1;
	$res2 = mysql_query('select * from unack');
	while ($row2 = mysql_fetch_array($res2))
		$k = $k + 1;
	//检验是否为重复添加
	$res3 = mysql_query('select * from relation');
	while ($row3 = mysql_fetch_array($res3))
		if (($row3['num1'] == $_POST['num_src'] && $row3['num2'] == $_POST['num_obj']) || ($row3['num2'] == $_POST['num_src'] && $row3['num1'] == $_POST['num_obj'])) {
			if (!isset($array))
				$array = array('status' => 2);
			break;
		}
	//检验是否已经提交过添加申请
	$res4 = mysql_query('select * from unack');
	while ($row4 = mysql_fetch_array($res4))
		if (($row4['num1'] == $_POST['num_src'] && $row4['num2'] == $_POST['num_obj']) || ($row4['num2'] == $_POST['num_src'] && $row4['num1'] == $_POST['num_obj'])) {
			if (!isset($array))
				$array = array('status' => 3);
			break;
		}
	//将好友关系加入待确认表中
	if (!isset($array))
	{
		$insert = mysql_query('insert into unack values(' . $k . ',' . $_POST['num_src'] . ',' . $_POST['num_obj'] . ')');
		$array = array('status' => 0);
	}
} else
	$array = array('status' => 1);
echo json_encode($array);
?>