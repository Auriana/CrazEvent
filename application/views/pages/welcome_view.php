<?php echo validation_errors(); ?>
<?php echo form_open('verify_login', 'class="form-horizontal" role="form"'); ?>
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
					<a class="centred" href="<?php echo base_url().'create_user'; ?>">...Sinon, inscris-toi!</a>
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
				<hr class="section-heading-spacer">
				<div class="clearfix"></div>
				<h2 class="section-heading">Death to the Stock Photo:<br>Special Thanks</h2>
				<p class="lead">A special thanks to <a target="_blank" href="http://join.deathtothestockphoto.com/">Death to the Stock Photo</a> for providing the photographs that you see in this template. Visit their website to become a member.</p>
			</div>
			<div class="col-lg-5 col-lg-offset-2 col-sm-6">
				<img class="img-responsive" src="img/ipad.png" alt="">
			</div>
		</div>

	</div>
	<!-- /.container -->

</div>
<!-- /.content-section-a -->


