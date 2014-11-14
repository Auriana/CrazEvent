<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
function validateForm() {
    return true;
}

function searchUser() {
    var firstname = $("#inputFirstName").val();
    var surname = $("#inputSurname").val();
    var region = $("#inputRegion").val();
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","search_user?f=" + firstname + "&s=" + surname + "&r=" + region ,true);
  xmlhttp.send();
}

function addContact(idUser, idContact) {
    $.ajax({
    type: "POST",
    url: '/manage_user/add_contact',
    dataType: 'json',
    data: {arguments: [idUser, idContact]},

    success: function (obj, textstatus) {
                  if( !('error' in obj) ) {
                      console.log("success");
                  }
                  else {
                      console.log(obj.error);
                  }
            }
});
}
</script>

<h3>Recherche un utilisateur</h3>
<br>


<div class="col-md-6 white-bloc">

    <div class="form-group">
        <label for="inputFirstName" class="col-sm-4 control-label">Prénom</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="inputFirstName" name="inputFirstName" placeholder="Entre un prénom">
            <span id="firstNameError"></span>
        </div>
    </div>

    <div class="form-group">
        <label for="inputSurname" class="col-sm-4 control-label">Nom de famille</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="inputSurname" name="inputSurname" placeholder="Entre un nom de famille">
            <span id="surnameError"></span>
        </div>
    </div>

    <div class="form-group">
        <label for="inputRegion" class="col-sm-4 control-label">Région</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="inputRegion" name="inputRegion" placeholder="Entre une région">
            <span id="regionError"></span>
        </div>
    </div>

    <button value="search" class="btn btn-default btn-lg" onClick="searchUser()">Recherche</button>

<div class="clearer"><br><b>Résultat de la recherche.</b>
<div id="txtHint"></div>
</div>
</div>