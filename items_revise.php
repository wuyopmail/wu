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

@$gettype=$_POST[type];
@$getitem_name=$_POST[item_name];
@$getauthor=$_POST[author];
@$getpress=$_POST[press];
@$gettime=$_POST['time'];
@$getcondition_precent=$_POST[condition_precent];
@$getdiscount_price=$_GET[discount_price];
@$getprice=$_POST[price];
@$getqty=$_GET[qty];
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
$item_id = getvar(@$_GET['item_id']);
$type = getvar(@$_GET['type']);
$delete_id = getvar(@$_GET['delete_id']);
$search_name = getvar(@$_GET['search_name']);
$search_author = getvar(@$_GET['search_author']);
$search_press = getvar(@$_GET['search_press']);
$search_discount_price = getvar(@$_GET['search_discount_price']);
$search_qty = getvar(@$_GET['search_qty']);
$search_type = getvar(@$_GET['search_type']);
if($item_id != '' && $type != '' && $qty != '' && $discount_price != ''){
	$query = "update item set type = '".$type."' ,qty = '".$qty."' ,discount_price = '".$discount_price."'where item_id = '".$item_id."'";
	$server_query = mysql_query("$query");
}
if($delete_id != ''){
	$query = "delete from item where item_id = '".$delete_id."'";
	$server_query = mysql_query("$query");
}
?>
<!DOCTYPE html>
<html class="html2">
	<head>
		<meta charset="UTF-8">
		<title>商品管理</title>
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
						<li><a href="#"><i class="glyphicon glyphicon-grain"></i>数据统计</a></li>
					</ul>
				</div>
				<!--商品添加-->
				<div class="col-md-10 col-sm-12 col-xs-12">
					<h3 class="kaiti-font col-md-offset-1">卖家中心->商品管理</h3>
					<div class="col-md-11 col-md-offset-1 col-sm-12 col-xs-12 bot">
						<form action="items_revise.php" method="get">
							<div class="col-md-12">
								<span class="lf-font2">书名：</span><input type="text" name="search_name" value="" />
								<span class="lf-font2">作者：</span><input type="text" name="search_author" value="" />
								<span class="lf-font2">出版社：</span><input type="text" name="search_press" value="" />
							</div>
							<div class="col-md-12">
								<span class="lf-font2">售价：</span><input type="text" name="search_discount_price" value="" />
								<span class="lf-font2">库存：</span><input type="text" name="search_qty" value="" />
								<span class="lf-font2">分类：</span>
								<select name="search_type" style="margin-left: 10px;padding: 3px 10px 6px 11px;">
							        <option value="大学教材" selected="selected">大学教材</option>
							        <option value="英语考级">英语考级</option>
							        <option value="考研专题">考研专题</option>
							        <option value="公务员项">公务员项</option>
							        <option value="课外书本">课外书本</option>
							        <option value="旧书教材">旧书教材</option>
								<option value="英语考级">热门资料</option>
							 	</select>
								<input type="submit" value="搜索" class="pink"/>
							</div>
						</form>
					</div>
					<form action="shopping_cart.php" method="GET">
					<div class="col-md-12 min-h">
						<ul class="cart-con">
							<li class="col-md-1">
								<div class="row">
									<input type="checkbox" name="" class="all_check"/><label for="">全选</label>
								</div>
							</li>
							<li class="col-md-5 text-center">
								<div class="row">
									商品信息
								</div>
							</li>
							<li class="col-md-1 text-center">
								<div class="row">
									分类
								</div>
							</li>
							<li class="col-md-2">
								<div class="row text-center">
									<span>库存</span>
								</div>
							</li>
							<li class="col-md-2 text-center">
								<div class="row">
									售价
								</div>
							</li>
							<li class="col-md-1 text-center">
								<div class="row">
									操作
								</div>
							</li>
						</ul>
						<hr />
						<!--购物单-->
						<div id="cart-list-container">
							<!--动态加载区域-->
							<?php
							if($search_name || $search_author || $search_press || $search_discount_price || $search_qty || $search_type){
								$query = "select * from item where type like '%$search_type%' and item_name like '%$search_name%' and author like '%$search_author%' and press like '%$search_press%' and discount_price like '%$search_discount_price%' and qty like '%$search_qty%'";
							} else {
								$query = "select * from item";
							}
							$queryuser = mysql_query("$query");
							while($row = mysql_fetch_array($queryuser)){
							echo <<<EOT
							<ul class="cart-con bord-li">
								<li class="col-md-1 col-sm-1 col-xs-1 no-padding">
									<input type="checkbox" name="select[]" value="$row[item_id]" class="input_check"/>
								</li>
								<li class="col-md-1 col-sm-4 col-xs-4 no-padding">
									<a href="#"><img src="img/21.jpg" class="t-img"></a>
								</li>
								<li class="col-md-10 no-padding">
									<ul class="cart-con">
										<li class="col-md-5"><a href="#"><h5 class="t-title">$row[item_name]</h5></a></li>
										<li class="col-md-2"><div class="row"><h5>$row[type]</h5</div></li>
										<li class="col-md-2"><h5>$row[qty]</h5></li>
										<li class="col-md-2"><h5 class="t-price">￥$row[discount_price]</h5></li>
										<li class="col-md-1">
											<div class="row">
												<!-- Button trigger modal -->
												<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal1$row[item_id]">更改</a>
												<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal2$row[item_id]">删除</a>
												<!-- Modal-1 -->
												<div class="modal fade" id="myModal1$row[item_id]" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
												  	<div class="modal-dialog" role="document">
												    	<div class="modal-content">
												    		<form action="./items_revise.php" method="get">
																<input type="hidden" value="$row[item_id]" name="item_id" id="item_id" />
													      		<div class="modal-header">
														        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														        	<h4 class="modal-title" id="myModalLabel">填写需要更改的数据即可</h4>
														      	</div>
														      	<div class="modal-body">
														        	<input type="text" name="type" placeholder="分类" />
														        	<input type="text" name="qty" placeholder="库存" />
														        	<input type="text" name="discount_price" placeholder="售价" />
														      	</div>
														      	<div class="modal-footer">
														        	<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
														        	<button type="button" class="btn btn-primary">
														        		<input type="submit" value="提交" class="modal-sub"/>
														        	</button>
														      	</div>
														    </form>
												    	</div>
												  	</div>
												</div>
												<!-- Modal-2 -->
												<div class="modal fade" id="myModal2$row[item_id]" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
												  	<div class="modal-dialog" role="document">
												    	<div class="modal-content">
												    		<form action="./items_revise.php" method="get">
																<input type="hidden" value="$row[item_id]" name="delete_id" id="delete_id" />
													      		<div class="modal-header">
														        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														        	<h4 class="modal-title" id="myModalLabel">确认删除?</h4>
														      	</div>
														      	<!--<div class="modal-body">
														        	<input type="text" name="" placeholder="分类" />
														        	<input type="text" name="" placeholder="库存" />
														        	<input type="text" name="" placeholder="售价" />
														      	</div>-->
														      	<div class="modal-footer">
														        	<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
														        	<button type="button" class="btn btn-primary">
														        		<input type="submit" value="确定" class="modal-sub"/>
														        	</button>
														      	</div>
														    </form>
												    	</div>
												  	</div>
												</div>
											</div>
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
					<div class="col-md-12">
						<ul class="cart-con">
							<li class="col-md-1">
								<div class="row">
									<input type="checkbox" name="" class="all_check input_check"/><label for="">全选</label>
								</div>
							</li>
							<li class="col-md-1 col-md-offset-10 text-center">
								<div class="row">
									<button href="#" data-toggle="modal" data-target="#myModal2">删除所选</button>
									<button href="#" class="button btn btn-default" title="add to cart" value="$row[item_id]" name="item_id">加入购物车</button>
								
								</div>
							</li>
						</ul>
						<hr />
					</div>
					</form>
					
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
			//全选功能
	        $('.all_check').click(function(){
	        	var status = $(this).prop('checked');
        		$(".input_check").each(function(key, val){
        			if (status){
        			    $(val).prop('checked', true);
        			} else {
        				$(val).prop('checked', false);
        			}
        		});
        		countplay();
	        })
	        //单选功能
	        $("#cart-list-container .input_check").click(function(){
	        	var status = $(this).prop('checked');
    	    	if (status){
    			    $(this).prop('checked', true);
    			} else {
    				$(this).prop('checked', false);
    			}
    			countplay();
	        });
		</script>
		<!--后退按钮-->z
		<script type="text/javascript">
		    var goBack = document.getElementById('back');
		    goBack.onclick = function(){
		      // console.log("1");
		      window.history.back(-1); 
		    }
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
		<script type="text/javascript">
			$('#myModal1').on('shown.bs.modal', function () {
			  $('#myInput').focus()
			})
		</script>
	</body>
</html>
		
