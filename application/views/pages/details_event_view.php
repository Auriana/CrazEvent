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
                      if( true ) {
                          $('#inviteContact' + idUser).text("invitation envoyée");
                      }
                      else {
                          console.log(obj.error);
                      }
                }
        });
    }
    
    function dealWithIndividualProposition(idIndividualProposition) {
        $.ajax({
        type: "POST",
        url: '/details_event/deal_with_individual_proposition/' + idIndividualProposition,
        dataType: 'json',

        success: function (obj, textstatus) {
                      if( !('error' in obj) ) {
                          $('#dealWithIndividualProposition' + idIndividualProposition).html(' (Pris en charge par toi) <button type="button" class="btn btn-default" onclick="giveUpIndividualProposition(' + idIndividualProposition + ')">Ne plus prendre en charge</button>');
                      }
                      else {
                          alert(obj.error);
                          console.log(obj.error);
                      }
                }
        });
    }
    
    function giveUpIndividualProposition(idIndividualProposition) {
        $.ajax({
        type: "POST",
        url: '/details_event/give_up_individual_proposition/' + idIndividualProposition,
        dataType: 'json',

        success: function (obj, textstatus) {
                      if( !('error' in obj) ) {
                          $('#dealWithIndividualProposition' + idIndividualProposition).html(' <button type="button" class="btn btn-default" onclick="dealWithIndividualProposition(' + idIndividualProposition + ')">Prendre en charge</button>');
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

	
    function addIndividualProposition(idEvent) {
        $(document).ready(function(){
            var individualProposition = $("#inputIndividualProposition").val();
            $("#inputIndividualProposition").empty();

            $.ajax({
            type: "POST",
            url: '/manage_event/add_individual_proposition/' + idEvent,
            dataType: 'json',
            data: {arguments: [individualProposition]},

            success: function (obj, textstatus) {
                          if( !('error' in obj) ) {
                              $("#individualPropositionContainer").append(' <li class="star-r">' + individualProposition + '<span id=dealWithIndividualProposition' + obj.result + '><button type="button" class="btn btn-default" onclick="dealWithIndividualProposition(' + obj.result + ')">Prendre en charge</button></span></li>');

                          }
                          else {
                              console.log(obj.error);
                          }
                    }
            });      
        });
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
		<p><b>Où: </b><?php echo $event->start_place; ?></p>
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
    <div class="bloc-info"> 
        <ul id="individualPropositionContainer" class="individual_proposition">
            <h3>Propositions individuelles</h3>
            <?php
                if(isset($eventIndividualPropositions)) {
                    foreach ($eventIndividualPropositions as $individualProposition) {
                        echo '<li class="star-r">'.$individualProposition->content;
                        echo '<span id=dealWithIndividualProposition'. + $individualProposition->individual_proposition_id.'>';
                        if($individualProposition->user_dealing_with_it == '') {
                            echo ' <button type="button" class="btn btn-default" onclick="dealWithIndividualProposition('.$individualProposition->individual_proposition_id.')">Prendre en charge</button>';
                        } else {
                            echo ' (Pris en charge par : '.$individualProposition->firstname.' '.$individualProposition->surname.')';
                            if($individualProposition->user_dealing_with_it == $id_user) {
                                echo ' <button type="button" class="btn btn-default" onclick="giveUpIndividualProposition('.$individualProposition->individual_proposition_id.')">Ne plus prendre en charge</button>';
                            }
                        }
                        echo '</span>';
                        echo '</li>';
                    }
                }
            ?>
        </ul>
        <?php
            if($event->individual_proposition_suggestion_allowed == 1) {
                echo '<input type="text" class="form-control inputIndividualProposition" name="inputIndividualProposition" id="inputIndividualProposition" placeholder="Entre une chose à faire/prendre">';
                echo ' <button type="button" class="btn btn-default" onclick="addIndividualProposition('.$event->id.')">Créer une proposition individuelle</button>';
            }
        ?>
    </div>
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
