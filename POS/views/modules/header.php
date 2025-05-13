<header class="main-header">
	<!--==========================	=            logo            =	===========================-->
	<a href="home" class="logo"> <?php
										$info = $_SESSION["company_db"];
										$company_name = $info["company_name"];
									if (isset($company_name) && $company_name != "") {
										$first_letter = strtoupper($company_name[0]);
										echo '<span class="logo-lg"><b>' . $company_name. '</b></span><span class="logo-mini" style="padding: 0 5px;"><b>' . $first_letter . '</b></span>';
									} else {
										echo '<span class="logo-mini"><b>'. $company_name .'</b></span>';
									} ?>
		</span> </a> 
		<!--=====================================	=            navigation         =	======================================-->
	<nav class="navbar navbar-static-top" role="navigation"> <!-- Navigation button -->
		<a class="sidebar-toggle" data-toggle="push-menu" role="button" href="#">
			<span class="sr-only">Toggle Navigation</span> </a> <!-- User Profile -->
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<li class="dropdown user user-menu"> <a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<?php if ($_SESSION["name"] != "") {
							echo '<img class="user-image" src="views/img/users/default/anonymous.png">';
						} else {
							echo '<img class="user-image" src="views/img/users/default/anonymous.png">';
						} ?>
						<span class="hidden-xs"><?php echo $_SESSION["name"]; ?></span> </a> <!-- dropdown toggle -->
					<ul class="dropdown-menu">
						<li class="user-body">
							<div class="pull-right"> <a class="btn btn-default btn-flat" href="logout">Logout</a> </div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</header>