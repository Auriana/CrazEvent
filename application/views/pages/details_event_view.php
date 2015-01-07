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
    
    function dealWithIndividualProposition(idIndividualProposition) {
        $.ajax({
        type: "POST",
        url: '/details_event/deal_with_individual_proposition/' + idIndividualProposition,
        dataType: 'json',

        success: function (obj, textstatus) {
                      if( !('error' in obj) ) {
                          $('#dealWithIndividualProposition' + idIndividualProposition).html(' (Pris en charge par toi) <div class="individual-proposition-button"><button type="button" class="btn btn-spec" onclick="giveUpIndividualProposition(' + idIndividualProposition + ')"><span class="glyphicon glyphicon-remove-sign" aria-hidden="Ne plus prendre en charge"></button></div>');
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
                          $('#dealWithIndividualProposition' + idIndividualProposition).html(' <div class="individual-proposition-button"><button type="button" class="btn btn-spec" onclick="dealWithIndividualProposition(' + idIndividualProposition + ')"><span class="glyphicon glyphicon-ok-sign" aria-hidden="Prendre en charge"></span></button></div>');
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
                              $("#individualPropositionContainer").append(' <li class="star-r individual-proposition">' + individualProposition + '<span id=dealWithIndividualProposition' + obj.result + '><div class="individual-proposition-button"><button type="button" class="btn btn-spec" onclick="dealWithIndividualProposition(' + obj.result + ')"><span class="glyphicon glyphicon-ok-sign" aria-hidden="Prendre en charge"></span></button></span></div></li>');

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
		<p><b>Où: </b>
            <?php
            if ($event->start_place != null) {
                echo $event->start_place;
            } else if(isset($eventPlaces)) {
                echo '<div id="placeChoice">';
                foreach ($eventPlaces as $place) {
                    echo '<li class="star-r">'.$place.'<button onclick=\'selectPlace('.$event->id.', "'.$place.'")\'>Choisir</button></li>';
                }
                echo '</div>';
            }
        ?></p>
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
        <h3>Propositions individuelles</h3>
		<ul id="individualPropositionContainer" class="list-individual-proposition col-md-7 ">
            <?php
                if(isset($eventIndividualPropositions)) {
                    foreach ($eventIndividualPropositions as $individualProposition) {
                        echo '<li class="star-r individual-proposition">'.$individualProposition->content;
                        echo '<span id=dealWithIndividualProposition'. + $individualProposition->individual_proposition_id.'>';
                        if($individualProposition->user_dealing_with_it == '') {
                            echo ' <div class="individual-proposition-button"><button type="button" class="btn btn-spec" onclick="dealWithIndividualProposition('.$individualProposition->individual_proposition_id.')"><span class="glyphicon glyphicon-ok-sign" aria-hidden="Prendre en charge"></span></button></div>';
                        } else {
                            echo ' (Pris en charge par : '.$individualProposition->firstname.' '.$individualProposition->surname.')';
                            if($individualProposition->user_dealing_with_it == $id_user) {
                                echo ' <div class="individual-proposition-button"><button type="button" class="btn btn-spec" onclick="giveUpIndividualProposition('.$individualProposition->individual_proposition_id.')"><span class="glyphicon glyphicon-remove-sign" aria-hidden="Ne plus prendre en charge"></span></button></div>';
                            }
                        }
                    }
                }
            ?>
        </ul>
        <?php
            if($event->individual_proposition_suggestion_allowed == 1) {
                echo '<div class="col-sm-12"><div class="col-sm-5"><input type="text" class="form-control inputIndividualProposition" name="inputIndividualProposition" id="inputIndividualProposition" placeholder="Entre une chose à faire/prendre"></div>';
                echo '<div class="col-sm-5"><button type="button" class="btn btn-default" onclick="addIndividualProposition('.$event->id.')">Créer une proposition individuelle</button></div></div>';
            }
        ?>
		<div class="clearer"></div>
    </div>
    <div class="small-marg marg-top">
        <?php
            if($event->invitation_suggestion_allowed == 1 || $event->organizer == $id_user) {
                echo '<button type="button" id="inviteUser" class="btn btn-default btn-lg" onclick="invitationList('.$event->id.')">'.($event->private == 1 ? "Inviter des contacts" : "Suggérer l\'événement" ).'</button>';
            }
        ?>
        <div id="contactList">
        </div>
	</div>
</div>
