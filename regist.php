<?php
/*
 * 用于新用户注册
 * 需要上传的数据：num手机号,name用户名，pwd密码
 * 密码合法性请在客户端验证，最好散列之后传过来
 * 返回值:status=0	正常
 * 				1	手机号已注册
 */
 require 'conMysql.php';
 //检查手机号是否已被注册
 $res = mysql_query('select * from user');
 while($row = mysql_fetch_array($res))
 	if($row['num'] == $_POST['num'])
	{
		$array = array('status' => 1 );
		break;
	}
//插入用户信息
if(!isset($array))
{
	$insert = mysql_query('insert into user values("'.$_POST['num'].'","'.$_POST['name'].'","'.$_POST['pwd'].'")');
	if($insert)
		$array = array('status' => 0 );
	else
		$array = array('status' => 3 );
}
echo json_encode($array);
?>