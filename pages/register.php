<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once '../functions/helper.php';

if (!empty($_POST)) {
    $errors = registerUser($_POST);
}
?>

<?php
buildHeader("Page Register");
?>
    <div class="register-photo">
        <div class="form-container">
            <div class="image-holder"></div>
            <form method="post" autocomplete="off">
                <?php
                if (!empty($errors) && count($errors) > 0) {
                    echo '<div class="alert alert-danger error-container " role="alert">';
                    foreach ($errors as $error) {
                        echo <<<TAG
                                    <ul>
                                        <li>{$error}</li>
                                    </ul>                            
                            TAG;
                    }
                    echo '</div>';
                } else {
                    echo '<h2 class="text-center titre-register"><strong>Créer</strong> un compte</h2>';
                }
                ?>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-user-tie"></i>
                        </span>
                    </div>
                    <input id="pseudo" class="form-control" type="text" name="pseudo"
                           placeholder="Votre pseudo" required/>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-key"></i>
                        </span>
                    </div>
                    <input id="mdp" class="form-control" type="password" name="mdp"
                           placeholder="Votre mot de passe" required/>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fas fa-key"></i>
                        </span>
                    </div>
                    <input id="mdp-repeat" class="form-control" type="password" name="mdp-repeat"
                           placeholder="Repetez le mot de passe" required>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" name="cgu" type="checkbox">J'accepte les termes
                            d'utilisation.</label>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block" type="submit">S'enregister</button>
                </div>
                <a class="already" href="login.php">Vous avez déjà un compte? Connectez-vous ici.</a></form>
        </div>
    </div>
<?php
buildFooter();
?>