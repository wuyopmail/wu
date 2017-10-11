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
	//print_r($row);
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
		<!--head_banner	开始-->
		<div class="col-lg-12 col-md-12 col-sm-12 hidden-xs">
			<div class="row">
				<div class="head_banner1">
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
			</div>
		</div>
		<div class="hidden-lg hidden-md hidden-sm col-xs-12">
			<div class="row">
				<div class="head_banner2">
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
								    			<h2 class="panel-title">
								    				不能说的秘密
								    			</h2>
										  	</div>
										</div>
									</div>
									</div>
									<div class="col-md-8 col-sm-12 col-xs-12">
									<!--书物图片-->
										<div class="col-md-12 col-sm-12 col-xs-12 img-bor text-center auto-width">
											<img src="img/singlepro/1.jpg" id="placeholder" class="big-img"/>
										</div>
										<!--缩略图-->
										<div class="col-md-12 col-sm-12 col-xs-12 img-bor top-mar bot-mar">
											<div class="text-center bg-c-gr">
												<i class="glyphicon glyphicon-chevron-left i-lf" id="left_img" ></i>
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
													<li>
														<a href="img/singlepro/11.jpg">
															<img src="img/singlepro/11.jpg" title="placeholder" class="small-img"/>
														</a>
													</li>
												</ul>
												<i class="glyphicon glyphicon-chevron-right i-rt" id="right_img"></i>
											</div>
										</div>
									</div>
									<div class="col-md-4 col-sm-12 col-xs-12">
									<!--书物介绍-->
										<div id="book">
											<div class="book-con">
												<p>
													作者： <span>周杰伦</span> <!--数据返回-->
												</p>
												<p>
													出版社： <span>浙江人民出版社</span> <!--数据返回-->
												</p>
												<p>
													页数： <span>300</span> <!--数据返回-->
												</p>
												<p>
													品相： <span>8成新</span> <!--数据返回-->
												</p>
												<p>
													ISBN： <span>9787115249999</span> <!--数据返回-->
												</p>
											</div>
											<div class="book-price">
												<p>
													售价： ¥ <span class="or-color">34.00</span> <!--数据返回-->
												</p>
												<p>
													原价： ¥ <span class="decoration">44.00</span> <!--数据返回-->
												</p>
												<p class="hidden-lg hidden-md data">书店微信：huimin605</p>
												<p class="no-padding">
													客服姐姐：
													<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=501443528&site=qq&menu=yes">
														<img border="0" src="http://wpa.qq.com/pa?p=2:501443528:51" alt="点击这里给我发消息" title="点击这里给我发消息"/>
													</a>
												</p>
											</div>
											<form action="./shopping_cart.php" method="get">
												<div class="add-to-cart mar">
													<p>
														<span style="float: left;">购买数量：</span>
														<a id="jian" class="change">-</a>
														<input type="text" value="1" name="qty" id="add-num" class="input-num"/> <!--数据返回-->
														<a id="jia" class="change">+</a>
														<span>（库存数120）</span>
													</p>
													<div class="pro-action">
														<input type="hidden" value="<?php echo $item_id;?>" name="item_id" id="item_id" />
														<button type="submit" class="button btn btn-default" title="add to cart">
															<i class="glyphicon glyphicon-shopping-cart"></i>
															加入购物车
														</button>
														<a class="add-wishlist" href="./wish_list.php?item_id=<?php echo $item_id;?>" title="add to wishlist">
															<i class="glyphicon glyphicon-heart-empty "></i>
														</a>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
									
							</div>
							<div class="col-md-3 hidden-sm hidden-xs mar ">
								<!--商铺简介以及QQ交流工具-->
								<div class="row img-bor text-center bookshop-info">
									<ul class="shop-info">
										<li>店铺名称：惠民书屋</li>
										<li>店主昵称：超人不会飞</li>
										<li><img src="img/data.png"/></li>
										<li>微信联系如上图：huimin605</li>
										<li>电话联系：159635742882</li>
									</ul>
								</div>
							</div>
							<!--商品详情	商品评价	支付说明	配送说明-->
							<div class="col-md-12 col-sm-12 col-xs-12">
								<!--导航-标签页-->
								<div class="col-md-2 hidden-sm hidden-xs">
									<div class="content-box">
										<span class="zt">书本分类</span>
										<ul>
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
								<div class="col-md-10 col-xs-12">
									<div class="row">
										<div class="col-md-12 col-xs-12 top-mar">
											<!--导航-标签页-->
											<div class="col-md-12 hidden-xs hidden-sm">
												<div class="row">
													<ul class="nav nav-tabs" style="margin-top: -6px;">
													  <li role="presentation" class="active"><a href="#">商品详情</a></li>
													  <li role="presentation"><a href="#evaluation">商品评价</a></li>
													  <li role="presentation"><a href="#pay">支付说明</a></li>
													  <li role="presentation"><a href="#send">配送说明</a></li>
													</ul>
												</div>
											</div>
											<div class="row">
												<div class="hidden-md hidden-lg col-sm-12 col-xs-12">
													<div class="row">
														<ul class="nav nav-tabs no-p" style="margin-top: -6px;">
														  <li role="presentation" class="active"><a href="#">商品详情</a></li>
														  <li role="presentation"><a href="#evaluation">商品评价</a></li>
														  <li role="presentation"><a href="#pay">支付说明</a></li>
														  <li role="presentation"><a href="#send">配送说明</a></li>
														</ul>
													</div>
												</div>
											</div>
										</div>
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<div class="row">
												<!--商品详情-->
												<div id="book-content">
													<p><strong>书物分类：</strong></p>
													<a href="#" class="lr-pad">书本分类 >>旧书教材</a>
													<p><strong>详细描述：</strong></p>
													<p id="book-info">请同学看好下单，如有疑问可在售前问清，如有不满意可持旧书教材到书店进行换货</p>
												</div>
											</div>
										</div>
										<div class="table-responsive col-lg-12 col-md-12 hidden-xs hidden-sm">
											<div class="row">
												<!--商品评价-->
												<h4 id="evaluation">
														商品评价
														<span class="lr-pad2">累计评价12条</span>
														<a href="evaluation.html">
															<span class="floatright size-font">更多>></span>
														</a>
												</h4>
												<table class="table">
													<tr>
														<th>全部评价</th>
														<th>评价内容</th>
														<th>评价用户</th>
														<th>评价时间</th>
													</tr>
													<tr>
														<td>
															<i class="glyphicon glyphicon-thumbs-up"></i>好评！
														</td>
														<td>旧书教材很便宜，书中还有此前学长的一些笔记，成色一般，不过不错</td>
														<td>
															<i class="glyphicon glyphicon-user"></i>chenf
														</td>
														<td><span>2017-8-1</span></td>
													</tr>
													<tr>
														<td>
															<i class="glyphicon glyphicon-thumbs-up"></i>好评！
														</td>
														<td>旧书教材很便宜，书中还有此前学长的一些笔记，成色一般，不过不错</td>
														<td>
															<i class="glyphicon glyphicon-user"></i>chenf
														</td>
														<td><span>2017-8-1</span></td>
													</tr>
													<tr>
														<td>
															<i class="glyphicon glyphicon-thumbs-up"></i>好评！
														</td>
														<td>旧书教材很便宜，书中还有此前学长的一些笔记，成色一般，不过不错</td>
														<td>
															<i class="glyphicon glyphicon-user"></i>chenf
														</td>
														<td><span>2017-8-1</span></td>
													</tr>
												</table>
											</div>
										</div>
										<div class="hidden-lg hidden-md col-sm-12 col-xs-12">
											<div class="row">
												<!--移动端评价显示-->
												<h4 id="evaluation">
													商品评价
													<span class="floatright">累计12条</span>
												</h4>
												<ul class="cart-con bord-li3">
													<li class="col-md-1 col-sm-12 col-xs-12 no-padding min-height">
														&nbsp;&nbsp;<i class="glyphicon glyphicon-thumbs-up"></i>好评！&nbsp;&nbsp;
														<span>旧书教材很便宜，书中还有此前学长的一些笔记，成色一般，不过不错</span>
													</li>
													<li class="col-md-10 col-sm-6 col-xs-6 no-padding">
														&nbsp;&nbsp;<span><i class="glyphicon glyphicon-user"></i>chenf</span>
													</li>
													<li class="col-md-10 col-sm-6 col-xs-6 no-padding text-center">
														&nbsp;&nbsp;<span>2017-8-1</span>
													</li>
												</ul>
												<ul class="cart-con bord-li3">
													<li class="col-md-1 col-sm-12 col-xs-12 no-padding min-height">
														&nbsp;&nbsp;<i class="glyphicon glyphicon-thumbs-up"></i>好评！&nbsp;&nbsp;
														<span>旧书教材很便宜，书中还有此前学长的一些笔记，成色一般，不过不错</span>
													</li>
													<li class="col-md-10 col-sm-6 col-xs-6 no-padding">
														&nbsp;&nbsp;<span><i class="glyphicon glyphicon-user"></i>chenf</span>
													</li>
													<li class="col-md-10 col-sm-6 col-xs-6 no-padding text-center">
														&nbsp;&nbsp;<span>2017-8-1</span>
													</li>
												</ul>
												<ul class="cart-con bord-li3">
													<li class="col-md-1 col-sm-12 col-xs-12 no-padding min-height">
														&nbsp;&nbsp;<i class="glyphicon glyphicon-thumbs-up"></i>好评！&nbsp;&nbsp;
														<span>旧书教材很便宜，书中还有此前学长的一些笔记，成色一般，不过不错</span>
													</li>
													<li class="col-md-10 col-sm-6 col-xs-6 no-padding">
														&nbsp;&nbsp;<span><i class="glyphicon glyphicon-user"></i>chenf</span>
													</li>
													<li class="col-md-10 col-sm-6 col-xs-6 no-padding text-center">
														&nbsp;&nbsp;<span>2017-8-1</span>
													</li>
												</ul>
												<div class="text-center">
													<div style="margin: 20px;">
														<a href="evaluation.html">
															<span class="form-control">更多评价~</span>
														</a>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12 col-xs-12">
											<div class="row">
												<!--支付说明-->
												<h4 id="pay">
													支付说明
												</h4>
												<div id="pay-info">
													<p><strong>线上下单-->线下交易：</strong></p>
													<p class="lr-pad">
														通过线上下单，系统收到订单后，直接将购买图书送上门，面付即可，交易结束后请同学线上确认收货，并填写书物评价，已助自己或他人参考。
													</p>	
												</div>	
											</div>
										</div>
										<div class="col-md-12 col-xs-12">
											<div class="row">
												<!--配送说明-->
												<h4 id="send">
													配送说明
												</h4>
												<div id="send-info">
													<p><strong>5kg以内包邮：</strong></p>
													<p class="lr-pad">
														不收运费
													</p>
													<p><strong>5kg以后加费用：</strong></p>
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
				</div>
			</div>
		</div>
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
		<!--header顶部下拉菜单-->
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
				var gallery = document.getElementById("imagegallery");
				var links = gallery.getElementsByTagName("a");
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
