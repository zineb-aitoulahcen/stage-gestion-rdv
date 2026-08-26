<?php
require_once __DIR__ . '/../config/db.php';
class Patient {

    public static function afficher() {
        $db = connectToDB();
        $stmt = $db->query("SELECT * FROM patient");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function ajouter($nom, $prenom, $telephone) {
        $db = connectToDB();
        $stmt = $db->prepare("INSERT INTO patient (nom, prenom, tele) VALUES (?, ?, ?)");
        $stmt->execute([$nom, $prenom, $telephone]);
    }

    public static function modifier($idPatient, $nom, $prenom, $telephone) {
        $db = connectToDB();
        $stmt = $db->prepare("UPDATE patient SET nom = ?, prenom = ?, tele = ? WHERE idPatient = ?");
        $stmt->execute([$nom, $prenom, $telephone, $idPatient]);
    }

    public static function supprimer($idPatient) {
        $db = connectToDB();
        $stmt = $db->prepare("DELETE FROM patient WHERE idPatient = ?");
        $stmt->execute([$idPatient]);
    }

    public static function trouverParId($idPatient) {
        $db = connectToDB();
        $stmt = $db->prepare("SELECT * FROM patient WHERE idPatient = ?");
        $stmt->execute([$idPatient]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function nomPrenomExiste($nom, $prenom) {
        $db = connectToDB();
        $stmt = $db->prepare("SELECT COUNT(*) FROM patient WHERE nom = ? AND prenom = ?");
        $stmt->execute([$nom, $prenom]);
        return $stmt->fetchColumn() > 0;
    }

    public static function telephoneExiste($telephone) {
        $db = connectToDB();
        $stmt = $db->prepare("SELECT COUNT(*) FROM patient WHERE tele = ?");
        $stmt->execute([$telephone]);
        return $stmt->fetchColumn() > 0;
    }

    public static function nomPrenomExisteSaufId($nom, $prenom, $idPatient) {
        $db = connectToDB();
        $stmt = $db->prepare("SELECT idPatient FROM patient WHERE nom = ? AND prenom = ? AND idPatient != ?");
        $stmt->execute([$nom, $prenom, $idPatient]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public static function telephoneExisteSaufId($telephone, $idPatient) {
        $db = connectToDB();
        $stmt = $db->prepare("SELECT idPatient FROM patient WHERE tele = ? AND idPatient != ?");
        $stmt->execute([$telephone, $idPatient]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }


}?>