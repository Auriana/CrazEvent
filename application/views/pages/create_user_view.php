<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
function validateForm() {
    var isValid = true;
    if ($("#inputFirstName").val() == "") {
        $("#firstNameError").text("Le prénom est obligatoire");
        isValid = false;
    } else {
        $("#firstNameError").text("");
    }
    if ($("#inputSurname").val() == "") {
        $("#surnameError").text("Le nom de famille est obligatoire");
        isValid = false;
    } else {
        $("#surnameError").text("");
    }
    if ($("#inputPassword").val() == "") {
        $("#passwordError").text("Le mot de passe est obligatoire");
        isValid = false;
    } else {
        $("#passwordError").text("");
    }
    if ($("#inputBirthdate").val() == "") {
        $("#birthdateError").text("La date de naissance est obligatoire");
        isValid = false;
    } else {
        $("#birthdateError").text("");
    }
    if ($("#inputEmail").val() == "") {
        $("#emailError").text("Un email est obligatoire");
        isValid = false;
    } else {
        $("#emailError").text("");
    }
    return isValid;
}
</script>

<h3>Crée ton compte</h3>
<br>

<?php echo validation_errors(); ?>
<?php echo form_open( 'verify_create_user', 'name="register" class="form-horizontal" role="form" onsubmit="return validateForm()"'); ?>
<div class="col-md-6 white-bloc centred">
	<h1 class="text-centred">
		Insère tes données
	</h1>
    <div class="form-group">
        <label for="inputFirstName" class="col-sm-4 control-label">Prénom</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="inputFirstName" name="inputFirstName" placeholder="Entre ton prénom">
            <span id="firstNameError"></span>
        </div>
    </div>

    <div class="form-group">
        <label for="inputSurname" class="col-sm-4 control-label">Nom de famille</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="inputSurname" name="inputSurname" placeholder="Entre ton nom de famille">
            <span id="surnameError"></span>
        </div>
    </div>

    <div class="form-group">
        <label for="inputPassword" class="col-sm-4 control-label">Mot de passe</label>
        <div class="col-sm-8">
            <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Entre ton mot de passe">
            <span id="passwordError"></span>
        </div>
    </div>

    <div class="form-group">
        <label for="inputBirthdate" class="col-sm-4 control-label">Date de naissance</label>
        <div class="col-sm-8">
            <input type="date" class="form-control" id="inputBirthdate" name="inputBirthdate" placeholder="Entre ta date de naissance">
            <span id="birthdateError"></span>
        </div>
    </div>

    <div class="form-group">
        <label for="inputRegion" class="col-sm-4 control-label">Région</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="inputRegion" name="inputRegion" placeholder="Entre ta région">
            <span id="regionError"></span>
        </div>
    </div>

    <div class="form-group">
        <label for="inputEmail" class="col-sm-4 control-label">Adresse e-mail</label>
        <div class="col-sm-8">
            <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Entre ton adresse e-mail">
            <span id="emailError"></span>
        </div>
    </div>

	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
    		<button type="submit" value="login" class="btn btn-default btn-lg">Je m'inscris !</button>
		</div>
	</div>

</div>
</form>