<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once '../functions/helper.php';

if (!empty($_POST)) {
    $errors = loginUser($_POST);
}

?>

<?php
buildHeader("Page Login");
?>

<div class="login-clean">
    <form method="post" autocomplete="off">
        <h2 class="sr-only">Login Form</h2>
        <div class="illustration">
            <i class="fas fa-unlock-alt"></i>
        </div>
        <?php
        if(!empty($errors['user'])){
            echo <<<TAG
                        <div class="alert alert-danger error-container text-center" role="alert">
                            {$errors['user']}
                        </div>
                    TAG;
        }
        ?>
        <div class="form-group">
            <input id="pseudo" class="form-control" type="text" name="pseudo" placeholder="Votre pseudo de connexion"
                   required>
            <?php
            if(!empty($errors['pseudo'])){
                echo <<<TAG
                        <small class="text-danger">{$errors['pseudo']}</small>
                    TAG;
            }
            ?>
        </div>
        <div class="form-group">
            <input id="mdp" class="form-control" type="password" name="mdp" placeholder="Votre mot de passe">
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-block" type="submit">Connexion</button>
        </div>
        <a class="already" href="register.php">Vous n'avez pas un compte? Créez en un ici.</a>
    </form>
</div>

<?php
buildFooter();
?>
