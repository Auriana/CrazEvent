<div class="col-md-12 white-bloc centred">
	<h1 class="text-centred">
		<?php echo $name; ?>
	</h1>
	<h5>
		<?php echo ($private = 1 ? "Privé" : "Public" ); ?>
	</h5>
	<div id="link-answer">
		<a href="#" alt=""><?php echo ($private = 1 ? "Répondre à l'invitation" : "S'inscrire" ); ?></a>
	</div>
	<p class="bloc-info"> 
		<?php echo $description; ?>
	</p>
	<ul class="bloc-info">
		<li><?php echo $start_date; ?></li>
		<li>S'inscrire jusqu'au <?php echo $inscription_deadline; ?></li>
		<li>A <?php echo $start_place; ?></li>
	</ul>
	<ul class="bloc-info">
		<b>Activités</b>
		<li>activité 1</li>
	</ul>
	<ul class="bloc-info">
		<b>Checklist</b>
		<li>truc</li>
	</ul>
	<ul class="bloc-info">
		<li>Nombre maximum de participants: <?php echo $participant_max_nbr; ?></li>	
		<li>Age minimal requis : <?php echo $participant_minimum_age; ?></li>
	</ul>

</div>
