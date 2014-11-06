<div class="container">

    <?php echo validation_errors(); ?>
    <?php echo form_open('verify_login', 'class="form-horizontal" role="form"'); ?>
        <div class="col-md-6">

            <div class="form-group">
                <label for="inputMail" class="col-sm-4 control-label">Email</label>
                <div class="col-sm-8">
                    <input type="email" class="form-control" id="inputMail" name="inputMail" placeholder="Entre ton email">
                </div>
            </div>

            <div class="form-group">
                <label for="inputPassword" class="col-sm-4 control-label">Mot de passe</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Entre ton mot de passe">
                </div>
            </div>

            <button type="submit" value="login" class="btn btn-primary btn-lg">Se connecter</button>

            <a href="<?php echo base_url().'create_user'; ?>">Inscription</a>

        </div>
    </form>

</div>