        <?php echo validation_errors(); ?>
        <?php echo form_open('verify_create_user', 'class="form-horizontal" role="form"'); ?>
            <div class="col-md-6">

                <div class="form-group">
                    <label for="inputFirstName" class="col-sm-4 control-label">Prénom</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputFirstName" name="inputFirstName" placeholder="Entre ton prénom">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="inputSurname" class="col-sm-4 control-label">Nom de famille</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputSurname" name="inputSurname" placeholder="Entre ton nom de famille">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPassword" class="col-sm-4 control-label">Mot de passe</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Entre ton mot de passe">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputBirthdate" class="col-sm-4 control-label">Date de naissance</label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" id="inputBirthdate" name="inputBirthdate" placeholder="Entre ta date de naissance">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPlace" class="col-sm-4 control-label">Région</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputRegion" name="inputRegion" placeholder="Entre ta région">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputEmail" class="col-sm-4 control-label">Adresse e-mail</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Entre ton adresse e-mail">
                    </div>
                </div>

                <button type="submit" value="login" class="btn btn-primary btn-lg">Inscription</button>

            </div>
        </form>