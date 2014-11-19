<div class="col-md-12 white-bloc centred">
	<h1 class="text-centred">
		<?php echo $event->name; ?>
	</h1>
	<h5>
		<?php echo ($event->private == 1 ? "Privé" : "Public" ); ?>
	</h5>
	<div id="link-answer">
		<a href="#" alt=""><?php echo ($event->private == 1 ? "Répondre à l'invitation" : "S'inscrire" ); ?></a>
	</div>
	<p class="bloc-info"> 
		<?php echo $event->description; ?>
	</p>
	<ul class="bloc-info">
		<li><?php echo $event->start_date; ?></li>
		<li>S'inscrire jusqu'au <?php echo $event->inscription_deadline; ?></li>
		<li>A <?php echo $event->start_place; ?></li>
	</ul>
	<ul class="bloc-info">
		<b>Activités</b>
        <?php
            if(isset($eventActivities)) {
                foreach ($eventActivities as $activity)
                {
                    echo '<li>'.$activity.'</li>';
                }
            }
        ?>
	</ul>
	<ul class="bloc-info">
		<b>Checklist</b>
        <?php
            if(isset($eventChecklist)) {
                foreach ($eventChecklist as $checklistItem)
                {
                    echo '<li>'.$checklistItem.'</li>';
                }
            }
        ?>
	</ul>
	<ul class="bloc-info">
		<li>Nombre maximum de participants: <?php echo $event->participant_max_nbr; ?></li>	
		<li>Age minimal requis : <?php echo $event->participant_minimum_age; ?></li>
	</ul>
    <ul class="bloc-info">
		<b>Participants</b>
        <?php
            foreach ($eventParticipants as $participant)
            {
                echo '<li>'.$participant->firstname.' '.$participant->surname.'</li>';
            }
        ?>
	</ul>
	<ul class="bloc-info">
		<b>Keywords</b>
        <?php
            if(isset($eventKeywords)) {
                foreach ($eventKeywords as $keyword)
                {
                    echo '<li>'.$keyword.'</li>';
                }
            }
        ?>
	</ul>
</div>
