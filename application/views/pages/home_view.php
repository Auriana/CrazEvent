<div class="container theme-showcase" role="main">
<h1 class="text-centred white-font small-marg">
	Bienvenue, <?php echo $firstname; ?> !
</h1>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-5 white-bloc col-2-blocs">
			<h2>
				Mes prochains événements
                <ul>
				    <?php echo $my_events; ?>
			     </ul>
                <a href="calendar">voir tous ses évènements</a>
			</h2>
			
		</div>
		<div class="col-md-5 white-bloc col-2-blocs">
			<h2>
				Actions
			</h2>
			<p>
				<a href="manage_event/creation">Créer un évènement</a> !
			</p>
			<p>
				<a href="search/user">Rechercher un utilisateur</a>
			</p>
            <p>
				<a href="search/event">Rechercher un évènement</a>
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
            Seul les plus récents sont affichés.
		</div>
	</div>
</div>

