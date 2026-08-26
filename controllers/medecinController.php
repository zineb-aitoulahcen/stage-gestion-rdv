<?php
require_once __DIR__ . '/../models/medecin.php';
require_once __DIR__ . '/../models/specialite.php';
require_once __DIR__ . '/../models/rendezvous.php';
$action = $_GET['action'] ?? $_POST['action'] ?? 'liste';
switch ($action) {
    //Afficher la liste des médecins
    case 'liste':
        $medecins = Medecin::afficher();
        require __DIR__ . '/../views/listeMedecin.php';
        break;
    //Afficher le formulaire d'ajout ou de modification
    case 'formulaire':
        $medecin = null;
        if (isset($_GET['id']) &&$_GET['id'] !== '') {
            $medecin = Medecin::trouverParId($_GET['id']);
        }
        $specialites = Specialite::afficher();
        $erreurs = [];
        require __DIR__ . '/../views/formMedecin.php';
        break;
    //Ajouter un médecin
    case 'ajouter':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $prenom = trim($_POST['prenom'] ?? '');
            $tele = trim($_POST['tele'] ?? '');
            $idSpecialite = $_POST['idSpecialite'] ?? '';
            $erreurs = [];
            if ($nom !== '' && $prenom !== '' && Medecin::nomPrenomExiste($nom, $prenom)) {
                $erreurs[] = "Ce médecin existe déjà.";
            }
            if ($tele !== '' && Medecin::telephoneExiste($tele)) {
                $erreurs[] =
                    "Ce numéro de téléphone est déjà utilisé.";
            }
            if (empty($erreurs)) {
                Medecin::ajouter($nom,$prenom,$tele,$idSpecialite);
                header('Location: medecinController.php?action=liste');
                exit;
            }
            //Conserver les données en cas d'erreur
            $medecin = [
                'idMedecin' => '',
                'nom' => $nom,
                'prenom' => $prenom,
                'tele' => $tele,
                'idSpecialite' => $idSpecialite 
            ];
            $specialites = Specialite::afficher();
            require __DIR__ . '/../views/formMedecin.php';
            exit;
        }
        break;
    //Modifier un médecin
    case 'modifier':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idMedecin = $_POST['idMedecin'] ?? '';
            $nom = trim($_POST['nom'] ?? '');
            $prenom = trim($_POST['prenom'] ?? '');
            $tele = trim($_POST['tele'] ?? '');
            $idSpecialite = $_POST['idSpecialite'] ?? '';
            $erreurs = [];
            if ($idMedecin === '') {
                $erreurs[] ="L'identifiant du médecin est manquant.";
            }
            if ($nom === '') {
                $erreurs[] = "Le nom est obligatoire.";
            }
            if ($prenom === '') {
                $erreurs[] = "Le prénom est obligatoire.";
            }
            if ($tele === '') {
                $erreurs[] = "Le téléphone est obligatoire.";
            }
            if ($idSpecialite === '') {
                $erreurs[] = "La spécialité est obligatoire.";
            }
            if ($idMedecin !== '' && $nom !== '' && $prenom !== '' && Medecin::nomPrenomExisteSaufId($nom,$prenom,$idMedecin)) {
                $erreurs[] = "Ce médecin existe déjà.";
            }
            if ($idMedecin !== '' && $tele !== '' && Medecin::telephoneExisteSaufId($tele,$idMedecin)) {
                $erreurs[] ="Ce numéro de téléphone est déjà utilisé.";
            }
            if (empty($erreurs)) {
                Medecin::modifier($idMedecin,$nom,$prenom,$tele,$idSpecialite );
                header('Location: medecinController.php?action=liste');
                exit;
            }
            //Conserver les données en cas d'erreur 
            $medecin = [
                'idMedecin' => $idMedecin,
                'nom' => $nom,
                'prenom' => $prenom,
                'tele' => $tele,
                'idSpecialite' => $idSpecialite
            ];
            $specialites = Specialite::afficher();
            require __DIR__ . '/../views/formMedecin.php';
            exit;
        }
        break;
    //Supprimer un médecin
    case 'supprimer':
        $idMedecin = $_POST['idMedecin'] ?? '';
        $erreurs = [];
        if (rendezvous::medecin_a_rdv($idMedecin)){
            $erreurs[] = "Ce médecin a des rendez-vous planifiés. Impossible de le supprimer avant la réalisation ou l'annulation des rendez-vous.";
        }
        if(empty($erreurs)&& $idMedecin !== ''){
            Medecin::supprimer($idMedecin);
            header('Location: medecinController.php?action=liste');
            exit;
        }else{
            $medecins = Medecin::afficher();
            require __DIR__ . '/../views/listeMedecin.php';
            exit;
        }
    //Action inconnue
    default:
        header('Location: medecinController.php?action=liste');
        exit;
}