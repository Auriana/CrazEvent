<?php echo validation_errors(); ?>
<?php echo form_open('welcome/login', 'class="form-horizontal" role="form"'); ?>
<div class="intro-header">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="intro-message">
					<p class="text-centred">Tu veux qu’un maximum de tes invités soit présent à ton événement ? <br />
						Tu souhaites organiser un voyage, tout en déléguant certaines tâches ?</p>
					<br />
					<h1>Organise ton événement 
						<br />et propose-le à tes amis !
					</h1>
				</div>
			</div>
			<div class="col-md-3 white-bloc">
				<section>
					<h1 class="text-centred">
						Identifie-toi
					</h1>
					<div class="form-group form-login">
						<label for="inputEmail" class="control-label">Email</label>
						<input type="email" class="form-control col-sm-4 " id="inputEmail" name="inputEmail" placeholder="Entre ton email">
					</div>

					<div class="form-group form-login">
						<label for="inputPassword" class="control-label">Mot de passe</label>
						<input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Entre ton mot de passe">
					</div>
                    
                    <?php if ($error != null) {
                        echo "<p class='text-red'>L'email ou le mot de passe est erroné</p>";
                    }
                    ?>
					
					<div class="form-group form-login">
						<button type="submit" value="login" class="btn btn-default btn-lg centred">Se connecter</button>
					</div>
						
					<div class="clearer"></div>
					<a class="centred" href="<?php echo base_url().'manage_user/creation'; ?>">...Sinon, inscris-toi!</a>
				</section>
			</div>
			</form>
		</div>
	</div><!-- /.container -->
</div><!-- /.intro-header -->    

 <!-- Page Content -->

<div class="content-section-a">

	<div class="container">
		<div class="row mt centered">
			<div class="col-lg-6 col-lg-offset-3">
				<h1 class="text-centred">Des fonctionnalités hors normes</h2>
				<p class="lead text-centred">Tout a été minutieusement étudié pour te permettre de planifier dans les moindres détails ton événement. </p>
			</div>
		</div>
		<div class="row mt centered">
			<div class="col-lg-4">
				<!--<img src="assets/img/ser01.png" width="180" alt="">-->
				<h4><span class="glyphicon glyphicon-star" aria-hidden="Checklist"></span> Options ouvertes</h4>
				<p>Tu veux trouver une date ou un lieu idéal(e) pour tous tes invités ? Fais-leur plusieurs propositions !</p>
			</div>

			<div class="col-lg-4">
				<h4><span class="glyphicon glyphicon-star" aria-hidden="Checklist"></span> Checklist</h4>
				<p>Voici une façon simple de communiquer les choses à prendre avec soi lors de ton événement.</p>

			</div>

			<div class="col-lg-4">
				<h4><span class="glyphicon glyphicon-star" aria-hidden="Checklist"></span> Propositions individuelles</h4>
				<p>Distribue des tâches à faire ou des choses à prendre parmi les participants. Ceux-ci peuvent même t'aider à compléter cette liste !</p>

			</div>
		</div><!-- /row -->
	</div><!-- /.container -->
</div><!-- /.content-section-a -->
<div class="content-section-b">
	<div class="container">
		<div class="col-lg-7">
			<h1 class="text-centred">Inscris-toi, c'est gratuit !</h1>
		</div>
		<div class="col-lg-5">
			<a class="btn btn-default btn-lg btn-special" href= "<?php echo base_url().'manage_user/creation'; ?>"><span class="glyphicon glyphicon-hand-right" aria-hidden="Inscription"></span> &nbsp; &Ccedil;a se passe ici !</a>
		</div>
	</div><!-- /.container -->
</div><!-- /.content-section-b -->


