<script>
function validateForm() {
    return true;
}

function searchEvent() {
    var searchString = $("#inputSearchString").val();
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
  xmlhttp.open("GET","search_event?s=" + searchString,true);
  xmlhttp.send();
}
    
</script>
<div class="container theme-showcase" role="main">
<div class="form-horizontal">
<div class="col-md-6 white-bloc centred">
	<h1 class="text-centred">Recherche un évènement</h1>

    <div class="form-group">
        <label for="inputSearchString" class="col-sm-4 control-label">Mots-clés</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="inputSearchString" name="inputSearchString" placeholder="Mots-clés">
        </div>
    </div>
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-7">
    		<button value="search" class="btn btn-default btn-lg" onClick="searchEvent()">Rechercher</button>
		</div>
	</div>

    
<div class="clearer"></div>
<div id="txtHint" class="centred"></div>
	
<div class="clearer"></div>	
</div>
</div>