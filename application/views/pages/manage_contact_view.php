<script>
var getContacts = function () {
    $.ajax({
    type: "POST",
    url: '/manage_user/get_contacts',

    success: function (obj, textstatus) {
                  if( true ) {
                      $('#contactList').html(obj);
                  }
                  else {
                      console.log(obj.error);
                  }
            }
    });
}
getContacts();
function removeContact(idContact) {
    $.ajax({
    type: "POST",
    url: '/manage_user/remove_contact',
    dataType: 'json',
    data: {arguments: [idContact]},

    success: function (obj, textstatus) {
                  if( !('error' in obj) ) {
                      $('#removeContact' + idContact).remove();
                  }
                  else {
                      console.log(obj.error);
                  }
            }
    });
}
</script>
<div class="container theme-showcase" role="main">
<div class="form-horizontal">
<div class="col-md-6 white-bloc centred">
	<h1 class="text-centred">Contacts</h1>
	<div id="contactList"></div>
    
<div class="clearer"></div>
<div id="txtHint" class="centred"></div>
<p class="text-centred">
	Tu souhaites rechercher un utilisateur ? C'est <a class="" href="<?php echo base_url().'search/user'; ?>">ici</a>.
</p>
	
	</div>
</div>