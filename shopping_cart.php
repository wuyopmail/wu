<?php
session_start();

//检测是否登录，若没登录则转向登录界面
//if(!isset($_SESSION['userid'])){
//	header("Location:login.html");
//	exit();
//}

//包含数据库连接文件
include('conn.php');
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$getitem_id = @$_GET[item_id];
$getqty = @$_GET[qty];
$user_query = mysql_query("select * from user where uid=$userid limit 1");
$row = mysql_fetch_array($user_query);
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
	print_r($server_query[0]);
	if($server_query[0] == 0){
		$query = "insert into cart(uid, item_id, qty) values ('".$userid."', '".$item_id."', '".$qty."')";
		$server_query = mysql_query("$query");
	} else {
		$query = "update cart set qty = '".$qty."' where uid = '".$userid."' and item_id = '".$item_id."'";
		$server_query = mysql_query("$query");
	}
}
?>
<!DOCTYPE html>
<html class="html">
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
		<header>
			<div class="header-top">
				<div class="container">
					<div class="row">
						<div class="col-md-6 col-xs-12 col-sm-12">
							<div class="header-top-left">
								<span>欢迎<?php echo"$username"?>光临 物友-情书~</span>
								<span class="cf">
									<a href="register.html" class="cf">
                                       	<?php if($userid == ""){
											echo "注册";
										}
										?>
                                    </a>
								</span>
                                <span class="cf">
									<a href="login.html" class="cf">
                                       	<?php if($userid == ""){
											echo "登录";
										}
										?>
                                    </a>
								</span>
                                <span class="cf">
									<a href="login.html" class="cf">
                                       	<?php if($userid != ""){
											echo '<a href="login.php?action=logout">注销</a>';
										}
										?>
                                    </a>
								</span>
							</div>
						</div>
						<div class="col-md-6 col-xs-12 col-sm-12">
							<div class="header-top-right">
								<ul style="text-align: center;margin-left: -40px;">
									<li class="floatleft">
                                        <a href="#">
                                        	<i  class="glyphicon glyphicon-shopping-cart" style="color: hotpink;"></i>
                                           	购物车
                                        </a>
                                    </li>
                                    <li class="floatleft">
                                        <a href="#">
                                        	<i  class="glyphicon glyphicon-heart-empty"></i>
                                           	我的收藏
                                        </a>
                                    </li>
									<li class="floatleft dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="down1">
                                           	个人中心<i  class="glyphicon glyphicon-triangle-bottom" style="color: #87CEEB;"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="down1">
                                        	<li><a href="#">密码修改</a></li>
										    <li role="separator" class="divider"></li>
										    <li><a href="#">我的收藏</a></li>
										    <li><a href="#">我的订单</a></li>
                                        </ul>
                                    </li>
                                    <li class="floatleft dropdown hidden-sm hidden-xs">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="down2">
                                           	卖家中心<i  class="glyphicon glyphicon-triangle-bottom" style="color: #87CEEB;"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="down2">
                                        	<li><a href="#">添加商品</a></li>
										    <li role="separator" class="divider"></li>
										    <li><a href="#">管理未售</a></li>
										    <li><a href="#">管理订单</a></li>
                                        </ul>
                                    </li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="header-middle">
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-xs-12 col-sm-4">
							<div class="logo1">
								<img src="img/logo/logo2.1.jpg" />
							</div>
						</div>
						<div class="col-md-5 col-xs-12 col-sm-8">
							<div style="width: 100%;margin-top: 30px;">
									<form action="#">
										<div style="float:left;width: 87%;">
											<input type="text" class="form-control" placeholder="搜索书库"/>	
										</div>
										<button type="submit" class="sub" value="">
											<span class="glyphicon glyphicon-search"></span>
										</button>
									</form>
							</div>
						</div>
						<div class="col-md-3 hidden-xs hidden-sm">
							<div class="logo2">
								<img src="img/logo/logo1.2.png" />
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>
		<!--header	结束-->
		
		<!--中间区域tab页开始-->
		<div class="container">
			<div class="row">
				<div class="col-md-5 hidden-sm hidden-xs">
					
				</div>
				<div class="col-md-7 hidden-sm hidden-xs text-center">
					<div class="wu pad-bg">我的购物车</div>
					<div class="glyphicon glyphicon-arrow-right wu"></div>
					<div class="wu pad-bg">填写订单</div>
					<div class="glyphicon glyphicon-arrow-right wu"></div>
					<div class="wu pad-bg">完成订单</div>
				</div>
			</div>
		</div>
		<!--收藏	 开始-->
		<div class="container">
			<div class="row">
				<!--左侧目录栏-->
				<div class="hidden-lg hidden-md hidden-sm hidden-xs">
					<h3>个人中心</h3>
					<ul>
						<li><a href="#">密码修改</a></li>
						<li><a href="#">我的收藏</a></li>
						<li><a href="#">我的订单</a></li>
					</ul>
					<h3>卖家中心</h3>
					<ul>
						<li><a href="#">添加商品</a></li>
						<li><a href="#">管理未售</a></li>
						<li><a href="#">管理订单</a></li>
					</ul>
				</div>
				<!--收藏区域-->
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
						<li class="col-md-1 text-right">
							<div class="row">
								操作
							</div>
						</li>
					</ul>
					<hr />
					<!--购物单-->
					
					<!--动态加载区域-->
					<ul class="cart-con">
						<li class="col-md-1 col-sm-1 col-xs-1 no-padding">
							<input type="checkbox" name=""/>
						</li>
						<li class="col-md-1 col-sm-4 col-xs-4 no-padding">
							<a href="#"><img src="img/21.jpg" class="t-img"></a>
						</li>
						<li class="col-md-10 col-sm-7 col-xs-7 no-padding">
							<ul class="cart-con">
								<li class="col-md-5 col-sm-12 col-xs-12"><a href="#"><span class="t-title">计算机科学技术与物联网工程组成原理</span></a></li>
								<li class="col-md-1 hidden-sm hidden-xs"><span class="t-title">￥48</span></li>
								<li class="col-md-2 col-md-offset-1 col-sm-8 col-xs-8">
									<a href="#" class="change jian1">-</a>
									<input type="text" value="" class="add-num"/>
									<a href="#" class="change jia1">+</a>
								</li>
								<li class="col-md-2 col-sm-1 col-xs-1"><h5 class="t-price">￥48</h5></li>
								<li class="col-md-1 col-sm-2 col-xs-12">
									<a href="#"><span class="t-delete">收藏</span></a>
									<a href="#"><span class="t-delete">删除</span></a>
								</li>
							</ul>
						</li>
					</ul>
					<!--动态加载区域-->
				</div>
				<div class="pay col-md-12">
					<ul class="shopping-cart hidden-sm hidden-xs cart-con">
						<li class="col-md-1">
							<div class="row">
								<input type="checkbox" name=""/><label for="">全选</label>
							</div>
						</li>
						<li class="col-md-2 text-center">
							<div class="row">
								<a href="#">批量删除</a>
							</div>
						</li>
						<li class="col-md-3 text-center">
							<div class="row">
								已经选择？件商品
							</div>
						</li>
						<li class="col-md-3 text-right">
							<div class="row">
								<span class="rt-mar">总计：</span>
							</div>
						</li>
						<li class="col-md-1 text-left">
							<div class="row">
								1231321321
							</div>
						</li>
						<li class="col-md-2 text-right">
							<div class="row">
								<button type="button" class="payment">
									结算
								</button>
							</div>
						</li>
					</ul>
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
		<!--下拉菜单出现-->
		<script>
			$("data-toggle").dropdown();
		</script>
	</body>
</html>
		