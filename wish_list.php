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
$address = $row['address'];
$name = $row['name'];
$telephone = $row['telephone'];
$disabled = $row['name'];
$row1 = $row;
$item_id_all = '';
$delete_id = getvar(@$_GET['delete_id']);
$add_id = getvar(@$_GET['item_id']);
if($delete_id != ''){
	$query = "delete from bookmark where uid = '".$userid."' and item_id = '".$delete_id."'";
	//print_r($query);
	$delete_id = mysql_query("$query");
}
if($add_id != ''){
	$query = "insert into bookmark(uid, item_id, time) values ('".$userid."', '".$add_id."', '".time()."')";
	//print_r($query);
	$delete_id = mysql_query("$query");
}
?>
<!DOCTYPE html>
<html class="html">
	<head>
		<meta charset="UTF-8">
		<title>我的收藏</title>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/index.css" />
		<link rel="stylesheet" href="css/shopping_cart.css" />
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
		<header>
			<div class="header-top">
				<div class="container">
					<div class="row">
						<div class="col-md-6 col-xs-12 col-sm-12">
							<div class="header-top-left">
								<span>欢迎光临 物友-情书~</span>
								<span class="cf">
									<a href="register.html" class="cf">
                                       	注册
                                    </a>
								</span>
                                <span class="cf">
									<a href="login.html" class="cf">
                                       	登录
                                    </a>
								</span>
							</div>
						</div>
						<div class="col-md-6 col-xs-12 col-sm-12">
							<div class="header-top-right">
								<ul style="text-align: center;margin-left: -40px;">
									<li class="floatleft">
                                        <a href="shopping_cart.html">
                                        	<i  class="glyphicon glyphicon-shopping-cart" style="color: hotpink;"></i>
                                           	购物车
                                        </a>
                                    </li>
                                    <li class="floatleft">
                                        <a href="wish_list.html">
                                        	<i  class="glyphicon glyphicon-heart-empty"></i>
                                           	我的收藏
                                        </a>
                                    </li>
									<li class="floatleft dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="down1">
                                           	个人中心<i  class="glyphicon glyphicon-triangle-bottom" style="color: #87CEEB;"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="down1">
                                        	<li><a href="secret_revise.html">密码修改</a></li>
										    <li role="separator" class="divider"></li>
										    <li><a href="wish_list.html">我的收藏</a></li>
										    <li><a href="order.html">我的订单</a></li>
                                        </ul>
                                    </li>
                                    <li class="floatleft dropdown hidden-sm hidden-xs">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="down2">
                                           	卖家中心<i  class="glyphicon glyphicon-triangle-bottom" style="color: #87CEEB;"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="down2">
                                        	<li><a href="items_add.html">商品添加</a></li>
										    <li role="separator" class="divider"></li>
										    <li><a href="items_revise.html">商品管理</a></li>
										    <li><a href="#">数据统计</a></li>
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
								<a href="index.html">
									<img src="img/logo/logo1.2.png" />
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>
		<!--header	结束-->
		<!--收藏	 开始-->
		<div class="container">
			<div class="row">
				<!--左侧目录栏-->
				<div class="col-md-2 hidden-sm hidden-xs lf-nav">
					<h4 class="lf-nag-bgc row">个人中心</h4>
					<ul class="lf-nav-ul">
						<li><a href="#"><i class="glyphicon glyphicon-grain"></i>密码修改</a></li>
						<li><a href="#"><i class="glyphicon glyphicon-grain"></i>我的收藏</a></li>
						<li><a href="#"><i class="glyphicon glyphicon-grain"></i>我的订单</a></li>
					</ul>
					<h4 class="lf-nag-bgc row">卖家中心</h4>
					<ul class="lf-nav-ul">
						<li><a href="#"><i class="glyphicon glyphicon-grain"></i>添加商品</a></li>
						<li><a href="#"><i class="glyphicon glyphicon-grain"></i>管理未售</a></li>
						<li><a href="#"><i class="glyphicon glyphicon-grain"></i>管理订单</a></li>
					</ul>
				</div>
				<!--收藏区域-->
				<div class="col-md-10 col-sm-12 col-xs-12">
					<!--全选标题栏-->
					<div class="hidden-md hidden-lg col-xs-12 cart-con text-center hidden-font">我的收藏</div>
					<ul class="shopping-cart hidden-sm hidden-xs cart-con">
						<li class="col-md-1">
							<div class="row">
								<input type="checkbox" id="all_check" name=""/><label for="">全选</label>
							</div>
						</li>
						<li class="col-md-5 text-center">
							<div class="row">
								商品信息
							</div>
						</li>
						<li class="col-md-2 text-center">
							<div class="row">
								单价
							</div>
						</li>
						<li class="col-md-2 text-right">
							<div class="row">
								收藏时间
							</div>
						</li>
						<li class="col-md-2 text-right">
							<div class="row">
								操作
							</div>
						</li>
					</ul>
					<hr />
					<!--购物单-->
					<?php
					$query = "select * from bookmark where uid = '".$userid."'";
					$queryuser = mysql_query("$query");
					while($row = mysql_fetch_array($queryuser)){
						$query = "select * from item where item_id = '".$row['item_id']."'";
						$server_query = mysql_query("$query");
						$server_query = mysql_fetch_array($server_query);
<<<<<<< HEAD
<<<<<<< HEAD
						///print_r($row);
=======
>>>>>>> 3e9698f1e4fef92b1324d69d365b2f37ad959c7d
=======
>>>>>>> 3e9698f1e4fef92b1324d69d365b2f37ad959c7d
						$times = date(("Y.m.d"),$server_query['time']);
						//print_r($times);
						echo <<<EOT
					<ul class="cart-con bord-li">
						<li class="col-md-1 col-xs-2 no-padding"><input type="checkbox" class="input_check" name=""/></li>
						<li class="col-md-2 col-xs-3 no-padding"><div class="d-img"><a href="#"><img src="img/21.jpg" class="t-img"></a></div></li>
						<li class="col-md-9 col-xs-7 no-padding"> 
							<ul class="cart-con">
								<li class="col-md-5 col-xs-12"><a href="#"><h5>$server_query[item_name]</h5></a></li>
								<li class="col-md-3 col-xs-5"><h5>￥$server_query[price]</h5></li>
								<li class="col-md-2 col-xs-7"><h5>$times</h5></li>
								<li class="col-md-2 col-xs-12 text-right">
									<a href="./shopping_cart.php?qty=1&item_id=$server_query[item_id]"><span>移入至<i class="glyphicon glyphicon-shopping-cart"></i></span></a>
									<a href="./wish_list.php?delete_id=$server_query[item_id]"><span class="t-delete">删除</span></a>
								</li>
							</ul>
						</li>
					</ul>
EOT;
					}
					?>
					<!--动态加载区域-->
					
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
		<script type="text/javascript" src="js/bootstrap.min.js" ></script>
		<script type="text/javascript" src="layer/layer.js"></script>
		<!--placeholder	对IE浏览器支持-->
		<script type="text/javascript">
		    $(function () {
		        // Invoke the plugin
		        $('input, textarea').placeholder();
		        //全选功能
		        $('#all_check').click(function(){
	        	    var status = $(this).prop('checked');
	        		$(".input_check").each(function(key, val){
	        			if (status){
	        			    $(val).prop('checked', true);
	        			} else {
	        				$(val).prop('checked', false);
	        			}
	        		});
		        });
		        function deleteApi (url, data, massage) {
		        	$.post(url, data, function (res){
		        		if (res === true) {
		        			$(this).parents('.bord-li').remove();
		        		} else {
		        			layer.msg(massage);
		        		}
		        	});
		        	return layer.msg(massage);
		        }
		        //购物车删除功能
		        $(".t-delete").click(function(){
		        	deleteApi('', {name:''}, msg);
		        });
		        //移入购物车功能
		        $(".move-car").click(function(){
		        	deleteApi('', {name:''}, msg);
		        });
		    });
		</script>
		<!--下拉菜单出现-->
		<script>
			$("data-toggle").dropdown();
		</script>
	</body> 
</html>
		