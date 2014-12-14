<?php
include("Controleur/FacadeVue.php");

try {
    $bd = new PDO('sqlite:NFL.db');
}
catch (PDOException $exception) {
    echo 'Connection failed: ' . $exception->getMessage();
}

try {
    $bd->exec("CREATE TABLE IF NOT EXISTS Utilisateurs(
                UtilisateurID integer PRIMARY KEY,
                UtilisateurEmail TEXT,
                UtilisateurMDP TEXT,
                UtilisateurNbJetons INTEGER,
                UtilisateurRole integer);

                CREATE TABLE IF NOT EXISTS Equipes(
                EquipeID integer PRIMARY KEY,
                EquipeNom TEXT,
                EquipeDefaites INTEGER,
                EquipeVictoires INTEGER,
                EquipePF INTEGER,
                EquipePA INTEGER);

                CREATE TABLE IF NOT EXISTS Parties(
                PartieID integer PRIMARY KEY,
                PartieNomHote TEXT,
                PartieNomVisiteur TEXT,
                PartiePointsHote INTEGER ,
                PartiePointsVisiteur INTEGER ,
                PartieDate TEXT,
                FOREIGN KEY (PartieNomHote) REFERENCES Equipes(EquipeNom),
                FOREIGN KEY (PartieNomVisiteur) REFERENCES Equipes(EquipeNom));

                CREATE TABLE IF NOT EXISTS Mises(
                MiseID INTEGER PRIMARY KEY,
                MiseIDUsager integer,
                MiseIDPartie integer,
                MiseJetonGagne INTEGER ,
                MiseType INTEGER ,
                MiseDate TEXT,
                MiseSurHote boolean,
                FOREIGN KEY (MiseIDUsager) REFERENCES Utilisateurs(UtilisateurID),
                FOREIGN KEY (MiseIDPartie) REFERENCES Parties(PartieID))");
}
catch(PDOException $exception)
{
    echo 'connection failed:' . $exception->getMessage();
}

// Parse URL
$path = parse_url($_SERVER["REQUEST_URI"])["path"];
$path = array_filter(explode("/", $path));
$pos = array_search("index.php", $path);

// Get the Controller
if (isset($path[$pos+1])) {
    $Controller = $path[$pos+1];
}
else
{
    header("Location:index.php/Login");
}

// Post ou non
$post = $_SERVER['REQUEST_METHOD'] === 'POST';
include("Controleur/$Controller.php");
$control = new $Controller($path,$pos, $post,$bd);

?>