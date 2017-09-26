		<header>
			<div class="header-top">
				<div class="container">
					<div class="row">
						<div class="col-md-6 col-xs-12 col-sm-12">
							<div class="header-top-left">
								<span>欢迎<?php echo"$username"?>光临 物友-情书~</span>
								<span class="cf">
									<a href="register.php" class="cf">
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
								<?php if($userid != ""){
                                echo <<<EOT
								<span class="cf">
									<a href="login.php?action=logout">注销</a>
								</span>
EOT;
								}
								?>
							</div>
						</div>
						<div class="col-md-6 col-xs-12 col-sm-12">
							<div class="header-top-right">
								<ul style="text-align: center;margin-left: -40px;">
									<li class="floatleft">
                                        <a href="shopping_cart.php">
                                        	<i  class="glyphicon glyphicon-shopping-cart" style="color: hotpink;"></i>
                                           	购物车
                                        </a>
                                    </li>
                                    <li class="floatleft">
                                        <a href="wish_list.php">
                                        	<i  class="glyphicon glyphicon-heart-empty"></i>
                                           	我的收藏
                                        </a>
                                    </li>
									<li class="floatleft dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="down1">
                                           	个人中心<i  class="glyphicon glyphicon-triangle-bottom" style="color: #87CEEB;"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="down1">
                                        	<li><a href="secret_revise.php">密码修改</a></li>
										    <li role="separator" class="divider"></li>
										    <li><a href="wish_list.php">我的收藏</a></li>
										    <li><a href="order.php">我的订单</a></li>
                                        </ul>
                                    </li>
                                    <li class="floatleft dropdown hidden-sm hidden-xs">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="down2">
                                           	卖家中心<i  class="glyphicon glyphicon-triangle-bottom" style="color: #87CEEB;"></i>
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="down2">
                                        	<li><a href="items_add.php">商品添加</a></li>
										    <li role="separator" class="divider"></li>
										    <li><a href="items_revise.php">商品管理</a></li>
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
									<form action="index.php" method="GET">
									<?php
										include_once('./core/function.php');
										$search = getvar(@$_GET['search']);
									?>
										<div style="float:left;width: 87%;">
											<input type="text" name="search" class="form-control" placeholder="搜索书库"/>	
										</div>
										<button type="submit" class="sub" value="">
											<span class="glyphicon glyphicon-search"></span>
										</button>
									</form>
							</div>
						</div>
						<div class="col-md-3 hidden-xs hidden-sm">
							<div class="logo2">
								<a href="index.php">
									<img src="img/logo/logo1.2.png" />
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>
