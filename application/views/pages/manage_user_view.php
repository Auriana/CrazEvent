<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>    
<script src="<?php echo asset_url().'js/jquery-ui.min.js'; ?>"></script>
<script>
    $(document).ready(function(){
        //using JQueryUI to handle date picking
        $("#changeBirthdate").datepicker({
           dateFormat: "yy-mm-dd"
        });
    });

    var idUser = <?php echo $user['id']; ?>;
    // informations fields must be flushed before performing a new action
    function flushInfos() {
        $("#firstnameInfo").text("");
        $("#surnameInfo").text("");
        $("#passwordInfo").text("");
        $("#regionInfo").text("");
    }
    function changeFirstname() {
        var newFirstname = $("#changeFirstname").val();
        flushInfos();
        if (newFirstname == "") {
            $("#firstnameInfo").text("Le prénom est obligatoire");
            return;
        }
        $.ajax({
            type: "POST",
            url: '/manage_user/change_firstname',
            dataType: 'json',
            data: {arguments: [idUser, newFirstname]},

            success: function (obj, textstatus) {
                if( !('error' in obj) ) {
                    $('#actualFirstname').html('Prénom : ' + newFirstname);
                    $("#firstnameInfo").text("Le prénom a été changé");
                }
                else {
                    console.log(obj.error);
                    $("#firstnameInfo").text("Erreur lors de la mise à jour");
                }
            },
            error: function (obj, textstatus) {
                $("#firstnameInfo").text("Erreur lors de la mise à jour");
            }
        });
    }
    function changeSurname() {
        var newSurname = $("#changeSurname").val();
        flushInfos();
        if (newSurname == "") {
            $("#surnameInfo").text("Le nom de famille est obligatoire");
            return;
        }
        $.ajax({
            type: "POST",
            url: '/manage_user/change_surname',
            dataType: 'json',
            data: {arguments: [idUser, newSurname]},

            success: function (obj, textstatus) {
                if( !('error' in obj) ) {
                    $('#actualSurname').html('Nom de famille : ' + newSurname);
                    $("#surnameInfo").text("Le nom de famille a été changé");
                }
                else {
                    console.log(obj.error);
                    $("#surnameInfo").text("Erreur lors de la mise à jour");
                }
            },
            error: function (obj, textstatus) {
                $("#surnameInfo").text("Erreur lors de la mise à jour");
            }
        });
    }
    function changePassword() {
        var newPassword = $("#newPassword").val();
        var oldPassword = $("#oldPassword").val();
        flushInfos();
        if (newPassword == "" || oldPassword == "") {
            $("#passwordInfo").text("Le mot de passe est obligatoire");
            return;
        } else if (newPassword != $("#confirmPassword").val()) {
            $("#passwordInfo").text("La confirmation doit être identique");
            return;
        }
        $.ajax({
            type: "POST",
            url: '/manage_user/change_password',
            dataType: 'json',
            data: {arguments: [idUser, oldPassword, newPassword]},

            success: function (obj, textstatus) {
                if( !('error' in obj) ) {
                    $("#passwordInfo").text("Le mot de passe a été changé");
                }
                else {
                    console.log(obj.error);
                    $("#passwordInfo").text("Erreur lors de la mise à jour");
                }
            },
            error: function (obj, textstatus) {
                $("#passwordInfo").text("Erreur lors de la mise à jour");
            }
        });
    }
    function changeRegion() {
        var newRegion = $("#changeRegion").val();
        flushInfos();
        $.ajax({
        type: "POST",
        url: '/manage_user/change_region',
        dataType: 'json',
        data: {arguments: [idUser, newRegion]},

            success: function (obj, textstatus) {
                if( !('error' in obj) ) {
                    $('#actualRegion').html('Region : ' + obj['newRegion']);
                    $("#regionInfo").text("La région a été changé");
                }
                else {
                    console.log(obj.error);
                    $("#regionInfo").text("Erreur lors de la mise à jour");
                }
            },
            error: function (obj, textstatus) {
                $("#regionInfo").text("Erreur lors de la mise à jour");
            }
        });
    }
    function changeBirthdate() {
        var newBirthdate = $("#changeBirthdate").val();
        flushInfos();
        console.log(newBirthdate);
        if (newBirthdate == "") {
            $("#birthdateInfo").text("La date est obligatoire");
            return;
        }
        $.ajax({
        type: "POST",
        url: '/manage_user/change_birthdate',
        dataType: 'json',
        data: {arguments: [idUser, newBirthdate]},

        success: function (obj, textstatus) {
                      if( !('error' in obj) ) {
                          $('#actualBirthdate').html('Date de naissance : ' + obj['newBirthdate']);
                          $("#birthdateInfo").text("La date a été changée");
                      }
                      else {
                          console.log(obj.error);
                          $("#birthdateInfo").text("Erreur lors de la mise à jour");
                      }
                },
        error: function (obj, textstatus) {
                        $("#birthdateInfo").text("Erreur lors de la mise à jour");
                }
        });
    }
    function suppressAccount() {
        var txt;
        var response = confirm("Veux tu vraiment supprimer ton compte?\nCe sera irréversible!");
        if (response == true) {
            $.ajax({
                type: "POST",
                url: '/manage_user/suppress_account',
                dataType: 'json',
                // The idUser is send as a confirmation for the action
                data: {arguments: [idUser]},

                success: function (obj, textstatus) {
                              if( !('error' in obj) ) {
                                  window.location.replace('<?php echo base_url() . 'home/logout' ?>');
                                  alert('Compte supprimé');
                              }
                              else {
                                  alert('Erreur lors de la suppression du compte');
                              }
                        },
                error: function (obj, textstatus) {
                                alert('Erreur lors de la suppression du compte');
                }
            });
        }
    }
</script>
<div class="container theme-showcase" role="main">
	<div class="col-md-10 white-bloc centred">
		<h1 class="text-centred">
			Gestion de ton compte
		</h1>

		<div class="form-group"> 
			<label id="actualFirstname" for="changeFirstname" class="col-sm-3 control-label"><?php echo "Prénom : " .$user['firstname']; ?></label>
			<div class="col-sm-4">
				<input type="text" class="pull-center form-control" id="changeFirstname" placeholder="Modifer prénom">
				<span id="firstnameInfo"></span>
			</div>
			<div class="col-sm-4">
				<button value="changeFirstname" class="btn btn-default" onClick="changeFirstname()">Modifier</button>	
			</div>
		</div>

		<div class="clearer"></div>
		<div class="form-group multi-input"> 
			<label id="actualSurname" for="changeSurname" class="col-sm-3 control-label"><?php echo "Nom de famille : " .$user['surname']; ?></label>
			<div class="col-sm-4">
				<input type="text" class="pull-center form-control" id="changeSurname" placeholder="Modifer nom de famille">
				<span id="surnameInfo"></span>
			</div>
			<div class="col-sm-4">
				<button value="changeSurname" class="btn btn-default" onClick="changeSurname()">Modifier</button>
			</div>
		</div>
		
		<div class="clearer"></div>
		<div class="form-group multi-input"> 
			<label id="actualRegion" for="changeRegion" class="col-sm-3 control-label"><?php echo "Région : " .$user['region']; ?></label>
			<div class="col-sm-4">
				<select id="changeRegion" class="pull-center form-control" name="changeRegion" placeholder="Modifer région">
					<?php echo $regions; ?>
				</select>
				<span id="regionInfo"></span>
			</div>
			<div class="col-sm-4">
				<button value="changeRegion" class="btn btn-default" onClick="changeRegion()">Modifier</button>
			</div>
		</div>
        
        <div class="clearer"></div>
		<div class="form-group multi-input"> 
			<label id="actualBirthdate" for="changeBirthdate" class="col-sm-3 control-label"><?php echo "Date de naissance : " . $user['birthdate']; ?></label>
			<div class="col-sm-4">
				<input type="text" class="pull-center form-control" id="changeBirthdate" placeholder="Changer date de naissance">
				<span id="birthdateInfo"></span>
			</div>
			<div class="col-sm-4">
				<button value="changeBirthdate" class="btn btn-default" onClick="changeBirthdate()">Modifier</button>
			</div>
		</div>
		
		<div class="clearer"></div>
		<div class="form-group multi-input"> 
			<label for="changePassword" class="col-sm-3 control-label">Mot de passe</label>
			<div class="col-sm-4">
				<input type="password" class="pull-center form-control" id="oldPassword" placeholder="Ancien mot de passe">
				<span id="passwordInfo"></span>
			</div>
			<div class="clearer"></div>
			<div class="multi-input">
				<div class="col-sm-3"></div>
				<div class="col-sm-4">
					<input type="password" class="pull-center form-control" id="newPassword" placeholder="Nouveau mot de passe">
				</div>
			</div>
			<div class="clearer"></div>
			<div class="multi-input">
				<div class="col-sm-3"></div>
				<div class="col-sm-4">
					<input type="password" class="pull-center form-control" id="confirmPassword" placeholder="Confirme le nouveau mot de passe">
				</div>
				<div class="col-sm-4">
					<button value="changePassword" class="btn btn-default" onClick="changePassword()">Modifier</button>
				</div>
			</div>
		</div>	
		
		<div class="clearer"></div>
		<div class="form-group multi-input"> 
			<button value="suppressUser" class="btn btn-danger btn-lg" onClick="suppressAccount()">Supprimer le compte</button>
		</div>
	</div>