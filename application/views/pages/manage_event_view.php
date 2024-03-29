<script src="<?php echo asset_url().'js/jquery-ui.min.js'; ?>"></script>	
<script src="<?php echo asset_url().'js/jquery-ui-timepicker-addon.js'; ?>"></script>

<!--localization files for datePicker and timePicker-->
<script src="<?php echo asset_url().'js/jquery-ui-timepicker-fr.js'; ?>"></script>
<script src="<?php echo asset_url().'js/datepicker-fr-CH.js'; ?>"></script>

<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="<?php echo asset_url().'js/jquery.ui.addresspicker.js'; ?>"></script>
<script>
    function validateForm() {
        var isValid = true;
        if ($("#inputEventName").val() == "") {
            $("#nameError").text("Le nom est obligatoire");
            isValid = false;
        } else {
            $("#nameError").text("");
        }
        if ($("#inputDescription").val() == "") {
            $("#descriptionError").text("La description est obligatoire");
            isValid = false;
        } else {
            $("#descriptionError").text("");
        }
        var activities = "";
        $( ".inputActivity" ).each(function( index ) {
            activities = activities + $(this).val();
        });
        if (activities == "") {
            $("#activity1Error").text("Une activité au moins est requise");
            isValid = false;
        } else {
            $("#activity1Error").text("");
        }
        return isValid;
    }
    
$(document).ready(function(){
    // TIME PICKER
    //using JQueryUI with an add-on to handle date and time picking
    $('#inputDate').datetimepicker({
       dateFormat: "yy-mm-dd",
	   timeFormat: "HH:mm:ss"
    });
    //using JQueryUI with an add-on to handle date and time picking
    $('#inputJoinDate').datetimepicker({
       dateFormat: "yy-mm-dd",
	   timeFormat: "HH:mm:ss"
    });
	
	
    
    //controls to modify the form
    var activityNbr = $('.inputActivity').length;
    var keywordNbr = $('.inputKeyword').length;
    var checklistItemNbr = $('.inputChecklistItem').length;
    var individualPropositionNbr = $('.inputIndividualProposition').length;
    
    //controls to modify the form
    var placeNbr = $('.inputPlace').length;
    
    // PLACE
    $("#addPlace").click(function(){
        ++placeNbr;
		$("#placeSuperContainer").append(
            '<div id="clearP' + placeNbr +'" class="clearer clearerP"></div>\
            <div id="place' + placeNbr +'" class="multi-input  placeContainer">\
                <div class="col-sm-4"></div>\
                <div class="inputPlaceContainer col-sm-4">\
                    <input type="text" class="form-control inputPlace" id="inputPlace' + placeNbr + '" name="inputPlace' + placeNbr + '" placeholder="Entre un lieu">\
                    <input type="hidden" class="form-control inputPlaceId" name="inputPlaceId' + placeNbr + '" id="inputPlaceId' + placeNbr + '" value">\
                </div>\
                <div class="removePlaceContainer col-sm-2">\
                    <button type="button" class="btn btn-default removePlace but-icon" id="removePlace' + placeNbr + '"><span class="glyphicon glyphicon-trash" aria-hidden="Supprimer"></span></button>\
                </div>\
            </div>');	
    });
	
    $('body').on('click', '.removePlace', function() {
        var deletedPlaceNbr = $(this).attr('id').substring(11);
        
        //delete the place
		$("#clearP" + deletedPlaceNbr).remove();
		$("#place" + deletedPlaceNbr).remove();
        
        //renumber the other places
        --placeNbr;
        var indexPlace = placeNbr;
		//the clearer div
		$( ".clearerP" ).each(function( index ) {
            $(this).attr('id', "clearP" + indexPlace--);
        });
        indexPlace = placeNbr;
		//the multi-input div
		$( ".placeContainer" ).each(function( index ) {
            $(this).attr('id', "place" + indexPlace--);
        });
        indexPlace = placeNbr;
		//the input text
        $( ".inputPlace" ).each(function( index ) {
            $(this).attr('id', "inputPlace" + indexPlace);
            $(this).attr('name', "inputPlace" + indexPlace);
            --indexPlace;
        });
        indexPlace = placeNbr;
        //the hidden id input
        $( ".inputPlaceId" ).each(function( index ) {
            $(this).attr('id', "inputPlaceId" + indexPlace);
            $(this).attr('name', "inputPlaceId" + indexPlace);
            --indexPlace;
        });
        indexPlace = placeNbr;
		//the remove button
        $( ".removePlace" ).each(function( index ) {
            $(this).attr('id', "removePlace" + indexPlace--);
        });
    });
    

    
    
    // ACTIVITY
    $("#addActivity").click(function(){
        ++activityNbr;
		$("#activitySuperContainer").append(
            '<div id="clearA' + activityNbr +'" class="clearer clearerA"></div>\
            <div id="activity' + activityNbr +'" class="multi-input  activityContainer">\
                <div class="col-sm-4"></div>\
                <div class="inputActivityContainer col-sm-4">\
                    <input type="text" class="form-control inputActivity" id="inputActivity' + activityNbr + '" name="inputActivity' + activityNbr + '" placeholder="Entre une activité">\
                </div>\
                <div class="removeActivityContainer col-sm-2">\
                    <button type="button" class="btn btn-default removeActivity but-icon" id="removeActivity' + activityNbr + '"><span class="glyphicon glyphicon-trash" aria-hidden="Supprimer"></span></button>\
                </div>\
            </div>');	
    });
	
	
    $('body').on('click', '.removeActivity', function() {
        var deletedActivityNbr = $(this).attr('id').substring(14);
        
        //delete the activity
		$("#clearA" + deletedActivityNbr).remove();
		$("#activity" + deletedActivityNbr).remove();
        
        //renumber the other activites
        --activityNbr;
        var indexActivity = activityNbr;
		//the clearer div
		$( ".clearerA" ).each(function( index ) {
            $(this).attr('id', "clearA" + indexActivity--);
        });
        indexActivity = activityNbr;
		//the multi-input div
		$( ".activityContainer" ).each(function( index ) {
            $(this).attr('id', "activity" + indexActivity--);
        });
        indexActivity = activityNbr;
		//the input text
        $( ".inputActivity" ).each(function( index ) {
            $(this).attr('id', "inputActivity" + indexActivity);
            $(this).attr('name', "inputActivity" + indexActivity);
            --indexActivity;
        });
        indexActivity = activityNbr;
		//the remove button
        $( ".removeActivity" ).each(function( index ) {
            $(this).attr('id', "removeActivity" + indexActivity--);
        });
    });
	
	// KEYWORDS
    $("#addKeyword").click(function(){
        ++keywordNbr;
        $("#keywordSuperContainer").append(
			'<div id="clearK' + keywordNbr +'" class="clearer clearerK"></div>\
			<div id="keyword' + keywordNbr +'" class="multi-input keywordContainer">\
			<div class="col-sm-4"></div>\
			<div class="inputKeywordContainer col-sm-4">\
			<input type="text" class="form-control" name="inputKeyword' + keywordNbr + '" id="inputKeyword' + keywordNbr + '" placeholder="Entre un mot-clé">\
			</div>\
			<div class="removeKeywordContainer col-sm-2">\
			<button type="button" class="btn btn-default removeKeyword but-icon" id="removeKeyword' + keywordNbr + '" class="btn btn-primary"><span class="glyphicon glyphicon-trash" aria-hidden="Supprimer"></span> </button>\
			</div>\
			</div>');
    });

    $('body').on('click', '.removeKeyword', function() {
        var deletedKeywordNbr = $(this).attr('id').substring(13);
        
        //delete the keyword
		$("#clearK" + deletedKeywordNbr).remove();
		$("#keyword" + deletedKeywordNbr).remove();
        //renumber the other keywords
        --keywordNbr;
        var indexKeyword = keywordNbr;
		//the clearer div
		$( ".clearerK" ).each(function( index ) {
            $(this).attr('id', "clearK" + indexKeyword--);
        });
        indexKeyword = keywordNbr;
		//the multi-input div
		$( ".keywordContainer" ).each(function( index ) {
            $(this).attr('id', "keyword" + indexKeyword--);
        });
        indexKeyword = keywordNbr;
		//the input text
		$( ".inputKeyword" ).each(function( index ) {
            $(this).attr('id', "inputKeyword" + indexKeyword);
            $(this).attr('name', "inputKeyword" + indexKeyword);
            --indexKeyword;
        });
		indexKeyword = keywordNbr;
		//the remove button
        $( ".removeKeyword" ).each(function( index ) {
            $(this).attr('id', "removeKeyword" + indexKeyword--);
        });
    });	
    
    // CHECKLIST
    $("#addChecklistItem").click(function(){
        ++checklistItemNbr;
        $("#checklistSuperContainer").append(
			'<div id="clearC' + checklistItemNbr + '" class="clearer clearerC"></div>\
			<div id="checklist' + checklistItemNbr + '" class="multi-input checklistContainer">\
			<div class="col-sm-4"></div>\
			<div class="inputChecklistContainer col-sm-4">\
			<input type="text" class="form-control inputChecklistItem" name="inputChecklistItem' + checklistItemNbr + '" id="inputChecklistItem' + checklistItemNbr + '" placeholder="Chose à faire/prendre">\
			</div>\
			<div class="removeChecklistContainer col-sm-2">\
			<button type="button" class="btn btn-default removeChecklistItem but-icon" id="removeChecklistItem' + checklistItemNbr + '"><span class="glyphicon glyphicon-trash" aria-hidden="Supprimer"></span></button>\
			</div>\
			</div>');
    });
	
    $('body').on('click', '.removeChecklistItem', function() {
        var deletedChecklistItemNbr = $(this).attr('id').substring(19);
        
        //delete the checklistItem
		$("#clearC" + deletedChecklistItemNbr).remove();
		$("#checklist" + deletedChecklistItemNbr).remove();
		//renumber the other keywords
        --checklistItemNbr;
        var indexChecklistItem = checklistItemNbr;
		//the clearer div
		$( ".clearerC" ).each(function( index ) {
            $(this).attr('id', "clearC" + indexChecklistItem--);
        });
        indexChecklistItem = checklistItemNbr;
		//the multi-input div
		$( ".checklistContainer" ).each(function( index ) {
            $(this).attr('id', "checklist" + indexChecklistItem--);
        });
        //renumber the other checklistItem
        indexChecklistItem = checklistItemNbr;
        $( ".inputChecklist" ).each(function( index ) {
            $(this).attr('id', "inputChecklistItem" + indexChecklistItem);
            $(this).attr('name', "inputChecklistItem" + indexChecklistItem);
            --indexChecklistItem;
        });
        indexChecklistItem = checklistItemNbr;
        $( ".removeChecklistItem" ).each(function( index ) {
            $(this).attr('id', "removeChecklistItem" + indexChecklistItem--);
        });
    });
	
	// INDIVIDUAL PROPOSITION
    $("#addIndividualProposition").click(function(){
        ++individualPropositionNbr;
        $("#individualPropositionSuperContainer").append(
			'<div id="clearI' + individualPropositionNbr + '" class="clearer clearerI"></div>\
			<div id="individualProposition' + individualPropositionNbr + '" class="multi-input individualPropositionContainer">\
			<div class="col-sm-4"></div>\
			<div class="inputIndividualPropositionContainer col-sm-4">\
			<input type="text" class="form-control inputIndividualProposition" name="inputIndividualProposition' + individualPropositionNbr + '" id="inputIndividualProposition' + individualPropositionNbr + '" placeholder="Chose à faire/prendre">\
			<input type="hidden" class="form-control inputIndividualPropositionUser" name="inputIndividualPropositionUser' + individualPropositionNbr + '" id="inputIndividualPropositionUser' + individualPropositionNbr + '" value>\
			</div>\
			<div class="removeIndividualPropositionContainer col-sm-2">\
			<button type="button" class="btn btn-default removeIndividualProposition but-icon" id="removeIndividualProposition' + individualPropositionNbr + '"><span class="glyphicon glyphicon-trash" aria-hidden="Supprimer"></span></button>\
			</div>\
			</div>');
    });
	
    $('body').on('click', '.removeIndividualProposition', function() {
        var deletedIndividualPropositionNbr = $(this).attr('id').substring(27);
        
        //delete the IndividualProposition
		$("#clearI" + deletedIndividualPropositionNbr).remove();
		$("#individualProposition" + deletedIndividualPropositionNbr).remove();
		//renumber the other IndividualPropositions
        --individualPropositionNbr;
        var indexIndividualProposition = individualPropositionNbr;
		//the clearer div
		$( ".clearerI" ).each(function( index ) {
            $(this).attr('id', "clearI" + indexIndividualProposition--);
        });
        indexIndividualProposition = individualPropositionNbr;
		//the multi-input div
		$( ".individualPropositionContainer" ).each(function( index ) {
            $(this).attr('id', "individualProposition" + indexIndividualProposition--);
        });
        indexIndividualProposition = individualPropositionNbr;
        //the input text
        $( ".inputIndividualProposition" ).each(function( index ) {
            $(this).attr('id', "inputIndividualProposition" + indexIndividualProposition);
            $(this).attr('name', "inputIndividualProposition" + indexIndividualProposition);
            --indexIndividualProposition;
        });
        $( ".inputIndividualPropositionUser" ).each(function( index ) {
            $(this).attr('id', "inputIndividualPropositionUser" + indexIndividualProposition);
            $(this).attr('name', "inputIndividualPropositionUser" + indexIndividualProposition);
            --indexIndividualProposition;
        });
        indexIndividualProposition = individualPropositionNbr;
        $( ".removeIndividualProposition" ).each(function( index ) {
            $(this).attr('id', "removeIndividualProposition" + indexIndividualProposition--);
        });
    });
	
	// ADDRESS PICKER
    $('body').on('focus',".inputPlace", function(){
        $(this).addresspicker();
    });
});
</script>

<?php echo validation_errors();?>
<?php echo form_open( 'manage_event/update/'. $event->id, 'name="eventUpdate" class="form-horizontal" role="form" onsubmit="return validateForm()"'); ?>
<div class="container theme-showcase" role="main">
<div class="col-md-12 white-bloc centred">
	<h1 class="text-centred">
		Modifie ton événement
	</h1>
    <div class="form-group">
        <label for="inputEventName" class="col-sm-4 control-label">*Nom de l'événement</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="inputEventName" id="inputEventName" placeholder="Entre le nom de ton événement" value="<?php echo $event->name; ?>">
            <span id="nameError"></span>
        </div>
    </div>

    <div class="form-group">
        <label class="radio-inline col-sm-2 col-md-offset-4">
            <input type="radio" name="privatePublic" id="privateRadio" value="private" <?php if($event->private == 1){echo "checked";} ?>>
            *Privé
        </label>
        <label class="radio-inline col-sm-2">
            <input type="radio" name="privatePublic" id="publicRadio" value="public" <?php if($event->private == 0){echo "checked";} ?>>
            *Public
        </label>
    </div>
	
    <div class="form-group">
        <label for="inputDate" class="col-sm-4 control-label">Date de début</label>
        <div class="col-sm-2">
            <input type="text" class="form-control" name="inputDate" id="inputDate" placeholder="" value="<?php echo $event->start_date; ?>">
        </div>
    </div>
    
    <div class="form-group">
        <label for="inputDuration" class="col-sm-4 control-label">Durée (jour)</label>
        <div class="col-sm-1">
            <input type="text" class="form-control" name="inputDuration" id="inputDuration" value="<?php echo $event->duration; ?>">
        </div>
    </div>

    <!--
    <div class="form-group">
        <label for="inputPlace" class="col-sm-4 control-label">Adresse de début<br>(indique plusieurs lieus pour créer un sondage)</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="inputPlace" id="inputPlace" placeholder="Entre un lieu">
			<span id="placeError"></span>
        </div>
    </div>
    -->
    
    <div id ="placeSuperContainer" class="form-group">
        <label for="inputPlace" class="col-sm-4 control-label">Lieu(s)</label>  
		<div id="addPlaceContainer" class="col-sm-6">
			<button type="button" id="addPlace" class="btn btn-default">Ajouter un lieu</button>
            <span>(indique plusieurs lieus pour créer un sondage)</span>
        </div>
		
		<?php
            if($event->start_place != null) {
                $placeNumber = 1;
                echo '<div id="clearP'.$placeNumber.'" class="clearer clearerP"></div>';
                echo '<div id="place'.$placeNumber.'" class="multi-input placeContainer">';
                echo '<div class="col-sm-4"></div>';
                echo '<div class="inputPlaceContainer col-sm-4">';
                echo '<input type="text" class="form-control inputPlace" name="inputPlace'.$placeNumber.'" id="inputPlace'.$placeNumber.'" placeholder="Entre un lieu" value="'.$event->start_place.'">';
                echo '<span id="place1Error"></span>';
                echo '</div>';
                echo '<div class="removePlaceContainer col-sm-2">';
                echo '<button type="button" class="btn btn-default removePlace but-icon" id="removePlace'.$placeNumber.'"><span class="glyphicon glyphicon-trash" aria-hidden="Supprimer"></span></button>';
                echo '</div>';
                echo '</div>';
                ++$placeNumber;
            } else if(isset($eventPlaces)) {
				$placeNumber = 1;
				foreach ($eventPlaces as $place) {
					echo '<div id="clearP'.$placeNumber.'" class="clearer clearerP"></div>';
					echo '<div id="place'.$placeNumber.'" class="multi-input placeContainer">';
					echo '<div class="col-sm-4"></div>';
					echo '<div class="inputPlaceContainer col-sm-4">';
					echo '<input type="text" class="form-control inputPlace" name="inputPlace'.$placeNumber.'" id="inputPlace'.$placeNumber.'" placeholder="Entre un lieu" value="'.$place['place'].'">';
					echo '<span id="place1Error"></span>';
                    echo '<input type="hidden" class="form-control inputPlaceId" name="inputPlaceId'.$placeNumber.'" id="inputPlaceId'.$placeNumber.'" value="'.$place['id'].'">';
					echo '</div>';
					echo '<div class="removePlaceContainer col-sm-2">';
					echo '<button type="button" class="btn btn-default removePlace but-icon" id="removePlace'.$placeNumber.'"><span class="glyphicon glyphicon-trash" aria-hidden="Supprimer"></span></button>';
					echo '</div>';
					echo '</div>';
					++$placeNumber;
				}
			}
		?>
    </div>
    
    <div class="form-group">
        <label for="inputRegion" class="col-sm-4 control-label">Région</label>
		<div class="col-sm-6">
			<select id="inputRegion" name="inputRegion" class="form-control">
				<?php echo $regions; ?>
			</select>
		</div>
    </div>

    <div id ="activitySuperContainer" class="form-group">
        <label for="inputActivity" class="col-sm-4 control-label">*Activité(s)</label>
        <div id="addActivityContainer" class="col-sm-6">
			<button type="button" id="addActivity" class="btn btn-default">Ajouter une activité</button>
		</div>
		
		<?php
			if(isset($eventActivities)) {
				$activityNumber = 1;
				foreach ($eventActivities as $activity) {
					echo '<div id="clearA'.$activityNumber.'" class="clearer clearerA"></div>';
					echo '<div id="activity'.$activityNumber.'" class="multi-input activityContainer">';
					echo '<div class="col-sm-4"></div>';
					echo '<div class="inputActivityContainer col-sm-4">';
					echo '<input type="text" class="form-control inputActivity" name="inputActivity'.$activityNumber.'" id="inputActivity'.$activityNumber.'" placeholder="Entre une activité" value="'.$activity.'">';
					echo '<span id="activity1Error"></span>';
					echo '</div>';
					echo '<div class="removeActivityContainer col-sm-2">';
					echo '<button type="button" class="btn btn-default removeActivity but-icon" id="removeActivity'.$activityNumber.'"><span class="glyphicon glyphicon-trash" aria-hidden="Supprimer"></span></button>';
					echo '</div>';
					echo '</div>';
					++$activityNumber;
				}
			}
		?>      
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label">*Description</label>
		<div class="col-sm-6">
        	<textarea class="form-control" rows="5" name="inputDescription" id="inputDescription"><?php echo $event->description; ?></textarea>
            <span id="descriptionError"></span>
		</div>
    </div>

    <div id ="keywordSuperContainer" class="form-group">
        <label for="inputKeyword" class="col-sm-4 control-label">Mot(s)-clé(s)</label>
        <div id="addKeywordContainer" class="col-sm-6">
			<button type="button" id="addKeyword" class="btn btn-default">Ajouter un mot-clé</button>
		</div>
		
		<?php
			if(isset($eventKeywords)) {
				$keywordNumber = 1;
				foreach ($eventKeywords as $keyword) {
					echo '<div id="clearK'.$keywordNumber.'" class="clearer clearerK"></div>';
					echo '<div id="keyword'.$keywordNumber.'" class="multi-input keywordContainer">';
					echo '<div class="col-sm-4"></div>';
					echo '<div class="inputKeywordContainer col-sm-4">';
					echo '<input type="text" class="form-control inputKeyword" name="inputKeyword'.$keywordNumber.'" id="inputKeyword'.$keywordNumber.'" placeholder="Entre un mot-clé" value="'.$keyword.'">';
				echo '</div>';
				echo '<div class="removeKeywordContainer col-sm-2">';
					echo '<button type="button" class="btn btn-default removeKeyword but-icon" id="removeKeyword'.$keywordNumber.'"><span class="glyphicon glyphicon-trash" aria-hidden="Supprimer"></span></button>';
					echo '</div>';
					echo '</div>';
					++$keywordNumber;
				}
			}
		?>
    </div>

    <div id ="checklistSuperContainer" class="form-group">
        <label for="inputChecklist" class="col-sm-4 control-label">Checklist</label>
        <div id="addChecklistContainer" class="col-sm-6">
			 <button type="button" id="addChecklistItem" class="btn btn-default">Ajouter une chose à faire/prendre</button>
		</div>            
		<?php
			if(isset($eventChecklist)) {
				$checklistItemNumber = 1;
				foreach ($eventChecklist as $checklistItem) {
					echo '<div id="clearC'.$checklistItemNumber.'" class="clearer clearerC"></div>';
					echo '<div id="checklist'.$checklistItemNumber.'" class="multi-input checklistContainer">';
					echo '<div class="col-sm-4"></div>';
					echo '<div class="inputChecklistContainer col-sm-4">';
					echo '<input type="text" class="form-control inputChecklistItem" name="inputChecklistItem'.$checklistItemNumber.'" id="inputChecklistItem'.$checklistItemNumber.'" placeholder="Entre une chose à faire/prendre" value="'.$checklistItem.'">';
					echo '</div>';
					echo '<div class="removeChecklistContainer col-sm-2">';
					echo '<button type="button" class="btn btn-default removeChecklistItem but-icon" id="removeChecklistItem'.$checklistItemNumber.'"><span class="glyphicon glyphicon-trash" aria-hidden="Supprimer"></span></button>';
					echo '</div>';
					echo '</div>';
					++$checklistItemNumber;
				}
			}
		?>  
    </div>
    
    <div id ="individualPropositionSuperContainer" class="form-group">
        <label for="inputIndividualProposition" class="col-sm-4 control-label">Propositions individuelles</label>
        <div id="addIndividualPropositionContainer" class="col-sm-6">
			<button type="button" id="addIndividualProposition" class="btn btn-default">Ajouter quelque chose</button>
        </div>
		
        <?php
			if(isset($eventIndividualPropositions)) {
				$individualPropositionNumber = 1;
				foreach ($eventIndividualPropositions as $individualProposition) {
					echo '<div id="clearI'.$individualPropositionNumber.'" class="clearer clearerI"></div>';
					echo '<div id="individualProposition'.$individualPropositionNumber.'" class="multi-input individualPropositionContainer">';
					echo '<div class="col-sm-4"></div>';
					echo '<div class="inputIndividualPropositionContainer col-sm-4">';
					echo '<input type="text" class="form-control inputIndividualProposition" name="inputIndividualProposition'.$individualPropositionNumber.'" id="inputIndividualProposition'.$individualPropositionNumber.'" placeholder="Entre une chose à faire/prendre" value="'.$individualProposition->content.'">';
                    echo '<input type="hidden" class="form-control inputIndividualPropositionUser" name="inputIndividualPropositionUser'.$individualPropositionNumber.'" id="inputIndividualPropositionUser'.$individualPropositionNumber.'" value="'.$individualProposition->user_dealing_with_it.'">';
					echo '</div>';
					echo '<div class="removeIndividualPropositionContainer col-sm-2">';
					echo '<button type="button" class="btn btn-default removeIndividualProposition but-icon" id="removeIndividualProposition'.$individualPropositionNumber.'"><span class="glyphicon glyphicon-trash" aria-hidden="Supprimer"></span></button>';
					echo '</div>';
					echo '</div>';
					++$individualPropositionNumber;
				}
			}
		?>
    </div>
    
    <div class="form-group">
        <label  for="inputIndividualPropositionAllowed" class="col-sm-4 control-label">Autoriser les suggestions de propositions individuelles</label>
		<div class="col-sm-1">
            <input type="checkbox" class="form-control" name="inputIndividualPropositionAllowed" id="inputIndividualPropositionAllowed" <?php if($event->individual_proposition_suggestion_allowed == 1){echo "checked";} ?>>
		</div>
    </div>

    <div class="form-group">
        <label for="inputInvitationAllowed" class="col-sm-4 control-label">Autoriser les suggestions d'invités</label>
		<div class="col-sm-1">
            <input type="checkbox" class="form-control" name="inputInvitationAllowed" id="inputInvitationAllowed" <?php if($event->invitation_suggestion_allowed == 1){echo "checked";} ?>>
		</div>
    </div>
    
    <div class="form-group">
        <label for="inputMaxParticipant" class="col-sm-4 control-label">Nombre maximum de participants</label>
        <div class="col-sm-1">
            <input type="text" class="form-control" name="inputMaxParticipant" id="inputMaxParticipant" value="<?php echo $event->participant_max_nbr ?>">
        </div>
    </div>
    
    <div class="form-group">
        <label for="inputMinAge" class="col-sm-4 control-label">Age minimal requis</label>
        <div class="col-sm-1">
            <input type="text" class="form-control" name="inputMinAge" id="inputMinAge" value="<?php echo $event->participant_minimum_age ?>">
        </div>
    </div>

    <div class="form-group">
        <label for="inputJoinDate" class="col-sm-4 control-label">Date de fin d'inscription</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" name="inputJoinDate" id="inputJoinDate" placeholder="Entre une date" value="<?php echo $event->inscription_deadline ?>">
        </div>
    </div>
	
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-6">
    		<button type="submit" class="btn btn-default btn-lg">Modifier l'événement</button>
		</div>
	</div>

</div>

</div>
</form>