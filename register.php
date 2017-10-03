<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
		<meta http-equiv="X-UA-Compatible" content="IE=9" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/login.css" />
		<!--[if lt IE 9]>
		    <script src="js/shiv.min.js"></script>
		    <script src="js/respond.min.js"></script>
		<![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	</head>
	<body>
		<header>
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-md-offset-2 col-sm-12 col-xs-12">
						<div class="row">
							<a href="index.php">
								<img src="img/logo/logo1.2.png"/>
							</a>
						</div>
					</div>
					<div class="col-md-3 col-md-offset-3 hidden-sm hidden-xs">
						<div class="row top-pad text-right">
							<a href="#">
								<span class="gr-color">给当前样式提意见</span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</header>
		<div class="login-area">
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-md-offset-2 col-sm-12 col-xs-12">
						<div class="lr-pad top-pad">
							<h2 class="kaiti-font">注册</h2>
							<form action="#" method="post" class="lg">
								<input type="text" placeholder="学号/手机号/邮箱" class="form-control"/>
								<input type="password" placeholder="请输入密码" class="form-control"/>
								<input type="text" placeholder="填写邮箱利于密码找回" class="form-control"/>
								<div class="tb-pad">
									<input type="checkbox" value="checkbox"/ style="width: 12px;height: 12px;">
									<span style="font-size: 11px;">
										我已阅读并接受物友网
										<a href="">《服务协议》</a><span>和</span><a href="">《账户协议》</a>
									</span>
								</div>
								<input type="submit" value="注册" class="size-font form-control kaiti-font bg-c-br"/>
							</form>
						</div>
					</div>
					<div class="col-md-4 col-md-offset-2 hidden-sm hidden-xs">
						<div class="bg-top">
							<div class="row top-pad">
								<a href="login.html" class="br-c-gr">
									<span class="bl-color kaiti-font size-font">已有物书账号？&nbsp;</span>
									<span style="color: deepskyblue;">快速登录</span>
								</a>
							</div>
						</div>
					</div>	
				</div>
			</div>
		</div>
		<script src="js/jquery.placeholder.min.js" type="text/javascript" charset="utf-8"></script>
		<!--placeholder	对IE浏览器支持-->
		<script type="text/javascript">
		    $(function () {
		        // Invoke the plugin
		        $('input, textarea').placeholder();
		    });
		</script>
	</body>
</html>
