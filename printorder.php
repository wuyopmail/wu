<?php
session_start();
header("Content-type: text/plain");
//检测是否登录，若没登录则转向登录界面
//if(!isset($_SESSION['userid'])){
//	header("Location:login.html");
//	exit();
//}

//包含数据库连接文件
include('conn.php');
include('./core/function.php');
$userid = @$_SESSION['userid'];
$username = @$_SESSION['username'];

@$gettype=$_POST[type];
@$getitem_name=$_POST[item_name];
@$getauthor=$_POST[author];
@$getpress=$_POST[press];
@$gettime=$_POST['time'];
@$getcondition_precent=$_POST[condition_precent];
@$getdiscount_price=$_GET[discount_price];
@$getprice=$_POST[price];
@$getqty=$_GET[qty];
@$getcontent=$_POST[content];

$user_query = mysql_query("select * from user where uid=$userid limit 1");
@$row = mysql_fetch_array($user_query);
$server_query = mysql_query("select * from server where uid=$userid limit 50");


if($gettype == ''){
	$type = '';
} else {
	$type = mysql_real_escape_string($gettype);
}
if($getitem_name == ''){
	$item_name = '';
} else {
	$item_name = mysql_real_escape_string($getitem_name);
}
if($getauthor == ''){
	$author = '';
} else {
	$author = mysql_real_escape_string($getauthor);
}
if($getpress == ''){
	$press = '';
} else {
	$press = mysql_real_escape_string($getpress);
}
if($gettime == ''){
	$time = '';
} else {
	$time = mysql_real_escape_string($gettime);
}
if($getcondition_precent == ''){
	$condition_precent = '';
} else {
	$condition_precent = mysql_real_escape_string($getcondition_precent);
}
if($getdiscount_price == ''){
	$discount_price = '';
} else {
	$discount_price = mysql_real_escape_string($getdiscount_price);
}
if($getprice == ''){
	$price = '';
} else {
	$price = mysql_real_escape_string($getprice);
}
if($getqty == ''){
	$qty = '';
} else {
	$qty = mysql_real_escape_string($getqty);
}
if($getcontent == ''){
	$content = '';
} else {
	$content = mysql_real_escape_string($getcontent);
}






















//$server_row = mysql_fetch_array($server_query);
/*echo '用户信息：<br />';
echo '用户ID：',$userid,'<br />';
echo '用户名：',$username,'<br />';
echo '邮箱：',$row['email'],'<br />';
echo '注册日期：',date("Y-m-d", $row['regdate']),'<br />';
echo '服务器名称：'.$row['servername'].'</br>';
echo '<a href="login.php?action=logout">注销</a> 登录<br />';*/
//echo $item_id;
//print_r($row);
?>
<?php
//数据处理部分
$item_id = getvar(@$_GET['item_id']);
$type = getvar(@$_GET['type']);
$delete_id = getvar(@$_GET['delete_id']);
$search_name = getvar(@$_GET['search_name']);
$search_author = getvar(@$_GET['search_author']);
$search_press = getvar(@$_GET['search_press']);
$search_discount_price = getvar(@$_GET['search_discount_price']);
$search_qty = getvar(@$_GET['search_qty']);
$search_type = getvar(@$_GET['search_type']);
$order_id = getvar(@$_GET['order_id']);
if($item_id != '' && $type != '' && $qty != '' && $discount_price != ''){
	$query = "update item set type = '".$type."', qty = '".$qty."', discount_price = '".$discount_price."' where item_id = '".$item_id."'";
	$server_query = mysql_query("$query");
}
if($delete_id != ''){
	$query = "delete from item where item_id = '".$delete_id."'";
	$server_query = mysql_query("$query");
}
?>
<?php
$query = "select * from orders where order_id = '$order_id'";
$queryuser = mysql_query("$query");
while($row = mysql_fetch_array($queryuser)){
echo <<<EOT
商品信息          单价           数量           总计
------------------------------------------------------------\n
EOT;

						//print_r($row);
						$order_arr = explode("|",$row['item_id']);
						//print_r($order_arr);
						$i = 0;//循环初始化
						//$cost = 0;//价格初始化
						$order_arr_num = count($order_arr);
						$order_arr_num--;
						$cost_all = 0;//价格初始化
						while($i < $order_arr_num)	{
							$cost = 0;//价格初始化
							$iid = explode("-",$order_arr[$i]);//item_id
							$i++;
							$cost = $cost + $iid[1] * $iid[2];
							$cost_all = $cost_all + $cost;//总价
							//print_r($iid);
								$query = "select * from item where item_id = '".$order_arr[0]."'";
								$item = mysql_query("$query");
								$item = mysql_fetch_array($item);
								//print_r($item);
echo sprintf("% -22s% -15s% -15s% -12s\n",$item['item_name'],$iid[2],$iid[1],$cost);
							}
							echo <<<EOT
订单号 $row[order_id]
合计 $cost_all
EOT;
}
?>