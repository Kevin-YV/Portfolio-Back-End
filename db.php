<?php
// Connexion à la base de données 
$bdd = new PDO(
    'mysql:host=localhost;dbname=portfolio','root','',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    ]
);

session_start();

function isLogged() {
    if (isset($_SESSION['user'])) {
        return true;
    } else {
        return false;
    }
}