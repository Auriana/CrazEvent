	<?php echo validation_errors(); ?>
    <?php echo form_open('verify_login', 'class="form-horizontal" role="form"'); ?>
        <div class="col-md-5 white-bloc centred">
			<section>
				<h1 class="text-centred">
					Identifie-toi
				</h1>
				<div class="form-group">
					<label for="inputEmail" class="col-sm-4 control-label">Email</label>
					<div class="col-sm-8">
						<input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Entre ton email">
					</div>
				</div>

				<div class="form-group">
					<label for="inputPassword" class="col-sm-4 control-label">Mot de passe</label>
					<div class="col-sm-8">
						<input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Entre ton mot de passe">
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<button type="submit" value="login" class="btn btn-default btn-lg">Se connecter</button>
					</div>
				</div>
				<div class="clearer"></div>
				<a class ="centred" href="<?php echo base_url().'create_user'; ?>">...Sinon, inscris-toi!</a>
			</section>
			<section>
				
			</section>
        </div>
    </form>