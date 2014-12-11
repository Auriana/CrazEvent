<html>
	<head>
		<title>Craz'event - <?php echo $title ?></title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Craz'event - Gestionnaire d'événements">
		<meta name="author" content="">

		<link rel="icon" href="<?php echo asset_url().'img/favicon.ico'; ?>">

		<link rel="stylesheet" type="text/css" href="<?php echo asset_url().'css/bootstrap.min.css'; ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo asset_url().'css/bootstrap-theme.min.css'; ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo asset_url().'css/ce-style.css'; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo asset_url().'css/jquery-ui.min.css'; ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo asset_url().'css/jquery-ui.structure.min.css'; ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo asset_url().'css/jquery-ui.theme.min.css'; ?>">
        <script>
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-57249666-2']);
            _gaq.push(['_setDomainName', 'none']);

            _gaq.push(['_trackPageview']);

            (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/u/ga_debug.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
        </script>
	</head>
	
	<body role="document">
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		
		<!-- Fixed navbar -->
		<div id="navbar-bloc no-marg">
		<div class="navbar navbar-inverse navbar-fixed-top no-marg" role="navigation">
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
