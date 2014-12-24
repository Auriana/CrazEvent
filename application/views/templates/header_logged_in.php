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
        <link rel="stylesheet" type="text/css" href="<?php echo asset_url().'css/ce-calendar-style.css'; ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo asset_url().'css/jquery-ui.min.css'; ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo asset_url().'css/jquery-ui.structure.min.css'; ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo asset_url().'css/jquery-ui.theme.min.css'; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo asset_url().'css/jquery-ui-timepicker-addon.css'; ?>">
        
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
        
		<div id="navbar-bloc">
		<div class="navbar navbar-inverse" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="/home">
							<img src="<?php echo asset_url().'img/logo_crazevent.png'; ?>" alt="Craz'event" />
					</a>
				</div>
				<div class="navbar-collapse collapse">
					<!-- Menu navigation -->
					<ul class="nav navbar-nav navbar-right">
					<!-- search through the appli here -->
						<li><a class="nav-icon" href="<?php echo base_url(); ?>" alt="Home" title="Home"><span class="glyphicon glyphicon-th-large" aria-hidden="Home"></span></a></li>
						<li><a class="nav-icon" href="<?php echo base_url().'calendar'; ?>" alt="Agenda" title="Agenda"><span class="glyphicon glyphicon-calendar" aria-hidden="Agenda"></span></a></li>
						<li><a class="nav-icon" href="<?php echo base_url().'manage_user/contact'; ?>" alt="Contacts" title="Contacts"><span class="glyphicon glyphicon-user" aria-hidden="Contact"></span></a></li>
						<li><a class="nav-icon" href="<?php echo base_url().'notification'; ?>" alt="Notifications" title="Notifications"><span class="glyphicon glyphicon-bell" aria-hidden="Notifications"></span><span class="badge">4</span></a></li>
						<li><a class="nav-icon" href="<?php echo base_url().'manage_user'; ?>" alt="Profil" title="Profil"><span class="glyphicon glyphicon-cog" aria-hidden="Profil"></span></a></li>
						<li><a class="nav-icon" href="<?php echo base_url().'home/logout'; ?>" alt="Déconnexion" title="Déconnexion"><span class="glyphicon glyphicon-log-out" aria-hidden="Deconnexion"></span></a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div><!-- /.container -->
		</div><!-- /.navbar -->
		</div><!-- /.navbar-bloc -->
		
