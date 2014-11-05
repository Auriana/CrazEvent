<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Craz'Event</title>
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url().'css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset_url().'css/bootstrap-theme.min.css'; ?>">
    <script src="<?php echo asset_url().'js/bootstrap.min.js'; ?>"></script>
</head>

<body>
    <div class="container">

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
                    <label for="inputPassword" class="col-sm-4 control-label">Mot de passe</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Entre ton mot de passe">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputBirthdate" class="col-sm-4 control-label">Date de naissance</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputBirthdate" placeholder="Entre ta date de naissance">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputPlace" class="col-sm-4 control-label">Région</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputPlace" placeholder="Entre ta région">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputMail" class="col-sm-4 control-label">Adresse e-mail</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputMail" placeholder="Entre ton adresse e-mail">
                    </div>
                </div>

                <button type="submit" value="login" class="btn btn-primary btn-lg">Inscription</button>

            </div>
        </form>

    </div>
    <!-- /container -->
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>

</html>