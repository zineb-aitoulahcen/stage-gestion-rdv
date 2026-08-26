<?php
    require_once __DIR__ . '/../config/db.php';
    require_once __DIR__ . '/../models/patient.php';
    require_once __DIR__ . '/../models/rendezvous.php';
    $action = $_GET['action'] ?? $_POST['action'] ?? 'liste';
    switch ($action) {
        case 'liste':
            $patients = Patient::afficher();
            require __DIR__ . '/../views/listePatient.php';
            break;
        case 'formulaire':
            $patient = null;
            if (isset($_GET['idPatient']) && $_GET['idPatient'] !== '') {
                $patient = Patient::trouverParId($_GET['idPatient']);
            }
            $erreurs = [];
            require __DIR__ . '/../views/formPatient.php';
            break;
        case 'ajouter':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nom = trim($_POST['nom']);
                $prenom = trim($_POST['prenom']);
                $tele = trim($_POST['telephone']);
                $erreurs = [];
                if ($nom !== '' && $prenom !== '' && Patient::nomPrenomExiste($nom, $prenom)) {
                    $erreurs[] = "Ce patient exixte déjà.";
                }
                if ($tele !== '' && Patient::telephoneExiste($tele)){
                    $erreurs[] = "Ce numéro de téléphone est déjà utilisé.";
                }
                if (empty($erreurs)){
                    Patient::ajouter($nom,$prenom,$tele);
                    header('Location: patientController.php?action=liste');
                    exit;
                }
                //Conserver les données en cas d'erreur
                $patient = ['idPatient' => '','nom' => $nom,'prenom' => $prenom,'tele' => $tele];
                require __DIR__ . '/../views/formPatient.php';
                exit;
            }
        case 'modifier':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $idPatient = $_POST['idPatient'] ?? '';
                $nom = trim($_POST['nom']);
                $prenom = trim($_POST['prenom']);
                $tele = trim($_POST['telephone']);
                $erreurs = [];
                if ($nom !== '' && $prenom !== '' && Patient::nomPrenomExisteSaufId($nom, $prenom, $idPatient)) {
                    $erreurs[] = "Ce patient existe déjà.";
                }
                if ($tele !== '' && Patient::telephoneExisteSaufId($tele, $idPatient)) {
                    $erreurs[] = "Ce numéro de téléphone est déjà utilisé.";
                }
                if (empty($erreurs)) {
                    Patient::modifier($idPatient,$nom,$prenom,$tele);
                    header('Location: patientController.php?action=liste');
                    exit;
                }
                //Conserver les données en cas d'erreur
                $patient = ['idPatient' => $idPatient,'nom' => $nom,'prenom' => $prenom,'tele' => $tele];
                require __DIR__ . '/../views/formPatient.php';
                exit;
            }
        case 'supprimer':
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $idPatient = $_POST['idPatient'] ?? '';
                $erreurs = [];
                if(RendezVous::patient_a_rdv($idPatient)){
                    $erreurs[] = "Ce patient a des rendez-vous planifiés. Impossible de le suprimer avant la réalisation ou l'annulation des rendez-vous.";
                }
                if ($idPatient !== ''&& empty($erreurs)) {
                    Patient::supprimer($idPatient);
                    header('Location: patientController.php?action=liste');
                    exit;
                }
                $patients = Patient::afficher();
                require __DIR__ . '/../views/listePatient.php';
                exit;
            }
        default:
            header('Location: patientController.php?action=liste');
            exit;

    }
?>