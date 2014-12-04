<div class="container theme-showcase" role="main">
<h1 class="text-centred white-font small-marg">
	Bienvenue, <?php echo $firstname; ?> !
</h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-5 white-bloc col-2-blocs">
			<h2>
				Mes prochains événements
			</h2>
			
		</div>
		<div class="col-md-5 white-bloc col-2-blocs">
			<h2>
				Les événements de ma région
			</h2>
			<p>
				Pas encore d'événement ici, <a href="create_event">crée-en un</a> !
			</p>
			<p>
				Ou <a href="search/user">Rechercher un utilisateur</a>
			</p>
            <p>
				Ou <a href="search/event">Rechercher un évènement</a>
			</p>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-5 white-bloc col-2-blocs">
			<h2>
				Nouveaux événements 
			</h2>
            <ul>
				<?php echo $new_events; ?>
			</ul>
		</div>
		<div class="col-md-5 white-bloc col-2-blocs">
			<h2>
				Historique
			</h2>
		</div>
	</div>
</div>

