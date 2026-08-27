<?php 
require_once __DIR__ . '/../config/db.php';
class RendezVous {
    public static function afficher() {
        $db = connectToDB();
        $stmt = $db->query("SELECT rendezvous.idRDV, rendezvous.date, rendezvous.heure,rendezvous.motif,rendezvous.status, 
                            medecin.nom AS nomMedecin, medecin.prenom AS prenomMedecin,
                            patient.nom AS nomPatient, patient.prenom AS prenomPatient
                            FROM rendezvous
                            JOIN medecin ON rendezvous.idMedecin = medecin.idMedecin
                            JOIN patient ON rendezvous.idPatient = patient.idPatient
                            ORDER BY rendezvous.date DESC, rendezvous.heure DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function ajouter($date,$heure,$motif, $idMedecin, $idPatient) {
        $db = connectToDB();
        $stmt = $db->prepare("INSERT INTO rendezvous (date, heure, motif, status, idMedecin, idPatient) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$date, $heure, $motif, 'PLANIFIE',$idMedecin, $idPatient]);
    }

    public static function modifier($date, $heure, $motif, $idMedecin, $idPatient, $idRendezVous) {
        $db = connectToDB();
        $stmt = $db->prepare("UPDATE rendezvous SET date=? , heure=? , motif=? , idMedecin=? , idPatient=? WHERE idRDV = ?");
        $stmt->execute([$date, $heure, $motif, $idMedecin, $idPatient, $idRendezVous]);
    }

    public static function supprimer($idRendezVous) {
        $db = connectToDB();
        $stmt = $db->prepare("DELETE FROM rendezvous WHERE idRDV = ?");
        $stmt->execute([$idRendezVous]);
    }

    public static function annuler ($idRDV) {
        $db = connectToDB();
        $stmt = $db->prepare("UPDATE rendezvous SET status = 'ANNULE' WHERE idRDV = ?");
        $stmt->execute([$idRDV]);
    }

    public static function marquerRealise ($idRDV) {
        $db = connectToDB();
        $stmt = $db->prepare("UPDATE rendezvous SET status = 'REALISE' WHERE idRDV = ?");
        $stmt->execute([$idRDV]);
    }

    public static function filtrerParMed($idMedecin) {
        $db = connectToDB();
        $stmt = $db->prepare("SELECT rendezvous.idRDV, rendezvous.date, rendezvous.heure,rendezvous.motif,rendezvous.status, 
                            medecin.nom AS nomMedecin, medecin.prenom AS prenomMedecin,
                            patient.nom AS nomPatient, patient.prenom AS prenomPatient
                            FROM rendezvous
                            JOIN medecin ON rendezvous.idMedecin = medecin.idMedecin
                            JOIN patient ON rendezvous.idPatient = patient.idPatient
                            WHERE rendezvous.idMedecin = ?
                            ORDER BY rendezvous.date DESC, rendezvous.heure DESC");
        $stmt->execute([$idMedecin]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function filtrerParDate($date) {
        $db = connectToDB();
        $stmt = $db->prepare("SELECT rendezvous.idRDV, rendezvous.date, rendezvous.heure,rendezvous.motif,rendezvous.status, 
                            medecin.nom AS nomMedecin, medecin.prenom AS prenomMedecin,
                            patient.nom AS nomPatient, patient.prenom AS prenomPatient
                            FROM rendezvous
                            JOIN medecin ON rendezvous.idMedecin = medecin.idMedecin
                            JOIN patient ON rendezvous.idPatient = patient.idPatient
                            WHERE rendezvous.date = ?
                            ORDER BY rendezvous.date DESC, rendezvous.heure DESC");
        $stmt->execute([$date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function filtreParPatient($idPatient){
        $db = connectToDB();
        $stmt = $db->prepare("SELECT rendezvous.idRDV, rendezvous.date, rendezvous.heure,rendezvous.motif,rendezvous.status, 
                            medecin.nom AS nomMedecin, medecin.prenom AS prenomMedecin,
                            patient.nom AS nomPatient, patient.prenom AS prenomPatient
                            FROM rendezvous
                            JOIN medecin ON rendezvous.idMedecin = medecin.idMedecin
                            JOIN patient ON rendezvous.idPatient = patient.idPatient
                            WHERE rendezvous.idPatient = ?
                            ORDER BY rendezvous.date DESC, rendezvous.heure DESC");
        $stmt->execute([$idPatient]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function filtrerPatientMed ($idPatient, $idMedecin){
        $db = connectToDB();
        $stmt = $db-> prepare ("SELECT rendezvous.idRDV, rendezvous.date, rendezvous.heure,rendezvous.motif,rendezvous.status, 
                            medecin.nom AS nomMedecin, medecin.prenom AS prenomMedecin,
                            patient.nom AS nomPatient, patient.prenom AS prenomPatient
                            FROM rendezvous
                            JOIN medecin ON rendezvous.idMedecin = medecin.idMedecin
                            JOIN patient ON rendezvous.idPatient = patient.idPatient
                            WHERE rendezvous.idPatient = ? AND rendezvous.idMedecin = ?
                            ORDER BY rendezvous.date DESC, rendezvous.heure DESC");
        $stmt->execute([$idPatient, $idMedecin]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function filtrerPatientDate($idPatient, $date){
        $db = connectToDB();
        $stmt = $db-> prepare ("SELECT rendezvous.idRDV, rendezvous.date, rendezvous.heure,rendezvous.motif,rendezvous.status, 
                            medecin.nom AS nomMedecin, medecin.prenom AS prenomMedecin,
                            patient.nom AS nomPatient, patient.prenom AS prenomPatient
                            FROM rendezvous
                            JOIN medecin ON rendezvous.idMedecin = medecin.idMedecin
                            JOIN patient ON rendezvous.idPatient = patient.idPatient
                            WHERE rendezvous.idPatient = ? AND rendezvous.date = ?
                            ORDER BY rendezvous.date DESC, rendezvous.heure DESC");
        $stmt->execute([$idPatient, $date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function filtrerTout($idPatient, $idMedecin, $date){
        $db = connectToDB();
        $stmt = $db-> prepare ("SELECT rendezvous.idRDV, rendezvous.date, rendezvous.heure,rendezvous.motif,rendezvous.status, 
                            medecin.nom AS nomMedecin, medecin.prenom AS prenomMedecin,
                            patient.nom AS nomPatient, patient.prenom AS prenomPatient
                            FROM rendezvous
                            JOIN medecin ON rendezvous.idMedecin = medecin.idMedecin
                            JOIN patient ON rendezvous.idPatient = patient.idPatient
                            WHERE rendezvous.idPatient = ? AND rendezvous.date = ? AND rendezvous.idMedecin = ?
                            ORDER BY rendezvous.date DESC, rendezvous.heure DESC");
        $stmt->execute([$idPatient, $date, $idMedecin]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function trouverParId($idRendezVous) {
        $db = connectToDB();
        $stmt = $db->prepare("SELECT * FROM rendezvous WHERE idRDV = ?");
        $stmt->execute([$idRendezVous]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function medecinDisponible($idMedecin, $date, $heure){
        $db = connectToDB();
        $stmt = $db->prepare("SELECT count(*) FROM rendezvous WHERE idMedecin =? AND date=? AND heure=?");
        $stmt->execute([$idMedecin, $date, $heure]);
        return $stmt->fetchColumn()<1;
    }

    public static function medecinDisponibleModification($idRendezVous, $idMedecin, $date, $heure){
        $db=connectToDB();
        $stmt = $db->prepare("SELECT count(*) FROM rendezvous WHERE idMedecin =? AND date=? AND heure=? AND idRDV != ? ");
        $stmt->execute([$idMedecin, $date, $heure, $idRendezVous]);
        return $stmt->fetchColumn()<1;
    }
    public static function filtrer_Medecin_Date($idMedecin,$date){
        $db = connectToDB();
        $stmt = $db->prepare("SELECT rendezvous.idRDV, rendezvous.date, rendezvous.heure,rendezvous.motif,rendezvous.status, 
                            medecin.nom AS nomMedecin, medecin.prenom AS prenomMedecin,
                            patient.nom AS nomPatient, patient.prenom AS prenomPatient
                            FROM rendezvous
                            JOIN medecin ON rendezvous.idMedecin = medecin.idMedecin
                            JOIN patient ON rendezvous.idPatient = patient.idPatient
                            WHERE rendezvous.idMedecin = ? AND rendezvous.date = ?");
        $stmt->execute([$idMedecin, $date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function medecin_a_rdv($idMedecin){
        $db = connectToDB();
        $stmt=$db->prepare("SELECT COUNT(*) FROM rendezvous WHERE idMedecin = ?");
        $stmt->execute([$idMedecin]);
        return $stmt->fetchColumn()>0;
    }

    public static function patient_a_rdv($idPatient){
        $db = connectToDB();
        $stmt=$db->prepare("SELECT COUNT(*) FROM rendezvous WHERE idPatient = ?");
        $stmt->execute([$idPatient]);
        return $stmt->fetchColumn()>0;
    }
}