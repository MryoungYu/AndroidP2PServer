<?php
$str = '256.fff.dfkua.-1';
$arr = explode('.', $str);
foreach($arr as $u)
{
	if($u>255 || $u<0)
		echo 'too big or small'.'<br />';
	else if(strlen($u)>3)
		echo 'so long'.'<br />';
	else
		echo "it's ok"."<br />";
	echo $u+1;
}
echo 'end';
?>