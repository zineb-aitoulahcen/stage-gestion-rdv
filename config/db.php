<?php
function chargerEnv() {
    $env = parse_ini_file(__DIR__ . '/../.env');
    foreach ($env as $cle => $valeur) {
        $_ENV[$cle] = $valeur;
    }
}

function connectToDB(){
    chargerEnv();
    try{
        $db = new PDO(
            "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8",
            $_ENV['DB_USER'],
            $_ENV['DB_PASS']
        );
        return $db;
    }
    catch(PDOException $e){
        die("Erreur de connexion : " . $e->getMessage());
    }
}
?>