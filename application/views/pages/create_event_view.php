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
        if ($("#inputActivity1").val() == "") {
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
    var activityNbr = 1;
    var keywordNbr = 1;
    var checklistItemNbr = 1;
    $("#addActivity").click(function(){
        ++activityNbr;
        $("#activityContainer").append("<input type='text' class='form-control' id='inputActivity" + activityNbr + "' name='inputActivity" + activityNbr + "' placeholder='Entre une activité'>");
    });
    $("#addKeyword").click(function(){
        ++keywordNbr;
        $("#keywordContainer").append("<input type='text' class='form-control' id='inputKeyword" + keywordNbr + "' name='inputKeyword" + keywordNbr + "' placeholder='Entre un mot-clé'>");
    });
    $("#addChecklistItem").click(function(){
        ++checklistItemNbr;
        $("#checklistContainer").append("<input type='text' class='form-control' id='inputChecklistItem" + checklistItemNbr + "' name='inputChecklistItem" + checklistItemNbr + "' placeholder='Entre une chose à faire/prendre'>");
    });
});
</script>

<?php echo validation_errors(); ?>
<?php echo form_open( 'verify_create_event', 'name="eventCreation" class="form-horizontal" role="form" onsubmit="return validateForm()"'); ?>

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
            <input type="text" class="form-control" name="inputPlace" id="inputPlace" placeholder="">
			<span id="birthdateError"></span>
        </div>
    </div>
    
    <div class="form-group">
        <label for="inputRegion" class="col-sm-4 control-label">Région</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="inputRegion" placeholder="">
        </div>
    </div>

    <div class="form-group">
        <label for="inputActivity" class="col-sm-4 control-label">*Activité(s)</label>
        <div id="activityContainer" class="col-sm-6">
            <input type="text" class="form-control" name="inputActivity1" id="inputActivity1" placeholder="Entre une activité">
            <span id="activity1Error"></span>
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
        </div>
        <button type="button" id="addKeyword" class="btn btn-primary">+</button>
    </div>

    <div class="form-group">
        <label for="inputChecklist" class="col-sm-4 control-label">Checklist</label>
        <div id="checklistContainer" class="col-sm-6">
            <input type="text" class="form-control" name="inputChecklistItem1" id="inputChecklistItem1" placeholder="Entre une chose à faire/prendre">
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