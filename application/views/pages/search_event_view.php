<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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

<h3>Recherche un évènement</h3>
<br>


<div class="col-md-6 white-bloc">

    <div class="form-group">
        <label for="inputSearchString" class="col-sm-4 control-label">Recherche</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="inputSearchString" name="inputSearchString" placeholder="recherche par mot-clés">
        </div>
    </div>

    <button value="search" class="btn btn-default btn-lg" onClick="searchEvent()">Recherche</button>

<div class="clearer"><br><b>Résultat de la recherche.</b>
<div id="txtHint"></div>
</div>
</div>