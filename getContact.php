<?php
/*
 * 获取好友列表
 * 需要上传数据: 'num'自身用户手机号
 * 上传方式： post
 * 反馈数据类型： json对象'name'-'num'
 */
 require 'conMysql.php';
 $res = mysql_query('select * from relation');
 $i = 0;
 while($row = mysql_fetch_array($res))
 {
	if($row['num1'] == $_POST['num'])
		$num = $row['num2'];
	else if($row['num2'] == $_POST['num'])
		$num = $row['num1'];
	else
		break;
	$res2 = mysql_query('select * from user where `num`='.$num.'');
	$row2 = mysql_fetch_array($res2);
	$name = $row2['name'];
	$arr[$i++] = array(
			"name" => $name,
			"num" => $num
		);
 }
 echo json_encode($arr);
?>