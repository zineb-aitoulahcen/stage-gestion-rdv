<?php
    require_once __DIR__ . '/../models/rendezvous.php';
    require_once __DIR__ . '/../models/medecin.php';
    require_once __DIR__ . '/../models/patient.php';

    $action = $_GET['action'] ?? $_POST['action'] ?? 'liste';
    switch ($action) {
        //Aficher la liste des rdv
        case 'liste':
            $tabRDV = RendezVous::afficher();
            $medecins = Medecin::afficher();
            $patients = Patient::afficher();
            $date ='';
            $idMedecin='';
            $idPatient='';
            $filtreMed = isset($_GET['idMedecin'])&&!empty($_GET['idMedecin']);
            $filtreDate = isset($_GET['date'])&&!empty($_GET['date']);
            $filtrePatient = isset($_GET['idPatient'])&&!empty($_GET['idPatient']);
            if ($filtreMed && $filtreDate){
                $idMedecin = $_GET['idMedecin'];
                $date = $_GET['date'];
                $tabRDV = rendezvous::filtrer_Medecin_Date($idMedecin,$date);
            }elseif($filtreMed){
                $idMedecin = $_GET['idMedecin'];
                $tabRDV = rendezvous::filtrerParMed($idMedecin);
            }elseif($filtreDate){
                $date = $_GET['date'];
                $tabRDV = rendezvous::filtrerParDate($date);
            }elseif($filtrePatient){
                $idPatient = $_GET['idPatient'];
                $tabRDV = rendezvous::filtreParPatient($idPatient);
            }elseif($filtreMed && $filtreDate && $filtrePatient){
                $idMedecin = $_GET['idMedecin'];
                $idPatient = $_GET['idPatient'];
                $date = $_GET['date'];
                $tabRDV = rendezvous::filtrerTout($idPatient, $idMedecin, $date);
            }elseif($filtrePatient && $filtreMed){
                $idMedecin = $_GET['idMedecin'];
                $idPatient = $_GET['idPatient'];
                $tabRDV = rendezvous::filtrerPatientMed ($idPatient, $idMedecin);
            }elseif($filtrePatient && $date){
                $idMedecin = $_GET['idMedecin'];
                $date = $_GET['date'];
                $tabRDV = rendezvous::filtrerPatientDate($idPatient, $date);
            }
            require __DIR__ . '/../views/listeRDV.php';
            break;
        //Afficher le formulaire d'ajout ou de modification
        case 'formulaire':
            $rdv = null;
            if (isset($_GET['idRendezVous']) && !empty($_GET['idRendezVous'])) {
                $rdv = RendezVous::trouverParId($_GET['idRendezVous']);
            }
            $medecins = Medecin::afficher();
            $patients = Patient::afficher();
            $erreurs = [];
            require __DIR__ . '/../views/formRDV.php';
            break;
        case 'ajouter':
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $date = $_POST['date'];
                $heure = $_POST['heure'];
                $motif = trim($_POST['motif']??'');
                $idMedecin = $_POST['idMedecin'];
                $idPatient = $_POST['idPatient'];
                //pour gerer les err aprés
                $erreurs=[];
                if(!rendezvous::medecinDisponible($idMedecin, $date, $heure)){
                    $erreurs[]=" Ce médecin a déjà un rendez‑vous à ce créneau. ";
                }
                if(empty($erreurs)){
                    RendezVous::ajouter($date, $heure, $motif, $idMedecin, $idPatient);
                    header('Location: rendezVousController.php?action=liste');
                    exit;
                }
                //Conserver les données en cas d'erreur
                $rdv =[
                    'idRDV' => '',
                    'date' => $date,
                    'heure' => $heure,
                    'motif' => $motif,
                    'idMedecin' => $idMedecin,
                    'idPatient' => $idPatient
                ];
                $medecins = Medecin::afficher();
                $patients = Patient::afficher();
                require __DIR__ . '/../views/formRDV.php';
                exit;
            }
        case 'modifier':
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $date = $_POST['date'];
                $heure = $_POST['heure'];
                $motif = trim($_POST['motif']??'');
                $idMedecin = $_POST['idMedecin'];
                $idPatient = $_POST['idPatient'];
                $idRendezVous = $_POST['idRendezVous'];
                $erreurs=[];
                if(!rendezvous::medecinDisponibleModification($idRendezVous, $idMedecin, $date, $heure)){
                    $erreurs[]=" Ce médecin a déjà un rendez‑vous à ce créneau. ";
                }
                if(empty($erreurs)){
                    RendezVous::modifier($date, $heure, $motif, $idMedecin, $idPatient, $idRendezVous);
                    header('Location: rendezVousController.php?action=liste');
                    exit;
                }
                //Conserver les données en cas d'erreur
                $rdv =[
                    'idRDV' => $idRendezVous,
                    'date' => $date,
                    'heure' => $heure,
                    'motif' => $motif,
                    'idMedecin' => $idMedecin,
                    'idPatient' => $idPatient
                ];
                $medecins = Medecin::afficher();
                $patients = Patient::afficher();
                require __DIR__ . '/../views/formRDV.php';
                exit;
            }
        case 'marquerRealise':
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $idRendezVous=$_POST['idRendezVous'];
                RendezVous::marquerRealise($idRendezVous);
                header('Location: rendezVousController.php?action=liste');
                exit;
            }
        case 'annuler':
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $idRendezVous=$_POST['idRendezVous'];
                RendezVous::annuler($idRendezVous);
                header('Location: rendezVousController.php?action=liste');
                exit;
            }
        default:
            header('Location: RdvController.php?action=liste');
            exit;
    }
?>