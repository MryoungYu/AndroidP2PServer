<?php
/*
 * 用于登录
 * 需要提交的数据：用户手机号num，密码pwd
 * 返回数据：status=0	正常
 * 					1	密码错误
 * 					2	用户名不存在
 */
require 'conMysql.php';
$res = mysql_query('select * from user where `num`=' . $_POST['num'] . '');
if ($row = mysql_fetch_array($res)) {
	if ($row['pwd'] == $_POST['pwd'])
		$array = array('status' => 0);
	else
		$array = array('status' => 1);
} else
	$array = array('status' => 2);
echo json_encode($array);
?>