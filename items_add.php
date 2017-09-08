<?php
session_start();

//检测是否登录，若没登录则转向登录界面
//if(!isset($_SESSION['userid'])){
//	header("Location:login.html");
//	exit();
//}

//包含数据库连接文件
include('conn.php');
$userid = @$_SESSION['userid'];
$username = @$_SESSION['username'];

@$gettype=$_POST[type];
@$getitem_name=$_POST[item_name];
@$getauthor=$_POST[author];
@$getpress=$_POST[press];
@$gettime=$_POST['time'];
@$getcondition_precent=$_POST[condition_precent];
@$getdiscount_price=$_POST[discount_price];
@$getprice=$_POST[price];
@$getqty=$_POST[qty];
@$getcontent=$_POST[content];

$user_query = mysql_query("select * from user where uid=$userid limit 1");
@$row = mysql_fetch_array($user_query);
$server_query = mysql_query("select * from server where uid=$userid limit 50");


if($gettype == ''){
	$type = '';
} else {
	$type = mysql_real_escape_string($gettype);
}
if($getitem_name == ''){
	$item_name = '';
} else {
	$item_name = mysql_real_escape_string($getitem_name);
}
if($getauthor == ''){
	$author = '';
} else {
	$author = mysql_real_escape_string($getauthor);
}
if($getpress == ''){
	$press = '';
} else {
	$press = mysql_real_escape_string($getpress);
}
if($gettime == ''){
	$time = '';
} else {
	$time = mysql_real_escape_string($gettime);
}
if($getcondition_precent == ''){
	$condition_precent = '';
} else {
	$condition_precent = mysql_real_escape_string($getcondition_precent);
}
if($getdiscount_price == ''){
	$discount_price = '';
} else {
	$discount_price = mysql_real_escape_string($getdiscount_price);
}
if($getprice == ''){
	$price = '';
} else {
	$price = mysql_real_escape_string($getprice);
}
if($getqty == ''){
	$qty = '';
} else {
	$qty = mysql_real_escape_string($getqty);
}
if($getcontent == ''){
	$content = '';
} else {
	$content = mysql_real_escape_string($getcontent);
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
if($item_name != ''){
	$query = "select count(*) from item where item_name = '".$item_name."'";
	$server_query = mysql_query("$query");
	$server_query = mysql_fetch_array($server_query);
	print_r($server_query[0]);
	if($server_query[0] == 0){
		$query = "insert into item(type, item_name, author, press, time, condition_precent, discount_price, price, qty, content) values ('".$type."', '".$item_name."', '".$author."', '".$press."', '".$time."', '".$condition_precent."', '".$discount_price."', '".$price."', '".$qty."', '".$content."')";
		$server_query = mysql_query("$query");
	} else {
		//$query = "update cart set qty = '".$qty."' where uid = '".$userid."' and item_id = '".$item_id."'";
		//$server_query = mysql_query("$query");
	}
}
?>
<!DOCTYPE html>
<html class="html2">
	<head>
		<meta charset="UTF-8">
		<title>商品添加</title>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/index.css" />
		<link rel="stylesheet" href="css/shopping_cart.css" />
		<link rel="stylesheet" href="css/wish.css" />
		<link rel="stylesheet" href="css/login.css" />
		<link rel="stylesheet" href="css/upload.css" />
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
						<li><a href="secret_revise.html"><i class="glyphicon glyphicon-grain"></i>密码修改</a></li>
						<li><a href="wish_list.html"><i class="glyphicon glyphicon-grain"></i>我的收藏</a></li>
						<li><a href="order.html"><i class="glyphicon glyphicon-grain"></i>我的订单</a></li>
					</ul>
					<h4 class="lf-nag-bgc row">卖家中心</h4>
					<ul class="lf-nav-ul">
						<li><a href="items_add.html"><i class="glyphicon glyphicon-grain"></i>商品添加</a></li>
						<li><a href="items_revise.html"><i class="glyphicon glyphicon-grain"></i>商品管理</a></li>
						<li><a href="#"><i class="glyphicon glyphicon-grain"></i>数据统计</a></li>
					</ul>
				</div>
				<!--商品添加-->
				<div class="col-md-10 col-sm-12 col-xs-12">
					<h3 class="kaiti-font col-md-offset-1">卖家中心->商品添加</h3>
					<div class="col-md-6 col-md-offset-2 col-sm-12 col-xs-12">
						<div class="col-md-4">
							<div class="lf-font text-left">分类：</div>
							<div class="lf-font text-left">书名：</div>
							<div class="lf-font text-left">ISBN：</div>
							<div class="lf-font text-left">作者：</div>
							<div class="lf-font text-left">出版社：</div>
							<div class="lf-font text-left">出版时间：</div>
							<div class="lf-font text-left">品相：</div>
							<div class="lf-font text-left">售价：</div>
							<div class="lf-font text-left">原价：</div>
							<div class="lf-font text-left">库存数：</div>
							<div class="lf-font text-left">上传图片：</div>
							<div class="lf-font text-left">详细描述：</div>
						</div>
						<div class="col-md-8 no-padding">
							<form action="./items_add.php" method="post" class="lg">
								<select name="type" style="padding: 10px;width: 100%;">
							        <option value="大学教材" selected="selected">大学教材</option>
							        <option value="英语考级">英语考级</option>
							        <option value="考研专题">考研专题</option>
							        <option value="公务员项">公务员项</option>
							        <option value="课外书本">课外书本</option>
							        <option value="旧书教材">旧书教材</option>
							 	</select><br />
							 	<input type="text" name="item_name" placeholder="必填书名" class="form-control"/>
							 	<input type="text" name="isbn" placeholder="选填-ISBN" class="form-control"/>
							 	<input type="text" name="author" placeholder="必填作者" class="form-control"/>
							 	<input type="text" name="press" placeholder="必填出版社" class="form-control"/>
							 	<input type="text" name="time" placeholder="必填出版时间" class="form-control"/>
							 	<input type="text" name="condition_precent" placeholder="必填品相" class="form-control"/>
							 	<input type="text" name="discount_price" placeholder="必填售价" class="form-control"/>
							 	<input type="text" name="price" placeholder="必填原价" class="form-control"/>
							 	<input type="text" name="qty" placeholder="必填库存数" class="form-control"/>
							 	<a id="zwb_upload">
							 		<input type="file" class="add" multiple="multiple"/><span class="up"><i class="glyphicon glyphicon-folder-open"></i>//请使用图床 上传文件</span>
							 	</a>
							 	<textarea name="content" placeholder="选填-详细描述" class="form-control"></textarea>
							 	
								<input type="submit" value="提交" class="size-font form-control kaiti-font bg-c-br"/>
							</form>
						</div>
					</div>
					<div class="col-md-6 col-md-offset-2 col-sm-12 col-xs-12">
						<div class="bg-top">
							<div class="lr-pad top-pad2">
								<div class="br-c-gr">
									<span class="bl-color kaiti-font size-font">Tip：&nbsp;</span>
									<span style="color: deepskyblue;">必填选项请您填写清楚o~</span>
								</div>
							</div>
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
		<!--文件上传-->
		<script src="js/upload.min.js"></script>
		<script type="text/javascript">
		    //配置需要引入jq 1.7.2版本以上
		    //服务器端成功返回 {state:1,path:文件保存路径}
		    //服务器端失败返回 {state:0,errmsg:错误原因}
		    //默认做了文件名不能含有中文,后端接收文件的变量名为file
		    $("#zwb_upload").bindUpload({
		        url:"/upload",//上传服务器地址
		        callbackPath:"#callbackPath2",//绑定上传成功后 图片地址的保存容器的id或者class 必须为input或者textarea等可以使用$(..).val()设置之的表单元素
		        // ps:值返回上传成功的 默认id为#callbackPath  保存容器为位置不限制,id需要加上#号,class需要加上.
		        // 返回格式为:
		        // 原来的文件名,服务端保存的路径|原来的文件名,服务端保存的路径|原来的文件名,服务端保存的路径|原来的文件名,服务端保存的路径....
		        num:10,//上传数量的限制 默认为空 无限制
		        type:"jpg|png|gif|svg",//上传文件类型 默认为空 无限制
		        size:3,//上传文件大小的限制,默认为5单位默认为mb
		    });
		</script>
	</body>
</html>
		