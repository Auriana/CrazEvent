<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
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
                      $('#actualBirthdate').html('Region : ' + obj['newBirthdate']);
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

<div class="col-md-12 white-bloc centred">
	<h1 class="text-centred">
		Gestion du compte
	</h1>
	<p class="bloc-info"> 
        <label id="actualFirstname" for="changeFirstname" class="">Prénom : <?php echo $user['firstname']; ?></label>
        <input type="text" class="pull-center" id="changeFirstname" placeholder="Modifer prénom">
        <button value="changeFirstname" class="btn btn-default btn-lg" onClick="changeFirstname()">Modifier</button>
        <span id="firstnameInfo"></span>
	</p>
    <p class="bloc-info"> 
        <label id="actualSurname" for="changeSurname" class="">Nom de famille : <?php echo $user['surname']; ?></label>
        <input type="text" class="pull-center" id="changeSurname" placeholder="Modifer nom de famille">
        <button value="changeSurname" class="btn btn-default btn-lg" onClick="changeSurname()">Modifier</button>
        <span id="surnameInfo"></span>
	</p>
    <p class="bloc-info"> 
        <label for="changePassword" class="">Mot de passe</label>
        <input type="password" class="pull-center" id="oldPassword" placeholder="Ancien mot de passe">
        <input type="password" class="pull-center" id="newPassword" placeholder="Nouveau mot de passe">
        <input type="password" class="pull-center" id="confirmPassword" placeholder="Confirme le mot de passe">
        <button value="changePassword" class="btn btn-default btn-lg" onClick="changePassword()">Modifier</button>
        <span id="passwordInfo"></span>
	</p>
    <p class="bloc-info"> 
        <label id="actualBirthdate" for="changeBirthdate" class="">Date de naissance : <?php echo $user['birthdate']; ?></label>
        <input type="date" class="pull-center" id="changeBirthdate" placeholder="Changer date de naissance">
        <button value="changeBirthdate" class="btn btn-default btn-lg" onClick="changeBirthdate()">Modifier</button>
        <span id="birthdateInfo"></span>
    </p>
    <p class="bloc-info"> 
        <label id="actualRegion" for="changeRegion" class="">Région : <?php echo $user['region']; ?></label>
        <select id="changeRegion" class="pull-center" name="changeRegion" placeholder="Modifer région">
            <?php echo $regions; ?>
        </select>
        <button value="changeRegion" class="btn btn-default btn-lg" onClick="changeRegion()">Modifier</button>
        <span id="regionInfo"></span>
    </p>
    <p class="boc-info">
        <button value="suppressUser" class="btn btn-default btn-lg" onClick="suppressAccount()">Supprimer le compte</button>
    </p>
</div>