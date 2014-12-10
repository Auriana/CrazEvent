<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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
                      $('#removeContact' + idContact).html('');
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
	<h1 class="text-centred">Mes contacts</h1>
	<div id="contactList"></div>
    
<div class="clearer"></div>
<div id="txtHint" class="centred"></div>
		
</div>
</div>