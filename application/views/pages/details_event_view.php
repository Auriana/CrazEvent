<script>
    var getContacts = function (idEvent) {
        $.ajax({
        type: "POST",
        url: '/manage_user/get_invitable_contacts/' + idEvent,

        success: function (obj, textstatus) {
                      if( true ) {
                          $('#contactList').html("<h5>Mes contacts</h5>" + obj);
                      }
                      else {
                          console.log(obj.error);
                      }
                }
        });
    }
    function joinEvent(idEvent, private) {
        $.ajax({
        type: "POST",
        url: '/manage_user/join_event/' + idEvent + '/' + private,
        dataType: 'json',

        success: function (obj, textstatus) {
                      if( !('error' in obj) ) {
                          $('#link-answer').html(obj.result);
                      }
                      else {
                          console.log(obj.error);
                      }
                }
        });
    }

    function quitEvent(idUser, idEvent, private) {
        $.ajax({
        type: "POST",
        url: '/manage_user/quit_event',
        dataType: 'json',
        data: {arguments: [idUser, idEvent, private]},

        success: function (obj, textstatus) {
                      if( !('error' in obj) ) {
                          $('#link-answer').html(obj.result);
                      }
                      else {
                          console.log(obj.error);
                      }
                }
        });
    }

    function cancelEvent(idEvent) {
        var r = confirm("Annuler l'évènement ?");
        if (r == true) {
            window.location.href="/manage_event/cancel/" + idEvent;
        }
    }
    
    function invite(idEvent, idUser) {
        $.ajax({
        type: "POST",
        url: '/details_event/invite/' + idEvent + "/" + idUser,

        success: function (obj, textstatus) {
                      if( true ) {
                          $('#inviteContact' + idUser).text("invitation envoyée");
                      }
                      else {
                          console.log(obj.error);
                      }
                }
        });
    }
    
    function invitationList(idEvent) {
        getContacts(idEvent);
    }
</script>
<div class="container theme-showcase" role="main">
<div class="col-md-12 white-bloc centred">
	<?php
        if($event->organizer == $id_user) {
			echo '<div id="control-event">';
            echo '<p><a class="" href="'.base_url().'manage_event/management/'.$event->id.'">Modifier l\'évènement</a></p>';
            echo '<p><button class="" onclick="cancelEvent('.$event->id.')">Annuler l\'évènement</button></p>';
			echo '</div>';
			echo '<div class="clearer"></div>';
        }
    ?>
	<h1 class="text-centred">
		<?php echo $event->name; ?>
	</h1>
    
	<h5 class="text-centred">
		<?php echo ($event->private == 1 ? "Privé" : "Public" ); ?>
	</h5>
	<div id="link-answer">
        <?php echo $participation; ?>
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
                foreach ($eventActivities as $activity) {
                    echo '<li>'.$activity.'</li>';
                }
            }
        ?>
	</ul>
	<ul class="bloc-info">
		<b>Checklist</b>
        <?php
            if(isset($eventChecklist)) {
                foreach ($eventChecklist as $checklistItem) {
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
            foreach ($eventParticipants as $participant) {
                echo '<li>'.$participant->firstname.' '.$participant->surname.'</li>';
            }
        ?>
	</ul>
    <ul class="bloc-info">
		<b>Invités</b>
        <?php
            foreach ($eventGuests as $guest) {
                echo '<li>'.$guest->firstname.' '.$guest->surname.'</li>';
            }
            if($event->invitation_suggestion_allowed == 1 || $event->organizer == $id_user) {
                echo '<h5>
                        <button type="button" id="inviteUser" class="btn btn-primary" onclick="invitationList('.$event->id.')">Inviter quelqu\'un</button>
                    </h5>';
            }
        ?>
        <div id="contactList">
        </div>
	</ul>
	<ul class="bloc-info">
		<b>Keywords</b>
        <?php
            if(isset($eventKeywords)) {
                foreach ($eventKeywords as $keyword) {
                    echo '<li>'.$keyword.'</li>';
                }
            }
        ?>
	</ul>
</div>
