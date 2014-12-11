<?php echo validation_errors(); ?>
<?php echo form_open('welcome/login', 'class="form-horizontal" role="form"'); ?>
<div class="intro-header">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="intro-message">
					<h1>Organise ton événement, et propose-le à tes amis !</h1>
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

		<div class="row">
			<div class="col-lg-5 col-sm-6">
				<h2 class="section-heading">Des fonctionnalités hors normes</h2>
				<p class="lead">Tout a été minutieusement étudié pour te permettre de planifier dans les moindres détails ton événement. </p>
			</div>
			<div class="col-lg-5 col-lg-offset-2 col-sm-6">
				<img class="img-responsive" src="img/ipad.png" alt="">
			</div>
		</div>
	</div><!-- /.container -->
</div><!-- /.content-section-a -->
<div class="content-section-b">
	<div class="container">
		<p class="text-centred">Tu veux qu’un maximum de tes invités soit présent à ton événement ? </p>
		<p class="text-centred">Tu souhaites organiser un voyage, tout en déléguant certaines tâches ?</p>
		<p class="text-centred">Tu aimerais que tes potes n’oublient pas d’apporter leurs boissons lors de ton apéro  comme la dernière fois ?</p>
		<p class="text-centred">Tu as envie d’organiser la meilleure fête de quartier sans voir arriver tes voisins de 12 ans ?</p>
	</div><!-- /.container -->
</div><!-- /.content-section-b -->


