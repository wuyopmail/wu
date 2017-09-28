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
	$query = "select count(*) from bookmark where uid = '".$userid."' and item_id = '".$item_id."'";
	$exist_query = mysql_query("$query");
	$exist_query = mysql_fetch_array($exist_query);
	//print_r($exist_query);
	if($exist_query[0] == 0){
		$query = "insert into bookmark(uid, item_id, time) values ('".$userid."', '".$add_id."', '".time()."')";
		//print_r($query);
		$add_id = mysql_query("$query");
	}
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
						<li><a href="data_statistics.html"><i class="glyphicon glyphicon-grain"></i>数据统计</a></li>
					</ul>
				</div>
				<!--收藏区域-->
				<div class="col-md-10 col-sm-12 col-xs-12 min-h">
					<!--全选标题栏-->
					<div class="hidden-md hidden-lg col-xs-12 cart-con text-center hidden-font">我的收藏</div>
					<ul class="shopping-cart hidden-sm hidden-xs cart-con">
						<li class="col-md-1">
							<div class="row">
								<input type="checkbox" class="all_check" name=""/><label for="">全选</label>
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
						$times = date(("Y.m.d"),$row['time']);
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
									<a href="./shopping_cart.php?qty=1&item_id=$server_query[item_id]"><span class="move-car anniu">移入至<i class="glyphicon glyphicon-shopping-cart"></i></span></a>
									<a href="./wish_list.php?delete_id=$server_query[item_id]"><span class="t-delete anniu">删除</span></a>
								</li>
							</ul>
						</li>
					</ul>
EOT;
					}
					?>
					<!--删除所选条-->
					<ul class="cart-con">
						<li class="col-md-1 col-xs-3">
							<div class="row">
								<input type="checkbox" name="" class="all_check"/><label for="">全选</label>
							</div>
						</li>
						<li class="col-md-11 col-xs-9 text-right bot-border">
							<div class="row">
								<a href="#" data-toggle="modal" data-target="#myModal2">删除所选</a>
							</div>
						</li>
					</ul>
					
				</div>
			</div>
		</div>
		<!--目录	 结束-->
		<!--后退按钮以及返回顶部设置-->
		<div class="back-fix" id="back">
			<i class="glyphicon glyphicon-arrow-left"></i>
		</div>
		<div class="up-fix">
			<a href="#top"><i class="glyphicon glyphicon-arrow-up"></i></a>
		</div>
		<!--footer	开始-->
		<footer>
			<div class="footer-area">
				
				<div class="footer-start">
					<div class="container">
						<div class="row">
							<div class="foot-top-padding col-md-12 col-lg-12 hidden-sm hidden-xs"></div>
							<div class="col-md-3 hidden-xs text-center">
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
							<div class="col-md-3 hidden-xs text-center">
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
							<div class="col-md-3 hidden-xs text-center">
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
							<div class="col-md-3 hidden-xs text-center">
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
				<div class="footer-endtext-center">
					<div class="container">
						<div class="row">
							<div class="foot-top-margin col-md-12 col-lg-12 hidden-sm hidden-xs"></div>
							<div class="footer-end-e text-center">
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
		        $('.all_check').click(function(){
	        	    var status = $(this).prop('checked');
	        		$(".input_check,.all_check").each(function(key, val){
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
		<!--后退按钮-->
		<script type="text/javascript">
		    var goBack = document.getElementById('back');
		    goBack.onclick = function(){
		      // console.log("1");
		      window.history.back(-1); 
		    }
		 </script>
	</body> 
</html>
		