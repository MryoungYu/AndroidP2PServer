<?php

/*
	作者：youngyu2012@sina.com
	时间：2015-05-18
	描述：用以创建聊天的一方将自身IP上传给服务器数据库，服务器会自动生成一个唯一的4位随机数来表示本次连接
	当尝试10000次未取得合法随机数时表示服务器繁忙，返回值为1(服务器繁忙 Busy Server)
	若正常，则返回格式为{"status":0,"ram":随机数}
	申请格式：POST名为'ip'的IP地址
	添加：参数检查，当所传参数不满足A.B.C.D的IP地址格式时，拒绝申请，返回码为2(非法参数 Illegal Parameter)
*/

require 'conMysql.php';
$i = 0;
//计数，检验当前繁忙程度
do {
	$ran = rand(0, 9999);
	$i = $i + 1;
	if ($i > 10000)
		break;
} while(!($res = mysql_query('insert into connection(`ID`,`IPA`) VALUES('.$ran.',"'.$_POST['ip'].'")')));
if ($i > 10000)
	$array = array('status' => 1);
else
	$array = array('status' => 0, 'ram' => $ran);
//将申请结果发往数据库记录访问时间
$time = date('y-m-d H:i:s',time());
$note = mysql_query('insert into state(`ID`,`StateA`) VALUES('.$ran.',"'.$time.'")');
echo json_encode($array);
?>