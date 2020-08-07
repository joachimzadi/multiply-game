<?php
if (!isset($_SESSION)) {
    session_start();
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET' && empty($_SESSION['user'])) {
    header('Location: http://multiplygame.as/pages/login.php');
    exit();
}

require_once '../functions/helper.php';

$user = $_SESSION['user'];

?>

<?php buildHeader('Page Game'); ?>
<div class="container">
    <div class="game-container mt-5">
        <span>Bonjour <?php echo $user; ?></span>
        <h2>Page de jeux</h2>
        <div class="jeux-form">
            <p class="text-center">
                <span class="titre">Voici votre défi du jour</span>
            </p>
            <p class="text-center multiplication">
                <span id="facteur-a"></span>
                <small>x</small>
                <span id="facteur-b"></span>
            </p>
            <form class="tentative-form" autocomplete="off">
                <input id="user" type="hidden" name="user" value="<?php echo $user ?>">
                <div class="input-group mb-3">
                    <input type="text" class="form-control text-center"
                           placeholder="Inscrire votre reponse ici"
                           id="tentative" required
                           name="tentative">
                    <div class="input-group-append">
                        <button id="submit-tentative" class="btn btn-success" type="submit">Valider</button>
                    </div>
                </div>
                <p class="text-center text-danger alert"><small id="msgTentative"></small></p>
            </form>
        </div>
        <p id="msgReponse">
            <span class="message-resulat"></span>
        </p>

        <table id="stats" class="table table-hover text-center">
            <thead class="thead-dark text-center">
            <tr>
                <th>ID</th>
                <th>MULTIPLICATION</th>
                <th>REPONSE</th>
                <th>CORRECT ?</th>
            </tr>
            </thead>
            <tbody id="tentatives-body"></tbody>
        </table>
    </div>
</div>
<script src="../assets/js/script.js" defer></script>
<?php buildFooter(); ?>

