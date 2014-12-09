<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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
});
</script>

<?php echo validation_errors(); ?>
<?php echo form_open( 'verify_create_event/create_event', 'name="eventCreation" class="form-horizontal" role="form" onsubmit="return validateForm()"'); ?>
<div class="container theme-showcase" role="main">
<div class="col-md-10 white-bloc centred">
	<h1 class="text-centred">
		Crée ton événement
	</h1>

    <div class="form-group">
        <label for="inputEventName" class="col-sm-4 control-label">*Nom de l'événement</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="inputEventName" id="inputEventName" placeholder="Entre le nom de ton événement">
            <span id="nameError"></span>
        </div>
    </div>

    <div class="form-group">
        <label class="radio-inline col-sm-2 col-md-offset-4">
            <input type="radio" name="privatePublic" id="privateRadio" value="private" checked>
            *Privé
        </label>
        <label class="radio-inline col-sm-2">
            <input type="radio" name="privatePublic" id="publicRadio" value="public">
            *Public
        </label>
    </div>
	
    <div class="form-group">
        <label for="inputDate" class="col-sm-4 control-label">Date de début</label>
        <div class="col-sm-2">
            <input type="date" class="form-control" name="inputDate" id="inputDate" placeholder="">
        </div>
        <!--<button type="button" class="btn btn-primary">Cal</button>-->
    </div>
    
    <div class="form-group">
        <label for="inputDuration" class="col-sm-4 control-label">Durée (jour)</label>
        <div class="col-sm-1">
            <input type="text" class="form-control" name="inputDuration" id="inputDuration">
        </div>
    </div>

    <div class="form-group">
        <label for="inputPlace" class="col-sm-4 control-label">Lieu de début</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="inputPlace" id="inputPlace" placeholder="Entre un lieu">
			<span id="placeError"></span>
        </div>
    </div>
    
    <div class="form-group">
        <label for="inputRegion" class="col-sm-4 control-label">Région</label>
        <div class="col-sm-6">
			<select id="inputRegion" class="form-control" name="inputRegion">
            	<?php echo $regions; ?>
			</select>
		</div>
    </div>
	
    <div id ="activitySuperContainer" class="form-group">
        <label for="inputActivity" class="col-sm-4 control-label">*Activité(s)</label>  
		<div id="addActivityContainer" class="col-sm-6">
			<button type="button" id="addActivity" class="btn btn-primary">Ajouter une activité</button>          
        </div>
		
		<div id="clearA1" class="clearer clearerA"></div>
		<div id="activity1" class="multi-input activityContainer">
			<div class="col-sm-4"></div>
			<div class="inputActivityContainer colK-sm-4">
				<input type="text" class="form-control inputActivity" name="inputActivity1" id="inputActivity1" placeholder="Entre une activité">
				<span id="activity1Error"></span>		
			</div>
			<div class="removeActivityContainer col-sm-2">
				<button type="button" class="btn btn-primary removeActivity" id="removeActivity1" class="btn btn-primary">-</button>
			</div>
		</div>
    </div>
	
    <div class="form-group">
        <label class="col-sm-4 control-label">*Description</label>
		<div class="col-sm-6">
        	<textarea class="form-control" rows="5" name="inputDescription" id="inputDescription"></textarea>
            <span id="descriptionError"></span>
		</div>
    </div>	
	
    <div id ="keywordSuperContainer" class="form-group">
        <label for="inputKeyword" class="col-sm-4 control-label">Mot(s)-clé(s)</label>
        <div id="addKeywordContainer" class="col-sm-6"> 
			<button type="button" id="addKeyword" class="btn btn-primary">Ajouter un mot-clé</button>        
        </div>
		
		<div id="clearK1" class="clearer clearerK"></div>
		<div id="keyword1" class="multi-input keywordContainer">
			<div class="col-sm-4"></div>
			<div class="inputKeywordContainer col-sm-4">
				<input type="text" class="form-control inputKeyword" name="inputKeyword1" id="inputKeyword1" placeholder="Entre un mot-clé">
			</div>
			<div class="removeKeywordContainer col-sm-2">
				<button type="button" class="btn btn-primary removeKeyword" id="removeKeyword1" class="btn btn-primary">-</button>
        	</div>
		</div>
    </div>	
	
    <div id ="checklistSuperContainer" class="form-group">
        <label for="inputChecklist" class="col-sm-4 control-label">Checklist</label>
        <div id="addChecklistContainer" class="col-sm-6">
			<button type="button" id="addChecklistItem" class="btn btn-primary">Ajouter quelque chose</button>
        </div>
		
		<div id="clearC1" class="clearer clearerC"></div>
		<div id="checklist1" class="multi-input checklistContainer">
			<div class="col-sm-4"></div>
			<div class="inputChecklistContainer col-sm-4">
				<input type="text" class="form-control inputChecklistItem" name="inputChecklistItem1" id="inputChecklistItem1" placeholder="Chose à faire/prendre">
			</div>
			<div class="removeChecklistContainer col-sm-2">
            	<button type="button" class="btn btn-primary removeChecklistItem" id="removeChecklistItem1" class="btn btn-primary">-</button>
			</div>
		</div>
    </div>
	
    <div class="form-group">
        <label for="inputInvitationAllowed" class="col-sm-4 control-label">Autoriser les suggestions d'invités</label>
		<div class="col-sm-2">
            <input type="checkbox" name="inputInvitationAllowed" id="inputInvitationAllowed" value="">
		</div>
    </div>
    
	<div class="form-group">
        <label  for="inputIndividualPropositionAllowed" class="col-sm-4 control-label">Autoriser les suggestions de propositions individuelles</label>
		<div class="col-sm-2">
            <input type="checkbox" name="inputIndividualPropositionAllowed" id="inputIndividualPropositionAllowed" value="">
		</div>
    </div>
    
    <div class="form-group">
        <label for="inputMaxParticipant" class="col-sm-4 control-label">Nombre maximum de participants</label>
        <div class="col-sm-1">
            <input type="text" class="form-control" name="inputMaxParticipant" id="inputMaxParticipant">
        </div>
    </div>
    
    <div class="form-group">
        <label for="inputMinAge" class="col-sm-4 control-label">Age minimal requis</label>
        <div class="col-sm-1">
            <input type="text" class="form-control" name="inputMinAge" id="inputMinAge">
        </div>
    </div>

    <div class="form-group">
        <label for="inputJoinDate" class="col-sm-4 control-label">Date de fin d'inscription</label>
        <div class="col-sm-2">
            <input type="date" class="form-control" name="inputJoinDate" id="inputJoinDate" placeholder="">
        </div>
        <!--<button type="button" class="btn btn-primary">Cal</button>-->
    </div>
	
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-6">
    		<button type="submit" class="btn btn-primary btn-lg">Créer l'événement</button>
		</div>
	</div>

</div>

</div>
</form>