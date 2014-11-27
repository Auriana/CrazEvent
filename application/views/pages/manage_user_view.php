<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
var idUser = <?php echo $user['id']; ?>;
// informations fields must be flushed before performing a new action
function flushInfos() {
    $("#firstnameInfo").text("");
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
		</span>
	</p>
    <p class="bloc-info"> 
        <label for="changeSurname" class="">Nom de famille : <?php echo $user['surname']; ?></label>
        <input type="text" class="pull-center" id="changeSurname" placeholder="Modifer nom de famille">
        <button value="changeSurname" class="btn btn-default btn-lg" onClick="changeSurname()">Modifier</button>
		</span>
	</p>
    <p class="bloc-info"> 
        <label for="changePassword" class="">Mot de passe</label>
        <input type="password" class="pull-center" id="changePassword" placeholder="Modifer mot de passe">
        <button value="changeFirstname" class="btn btn-default btn-lg" onClick="changePassword()">Modifier</button>
		</span>
	</p>
    <p class="boc-info">
        <button type="submit" value="suppressUser" class="btn btn-default btn-lg">Supprimer le compte</button>
    </p>
</div>