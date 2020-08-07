<?php

/**
 * Permet d'effectuer une connexion à la base de données
 * @return PDO
 */
function db_connexion()
{
    $database = "multiply_game_db";
    $user = "root";
    $pass = "";

    $url = "mysql:host=127.0.0.1;dbname=$database;charset=utf8";

    try {
        $connexion = new PDO($url, $user, $pass);
        $connexion->exec("set lc_time_names='fr_FR'");
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connexion;
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
}

/**
 * Permet de construire l'en-tete de la page du site
 * @param $titre
 */
function buildHeader($titre)
{
    if (empty($_SESSION['user'])) {
        echo <<<TAG
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <!-- Balises meta obligatoires -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        
            <!-- Kit Font Awesome -->
            <title>$titre</title>
        
            <!-- Kit Font Awesome -->
            <script src="https://kit.fontawesome.com/ec63adeb54.js" defer crossorigin="anonymous"></script>
        
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="../assets/css/app.css">
            <link rel="shortcut icon" href="../assets/img/j4l_logo.svg" type="image/x-icon">
            <link rel="stylesheet" href="../assets/css/style.css">
        </head>
        <body>
        <!-- >> LA NAVBAR -->
        <nav class="navbar navbar-light navbar-expand-md navigation-clean navbar-inverse navbar-fixed-top">
            <div class="container">
                <div>
                    <a class="navbar-brand" style="padding:0;margin-left:0;height:78px;" href="#">
                        <img class="img-fluid" src="../assets/img/expansion.png" alt="Logo">
                    </a>
                    <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="../pages/login.php">Login</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="../pages/register.php">Register</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- LA NAVBAR >> -->
    TAG;
    } else {
        echo <<<TAG
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <!-- Balises meta obligatoires -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        
            <!-- Kit Font Awesome -->
            <title>$titre</title>
        
            <!-- Kit Font Awesome -->
            <script src="https://kit.fontawesome.com/ec63adeb54.js" defer crossorigin="anonymous"></script>
            <link rel="shortcut icon" href="../assets/img/j4l_logo.svg" type="image/x-icon">
        
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="../assets/css/app.css">
            <link rel="stylesheet" href="../assets/css/style.css">
        </head>
        <body>
        <!-- >> LA NAVBAR -->
        <nav class="navbar navbar-light navbar-expand-md navigation-clean navbar-inverse navbar-fixed-top">
            <div class="container">
                <div>
                    <a class="navbar-brand" style="padding:0;margin-left:0;height:78px;" href="#">
                        <img class="img-fluid" src="../assets/img/expansion.png" alt="Logo">
                    </a>
                    <button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>                        
                    </ul>
                </div>
            </div>
        </nav>
        <!-- LA NAVBAR >> -->
    TAG;
    }
}

/**
 * Permet de construire le pied de page
 */
function buildFooter()
{
    echo <<<TAG
        <!-- Bootstrap JS -->
        <script src="../assets/js/app.js"></script>
        </body>        
        </html>
    TAG;
}

/**
 * @param string $chaine
 * @return bool
 */
function valideChaine(string $chaine)
{
    return trim($chaine) !== '';
}

/**
 * Permet de verifier la correpondance des mots de passes passés en parametres
 * @param string $mdp
 * @param string $mdpRepeat
 * @return bool
 */
function matchMotDePasse(string $mdp, string $mdpRepeat)
{
    return $mdp === $mdpRepeat;
}

/**
 * Permet d'effectuer l'enregistrement d'un USER
 * @param array $post
 * @return array La liste des eventuelles erreurs
 */
function registerUser(array $post)
{
    $pseudo = !empty($post['pseudo']) ? htmlspecialchars(ucwords(trim($post['pseudo']))) : '';
    $mdp = !empty($post['mdp']) ? $post['mdp'] : '';
    $mdpRepeat = !empty($post['mdp-repeat']) ? $post['mdp-repeat'] : '';
    $cgu = !empty($post['cgu']) ? $post['cgu'] : '';

    $pseudoValide = valideChaine($pseudo);
    $mdpMatch = matchMotDePasse($mdp, $mdpRepeat);
    $cguValide = $cgu === 'on';
    $errors = [];

    if (!$pseudoValide) {
        $msgPseudoValide = "Le pseudo est requis";
        $errors['pseudo'] = $msgPseudoValide;
    }

    if (!$mdpMatch) {
        $msgMdpMatch = "Les mots de passes sont différents";
        $errors['mdp'] = $msgMdpMatch;
    }

    if (!$cguValide) {
        $msgCduValide = "Vous devez accepter les CGU";
        $errors['cgu'] = $msgCduValide;
    }

    if ($cguValide && $mdpMatch && $pseudoValide) {
        $connexion = db_connexion();
        $sql = "insert into users(pseudo, mdp) values (?, ?)";
        try {
            $req_preparee = $connexion->prepare($sql);
            $req_preparee->execute([$pseudo, $mdp]);
        } catch (Exception $e) {
            $e->getMessage();
        } finally {
            $connexion = null;
        }
    }
    return $errors;
}

/**
 * Permet à un User de se connecter
 * @param array $post
 * @return array
 */
function loginUser(array $post)
{
    $pseudo = !empty($post['pseudo']) ? htmlspecialchars(ucwords(trim($post['pseudo']))) : '';
    $mdp = !empty($post['mdp']) ? $post['mdp'] : '';

    $pseudoValide = valideChaine($pseudo);

    $errors = [];

    if (!$pseudoValide) {
        $msgPseudo = "Le pseudo est requis";
        $errors['pseudo'] = $msgPseudo;
    }

    if ($pseudoValide) {
        $connexion = db_connexion();
        $sql = "select * from users where pseudo = ?";
        try {
            $req_preparee = $connexion->prepare($sql);
            $req_preparee->execute([$pseudo]);

            $userResult = $req_preparee->fetch(PDO::FETCH_ASSOC);

            if ($userResult && ($userResult['mdp'] === $mdp)) {
                $user = $pseudo;
                $_SESSION['user'] = $user;
                header('Location: http://multiplygame.as/pages/game.php');
                exit();
            }
            $errors['user'] = "User inconnu du système";
        } catch (Exception $e) {
            $e->getMessage();
        } finally {
            $connexion = null;
        }
    }
    return $errors;
}

