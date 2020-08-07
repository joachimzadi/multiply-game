<?php
if (!isset($_SESSION)) {
    session_start();
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET' && empty($_SESSION['user'])) {
    header('Location: http://multiplygame.as/pages/login.php');
    exit();
}

require_once 'functions/helper.php';

//GERENATION ALEATOIRE DES FACTEURS
if (!empty($_GET['update'])) {
    try {
        $facteurs['a'] = random_int(10, 99);
        $facteurs['b'] = random_int(10, 99);
        echo json_encode($facteurs, JSON_THROW_ON_ERROR);
    } catch (Exception $e) {
        $e->getMessage();
    }
}

//INSERTION EN BDD DES TENTATIVES
if (!empty($_POST['tentative'])) {

    $operation = $_POST['operation'];
    $reponse = (int)$_POST['reponse'];
    $statut = $_POST['statut'] === "true" ? 1 : 0;
    $pseudo = $_POST['pseudo'];

    $connexion = db_connexion();

    $sql = "insert into tentatives(operation, reponse, statut, pseudo) values (?, ?, ?, ?)";

    try {
        $req_preparee = $connexion->prepare($sql);
        $resutalt = $req_preparee->execute([$operation, $reponse, $statut, $pseudo]);
    } catch (Exception $e) {
        $e->getMessage();
    } finally {
        $connexion = null;
    }
}

//SELECTIONNE LED TENTATIVES D'UN USER
if (!empty($_GET['all'])) {

    $pseudo = $_GET['pseudo'];

    $connexion = db_connexion();

    $sql = "select * from tentatives where pseudo = ?";
    try {
        $req_preparee = $connexion->prepare($sql);
        $req_preparee->execute([$pseudo]);
        $tentatives = $req_preparee->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($tentatives, JSON_THROW_ON_ERROR);
    } catch (PDOException | JsonException $e) {
        $e->getMessage();
    } finally {
        $connexion = null;
    }
}