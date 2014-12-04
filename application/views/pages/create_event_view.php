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
        $("#activityContainer").append("<input type='text' class='form-control inputActivity' id='inputActivity" + activityNbr + "' name='inputActivity" + activityNbr + "' placeholder='Entre une activité'>");
        $("#activityContainer").append('<button type="button" class="btn btn-primary removeActivity" id="removeActivity' + activityNbr + '" class="btn btn-primary">-</button>');
    });
    $('body').on('click', '.removeActivity', function() {
        var deletedActivityNbr = $(this).attr('id').substring(14);
        
        //delete the activity
        $("#inputActivity" + deletedActivityNbr).remove();
        $(this).remove();
        
        //renumber the other activites
        --activityNbr;
        var indexActivity = activityNbr;
        $( ".inputActivity" ).each(function( index ) {
            $(this).attr('id', "inputActivity" + indexActivity);
            $(this).attr('name', "inputActivity" + indexActivity);
            --indexActivity;
        });
        indexActivity = activityNbr;
        $( ".removeActivity" ).each(function( index ) {
            $(this).attr('id', "removeActivity" + indexActivity--);
        });
    });
    $("#addKeyword").click(function(){
        ++keywordNbr;
        $("#keywordContainer").append("<input type='text' class='form-control inputKeyword' id='inputKeyword" + keywordNbr + "' name='inputKeyword" + keywordNbr + "' placeholder='Entre un mot-clé'>");
        $("#keywordContainer").append('<button type="button" class="btn btn-primary removeKeyword" id="removeKeyword' + keywordNbr + '" class="btn btn-primary">-</button>');
    });
    $('body').on('click', '.removeKeyword', function() {
        var deletedKeywordNbr = $(this).attr('id').substring(13);
        
        //delete the keyword
        $("#inputKeyword" + deletedKeywordNbr).remove();
        $(this).remove();
        
        //renumber the other keywords
        --keywordNbr;
        var indexKeyword = keywordNbr;
        $( ".inputKeyword" ).each(function( index ) {
            $(this).attr('id', "inputKeyword" + indexKeyword);
            $(this).attr('name', "inputKeyword" + indexKeyword);
            --indexKeyword;
        });
        indexKeyword = keywordNbr;
        $( ".removeKeyword" ).each(function( index ) {
            $(this).attr('id', "removeKeyword" + indexKeyword--);
        });
    });
    $("#addChecklistItem").click(function(){
        ++checklistItemNbr;
        $("#checklistContainer").append("<input type='text' class='form-control inputChecklistItem' id='inputChecklistItem" + checklistItemNbr + "' name='inputChecklistItem" + checklistItemNbr + "' placeholder='Entre une chose à faire/prendre'>");
        $("#checklistContainer").append('<button type="button" class="btn btn-primary removeChecklistItem" id="removeChecklistItem' + checklistItemNbr + '" class="btn btn-primary">-</button>');
    });
    $('body').on('click', '.removeChecklistItem', function() {
        var deletedChecklistItemNbr = $(this).attr('id').substring(19);
        
        //delete the checklistItem
        $("#inputChecklistItem" + deletedChecklistItemNbr).remove();
        $(this).remove();
        
        //renumber the other checklistItem
        --checklistItemNbr;
        var indexChecklistItem = checklistItemNbr;
        $( ".inputActivity" ).each(function( index ) {
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

<div class="col-md-12 white-bloc centred">
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
        <select id="inputRegion" name="inputRegion">
            <?php echo $regions; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="inputActivity" class="col-sm-4 control-label">*Activité(s)</label>
        <div id="activityContainer" class="col-sm-6">
            <input type="text" class="form-control" name="inputActivity1" id="inputActivity1" placeholder="Entre une activité">
            <span id="activity1Error"></span>
            <button type="button" class="btn btn-primary removeActivity" id="removeActivity1" class="btn btn-primary">-</button>
        </div>
        <button type="button" id="addActivity" class="btn btn-primary">+</button>
    </div>

    <div class="form-group">
        <label class="col-sm-4 control-label">*Description</label>
		<div class="col-sm-6">
        	<textarea class="form-control" rows="5" name="inputDescription" id="inputDescription"></textarea>
            <span id="descriptionError"></span>
		</div>
    </div>

    <div class="form-group">
        <label for="inputKeyword" class="col-sm-4 control-label">Mot(s)-clé(s)</label>
        <div id="keywordContainer" class="col-sm-6">
            <input type="text" class="form-control" name="inputKeyword1" id="inputKeyword1" placeholder="Entre un mot-clé">
            <button type="button" class="btn btn-primary removeKeyword" id="removeKeyword1" class="btn btn-primary">-</button>
        </div>
        <button type="button" id="addKeyword" class="btn btn-primary">+</button>
    </div>

    <div class="form-group">
        <label for="inputChecklist" class="col-sm-4 control-label">Checklist</label>
        <div id="checklistContainer" class="col-sm-6">
            <input type="text" class="form-control" name="inputChecklistItem1" id="inputChecklistItem1" placeholder="Entre une chose à faire/prendre">
            <button type="button" class="btn btn-primary removeChecklistItem" id="removeChecklistItem1" class="btn btn-primary">-</button>
        </div>
        <button type="button" id="addChecklistItem" class="btn btn-primary">+</button>
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