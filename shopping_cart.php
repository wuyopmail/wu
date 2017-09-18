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
$getitem_id = @$_GET[item_id];
$getqty = @$_GET[qty];
$user_query = mysql_query("select * from user where uid=$userid limit 1");
@$row = mysql_fetch_array($user_query);
$server_query = mysql_query("select * from server where uid=$userid limit 50");
if($getitem_id == ''){
	$item_id = '';
} else {
	//$item_id = $getitem_id;
	$item_id = mysql_real_escape_string($getitem_id);
}
if($getqty == ''){
	$qty = 1;
} else {
	//$qty = $getqty;
	$qty = mysql_real_escape_string($getqty);
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
if($item_id != '' && $qty != ''){
	$query = "select count(*) from cart where uid = '".$userid."' and item_id = '".$item_id."'";
	$server_query = mysql_query("$query");
	$server_query = mysql_fetch_array($server_query);
	//print_r($server_query[0]);
	if($server_query[0] == 0){
		$query = "insert into cart(uid, item_id, qty) values ('".$userid."', '".$item_id."', '".$qty."')";
		$server_query = mysql_query("$query");
	} else {
		$query = "update cart set qty = '".$qty."' where uid = '".$userid."' and item_id = '".$item_id."'";
		$server_query = mysql_query("$query");
	}
}
?>
<?php
//本页数据
$count_price = 0;//计算总价
//$item_id_all = "";//商品id
$delete_id = getvar(@$_GET['delete_id']);
if($delete_id != ''){
	$query = "delete from cart where uid = '".$userid."' and item_id = '".$delete_id."'";
	//print_r($query);
	$delete_id = mysql_query("$query");
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>购物车</title>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/index.css" />
		<link rel="stylesheet" type="text/css" href="css/shopping_cart.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<!--[if lt IE 9]>
		    <script src="shiv.min.js"></script>
		    <script src="respond.min.js"></script>
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
		
		<!--中间区域tab页开始-->
		<div class="container">
			<div class="row bord-bot">
				<div class="col-md-5 hidden-sm hidden-xs">
					
				</div>
				<div class="col-md-7 hidden-sm hidden-xs text-center">
					<div class="wu pad-bg1-1">我的购物车</div>
					<div class="wu pad-bg2-0">填写订单</div>
					<div class="wu pad-bg3-0">完成订单</div>
				</div>
			</div>
		</div>
		<!--收藏	 开始-->
		<div class="container">
			<div class="row">
				<!--购物车区域-->
				<div class="col-xs-12 min-h">
					<!--全选标题栏-->
					<ul class="shopping-cart hidden-sm hidden-xs cart-con">
						<li class="col-md-1">
							<div class="row">
								<input type="checkbox" name=""/><label for="">全选</label>
							</div>
						</li>
						<li class="col-md-5 text-center">
							<div class="row">
								商品信息
							</div>
						</li>
						<li class="col-md-1 text-center">
							<div class="row">
								单价
							</div>
						</li>
						<li class="col-md-2">
							<div class="row">
								<span class="rt-mar">数量</span>
							</div>
						</li>
						<li class="col-md-2 text-center">
							<div class="row">
								金额
							</div>
						</li>
						<li class="col-md-1 text-center">
							<div class="row">
								操作
							</div>
						</li>
					</ul>
					<hr />
					<!--购物单-->
					
					<!--动态加载区域-->
					<?php
					$query = "select * from cart where uid = '".$userid."'";
					$queryuser = mysql_query("$query");
					//$server_query = mysql_fetch_array($server_query);
					while($row = mysql_fetch_array($queryuser)){
						//print_r($row);
					//}
						$query = "select * from item where item_id = '".$row['item_id']."'";
						$server_query = mysql_query("$query");
						$server_query = mysql_fetch_array($server_query);
						//print_r($server_query);
						$final_price = $server_query['discount_price']*$row['qty'];//商品总价
						$count_price += $final_price;//总价
						//$item_id_all = "".$item_id_all."".$row['item_id']."|";//商品id
						//print_r($item_id_all);
						if(($row['qty'] + 1)<=$server_query['qty']){
							$up_qty=$row['qty'] + 1;
						} else {
							$up_qty=$row['qty'];
						}
						if(($row['qty'] - 1)>0){
							$down_qty=$row['qty'] - 1;
						} else {
							$down_qty=$row['qty'];
						}
						//print_r('!!!!!!!!!!!!!!!!!');
						echo <<<EOT
						<ul class="cart-con bord-li">
							<li class="col-md-1 col-sm-1 col-xs-1 no-padding">
								<input type="checkbox" name=""/>
							</li>
							<li class="col-md-1 col-sm-4 col-xs-4 no-padding">
								<a href="single_product.html"><img src="img/21.jpg" class="t-img"></a>
							</li>
							<li class="col-md-10 col-sm-7 col-xs-7 no-padding">
								<ul class="cart-con">
									<li class="col-md-5 col-sm-12 col-xs-12"><a href="#"><h5>$server_query[item_name]</h5></a></li>
									<li class="col-md-1 hidden-sm hidden-xs"><h5>￥$server_query[discount_price]</h5></li>
									<li class="col-md-2 col-md-offset-1 col-sm-8 col-xs-8 line">
										<a href="./shopping_cart.php?qty=$down_qty&item_id=$server_query[item_id]" class="change jian1">-</a>
										<input type="text" value="$row[qty]" class="add-num" disabled="disabled"/>
										<a href="./shopping_cart.php?qty=$up_qty&item_id=$server_query[item_id]" class="change jia1">+</a>
										<br/><br/>剩余$server_query[qty]
									</li>
									<li class="col-md-2 col-sm-1 col-xs-1"><h5 class="t-price">￥$final_price</h5></li>
									<li class="col-md-1 col-sm-2 col-xs-12">
										<a href="./wish_list.php?item_id=$server_query[item_id]">收藏</a>&nbsp;&nbsp;&nbsp;
										<a href="./shopping_cart.php?delete_id=$server_query[item_id]">删除</a>
									</li>
								</ul>
							</li>
						</ul>
EOT;
					}
					?>
					<!--动态加载区域-->
				</div>
				<div class="col-xs-12">
					<?php
					//$query = "select * from order where uid = '".$userid."' and item_id";
					//$server_query = mysql_query("$query");
					//$server_query = mysql_fetch_array($server_query);
					?>
					<ul class="pay cart-con bord-ul">
						<li class="col-md-1 col-xs-2">
							<div class="row">
								<input type="checkbox" name=""/><label for="">全选</label>
							</div>
						</li>
						<li class="col-md-2 text-center col-xs-3">
							<div class="row">
								<a href="#" class="payment">删除所选</a>
							</div>
						</li>
						<li class="col-md-3 text-center hidden-xs">
							<div class="row">
								已经选择0件商品
							</div>
						</li>
						<li class="col-md-4 text-right col-xs-4">
							<div class="row">
								<span>总计：￥<?php echo $count_price;?></span>
							</div>
						</li>
						<li class="col-md-2 text-right col-xs-3">
							<div class="row">
								<a href="shopping_cart2.php" class="payment">结算(0)</a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		
		<!--目录	 结束-->
		<!--footer	开始-->
		<footer>
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
			//购买商品数量增减
			$(function(){
		        $(".jia1").on("click", function(){
		            // 先找到当前加号的父元素class="line"的div,再寻找当前div下的文本框class="amount" 
		            var $countInput = $(this).parent(".line").children(".add-num");
		            $countInput.val($countInput.val()-0+1);
		        });
		        $(".jian1").on("click", function(){
		            var $countInput = $(this).parent(".line").children(".add-num");
		            if ($countInput.val()-0 > 0){
		                $countInput.val($countInput.val()-1);
		            }
		        });
		    });
		</script>
	</body>
</html>
		