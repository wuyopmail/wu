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
$type = getvar(@$_GET['type']);
$page = getvar(@$_GET['page']);
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
		<?php
		include_once('./core/header.php');
		?>
		<!--header	结束-->
		<!--head_banner	开始-->
		<div class="col-lg-12 col-md-12 col-sm-12 hidden-xs">
			<div class="row">
				<div class="head_banner1">
					<div class="container">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="cent">
									<a href="index.php">
										<span class="glyphicon glyphicon-home"></span>&nbsp;
										<span class="glyphicon glyphicon-chevron-right"></span>&nbsp;
										<span>shop</span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="hidden-lg hidden-md hidden-sm col-xs-12">
			<div class="row">
				<div class="head_banner2">
					<div class="container">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="cent">
									<a href="index.php">
										<span class="glyphicon glyphicon-home"></span>&nbsp;
										<span class="glyphicon glyphicon-chevron-right"></span>&nbsp;
										<span>shop</span>
									</a>
								</div>
							</div>
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
							<ul>
								<li>
									<a href="index.php?type=大学教材" class="btn">
										<i class="glyphicon glyphicon-pushpin"></i>
										大学教材 
									</a>
								</li>
								<li>
									<a href="index.php?type=英语考级" class="btn">
										<i class="glyphicon glyphicon-pushpin"></i>
										 英语考级
									</a>
								</li>
								<li>
									<a href="index.php?type=考研专题" class="btn">
										<i class="glyphicon glyphicon-pushpin"></i>
										 考研专题
									</a>
								</li>
								<li>
									<a href="index.php?type=公务员项" class="btn">
										<i class="glyphicon glyphicon-pushpin"></i>
										 公务员项
									</a>
								</li>
								<li>
									<a href="index.php?type=课外书本" class="btn">
										<i class="glyphicon glyphicon-pushpin"></i>
										 课外书本
									</a>
								</li>
								<li>
									<a href="index.php?type=旧书教材" class="btn">
										<i class="glyphicon glyphicon-pushpin"></i>
										 旧书教材
									</a>
								</li>
								<li>
									<a href="data_statistics.php" class="btn">
										<i class="glyphicon glyphicon-pushpin"></i>
										 销售排行
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
							    			<i class="glyphicon glyphicon-fire"></i>
							    			<?php
											if($type==''){
												echo "热门资料";
											} else {
												echo "$type";
											}
											?>
								    	</h3>
								  	</div>
								</div>
							</div>
							<?php
							$query = "select count(*) from item order by item_id DESC";
							$num = mysql_query("$query");
							$num = mysql_fetch_array($num);
							$num = $num[0];
							$page_num = $num / 50;//每页商品数量
							$page_num = intval($page_num) + 1;
							//echo $page_num;
							if($search == ''){
								if($page == ''){
									$query = "select * from item where type like '%$type%' order by item_id DESC limit 0,50";
								} else {
									$page--;
									$page = $page * 50;
									$query = "select * from item where type like '%$type%' order by item_id DESC limit $page,50";
								}
							} else {
								$query = "select * from item where item_name like '%$search%' order by item_id DESC limit 0,50";
							}
							//print_r($query);
							$queryuser = mysql_query("$query");
							//print_r($query);
							while($row = mysql_fetch_array($queryuser)){
							echo <<<EOT
							<div class="col-md-4 col-sm-6 col-xs-12 top-mar">
								<div class="single-product">
									<div class="single-product-img">
										<a href="single_product.php?item_id=$row[item_id]">
											<img class="imgs1" src="img/singlepro/8.jpg" />
										</a>
									</div>
									<div class="single-product-content">
										<div class="product-title">
                                            <h5>
                                                <a href="single_product.php?item_id=$row[item_id]">$row[item_name]</a>
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
                                            <a class="add-wishlist" href="./wish_list.php?item_id=$row[item_id]" title="add to wishlist">
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
							<!--替换翻页-->
							<div class="col-md-12 col-xs-12 mar">
								<form action="" method="post">
									<ul class="go">
										<li class="prev-next"><a href="#">上一页</a></li>
										<li style="width: 60px;">
											<input type="text" value="" class="wid-all"/>
										</li>
										<li class="">
											<input type="submit" value="跳转"/>
										</li>
										<li class="prev-next">
											（共<span>10</span>页）
										</li>
										<li class="prev-next"><a href="#">下一页</a></li>
									</ul>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--shop_area	结束-->
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
										<a href="about.html" class="colorwhite">
											<i class="glyphicon glyphicon-grain"></i>
											功能简介
										</a>
									</li>
									<li>
										<a href="about.html" class="colorwhite">
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
										<a href="about.html" class="colorwhite">
											<i class="glyphicon glyphicon-grain"></i>
											团队简介
										</a>
									</li>
									<li>
										<a href="about.html" class="colorwhite">
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
										<a href="send_message.html" class="colorwhite">
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
		<!--返回,后退按钮隐藏-->
		<script type='text/javascript'>  
	            //显隐按钮  
	            function showReposBtn(){  
	                var clientHeight = $(window).height();  
	                var scrollTop = $(document).scrollTop();  
	                var maxScroll = $(document).height() - clientHeight;  
	                //滚动距离超过可视一屏的距离时显示返回顶部按钮  
	                if( scrollTop > clientHeight || scrollTop >= maxScroll ){  
	                    $('#return_top').show();
	                    $('#back').show();
	                }else{  
	                    $('#return_top').hide();
	                    $('#back').hide();
	                }
	            }  
              
	            window.onload = function(){  
	                //获取文档对象  
	                $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $("html") : $("body")) : $("html,body");  
	                //显示按钮  
	                showReposBtn();  
	            }  
              
	            window.onscroll = function(){  
	                //滚动时调整按钮显隐  
	                showReposBtn();  
	            }  
              
	            //返回顶部  
	            function returnTop(){  
	                $body.animate({scrollTop: 0},400);  
	            }
	        </script>
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
