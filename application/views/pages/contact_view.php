<script>

</script>
<div class="container theme-showcase" role="main">
<div class="form-horizontal">
<div class="col-md-6 white-bloc centred">
	<h1 class="text-centred">Contact</h1>
	
	<p class="centred col-md-10 text-centred">
		Voici un formulaire pour nous envoyer toute question, suggestion ou remarque. <br/>
		Nous lisons tous les messages que nous recevons et tâchons d'y repondre dans les plus brefs délais.
	</p>
	
    <div class="form-group">
        <label for="inputName" class="col-sm-4 control-label">Nom</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="inputName" name="inputName" placeholder="Nom">
        </div>
    </div>
	
	<div class="form-group">
        <label for="inputEmail" class="col-sm-4 control-label">Email</label>
        <div class="col-sm-7">
            <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email">
        </div>
    </div>
	
		<div class="form-group">
        <label for="inputSubject" class="col-sm-4 control-label">Sujet</label>
        <div class="col-sm-7">
            <input type="text" class="form-control" id="inputSubject" name="inputSubject" placeholder="Sujet du message">
        </div>
    </div>
	
    <div class="form-group">
        <label for="inputMessage" class="col-sm-4 control-label">Message</label>
		<div class="col-sm-7">
        	<textarea class="form-control" rows="5" name="inputMessage" id="inputMessage"></textarea>
		</div>
    </div>	
	
	
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-7">
    		<button value="send" class="btn btn-default btn-lg" onClick="sendEmail()">Envoyer</button>
		</div>
	</div>

    
<div class="clearer"></div>
		
</div>
</div>