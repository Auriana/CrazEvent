<script>
    var getContacts = function (idEvent) {
        $.ajax({
        type: "POST",
        url: '/manage_user/get_invitable_contacts/' + idEvent,

        success: function (obj, textstatus) {
                      if( true ) {
                          $('#contactList').html(obj);
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
                      if( !('error' in obj) ) {
                          $('#inviteContact' + idUser).text("invitation envoyée");
                      }
                      else {
                          console.log(obj.error);
                      }
                }
        });
    }

    function selectPlace(idEvent, place) {
        $.ajax({
        type: "POST",
        url: '/manage_event/select_place/' + idEvent + "/" + place,

        success: function (obj, textstatus) {
                      if( true ) {
                          $('#placeChoice').html("");
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
<div class="col-md-10 white-bloc centred">
	<?php
        if($event->organizer == $id_user) {
			echo '<div id="control-event">';
            echo '<a class="btn btn-default" href="'.base_url().'manage_event/management/'.$event->id.'">Modifier</a>';
            echo '<button class="btn btn-danger" onclick="cancelEvent('.$event->id.')">Annuler</button>';
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
	<div id="link-answer" class="text-centred">
        <?php echo $participation; ?>
	</div>
	<ul class="bloc-info">
		<h3 class="rose">Infos</h3>
		<p><b>Quand: </b><?php echo $event->start_date; ?></p>
		<?php 
			if($event->inscription_deadline != '') {
				echo '<p><b>S\'inscrire jusqu\'au </b>'.$event->inscription_deadline.'</p>';
			}
		?>
		<p><b>Où: </b>
            <div id="placeChoice"><?php
            if(isset($eventPlaces)) {
                foreach ($eventPlaces as $place) {
                    echo '<li class="star-r">'.$place.'<button onclick=\'selectPlace('.$event->id.', "'.$place.'")\'>Choisir</button></li>';
                }
            }
        ?></div></p>
		<?php 
			if($event->participant_max_nbr != '') {
				echo '<p><b>Nombre maximum de participants: </b>'.$event->participant_max_nbr.'</p>';
			}
		?>
		<?php 
			if($event->participant_minimum_age != '') {
				echo '<p><b>Age minimal requis: </b>'.$event->participant_minimum_age.'</p>';
			}
		?>
	</ul>
	<div class="bloc-info"> 
		<h3>Description</h3>
		<p>
			<?php echo $event->description; ?>
		</p>
	</div>
	<ul class="bloc-info">
		<h3>Participants</h3>
        <?php
            foreach ($eventParticipants as $participant) {
                echo '<li class="star-t">'.$participant->firstname.' '.$participant->surname.'</li>';
            }
        ?>
		<!--<php
            foreach ($eventGuests as $guest) {
                echo '<li>'.$guest->firstname.' '.$guest->surname.'</li>';
            }
		?>-->
	</ul>
	<ul class="bloc-info">
		<h3>Activités</h3>
        <?php
            if(isset($eventActivities)) {
                foreach ($eventActivities as $activity) {
                    echo '<li class="star-r">'.$activity.'</li>';
                }
            }
        ?>
	</ul>
	<ul class="bloc-info">
		<h3>Checklist</h3>
        <?php
            if(isset($eventChecklist)) {
                foreach ($eventChecklist as $checklistItem) {
                    echo '<li class="star-r">'.$checklistItem.'</li>';
                }
            }
        ?>
	</ul>
    <div>
        <?php
            if($event->invitation_suggestion_allowed == 1 || $event->organizer == $id_user) {
                echo '<button type="button" id="inviteUser" class="btn btn-default" onclick="invitationList('.$event->id.')">Suggérer l\'événement</button>';
            }
        ?>
        <div id="contactList">
        </div>
	</div>
</div>
