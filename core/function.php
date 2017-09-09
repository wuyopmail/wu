<?php
function getvar($var){//对get或post的值进行防注入处理
	if($var == ''){
		return '';
	} else {
		return mysql_real_escape_string($var);
	}
}
//$name = '';
//$ser = getvar($name);
//echo '!!';
//echo $ser;
//echo '!!';
?>

