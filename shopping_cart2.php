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
<?php
//本页数据
$count_price = 0;//计算总价
//$item_id_all = "";//商品id
$address = getvar(@$_POST[address]);
$name = getvar(@$_POST[name]);
$telephone = getvar(@$_POST[telephone]);
if($address != '' && $name != '' && $telephone != ''){
	$query = "update user set address = '".$address."', name = '".$name."', telephone = '".$telephone."' where uid = '".$userid."'";
	mysql_query("$query");
}
$user_query = mysql_query("select * from user where uid=$userid limit 1");
@$row = mysql_fetch_array($user_query);//重新载入
$disabled = $row['name'];
$row1 = $row;
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
					<a href="shopping_cart.html"><div class="wu pad-bg1-0">我的购物车</div></a>
					<div class="wu pad-bg2-1">填写订单</div>
					<div class="wu pad-bg3-0">完成订单</div>
				</div>
			</div>
		</div>
		<!--收藏	 开始-->
		<div class="container">
			<div class="row">
				<!--收获地址区域-->
				<div  class="col-md-2 col-xs-6">
					<h4>收货人信息</h4>
				</div>
				<div class="col-md-10 col-xs-6 no-padding">
					<button type="button" class="btn btn-default h-wu" data-toggle="modal" data-target="#myModal3">新收货地址</button>
					<!-- Modal-3 -->
					<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					  	<div class="modal-dialog" role="document">
					    	<div class="modal-content">
					    		<form action="./shopping_cart2.php" method="post">
						      		<div class="modal-header">
							        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        	<h4 class="modal-title" id="myModalLabel">新的收货地址</h4>
							      	</div>
							      	<div class="modal-body">
							        	<input type="text" name="address" placeholder="地址" />
										<input type="text" name="name" placeholder="姓名" />
										<input type="text" name="telephone" placeholder="电话" />
							      	</div>
							      	<div class="modal-footer">
							        	<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
							        	<button type="button" class="btn btn-primary">
							        		<input type="submit" value="保存并使用" class="modal-sub"/>
							        	</button>
							      	</div>
							    </form>
					    	</div>
					  	</div>
					</div>
				</div>
				<ul class="address col-md-3 col-xs-10">
					<li class="col-md-10 col-xs-12">
						<h4 class="addr-info"><?php if(!$row['name']){echo '请点击新增收货地址以便修改收货信息';} else {echo $row['name'];};?></h4>
						<h4 class="addr-info"><?php echo $row['telephone'];?></h4>
						<hr />
						<h4><?php echo $row['address'];?></h4>
					</li>
				</ul>
				
				<div class="col-md-12 col-xs-12 bord-list top-mar no-padding">
					<div class="col-md-4 hidden-xs">
						<h3>送货清单</h3>
						<h5 class="top-mar">周六日暂休，只工作日送货哦~</h5>
						<h4 class="top-mar">Tip:一般情况书本将在第二天傍晚前到达~</h4>
					</div>
					<div class="col-md-8 no-padding bord-list-0">
						<!--全选标题栏-->
						<span class="form-control bord-ul">预计一下商品将于8月23号晚前抵达</span>
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
						<?php
						$query = "select * from cart where uid = '".$userid."'";
						$queryuser = mysql_query("$query");
						$i=0;
						while($row = mysql_fetch_array($queryuser)){
							$query = "select * from item where item_id = '".$row['item_id']."'";
							$server_query = mysql_query("$query");
							$server_query = mysql_fetch_array($server_query);
							$final_price = $server_query['discount_price']*$row['qty'];//商品总价
							$count_price += $final_price;//总价
							echo <<<EOT
						<ul class="cart-con bord-li">
							<li class="col-md-2 col-xs-4">
								<a href="single_product.html"><img src="img/21.jpg" class="t-img"></a>
							</li>
							<li class="col-md-10 col-xs-8">
								<ul class="cart-con">
									<li class="col-md-5 col-xs-12"><a href="#"><h5 class="row">$server_query[item_name]</h5></a></li>
									<li class="col-md-2 col-xs-2 text-center"><h5 class="row">￥$server_query[discount_price]</h5></li>
									<li class="col-md-3 col-xs-8 text-center"><h5 class="row">$row[qty]</h5></li>
									<li class="col-md-2 col-xs-2 text-center"><h5 class="t-price row">￥$final_price</h5></li>
								</ul>
							</li>
						</ul>
EOT;
						$i++;
						}
						?>
						<!--动态加载区域-->
					</div>
					<!--结算区域-->
					<div class="col-md-12 no-padding">
						<ul class="pay cart-con bord-ul">
							<li class="col-md-3 text-center col-xs-9">
								<!--<div class="row xs-font">
									初始订单号为<span class="color-re">454613218</span>，待付；
								</div>-->
							</li>
							<li class="col-md-2 col-md-offset-4 text-center hidden-xs">
								<div class="row xs-font">
									1个包裹
								</div>
							</li>
							<li class="col-md-3 text-right col-xs-3">
								<div class="row xs-font">
									合计：<?php echo $count_price;?>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<!--寄送至-->
				<div class="col-md-12 col-xs-12 top-mar no-padding">
					<ul class="pay cart-con bord-ul">
						<li class="col-md-3 col-md-offset-3 text-center col-xs-2">
							<div class="row xs-font">
								送至：
							</div>
						</li>
						<li class="col-md-2 col-xs-5">
							<div class="row xs-font">
								<?php echo $row1['address'];?>
							</div>
						</li>
						<li class="col-md-2 text-center col-xs-2">
							<div class="row xs-font">
								<?php echo $row1['name'];?>
							</div>
						</li>
						<li class="col-md-2 text-center col-xs-3">
							<div class="row xs-font">
								<?php echo $row1['telephone'];?>
							</div>
						</li>
					</ul>
				</div>
				<!--去支付-->
				<div class="col-md-12 col-xs-12 top-mar no-padding">
					<ul class="pay cart-con bord-ul">
						<li class="col-md-3 col-md-offset-3 text-center hidden-xs">
							<div class="row">
								共<?php echo $i;?>件商品
							</div>
						</li>
						<li class="col-md-4 text-right col-xs-9">
							<div class="row">
								合计金额：<span class="t-price"><?php echo $count_price;?></span>
							</div>
						</li>
						<li class="col-md-2 text-right col-xs-3">
							<div class="row">
								<a href="./shopping_cart3.php" class="btn btn-danger zhifu <?php if(!$disabled){echo 'disabled';};?>">去支付</a>
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
		<!--下拉菜单出现-->
		<script>
			$("data-toggle").dropdown();
		</script>
	</body>
</html>
		