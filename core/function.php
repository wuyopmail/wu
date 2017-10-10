<?php
function getvar($var){//对get或post的值进行防注入处理
	if($var == ''){
		return '';
	} else {
		return mysql_real_escape_string($var);
	}
}

function getarr($content){
    //如果magic_quotes_gpc=Off，那么就开始处理    
    if (!get_magic_quotes_gpc()) {    
        //判断$content是否为数组 
        if (is_array($content)) {    
            //如果$content是数组，那么就处理它的每一个单无    
            foreach ($content as $key=>$value) {    
                $content[$key] = mysql_real_escape_string($value);    
            }    
        } else {    
            //如果$content不是数组，那么就仅处理一次    
            mysql_real_escape_string($content);    
        }    
    } else {    
        //如果magic_quotes_gpc=On，那么就不处理    
    }    
    //返回$content    
    return $content;
}
//$name = '';
//$ser = getvar($name);
//echo '!!';
//echo $ser;
//echo '!!';
?>