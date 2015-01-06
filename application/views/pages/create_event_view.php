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
    var placeNbr = $('.inputPlace').length;
    var activityNbr = $('.inputActivity').length;
    var keywordNbr = $('.inputKeyword').length;
    var checklistItemNbr = $('.inputChecklistItem').length;
    var individualPropositionNbr = $('.inputIndividualProposition').length;
    
    // PLACE
    $("#addPlace").click(function(){
        ++placeNbr;
		$("#placeSuperContainer").append(
            '<div id="clearP' + placeNbr +'" class="clearer clearerP"></div>\
            <div id="place' + placeNbr +'" class="multi-input  placeContainer">\
                <div class="col-sm-4"></div>\
                <div class="inputPlaceContainer col-sm-4">\
                    <input type="text" class="form-control inputPlace" id="inputPlace' + placeNbr + '" name="inputPlace' + placeNbr + '" placeholder="Entre un lieu">\
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
        indexIndividualProposition = individualPropositionNbr;
        $( ".removeIndividualProposition" ).each(function( index ) {
            $(this).attr('id', "removeIndividualProposition" + indexIndividualProposition--);
        });
    });
	
	// ADDRESS PICKER
    $('#inputPlace').addresspicker();
});
</script>

<?php echo validation_errors(); ?>
<?php echo form_open( 'manage_event/create', 'name="eventCreation" class="form-horizontal" role="form" onsubmit="return validateForm()"'); ?>
<div class="container theme-showcase" role="main">
<div class="col-md-10 white-bloc centred">
	<h1 class="text-centred">
		Crée ton événement
	</h1>
	<div class="text-centred">
		<p>
			Les champs avec l'astérisque (*) sont obligatoires (les autres, non). 
		</p>
		<p>
			Si tu passes ta souris sur le point d'exclamation (<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="Aide"></span>), des informations au sujet du champ en question apparaîtront. 
		</p>
		<br/>
	</div>
	<div class="clearer"></div>

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
        <label for="inputDate" class="col-sm-4 control-label">*Date de début <a class="link-help" alt="Aide" title="TEXTE ICI"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="Aide"></span></a></label>
        <div class="col-sm-3">
            <input type="text" class="form-control" name="inputDate" id="inputDate">
        </div>
    </div>
    
    <div class="form-group">
        <label for="inputDuration" class="col-sm-4 control-label">Durée (par défaut 1 jour)</label>
        <div class="col-sm-1">
            <input type="text" class="form-control" name="inputDuration" id="inputDuration" placeholder="1">
        </div>
    </div>


    <div class="form-group">

        <label for="inputPlace" class="col-sm-4 control-label">*Adresse de début <a class="link-help" alt="Aide" title="TEXTE ICI"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="Aide"></span></a></label>

        <label for="inputPlace" class="col-sm-4 control-label">Adresse de début<br>(indique plusieurs lieus pour créer un sondage)</label>

        <label for="inputPlace" class="col-sm-4 control-label">Adresse de début <a class="link-help" alt="Aide" title="TEXTE ICI"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="Aide"></span></a></label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="inputPlace" id="inputPlace" placeholder="Entre un lieu">
			<span id="placeError"></span>
        </div>
    </div>

    
    <div id ="placeSuperContainer" class="form-group">
        <label for="inputPlace" class="col-sm-4 control-label">Lieu(s)</label>  
		<div id="addPlaceContainer" class="col-sm-6">
			<button type="button" id="addPlace" class="btn btn-default">Ajouter un lieu</button>
            <span>(indique plusieurs lieus pour créer un sondage)</span>
        </div>
		
		<div id="clearP1" class="clearer clearerP"></div>
		<div id="place1" class="multi-input placeContainer">
			<div class="col-sm-4"></div>
			<div class="inputPlaceContainer col-sm-4">
				<input type="text" class="form-control inputPlace" name="inputPlace1" id="inputPlace1" placeholder="Entre un lieu">
				<span id="place1Error"></span>		
			</div>
			<div class="removePlaceContainer col-sm-2">
				<button type="button" class="btn btn-default removePlace but-icon" id="removePlace1" class="btn btn-default"><span class="glyphicon glyphicon-trash" aria-hidden="Supprimer"></span></button>
			</div>
		</div>
    </div>
	
	<div class="form-group">
        <label for="inputJoinDate" class="col-sm-4 control-label">Date de fin d'inscription</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" name="inputJoinDate" id="inputJoinDate" placeholder="">
        </div>
    </div>
	
    
    <div class="form-group">
        <label for="inputRegion" class="col-sm-4 control-label">*Région</label>
        <div class="col-sm-6">
			<select id="inputRegion" class="form-control" name="inputRegion">
            	<?php echo $regions; ?>
			</select>
		</div>
    </div>
	
    <div id ="activitySuperContainer" class="form-group">
        <label for="inputActivity" class="col-sm-4 control-label">*Activité(s)</label>  
		<div id="addActivityContainer" class="col-sm-6">
			<button type="button" id="addActivity" class="btn btn-default">Ajouter une activité</button>          
        </div>
		
		<div id="clearA1" class="clearer clearerA"></div>
		<div id="activity1" class="multi-input activityContainer">
			<div class="col-sm-4"></div>
			<div class="inputActivityContainer col-sm-4">
				<input type="text" class="form-control inputActivity" name="inputActivity1" id="inputActivity1" placeholder="Entre une activité">
				<span id="activity1Error"></span>		
			</div>
			<div class="removeActivityContainer col-sm-2">
				<button type="button" class="btn btn-default removeActivity but-icon" id="removeActivity1" class="btn btn-default"><span class="glyphicon glyphicon-trash" aria-hidden="Supprimer"></span></button>
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
			<button type="button" id="addKeyword" class="btn btn-default">Ajouter un mot-clé</button>        
        </div>
		
		<div id="clearK1" class="clearer clearerK"></div>
		<div id="keyword1" class="multi-input keywordContainer">
			<div class="col-sm-4"></div>
			<div class="inputKeywordContainer col-sm-4">
				<input type="text" class="form-control inputKeyword" name="inputKeyword1" id="inputKeyword1" placeholder="Entre un mot-clé">
			</div>
			<div class="removeKeywordContainer col-sm-2">
				<button type="button" class="btn btn-default removeKeyword but-icon" id="removeKeyword1"><span class="glyphicon glyphicon-trash" aria-hidden="Supprimer"></span> </button>
        	</div>
		</div>
    </div>	
	
    <div id ="checklistSuperContainer" class="form-group">
		<label for="inputChecklist" class="col-sm-4 control-label">Checklist <a class="link-help" alt="Aide" title="La checklist est une liste de choses que chaque participant doit faire ou prendre. Exemple : son pique-nique."><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="Aide"></span></a></label>
        <div id="addChecklistContainer" class="col-sm-6">
			<button type="button" id="addChecklistItem" class="btn btn-default">Ajouter quelque chose</button>
        </div>
		
		
		<div id="clearC1" class="clearer clearerC"></div>
		<div id="checklist1" class="multi-input checklistContainer">
			<div class="col-sm-4"></div>
			<div class="inputChecklistContainer col-sm-4">
				<input type="text" class="form-control inputChecklistItem" name="inputChecklistItem1" id="inputChecklistItem1" placeholder="Chose à faire/prendre">
			</div>
			<div class="removeChecklistContainer col-sm-2">
            	<button type="button" class="btn btn-default removeChecklistItem but-icon" id="removeChecklistItem1"><span class="glyphicon glyphicon-trash" aria-hidden="Supprimer"></span> </button>
			</div>
		</div>
    </div>
    
    <div id ="individualPropositionSuperContainer" class="form-group">
        <label for="inputIndividualProposition" class="col-sm-4 control-label">Propositions individuelles <a class="link-help" alt="Aide" title="Les propositions individuelles sont les choses à prendre/faire proposées soit par l’organisateur, soit par le participant. Elles sont individuelles pour chaque participant. Exemple: Réserver les billets d'avion"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="Aide"></span></a></label>
        <div id="addIndividualPropositionContainer" class="col-sm-6">
			<button type="button" id="addIndividualProposition" class="btn btn-default">Ajouter quelque chose</button>
        </div>
		
		<div id="clearI1" class="clearer clearerI"></div>
		<div id="individualProposition1" class="multi-input individualPropositionContainer">
			<div class="col-sm-4"></div>
			<div class="inputIndividualPropositionContainer col-sm-4">
				<input type="text" class="form-control inputIndividualProposition" name="inputIndividualProposition1" id="inputIndividualProposition1" placeholder="Chose à faire/prendre">
			</div>
			<div class="removeIndividualPropositionContainer col-sm-2">
            	<button type="button" class="btn btn-default removeIndividualProposition but-icon" id="removeIndividualProposition1"><span class="glyphicon glyphicon-trash" aria-hidden="Supprimer"></span> </button>
			</div>
		</div>
    </div>
    
    <div class="form-group">
        <label  for="inputIndividualPropositionAllowed" class="col-sm-4 control-label">Autoriser les suggestions de propositions individuelles</label>
		<div class="col-sm-1">
            <input type="checkbox" class="form-control" name="inputIndividualPropositionAllowed" id="inputIndividualPropositionAllowed" value="">
		</div>
    </div>
	
    <div class="form-group">
        <label for="inputInvitationAllowed" class="col-sm-4 control-label">Autoriser les suggestions d'invités</label>
		<div class="col-sm-1">
            <input type="checkbox" class="form-control" name="inputInvitationAllowed" id="inputInvitationAllowed" value="">
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
		<div class="col-sm-offset-4 col-sm-6">
    		<button type="submit" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-star" aria-hidden="Créer l'événement"></span> Créer l'événement</button>
		</div>
	</div>

</div>

</div>
</form>