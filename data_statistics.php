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
<html class="html2">
	<head>
		<meta charset="UTF-8">
		<title>数据统计</title>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/index.css" />
		<link rel="stylesheet" href="css/shopping_cart.css" />
		<link rel="stylesheet" href="css/login.css" />
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
				<!--商品添加-->
				<div class="col-md-10 col-sm-12 col-xs-12">
					<h3 class="kaiti-font col-md-offset-1">卖家中心->数据统计</h3>
					<div class="col-md-11 col-md-offset-1 col-sm-12 col-xs-12 bot">
						<form action="" method="post">
							<div class="col-md-12">
								<span class="lf-font2">书名：</span><input type="text" name="book_title" value="" />
								<span class="lf-font2">作者：</span><input type="text" name="book_title" value="" />
								<span class="lf-font2">分类：</span>
								<select style="margin-left: 10px;padding: 3px 10px 6px 11px;">
							        <option value="大学教材" selected="selected">大学教材</option>
							        <option value="英语考级">英语考级</option>
							        <option value="考研专题">考研专题</option>
							        <option value="公务员项">公务员项</option>
							        <option value="课外书本">课外书本</option>
							        <option value="旧书教材">旧书教材</option>
							        <option value="旧书教材">热门资料</option>
							 	</select>
								<input type="submit" value="搜索" class="pink"/>
							</div>
						</form>
					</div>
					<!--分类书本销量统计-->
					<div class="col-md-12 book-type">
						<div class="col-md-4">
							<h5>大学教材</h5>
							<?php
							$query = "select count(*) from item where type='大学教材' order by sell_num DESC";
							$num = mysql_query("$query");
							$num = mysql_fetch_array($num);
							$num = $num[0];
							$page_num = $num / 10;//每页商品数量
							$page_num = intval($page_num) + 1;
							//echo $page_num;
							$query = "select * from item where type='大学教材' order by sell_num DESC LIMIT 0,10";
							//print_r($query);
							$queryuser = mysql_query("$query");
							//print_r($query);
							while($row = mysql_fetch_array($queryuser)){
							echo <<<EOT
							<p><a href="./single_product.php?item_id=$row[item_id]">$row[item_name]</a>：<span>$row[sell_num]</span></p>
EOT;
							}
							?>
						</div>
						<div class="col-md-4">
							<h5>大学教材</h5>
							<?php
							$query = "select count(*) from item where type='大学教材' order by sell_num DESC";
							$num = mysql_query("$query");
							$num = mysql_fetch_array($num);
							$num = $num[0];
							$page_num = $num / 10;//每页商品数量
							$page_num = intval($page_num) + 1;
							//echo $page_num;
							$query = "select * from item where type='大学教材' order by sell_num DESC LIMIT 0,10";
							//print_r($query);
							$queryuser = mysql_query("$query");
							//print_r($query);
							while($row = mysql_fetch_array($queryuser)){
							echo <<<EOT
							<p><a href="./single_product.php?item_id=$row[item_id]">$row[item_name]</a>：<span>$row[sell_num]</span></p>
EOT;
							}
							?>
						</div>
						<div class="col-md-4">
							<h5>大学教材</h5>
							<?php
							$query = "select count(*) from item where type='大学教材' order by sell_num DESC";
							$num = mysql_query("$query");
							$num = mysql_fetch_array($num);
							$num = $num[0];
							$page_num = $num / 10;//每页商品数量
							$page_num = intval($page_num) + 1;
							//echo $page_num;
							$query = "select * from item where type='大学教材' order by sell_num DESC LIMIT 0,10";
							//print_r($query);
							$queryuser = mysql_query("$query");
							//print_r($query);
							while($row = mysql_fetch_array($queryuser)){
							echo <<<EOT
							<p><a href="./single_product.php?item_id=$row[item_id]">$row[item_name]</a>：<span>$row[sell_num]</span></p>
EOT;
							}
							?>
						</div>
						<div class="col-md-4">
							<h5>大学教材</h5>
							<?php
							$query = "select count(*) from item where type='大学教材' order by sell_num DESC";
							$num = mysql_query("$query");
							$num = mysql_fetch_array($num);
							$num = $num[0];
							$page_num = $num / 10;//每页商品数量
							$page_num = intval($page_num) + 1;
							//echo $page_num;
							$query = "select * from item where type='大学教材' order by sell_num DESC LIMIT 0,10";
							//print_r($query);
							$queryuser = mysql_query("$query");
							//print_r($query);
							while($row = mysql_fetch_array($queryuser)){
							echo <<<EOT
							<p><a href="./single_product.php?item_id=$row[item_id]">$row[item_name]</a>：<span>$row[sell_num]</span></p>
EOT;
							}
							?>
						</div>
						<div class="col-md-4">
							<h5>大学教材</h5>
							<?php
							$query = "select count(*) from item where type='大学教材' order by sell_num DESC";
							$num = mysql_query("$query");
							$num = mysql_fetch_array($num);
							$num = $num[0];
							$page_num = $num / 10;//每页商品数量
							$page_num = intval($page_num) + 1;
							//echo $page_num;
							$query = "select * from item where type='大学教材' order by sell_num DESC LIMIT 0,10";
							//print_r($query);
							$queryuser = mysql_query("$query");
							//print_r($query);
							while($row = mysql_fetch_array($queryuser)){
							echo <<<EOT
							<p><a href="./single_product.php?item_id=$row[item_id]">$row[item_name]</a>：<span>$row[sell_num]</span></p>
EOT;
							}
							?>
						</div>
						<div class="col-md-4">
							<h5>大学教材</h5>
							<?php
							$query = "select count(*) from item where type='大学教材' order by sell_num DESC";
							$num = mysql_query("$query");
							$num = mysql_fetch_array($num);
							$num = $num[0];
							$page_num = $num / 10;//每页商品数量
							$page_num = intval($page_num) + 1;
							//echo $page_num;
							$query = "select * from item where type='大学教材' order by sell_num DESC LIMIT 0,10";
							//print_r($query);
							$queryuser = mysql_query("$query");
							//print_r($query);
							while($row = mysql_fetch_array($queryuser)){
							echo <<<EOT
							<p><a href="./single_product.php?item_id=$row[item_id]">$row[item_name]</a>：<span>$row[sell_num]</span></p>
EOT;
							}
							?>
						</div>
					</div>
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
		<script type="text/javascript">
			$('#myModal1').on('shown.bs.modal', function () {
			  $('#myInput').focus()
			})
		</script>
	</body>
</html>
		