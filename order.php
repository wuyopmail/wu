<?php
session_start();

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
if($item_id != '' && $type != '' && $qty != '' && $discount_price != ''){
	$query = "update item set type = '".$type."' ,qty = '".$qty."' ,discount_price = '".$discount_price."'where item_id = '".$item_id."'";
	$server_query = mysql_query("$query");
}
if($delete_id != ''){
	$query = "delete from item where item_id = '".$delete_id."'";
	$server_query = mysql_query("$query");
}
?>
<!DOCTYPE html>
<html class="html">
	<head>
		<meta charset="UTF-8">
		<title>全部订单</title>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/index.css" />
		<link rel="stylesheet" href="css/shopping_cart.css" />
		<link rel="stylesheet" href="css/wish.css" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<!--[if lt IE 9]>
		    <script src="js/shiv.min.js"></script>
		    <script src="js/respond.min.js"></script>
		<![endif]-->

        <!-- Mobile Specific Meta  -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	</head>
	<body> 
		<!--header	开始-->
		<?php
		include_once('./core/header.php');
		?>
		<!--header	结束-->
		<!--收藏	 开始-->
		<div class="container">
			<div class="row">
				<!--左侧目录栏-->
				<div class="col-md-2 hidden-sm hidden-xs lf-nav">
					<h4 class="lf-nag-bgc row">个人中心</h4>
					<ul class="lf-nav-ul">
						<li><a href="secret_revise.html"><i class="glyphicon glyphicon-grain"></i>密码修改</a></li>
						<li><a href="wish_list.html"><i class="glyphicon glyphicon-grain"></i>我的收藏</a></li>
						<li><a href="order.html"><i class="glyphicon glyphicon-grain"></i>我的订单</a></li>
					</ul>
					<h4 class="lf-nag-bgc row">卖家中心</h4>
					<ul class="lf-nav-ul">
						<li><a href="items_add.html"><i class="glyphicon glyphicon-grain"></i>商品添加</a></li>
						<li><a href="items_revise.html"><i class="glyphicon glyphicon-grain"></i>商品管理</a></li>
						<li><a href="#"><i class="glyphicon glyphicon-grain"></i>数据统计</a></li>
					</ul>
				</div>
				<!--订单进度条	tab分属页-->
				<div class="col-md-10">
					<div class="nav">
						<form action="" method="post">
							<ul class="col-md-12 col-xs-12">
								<li class="color colorwhite tab col-md-2 col-xs-4 custom-tab"><span class="sm-font">全部订单</span></li>
								<li class="tab col-md-2 col-xs-4 custom-tab"><span class="sm-font">待收货1</span></li>
								<li class="tab col-md-2 col-xs-4 custom-tab"><span class="sm-font">待评价1</span></li>
								<li class="col-md-5 hidden-xs" style="border: 0;">
									<input type="text" class="wid-all" placeholder="订单号/收货人姓名"/>
								</li>
								<li class="col-md-1 hidden-xs" style="border: 0;">
									<input type="submit" class="wid-all" value="查询"/>
								</li>
							</ul>
						</form>
						
					</div>
				</div>
				<div class="col-md-10 col-sm-12 col-xs-12 content">
					<!--全部订单tab页-->
					<div class="col-md-4 hidden-xs">
						<h3>送货清单</h3>
						<h5 class="top-mar">周六日暂休，只工作日送货哦~</h5>
						<h4 class="top-mar">Tip:一般情况书本将在第二天傍晚前到达~</h4>
					</div>
					
					<div class="col-md-8 bord-list top-mar no-padding con" style="display: block;">
						<?php
						$query = "select * from orders where uid = '$userid'";
						$queryuser = mysql_query("$query");
						while($row = mysql_fetch_array($queryuser)){
						echo <<<EOT
						<div class="col-md-12 no-padding bord-list-0">
							<!--全选标题栏-->
							<div class="form-control bord-ul ">
									<span class="color-gr col-md-6 col-xs-8">2017-8-24;14：59：53</span>
									<span class="col-md-6 hidden-xs">预计商品将于8月23号晚前抵达</span>
								</div>
							<ul class="shopping-cart hidden-sm hidden-xs cart-con">
								<li class="col-md-6 text-center">
									<div class="row">
										商品信息
									</div>
								</li>
								<li class="col-md-2 text-center">
									<div class="row">
										单价
									</div>
								</li>
								<li class="col-md-2 text-center">
									<div class="row">
										数量
									</div>
								</li>
								<li class="col-md-2 text-center">
									<div class="row">
										总计
									</div>
								</li>
							</ul>
							<hr />
							<!--购物单-->
							
							<!--动态加载区域-->
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
							echo <<<EOT
							<ul class="cart-con bord-li">
								<li class="col-md-2 col-xs-4">
									<a href="#"><img src="img/21.jpg" class="t-img"></a>
								</li>
								<li class="col-md-10 col-xs-8">
									<ul class="cart-con">
										<li class="col-md-5 col-xs-12"><a href="#"><h5 class="row">$item[item_name]</h5></a></li>
										<li class="col-md-2 col-xs-2 text-center"><h5 class="row">￥$iid[2]</h5></li>
										<li class="col-md-3 col-xs-8 text-center"><h5 class="row">$iid[1]</h5></li>
										<li class="col-md-2 col-xs-2 text-center"><h5 class="t-price row">￥$cost</h5></li>
									</ul>
								</li>
							</ul>
EOT;
							}
						

							echo <<<EOT
							<!--动态加载区域-->
						</div>
						<!--结算区域-->
						<div class="col-md-12 no-padding">
							<ul class="pay cart-con bord-ul">
								<li class="col-md-4 text-center col-xs-9">
									<div class="row xs-font">
										完成订单号为<span class="color-re">$row[order_id]</span>，待送；
									</div>
								</li>
								<li class="col-md-2 col-md-offset-3 text-center hidden-xs">
									<div class="row xs-font">
										1个包裹
									</div>
								</li>
								<li class="col-md-3 text-right col-xs-3">
									<div class="row xs-font">
										合计：$cost_all
									</div>
								</li>
							</ul>
						</div>
					
EOT;
						}
					echo '</div>';
					?>
					<!--待收货tab页-->
					<div class="col-md-8 bord-list top-mar no-padding con">
					<?php
						$query = "select * from orders where uid = '$userid' and order_status = '1'";
						$queryuser = mysql_query("$query");
						while($row = mysql_fetch_array($queryuser)){
						echo <<<EOT
						<!--<div class="col-md-4 hidden-xs">
							<h3>送货清单</h3>
							<h5 class="top-mar">周六日暂休，只工作日送货哦~</h5>
							<h4 class="top-mar">Tip:一般情况书本将在第二天傍晚前到达~</h4>
						</div>-->
						<div class="col-md-12 no-padding bord-list-0">
							<!--全选标题栏-->
							<div class="form-control bord-ul ">
								<span class="color-gr col-md-5 col-xs-8">2017-8-24;14：59：53</span>
								<span class="col-md-5 hidden-xs">预计商品将于8月23号晚前抵达</span>
								<button type="button" class="col-md-2 col-xs-4  but">确认收款</button>
							</div>
							<ul class="shopping-cart hidden-sm hidden-xs cart-con">
								<li class="col-md-6 text-center">
									<div class="row">
										商品信息
									</div>
								</li>
								<li class="col-md-2 text-center">
									<div class="row">
										单价
									</div>
								</li>
								<li class="col-md-2 text-center">
									<div class="row">
										数量
									</div>
								</li>
								<li class="col-md-2 text-center">
									<div class="row">
										总计
									</div>
								</li>
							</ul>
							<hr />
							<!--购物单-->
							
							<!--动态加载区域-->
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
							echo <<<EOT
							<ul class="cart-con bord-li">
								<li class="col-md-2 col-xs-4">
									<a href="#"><img src="img/21.jpg" class="t-img"></a>
								</li>
								<li class="col-md-10 col-xs-8">
									<form action="" method="post">
										<ul class="cart-con">
											<li class="col-md-5 col-xs-12"><a href="#"><h5 class="row">$item[item_name]</h5></a></li>
											<li class="col-md-2 col-xs-2 text-center"><h5 class="row">￥$iid[2]</h5></li>
											<li class="col-md-3 col-xs-8 text-center"><h5 class="row">$iid[1]</h5></li>
											<li class="col-md-2 col-xs-2 text-center"><h5 class="t-price row">￥$cost</h5></li>
										</ul>
									</form>
								</li>
							</ul>
EOT;
							}
							
							echo <<<EOT
							<!--动态加载区域-->
						</div>
						<!--结算区域-->
						<div class="col-md-12 no-padding">
							<ul class="pay cart-con bord-ul">
								<li class="col-md-4 text-center col-xs-9">
									<div class="row xs-font">
										完成订单号为<span class="color-re">$row[order_id]</span>，待送；
									</div>
								</li>
								<li class="col-md-2 col-md-offset-3 text-center hidden-xs">
									<div class="row xs-font">
										1个包裹
									</div>
								</li>
								<li class="col-md-3 text-right col-xs-3">
									<div class="row xs-font">
										合计：$cost_all
									</div>
								</li>
							</ul>
						</div>
EOT;
						}
					echo '</div>';
					?>
					<!--待评价tab页-->
					<div class="col-md-8 bord-list top-mar no-padding con">
						<!--<div class="col-md-4 hidden-xs">
							<h3>送货清单</h3>
							<h5 class="top-mar">周六日暂休，只工作日送货哦~</h5>
							<h4 class="top-mar">Tip:一般情况书本将在第二天傍晚前到达~</h4>
						</div>-->
					<?php
						$query = "select * from orders where uid = '$userid' and order_status = '2'";
						$queryuser = mysql_query("$query");
						while($row = mysql_fetch_array($queryuser)){
						echo <<<EOT
						<div class="col-md-12 no-padding bord-list-0">
							<!--全选标题栏-->
							<form action="" method="post">
								<div class="form-control bord-ul ">
									<span class="color-gr col-md-5 col-xs-8">2017-8-24;14：59：53</span>
									<span class="col-md-5 hidden-xs">预计商品将于8月23号晚前抵达</span>
									<input type="submit" class="col-md-2 col-xs-4 but" value="评价提交">
								</div>
								<ul class="shopping-cart hidden-sm hidden-xs cart-con">
									<li class="col-md-6 text-center">
										<div class="row">
											商品信息
										</div>
									</li>
									<li class="col-md-2 text-center">
										<div class="row">
											单价
										</div>
									</li>
									<li class="col-md-2 text-center">
										<div class="row">
											数量
										</div>
									</li>
									<li class="col-md-2 text-center">
										<div class="row">
											总计
										</div>
									</li>
								</ul>
								<hr />
								<!--购物单-->
								
								<!--动态加载区域-->
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
							echo <<<EOT
								<ul class="cart-con bord-li2">
									<li class="col-md-2 col-xs-4">
										<a href="#"><img src="img/21.jpg" class="t-img"></a>
									</li>
									<li class="col-md-10 col-xs-8">
										<form action="" method="post">
											<ul class="cart-con">
												<li class="col-md-5 col-xs-12"><a href="#"><h5 class="row">$item[item_name]</h5></a></li>
												<li class="col-md-2 col-xs-2 text-center"><h5 class="row">￥$iid[2]</h5></li>
												<li class="col-md-3 col-xs-8 text-center"><h5 class="row">$iid[1]</h5></li>
												<li class="col-md-2 col-xs-2 text-center"><h5 class="t-price row">￥$cost</h5></li>
											</ul>
										</form>
									</li>
									<li class="col-md-12 col-xs-12 text-center no-padding">
										<input type="text" class="form-control" placeholder="请给予您的评价"/>
									</li>
								</ul>
EOT;
							}
							
							echo <<<EOT
								<!--动态加载区域-->
							</form>
							
						</div>

						<!--结算区域-->
						<div class="col-md-12 no-padding">
							<ul class="pay cart-con bord-ul">
								<li class="col-md-4 text-center col-xs-9">
									<div class="row xs-font">
										完成订单号为<span class="color-re">$row[order_id]</span>，待送；
									</div>
								</li>
								<li class="col-md-2 col-md-offset-3 text-center hidden-xs">
									<div class="row xs-font">
										1个包裹
									</div>
								</li>
								<li class="col-md-3 text-right col-xs-3">
									<div class="row xs-font">
										合计：$cost_all
									</div>
								</li>
							</ul>
						</div>
EOT;
						}
					echo '</div>';
					?>
				</div>
			</div>
		</div>
		<!--目录	 结束-->
		<!--footer	开始-->
		<footer class="footer">
			<div class="footer-area">
				<div class="footer-start">
					<div class="container">
						<div class="row">
							<div class="col-md-3 col-sm-3 col-xs-12 text-center">
								<h4>关于网站</h4>
								<ul class="toggle-footer">
									<li>
										<a href="#" class="colorwhite">
											<i class="glyphicon glyphicon-grain"></i>
											功能简介
										</a>
									</li>
									<li>
										<a href="#" class="colorwhite">
											<i class="glyphicon glyphicon-grain"></i>
											后期拓展
										</a>
									</li>
								</ul>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-12 text-center">
								<h4>关于团队</h3>
								<ul class="toggle-footer">
									<li>
										<a href="#" class="colorwhite">
											<i class="glyphicon glyphicon-grain"></i>
											团队简介
										</a>
									</li>
									<li>
										<a href="#" class="colorwhite">
											<i class="glyphicon glyphicon-grain"></i>
											联系方式
										</a>
									</li>
								</ul>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-12 text-center">
								<h4>问题反馈</h3>
								<ul class="toggle-footer">
									<li>
										<a href="#" class="colorwhite">
											<i class="glyphicon glyphicon-grain"></i>
											反馈留言
										</a>
									</li>
								</ul>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-12 text-center">
								<h4>书店位置</h3>
								<ul class="toggle-footer">
									<li>
										<span class="colorwhite">
											<p class=""></p>
											<p class="lr-pad">
												<i class="glyphicon glyphicon-info-sign"></i>
												物院进校门右转6号家属楼一层
											</p>
										</span>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="footer-end top-mar text-center">
					<div class="container">
						<div class="row">
							<div class="footer-end-e">
								<p class="tb-pad">
									Copyright © 2017.版权归北京物资学院所有.
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!--footer	结束-->
		<script type="text/javascript" src="js/jquery-3.2.1.min.js" ></script>
		<script src="js/jquery.placeholder.min.js" type="text/javascript" charset="utf-8"></script>
		<!--placeholder	对IE浏览器支持-->
		<script type="text/javascript">
		    $(function () {
		        // Invoke the plugin
		        $('input, textarea').placeholder();
		    });
		</script>
		<script type="text/javascript" src="js/bootstrap.min.js" ></script>
		<script>
			//下拉菜单出现
			$("data-toggle").dropdown();
			//tab页切换
			$(".nav ul .tab").click(function(){
				var index =$(this).index();
				$(".con").hide();
				$(".con").eq(index).show();
				$(".nav ul .tab").removeClass("color colorwhite");
				$(this).addClass("color");
			});
		</script>
		
	</body>
</html>
		
