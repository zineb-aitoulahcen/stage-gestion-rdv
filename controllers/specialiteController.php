<?php
require_once __DIR__ . '/../models/specialite.php';
require_once __DIR__ . '/../models/medecin.php';
$action = $_GET['action'] ?? $_POST['action'] ?? 'liste';
switch ($action) {

    case 'liste':
        $specialites = Specialite::afficher();
        require __DIR__ . '/../views/listSpecialite.php';
        break;

    case 'ajouter':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $libelle = trim($_POST['libelle'] ?? '');

            if ($libelle !== '') {
                Specialite::ajouter($libelle);
            }
        }
        header('Location: specialiteController.php?action=liste');
        exit;

    case 'modifier':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id      = $_POST['idSpecialite'] ?? null;
            $libelle = trim($_POST['libelle'] ?? '');

            if ($id && $libelle !== '') {
                Specialite::modifier($id, $libelle);
            }
        }
        header('Location: specialiteController.php?action=liste');
        exit;

    case 'supprimer':
        $id = $_POST['idSpecialite'] ?? null;
        $erreurs = [];
        if ($id && Medecin::specialiteUtilisee($id)) {
            $erreurs[] = "Cette spécialité est associée à au moins un médecin et ne peut pas être supprimée.";
            $specialites = Specialite::afficher();
            require __DIR__ . '/../views/listSpecialite.php';
            break;
        }
        if ($id && !Medecin::specialiteUtilisee($id)){
            Specialite::supprimer($id);
            header('Location: specialiteController.php?action=liste');
            exit;
        }
        

    case 'formulaire':
        // Affiche formSpecialite.php, pré-rempli si un id est fourni (modification)
        $specialite = null;
        if (isset($_GET['id'])) {
            $specialite = Specialite::trouverParId($_GET['id']);
        }
        require __DIR__ . '/../views/formSpecialite.php';
        break;

    default:
        header('Location: specialiteController.php?action=liste');
        exit;
}