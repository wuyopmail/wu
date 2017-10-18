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
//本页数据
$password = getvar(@$_POST['password']);
$email = getvar(@$_POST['email']);
$recovery_number = getvar(@$_POST['recovery_number']);
$read = getvar(@$_POST['read']);
$query = "select * from user where email = '$email' limit 1";
$check_recovery_number = mysql_query("$query");
$check_recovery_number = mysql_fetch_array($check_recovery_number);
if($check_recovery_number == ''){
	$status = "邮箱不存在或输入错误，请检查后重新<a href=\"recovery.php\">输入</a>。";
} else {
	if($password != '' && $email != '' && $recovery_number != ''){
		$query = "select * from user where email = '$email' limit 1";
		$check_recovery_number = mysql_query("$query");
		$check_recovery_number = mysql_fetch_array($check_recovery_number);
		$uid = $check_recovery_number['uid'];
		if($recovery_number != $check_recovery_number['recovery_number']){
			$status = "验证码错误，请检查后重新输入。";
		} else {
			$password = md5($password);
			$query = "update user set password = '".$password."', recovery_number = '".$recovery_number."' where uid = '".$uid."'";
			$update_password = mysql_query("$query");
			$status = "密码已经重置，请重新<a href=\"login.html\">登陆</a>。";
		}
	} else if($email != '' && $recovery_number != ''){
		$status = "验证码和密码均不能为空，请检查后重新输入。";
	} else if($email != '' && $recovery_number == '' && $read == 'yes'){
		$status = "验证码和密码均不能为空，请检查后重新输入。";
	} else if($email != '' && $read == ''){
		$recovery_number = rand(100000,999999);
		$query = "update user set recovery_number = '".$recovery_number."' where email = '".$email."'";
		$smtpserver = "";//SMTP服务器
		$smtpserverport =25;//SMTP服务器端口
		$smtpusermail = "";//SMTP服务器的用户邮箱
		$smtpemailto = $email;//发送给谁
		$smtpuser = "";//SMTP服务器的用户帐号，注：部分邮箱只需@前面的用户名
		$smtppass = "";//SMTP服务器的用户密码
		$mailtitle = "找回密码验证码";//邮件主题
		$mailcontent = "<h1>您的验证码为</h1><br /><p>".$recovery_number."</p>";//邮件内容
		$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
		$smtp = new Smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
		$smtp->debug = false;//是否显示发送的调试信息
		$state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
		$update_recovery_number = mysql_query("$query");
		$status = "已经将验证码发送到".$email."。";
	}
}
?>
<!DOCTYPE html>
<html class="html">
	<head>
		<meta charset="UTF-8">
		<title>找回密码</title>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/index.css" />
		<link rel="stylesheet" href="css/shopping_cart.css" />
		<link rel="stylesheet" href="css/wish.css" />
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
						<li><a href="secret_revise.php"><i class="glyphicon glyphicon-grain"></i>密码修改</a></li>
						<li><a href="wish_list.php"><i class="glyphicon glyphicon-grain"></i>我的收藏</a></li>
						<li><a href="order.php"><i class="glyphicon glyphicon-grain"></i>我的订单</a></li>
					</ul>
					<h4 class="lf-nag-bgc row">卖家中心</h4>
					<ul class="lf-nav-ul">
						<li><a href="items_add.php"><i class="glyphicon glyphicon-grain"></i>商品添加</a></li>
						<li><a href="items_revise.php"><i class="glyphicon glyphicon-grain"></i>商品管理</a></li>
						<li><a href="#"><i class="glyphicon glyphicon-grain"></i>数据统计</a></li>
					</ul>
				</div>
				<!--密码修改-->
				<div class="col-md-10 col-sm-12 col-xs-12">
					<div class="login-area">
						<div class="col-md-6 col-md-offset-2 col-sm-12 col-xs-12">
							<div class="lr-pad top-pad2">
								<h2 class="kaiti-font">找回密码</h2>
								<form action="./recovery2.php" method="post" class="lg">
									<p><?php echo $status;?></p>
									<input type="hidden" name="email" value="<?php echo $email;?>" class="form-control"/>
									<input type="password" name="password" placeholder="请输入新密码" class="form-control"/>
									<input type="text" name="recovery_number" placeholder="请输入验证码" class="form-control"/>
									<input type="hidden" name="read" value="yes" class="form-control"/>
									<input type="submit" value="提交" class="size-font form-control kaiti-font bg-c-br"/>
								</form>
							</div>
						</div>
						<div class="col-md-6 col-md-offset-2 col-sm-12 col-xs-12">
							<div class="bg-top">
								<div class="lr-pad top-pad2">
									<div class="br-c-gr">
										<span class="bl-color kaiti-font size-font">Tip：&nbsp;</span>
										<span style="color: deepskyblue;">新密码确认无误后在提交哦~</span>
									</div>
								</div>
							</div>
						</div>
					</div>
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
		