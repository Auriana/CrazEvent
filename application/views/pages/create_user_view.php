<script>
    function checkdate(m, d, y) {
      //  discuss at: http://phpjs.org/functions/checkdate/
      // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
      // improved by: Pyerre
      // improved by: Theriault
      //   example 1: checkdate(12, 31, 2000);
      //   returns 1: true
      //   example 2: checkdate(2, 29, 2001);
      //   returns 2: false
      //   example 3: checkdate(3, 31, 2008);
      //   returns 3: true
      //   example 4: checkdate(1, 390, 2000);
      //   returns 4: false

      return m > 0 && m < 13 && y > 0 && y < 32768 && d > 0 && d <= (new Date(y, m, 0))
        .getDate();
    }
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
        if (!checkdate($("#inputMonth").val(), $("#inputDay").val(), $("#inputYear").val())) {
            $("#birthdateError").text("La date est fausse");
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

<?php echo validation_errors(); ?>
<?php echo form_open( 'manage_user/create', 'name="register" class="form-horizontal" role="form" onsubmit="return validateForm()"'); ?>
<div class="container theme-showcase big-marg-top" role="main">
<div class="col-md-6 white-bloc centred marg-top">
	<h1 class="text-centred">
		Crée ton compte
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
			<div class="col-sm-4">
				<select id="inputDay"  name="inputDay" class="form-control">
					<?php for ($i = 1; $i <= 31; $i++) { echo '<option>' . $i . '</option>'; } ?>      
				</select>
			</div>
			
			<div class="col-sm-4">
				<select id="inputMonth" name="inputMonth" class="form-control"> 
					<?php for ($i = 1; $i <= 12; $i++) { echo '<option>' . $i . '</option>'; } ?>       
				</select> 
			</div>
			
			<div class="col-sm-4">
				<select id="inputYear" name="inputYear" class="form-control"> 
					<?php for ($i = 1900; $i <= 2010; $i++) { echo '<option>' . $i . '</option>'; } ?>   
				</select> 
			</div>

            <span id="birthdateError"></span>
  
        </div>
    </div>

    <div class="form-group">
        <label for="inputRegion" class="col-sm-4 control-label">Région</label>
        <div class="col-sm-8">
            <select id="inputRegion" class="form-control" name="inputRegion">
                <?php echo $regions; ?>
            </select>
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
    
    <div class="clearer"></div>
    <a class ="centred" href="<?php echo base_url().'welcome'; ?>">Retour à l'accueil</a>

</div>
</form>