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
<html>
	<head>
		<meta charset="UTF-8">
		<title>主页</title>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/index.css" />
		<link rel="stylesheet" href="css/product.css" />
		<link rel="stylesheet" href="css/shopping_cart.css" />
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
		<!--head_banner	开始-->
		<div class="head_banner">s
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="cent">
							<a href="index.html">
								<span class="glyphicon glyphicon-home"></span>&nbsp;
								<span class="glyphicon glyphicon-chevron-right"></span>&nbsp;
								<span>shop</span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--head_banner	 结束-->
		<!--shop_area	开始-->
		<div class="shop-area">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-sm-3 col-xs-12">
						<div class="content-box">
							<span class="zt">书本分类</span>
							<ul class="">
								<li>
									<a href="#" class="btn">
										<i class="glyphicon glyphicon-pushpin"></i>
										大学教材 
									</a>
								</li>
								<li>
									<a href="#" class="btn">
										<i class="glyphicon glyphicon-pushpin"></i>
										 英语考级
									</a>
								</li>
								<li>
									<a href="#" class="btn">
										<i class="glyphicon glyphicon-pushpin"></i>
										 考研专题
									</a>
								</li>
								<li>
									<a href="#" class="btn">
										<i class="glyphicon glyphicon-pushpin"></i>
										 公务员项
									</a>
								</li>
								<li>
									<a href="#" class="btn">
										<i class="glyphicon glyphicon-pushpin"></i>
										 课外书本
									</a>
								</li>
								<li>
									<a href="#" class="btn">
										<i class="glyphicon glyphicon-pushpin"></i>
										 旧书教材
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<div class="row">
							<!--促销横条-->
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="panel panel-info mar">
								  	<div class="panel-heading">
								    	<h3 class="panel-title">
								    		<a href="index.html">
								    			<i class="glyphicon glyphicon-fire"></i>
								    			热门资料
								    		</a>
								    	</h3>
								  	</div>
								</div>
							</div>
							<?php
							$query = "select * from item order by item_id DESC";
							$queryuser = mysql_query("$query");
							print_r($query);
							while($row = mysql_fetch_array($queryuser)){
							echo <<<EOT
							<div class="col-md-4 col-sm-6 col-xs-12 top-mar">
								<div class="single-product">
									<div class="single-product-img">
										<a href="#">
											<img src="img/singlepro/8.jpg" />
										</a>
									</div>
									<div class="single-product-content">
										<div class="product-title">
                                            <h5>
                                                <a href="#">$row[item_name]</a>
                                            </h5>
                                        </div>
                                        <div class="rating">
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star"></div>
                                        </div>
                                        <div class="price-box">
                                            <span class="price">¥$row[discount_price]</span>
                                            <span class="old-price">¥$row[price]</span>
                                        </div>
                                        <div class="product-action">
										<form action="shopping_cart.php" method="GET">
                                            <button href="#" class="button btn btn-default" title="add to cart" value="$row[item_id]" name="item_id">加入购物车</button>
                                            <a class="add-wishlist" href="#" title="add to wishlist">
                                                <i class="glyphicon glyphicon-heart-empty "></i>
                                            </a>
										</form>
                                        </div>
									</div>
								</div>
							</div>
EOT;
							}
							?>
							<div class="col-md-4 col-sm-6 col-xs-12 top-mar">
								<div class="single-product">
									<div class="single-product-img">
										<a href="#">
											<img src="img/singlepro/8.jpg" />
										</a>
									</div>
									<div class="single-product-content">
										<div class="product-title">
                                            <h5>
                                                <a href="#">例一1标题</a>
                                            </h5>
                                        </div>
                                        <div class="rating">
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star"></div>
                                        </div>
                                        <div class="price-box">
                                            <span class="price">¥50.00</span>
                                            <span class="old-price">¥70.00</span>
                                        </div>
                                        <div class="product-action">
                                            <button class="button btn btn-default" title="add to cart">加入购物车</button>
                                            <a class="add-wishlist" href="#" title="add to wishlist">
                                                <i class="glyphicon glyphicon-heart-empty "></i>
                                            </a>
                                        </div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12 top-mar">
								<div class="single-product">
									<div class="single-product-img">
										<a href="#">
											<img src="img/singlepro/8.jpg" />
										</a>
									</div>
									<div class="single-product-content">
										<div class="product-title">
                                            <h5>
                                                <a href="#">例一标题</a>
                                            </h5>
                                        </div>
                                        <div class="rating">
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star"></div>
                                        </div>
                                        <div class="price-box">
                                            <span class="price">¥50.00</span>
                                            <span class="old-price">¥70.00</span>
                                        </div>
                                        <div class="product-action">
                                            <button class="button btn btn-default" title="add to cart">加入购物车</button>
                                            <a class="add-wishlist" href="#" title="add to wishlist">
                                                <i class="glyphicon glyphicon-heart-empty "></i>
                                            </a>
                                        </div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12 top-mar">
								<div class="single-product">
									<div class="single-product-img">
										<a href="#">
											<img src="img/singlepro/8.jpg" />
										</a>
									</div>
									<div class="single-product-content">
										<div class="product-title">
                                            <h5>
                                                <a href="#">例一标题</a>
                                            </h5>
                                        </div>
                                        <div class="rating">
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star"></div>
                                        </div>
                                        <div class="price-box">
                                            <span class="price">¥50.00</span>
                                            <span class="old-price">¥70.00</span>
                                        </div>
                                        <div class="product-action">
                                            <button class="button btn btn-default" title="add to cart">加入购物车</button>
                                            <a class="add-wishlist" href="#" title="add to wishlist">
                                                <i class="glyphicon glyphicon-heart-empty "></i>
                                            </a>
                                        </div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12 top-mar">
								<div class="single-product">
									<div class="single-product-img">
										<a href="#">
											<img src="img/singlepro/8.jpg" />
										</a>
									</div>
									<div class="single-product-content">
										<div class="product-title">
                                            <h5>
                                                <a href="#">例一标题</a>
                                            </h5>
                                        </div>
                                        <div class="rating">
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star"></div>
                                        </div>
                                        <div class="price-box">
                                            <span class="price">¥50.00</span>
                                            <span class="old-price">¥70.00</span>
                                        </div>
                                        <div class="product-action">
                                            <button class="button btn btn-default" title="add to cart">加入购物车</button>
                                            <a class="add-wishlist" href="#" title="add to wishlist">
                                                <i class="glyphicon glyphicon-heart-empty "></i>
                                            </a>
                                        </div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12 top-mar">
								<div class="single-product">
									<div class="single-product-img">
										<a href="#">
											<img src="img/singlepro/8.jpg" />
										</a>
									</div>
									<div class="single-product-content">
										<div class="product-title">
                                            <h5>
                                                <a href="#">例一标题</a>
                                            </h5>
                                        </div>
                                        <div class="rating">
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star"></div>
                                        </div>
                                        <div class="price-box">
                                            <span class="price">¥50.00</span>
                                            <span class="old-price">¥70.00</span>
                                        </div>
                                        <div class="product-action">
                                            <button class="button btn btn-default" title="add to cart">加入购物车</button>
                                            <a class="add-wishlist" href="#" title="add to wishlist">
                                                <i class="glyphicon glyphicon-heart-empty "></i>
                                            </a>
                                        </div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12 top-mar">
								<div class="single-product">
									<div class="single-product-img">
										<a href="#">
											<img src="img/singlepro/8.jpg" />
										</a>
									</div>
									<div class="single-product-content">
										<div class="product-title">
                                            <h5>
                                                <a href="#">例一标题</a>
                                            </h5>
                                        </div>
                                        <div class="rating">
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star"></div>
                                        </div>
                                        <div class="price-box">
                                            <span class="price">¥50.00</span>
                                            <span class="old-price">¥70.00</span>
                                        </div>
                                        <div class="product-action">
                                            <button class="button btn btn-default" title="add to cart">加入购物车</button>
                                            <a class="add-wishlist" href="#" title="add to wishlist">
                                                <i class="glyphicon glyphicon-heart-empty "></i>
                                            </a>
                                        </div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12 top-mar">
								<div class="single-product">
									<div class="single-product-img">
										<a href="#">
											<img src="img/singlepro/8.jpg" />
										</a>
									</div>
									<div class="single-product-content">
										<div class="product-title">
                                            <h5>
                                                <a href="#">例一标题</a>
                                            </h5>
                                        </div>
                                        <div class="rating">
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star"></div>
                                        </div>
                                        <div class="price-box">
                                            <span class="price">¥50.00</span>
                                            <span class="old-price">¥70.00</span>
                                        </div>
                                        <div class="product-action">
                                            <button class="button btn btn-default" title="add to cart">加入购物车</button>
                                            <a class="add-wishlist" href="#" title="add to wishlist">
                                                <i class="glyphicon glyphicon-heart-empty "></i>
                                            </a>
                                        </div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12 top-mar">
								<div class="single-product">
									<div class="single-product-img">
										<a href="#">
											<img src="img/singlepro/8.jpg" />
										</a>
									</div>
									<div class="single-product-content">
										<div class="product-title">
                                            <h5>
                                                <a href="#">例一标题</a>
                                            </h5>
                                        </div>
                                        <div class="rating">
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star"></div>
                                        </div>
                                        <div class="price-box">
                                            <span class="price">¥50.00</span>
                                            <span class="old-price">¥70.00</span>
                                        </div>
                                        <div class="product-action">
                                            <button class="button btn btn-default" title="add to cart">加入购物车</button>
                                            <a class="add-wishlist" href="#" title="add to wishlist">
                                                <i class="glyphicon glyphicon-heart-empty "></i>
                                            </a>
                                        </div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12 top-mar">
								<div class="single-product">
									<div class="single-product-img">
										<a href="#">
											<img src="img/singlepro/8.jpg" />
										</a>
									</div>
									<div class="single-product-content">
										<div class="product-title">
                                            <h5>
                                                <a href="#">例一标题</a>
                                            </h5>
                                        </div>
                                        <div class="rating">
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star"></div>
                                        </div>
                                        <div class="price-box">
                                            <span class="price">¥50.00</span>
                                            <span class="old-price">¥70.00</span>
                                        </div>
                                        <div class="product-action">
                                            <button class="button btn btn-default" title="add to cart">加入购物车</button>
                                            <a class="add-wishlist" href="#" title="add to wishlist">
                                                <i class="glyphicon glyphicon-heart-empty "></i>
                                            </a>
                                        </div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12 top-mar">
								<div class="single-product">
									<div class="single-product-img">
										<a href="#">
											<img src="img/singlepro/8.jpg" />
										</a>
									</div>
									<div class="single-product-content">
										<div class="product-title">
                                            <h5>
                                                <a href="#">例一标题</a>
                                            </h5>
                                        </div>
                                        <div class="rating">
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star"></div>
                                        </div>
                                        <div class="price-box">
                                            <span class="price">¥50.00</span>
                                            <span class="old-price">¥70.00</span>
                                        </div>
                                        <div class="product-action">
                                            <button class="button btn btn-default" title="add to cart">加入购物车</button>
                                            <a class="add-wishlist" href="#" title="add to wishlist">
                                                <i class="glyphicon glyphicon-heart-empty "></i>
                                            </a>
                                        </div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12 top-mar">
								<div class="single-product">
									<div class="single-product-img">
										<a href="#">
											<img src="img/singlepro/8.jpg" />
										</a>
									</div>
									<div class="single-product-content">
										<div class="product-title">
                                            <h5>
                                                <a href="#">例一标题</a>
                                            </h5>
                                        </div>
                                        <div class="rating">
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star star-on"></div>
                                            <div class="star"></div>
                                        </div>
                                        <div class="price-box">
                                            <span class="price">¥50.00</span>
                                            <span class="old-price">¥70.00</span>
                                        </div>
                                        <div class="product-action">
                                            <button class="button btn btn-default" title="add to cart">加入购物车</button>
                                            <a class="add-wishlist" href="#" title="add to wishlist">
                                                <i class="glyphicon glyphicon-heart-empty "></i>
                                            </a>
                                        </div>
									</div>
								</div>
							</div>
							<div class="col-md-12 hidden-sm hidden-xs">
								<nav aria-label="Page navigation">
								  <ul class="pagination">
								    <li>
								      <a href="#" aria-label="Previous">
								        <span aria-hidden="true">&laquo;</span>
								      </a>
								    </li>
								    <li><a href="#">1</a></li>
								    <li><a href="#">2</a></li>
								    <li><a href="#">3</a></li>
								    <li><a href="#">4</a></li>
								    <li><a href="#">5</a></li>
								    <li><a href="#">6</a></li>
								    <li><a href="#">7</a></li>
								    <li><a href="#">8</a></li>
								    <li><a href="#">9</a></li>
								    <li><a href="#">10</a></li>
								    <li>
								      <a href="#" aria-label="Next">
								        <span aria-hidden="true">&raquo;</span>
								      </a>
								    </li>
								  </ul>
								</nav>
							</div>
							<div class="hidden-lg hidden-md col-sm-12 col-xs-12 text-center">
								<div style="margin: 20px;">
									<a href="#">
										<span class="form-control">加载更多~</span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--shop_area	结束-->
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
		<!--下拉菜单-->
		<script>
			$("data-toggle").dropdown();
		</script>
	</body>
</html>
