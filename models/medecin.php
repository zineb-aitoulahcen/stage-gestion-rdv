<?php
require_once __DIR__ . '/../config/db.php';
class Medecin
{
    

    public static function afficher() {
        $db = connectToDB();
        $sql = "SELECT medecin.idMedecin,medecin.nom,medecin.prenom,medecin.tele,medecin.idSpecialite,specialite.libelle AS nomSpecialite
                FROM medecin
                JOIN specialite
                ON medecin.idSpecialite = specialite.idSpecialite
                ORDER BY medecin.idMedecin DESC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function trouverParId($id) {
        $db = connectToDB();
        $stmt = $db->prepare("SELECT * FROM medecin WHERE idMedecin = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function ajouter($nom,$prenom,$tele,$idSpecialite) {
        $db = connectToDB();
        $stmt = $db->prepare("INSERT INTO medecin(nom, prenom, tele, idSpecialite)VALUES(?, ?, ?, ?)");
        $stmt->execute([$nom,$prenom,$tele,$idSpecialite]);
    }

    public static function modifier($id,$nom,$prenom,$tele,$idSpecialite) {
        $db = connectToDB();
        $stmt = $db->prepare("UPDATE medecin SET nom = ?,prenom = ?,tele = ?,idSpecialite = ? WHERE idMedecin = ?");
        $stmt->execute([ $nom,$prenom,$tele,$idSpecialite,$id]);
    }

    public static function supprimer($id) {
        $db = connectToDB();
        $stmt = $db->prepare("DELETE FROM medecin WHERE idMedecin = ?");
        $stmt->execute([$id]);
    }

    public static function nomPrenomExiste($nom, $prenom) {
        $db = connectToDB();
        $stmt = $db->prepare("SELECT COUNT(*) FROM medecin WHERE nom = ? AND prenom = ?");
        $stmt->execute([$nom, $prenom]);
        return $stmt->fetchColumn() > 0;
    }

    public static function telephoneExiste($telephone) {
        $db = connectToDB();
        $stmt = $db->prepare("SELECT COUNT(*) FROM medecin WHERE tele = ?");
        $stmt->execute([$telephone]);
        return $stmt->fetchColumn() > 0;
    }

    public static function nomPrenomExisteSaufId($nom, $prenom, $idMedecin) {
        $db = connectToDB();
        $stmt = $db->prepare("SELECT idMedecin FROM medecin WHERE nom = ? AND prenom = ? AND idMedecin != ?");
        $stmt->execute([$nom,$prenom,$idMedecin]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public static function telephoneExisteSaufId($telephone,$idMedecin) {
        $db = connectToDB();
        $stmt = $db->prepare("SELECT idMedecin FROM medecin WHERE tele = ? AND idMedecin != ?");
        $stmt->execute([$telephone,$idMedecin]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public static function specialiteUtilisee($idSpecialite){
        $db = connectToDB();
        $stmt = $db->prepare("SELECT COUNT(*) FROM medecin WHERE idSpecialite = ?");
        $stmt->execute([$idSpecialite]);
        return $stmt->fetchColumn()>0;
    }

   
}?>