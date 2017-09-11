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
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
$getitem_id = @$_GET[item_id];
$user_query = mysql_query("select * from user where uid=$userid limit 1");
$row = mysql_fetch_array($user_query);
$server_query = mysql_query("select * from server where uid=$userid limit 50");
if($getitem_id == ''){
	$item_id = '';
} else {
	$item_id = $getitem_id;
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
//本页数据
$count_price = 0;//计算总价
//$item_id_all = "";//商品id
if($item_id != ''){
	$query = "select * from item where item_id = '".$item_id."'";
	$server_query = mysql_query("$query");
	$server_query = mysql_fetch_array($server_query);
	$row = $server_query;
	print_r($row);
}
$row1 = $row;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>物品详情</title>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/index.css" />
		<link rel="stylesheet" href="css/product.css" />
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
									<li class="floatleft">
                                        <a href="#">
                                           	个人中心
                                        </a>
                                        <i  class="glyphicon glyphicon-triangle-bottom" style="color: #87CEEB;"></i>
                                    </li>
                                    <li class="floatleft hidden-xs hidden-sm">
                                        <a href="#">
                                           	卖家中心
                                        </a>
                                        <i  class="glyphicon glyphicon-triangle-bottom" style="color: #87CEEB;"></i>
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
		<!--head_banner	开始-->
		<div class="head_banner">
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
					
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="row">
							<div class="col-md-9 col-sm-12 col-xs-12">
								<!--嵌套显示-->
								<div class="row">
									<div class="col-md-12 col-sm-12 col-xs-12">
								<!--书物标题-->
									<div id="book-title">
										<div class="panel panel-info  mar">
										  	<div class="panel-heading">
									    		<a href="index.html">
									    			<h2 class="panel-title">
									    				<?php echo $row['item_name'];?>
									    			</h2>
									    		</a>
										  	</div>
										</div>
									</div>
									</div>
									<div class="col-md-8 col-sm-12 col-xs-12">
									<!--书物图片-->
										<div class="col-md-12 col-sm-12 col-xs-12 img-bor text-center auto-width">
											<img src="img/head_banner/cat-and-piano.jpg" id="placeholder" class="big-img"/>
										</div>
										<!--缩略图-->
										<div class="col-md-12 col-sm-12 col-xs-12 img-bor top-mar bot-mar">
											<div class="text-center bg-c-gr">
												<i class="glyphicon glyphicon-chevron-left i-lf"></i>
												<ul class="inline-small" id="imagegallery">
													<li>
														<a href="img/singlepro/1.jpg">
															<img src="img/singlepro/1.jpg" title="placeholder" class="small-img"/>
														</a>
													</li>
													<li>
														<a href="img/singlepro/10.jpg">
															<img src="img/singlepro/10.jpg" title="placeholder" class="small-img"/>
														</a>
													</li>
													<li>
														<a href="img/singlepro/11.jpg">
															<img src="img/singlepro/11.jpg" title="placeholder" class="small-img"/>
														</a>
													</li>
													<li>
														<a href="img/singlepro/12.jpg">
															<img src="img/singlepro/12.jpg" title="placeholder" class="small-img"/>
														</a>
													</li>
												</ul>
												<i class="glyphicon glyphicon-chevron-right i-rt"></i>
											</div>
										</div>
									</div>
									<div class="col-md-4 col-sm-12 col-xs-12">
									<!--书物介绍-->
										<div id="book">
											<div class="book-con">
												<p>
													作者： <span><?php echo $row['author'];?></span> <!--数据返回-->
												</p>
												<p>
													出版社： <span><?php echo $row['press'];?></span> <!--数据返回-->
												</p>
												<p>
													页数： <span><?php echo $row['page'];?></span> <!--数据返回-->
												</p>
												<p>
													成色： <span><?php echo $row['condition_precent'];?></span> <!--数据返回-->
												</p>
												<p>
													ISBN： <span><?php echo $row['isbn'];?></span> <!--数据返回-->
												</p>
											</div>
											<div class="book-price">
												<p>
													售价： ¥ <span class="or-color"><?php echo $row['discount_price'];?></span> <!--数据返回-->
												</p>
												<p>
													原价： ¥ <span class="decoration"><?php echo $row['price'];?></span> <!--数据返回-->
												</p>
												<p>
													<span>配送至：</span>
													<input type="text" value="不需要" id="address" class="input-sm"/> <!--数据返回-->
												</p>
											</div>
											<form action="./shopping_cart.php" method="get">
												<div class="add-to-cart mar">
													<p>
														<span>购买数量：</span>
														<a href="#" id="jian">-</a>
														<input type="text" value="1" name="qty" id="add-num" style="display: inline; width: 15%;"/> <!--数据返回-->
														<a href="#" id="jia">+</a>
														<span>（库存数120）</span>
													</p>
													<div class="pro-action">
														<input type="hidden" value="<?php echo $item_id;?>" name="item_id" id="item_id" />
														<button type="submit" class="button btn btn-default" title="add to cart">
															<i class="glyphicon glyphicon-shopping-cart"></i>
															加入购物车
														</button>
														<a class="add-wishlist" href="#" title="add to wishlist">
															<i class="glyphicon glyphicon-heart-empty "></i>
														</a>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
									
							</div>
							<div class="col-md-3 col-sm-12 col-xs-12 mar">
								<!--商铺简介以及QQ交流工具-->
								<div class="row img-bor text-center bookshop-info">
									<ul class="shop-info">
										<li>店铺名称：惠民书屋</li>
										<li>店主昵称：超人不会飞</li>
										<li>--------------------------------------</li>
										<li>--------------------------------------</li>
										<li>
											客服姐姐：
											<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=501443528&site=qq&menu=yes">
												<img border="0" src="http://wpa.qq.com/pa?p=2:501443528:51" alt="点击这里给我发消息" title="点击这里给我发消息"/>
											</a>
										</li>
										<li>店铺地址：北京物资学院6号家属楼</li>
										<li>--------------------------------------</li>
										<li>--------------------------------------</li>
										<li>联系方式：110</li>
										<li>开通时间：2017-8-1</li>
										<li>--------------------------------------</li>
										<li>--------------------------------------</li>
									</ul>
								</div>
							</div>
							<!--商品详情	商品评价	支付说明	配送说明-->
							<div class="col-md-12 col-sm-12 col-xs-12">
								<!--导航-标签页-->
								<div class="col-md-2 hidden-sm hidden-xs">
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
								<div class="col-md-10 hidden-sm hidden-xs  top-mar">
									<!--导航-标签页-->
									<ul class="nav nav-tabs" style="margin-top: -6px;">
									  <li role="presentation" class="active"><a href="#">商品详情</a></li>
									  <li role="presentation"><a href="#evaluation">商品评价</a></li>
									  <li role="presentation"><a href="#pay">支付说明</a></li>
									  <li role="presentation"><a href="#send">配送说明</a></li>
									</ul>
								</div>
								<div class="col-md-10 hidden-sm hidden-xs">
									<!--商品详情-->
									<div id="book-content">
										<p><strong>书物分类：</strong></p>
										<a href="#" class="lr-pad">书本分类 >><?php echo $row['type'];?></a>
										<p><strong>详细描述：</strong></p>
										<p id="book-info"><?php echo $row['content'];?></p>
									</div>
								</div>
								<div class="col-md-10 hidden-sm hidden-xs mar">
									<!--商品评价-->
									<h4 id="evaluation">
										商品评价
										<a herf="">
											<span class="floatright size-font">更多>></span>
										</a>
									</h4>
									<div class="table-responsive">
										<table class="table">
											<tr>
												<th>全部评价</th>
												<th>评价内容</th>
												<th>评价用户</th>
												<th>评价时间</th>
											</tr>
											<?php
											$query = "select * from item where item_id = '".$item_id."'";
											$queryuser = mysql_query("$query");
											$i=0;
											while($row = mysql_fetch_array($queryuser)){
												$query = "select * from evaluation where item_id = '".$item_id."'";
												$eva_query = mysql_query("$query");
												$eva_query = mysql_fetch_array($eva_query);
												$time = date(("Y-m-d"),$eva_query['time']);
											echo <<<EOT
											<tr>
												<td>
													<i class="glyphicon glyphicon-thumbs-up"></i>$eva_query[precent]分
												</td>
												<td>$eva_query[comment]</td>
												<td>
													<i class="glyphicon glyphicon-user"></i>$eva_query[uid]
												</td>
												<td><span>$time</span></td>
											</tr>
EOT;
											}
											?>
										</table>
									</div>
									
								</div>
								<div class="col-md-10 col-md-offset-2 hidden-sm hidden-xs mar">
									<!--支付说明-->
									<h4 id="pay">
										支付说明
									</h4>
									<div id="pay-info">
										<p><strong>中介保护付款：</strong></p>
										<p class="lr-pad">
											&nbsp;&nbsp;&nbsp;&nbsp;买家付款后资金先暂存到网站中介保护账户，买家收到货并确认后，资金才转到卖家在网站的资金账户中，如有问题，可以申请退款以及换货。这种支付方式交易快速而且有保障，推荐您使用这种方式进行支付～
										</p>
										<p><strong>即时到账：</strong></p>
										<p class="lr-pad">
											买家资金将直接转到卖家在网站的资金账户，卖家收到钱后发货，这种支付方式同样快速但是无保障。
										</p>
										<p><strong>线下交易：</strong></p>
										<p class="lr-pad">
											通过线下购买，卖家收到钱后交易，需要徒步至书店，交易速度慢，不如等书送上门。
										</p>	
									</div>
								</div>
								<div class="col-md-10 col-md-offset-2 hidden-sm hidden-xs">
									<!--配送说明-->
									<h4 id="send">
										配送说明
									</h4>
									<div id="send-info">
										<p><strong>10kg以内包邮：</strong></p>
										<p class="lr-pad">
											不收运费
										</p>
										<p><strong>10kg以后加费用：</strong></p>
										<p class="lr-pad">
											加收相应运费
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
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
		<!--header顶部下拉菜单-->
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
		<!--切换缩略图-->
		<script type="text/javascript">
			//	showpic（whichpic）函数	whicpic是指某个元素节点，例<a>	用来修改图片占位符的src参数
			function showpic(whichpic){
				if(!document.getElementById("placeholder"))return false;
				var source = whichpic.getAttribute("href");
				var placeholder = document.getElementById("placeholder");
				placeholder.setAttribute("src",source);
			}
			
			//	prepareGallery()函数		对每一个<a>标签绑定点击事件，点击会修改图片占位符 的src参数
			function prepareGallery(){
				if(!document.getElementsByTagName)return false;
				if(!document.getElementById)return false;
				if(!document.getElementById("imagegallery"))return false;
				var garllery = document.getElementById("imagegallery");
				var links = garllery.getElementsByTagName("a");
				for(var i=0;i<links.length;i++){ 
					links[i].onclick = function(){
						showpic(this);
						return false;
					}
				}
			}
			window.onload = prepareGallery();
		</script>
		<!--增减买卖货物数量-->
		<script type="text/javascript">
			var cart_nums=1;
			function change_num(){
				var add_num = document.getElementById("add-num");
				var jian = document.getElementById("jian");
				var jia = document.getElementById("jia");
				jian.onclick = function(){
					if(cart_nums>0){
						cart_nums--;
						add_num.value = cart_nums;
					}
					return false;
				}
				jia.onclick = function(){
					cart_nums++;
					add_num.value = cart_nums;
					return false;
				}
			}
			window.onload = change_num();
		</script>
	</body>
</html>
