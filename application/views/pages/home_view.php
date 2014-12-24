<div class="container theme-showcase" role="main">
<h1 class="text-centred white-font small-marg">
	Bienvenue, <?php echo $firstname; ?> !
</h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-5 white-bloc col-2-blocs">
			<h2>
				Tes prochains événements 
			</h2>
			<p>
				Les événements auxquels tu participes se situent ici.
			</p>
			<ul>
				<?php echo $my_events; ?>
			</ul>
            <a href="calendar">Voir ton agenda</a>
		</div>

		<div class="col-md-5 white-bloc col-2-blocs">
			<h2>
				Evénements créés
			</h2>
			<p>
				Les événements que tu organises se trouvent ici. 
				<br />Pour l'instant, tu n'en as pas.
			</p>
			<a class="btn btn-danger" href="manage_event/creation">Crée-en un !</a>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-5 white-bloc col-2-blocs">
			<h2>
				Nouveaux événements 
			</h2>
			<p>Seuls les plus récents sont affichés.</p>
            <ul>
				<?php echo $new_events; ?>
			</ul>
		</div>
		<div class="col-md-5 white-bloc col-2-blocs">
			<h2>
				Actions
			</h2>
			<p>
				Nous avons centralisé les actions possibles ici.
			</p>
			<p class="centred">
				<a class="btn btn-danger small-marg width-loo" href="manage_event/creation">Créer un évènement !</a>
				<br />
				<a class="btn btn-default small-marg width-loo" href="search/user">Rechercher un utilisateur</a>
				<br />
				<a class="btn btn-default width-loo" href="search/event">Rechercher un évènement</a>
			</p>
		</div>
	</div>
	
</div>

