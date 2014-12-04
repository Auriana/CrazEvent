<html>
	<head>
		<title>Craz'event - <?php echo $title ?></title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Craz'event - Gestionnaire d'événements">
		<meta name="author" content="">

		<!--
		Favicon
		<link rel="icon" href="../../favicon.ico">
		-->

		<link rel="stylesheet" type="text/css" href="<?php echo asset_url().'css/bootstrap.min.css'; ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo asset_url().'css/bootstrap-theme.min.css'; ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo asset_url().'css/ce-style.css'; ?>">
	</head>
	
	<body role="document">
		
		<!-- Fixed navbar -->
		<div id="navbar-bloc">
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/home">
							<img src="<?php echo asset_url().'img/crazevent_small.png'; ?>" alt="Craz'event" />
					</a>
				</div>
				<div class="navbar-collapse collapse">
					<!-- Menu navigation -->
					<ul class="nav navbar-nav">
					<!-- search through the appli here -->
						<li><a href="<?php echo base_url().'create_user'; ?>">Créer un compte</a></li>
						<li><a href="<?php echo base_url().'welcome'; ?>">Connexion</a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div><!-- /.container -->
		</div><!-- /.navbar -->
		</div><!-- /.navbar-bloc -->
