<script src="<?php echo asset_url().'js/jquery-ui.min.js'; ?>"></script>	
<script src="<?php echo asset_url().'js/jquery-ui-timepicker-addon.js'; ?>"></script>
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
    /*
    * script to handle form control
    */
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
    
    var activityNbr = $('.inputActivity').length;
    var keywordNbr = $('.inputKeyword').length;
    var checklistItemNbr = $('.inputChecklistItem').length;
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
                    <button type="button" class="btn btn-primary removeActivity" id="removeActivity' + activityNbr + '" class="btn btn-primary">-</button>\
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
			<button type="button" class="btn btn-primary removeKeyword" id="removeKeyword' + keywordNbr + '" class="btn btn-primary">-</button>\
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
			<button type="button" class="btn btn-primary removeChecklistItem" id="removeChecklistItem' + checklistItemNbr + '" class="btn btn-primary">-</button>\
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
	
	// ADDRESS PICKER
    $('#inputPlace').addresspicker();
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

    <div class="form-group">
        <label for="inputPlace" class="col-sm-4 control-label">Adresse de début</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="inputPlace" id="inputPlace" placeholder="Entre un lieu" value="<?php echo $event->start_place; ?>">
			<span id="placeError"></span>
        </div>
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
			<button type="button" id="addActivity" class="btn btn-primary">Ajouter une activité</button>
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
					echo '<button type="button" class="btn btn-primary removeActivity" id="removeActivity'.$activityNumber.'" class="btn btn-primary">-</button>';
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
			<button type="button" id="addKeyword" class="btn btn-primary">Ajouter un mot-clé</button>
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
					echo '<button type="button" class="btn btn-primary removeKeyword" id="removeKeyword'.$keywordNumber.'" class="btn btn-primary">-</button>';
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
			 <button type="button" id="addChecklistItem" class="btn btn-primary">Ajouter une chose à faire/prendre</button>
		</div>            
		<?php
			if(isset($eventChecklist)) {
				$checklistItemNumber = 1;
				foreach ($eventChecklist as $checklistItem) {
					echo '<div id="clearC'.$checklistItemNumber.'" class="clearer clearerC"></div>';
					echo '<div id="checklist'.$checklistItemNumber.'" class="multi-input checklistContainer">';
					echo '<div class="col-sm-4"></div>';
					echo '<div class="inputChecklistContainer col-sm-4">';
					echo '<input type="text" class="form-control inputChecklistItem"; name="inputChecklistItem'.$checklistItemNumber.'" id="inputChecklistItem'.$checklistItemNumber.'" placeholder="Entre une chose à faire/prendre" value="'.$checklistItem.'">';
					echo '</div>';
					echo '<div class="removeChecklistContainer col-sm-2">';
					echo '<button type="button" class="btn btn-primary removeChecklistItem" id="removeChecklistItem'.$checklistItemNumber.'" class="btn btn-primary">-</button>';
					echo '</div>';
					echo '</div>';
					++$checklistItemNumber;
				}
			}
		?>  
    </div>

    <div class="form-group">
        <label for="inputInvitationAllowed" class="col-sm-4 control-label">Autoriser les suggestions d'invités</label>
		<div class="col-sm-1">
            <input type="checkbox" class="form-control" name="inputInvitationAllowed" id="inputInvitationAllowed" <?php if($event->invitation_suggestion_allowed == 1){echo "checked";} ?>>
		</div>
    </div>
    
	<div class="form-group">
        <label  for="inputIndividualPropositionAllowed" class="col-sm-4 control-label">Autoriser les suggestions de propositions individuelles</label>
		<div class="col-sm-1">
            <input type="checkbox" class="form-control" name="inputIndividualPropositionAllowed" id="inputIndividualPropositionAllowed" <?php if($event->individual_proposition_suggestion_allowed == 1){echo "checked";} ?>>
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
    		<button type="submit" class="btn btn-primary btn-lg">Modifier l'événement</button>
		</div>
	</div>

</div>

</div>
</form>