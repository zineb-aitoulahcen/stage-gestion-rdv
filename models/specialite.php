<?php
require_once __DIR__ . '/../config/db.php';

class Specialite {
    private $id;
    private $libelle;

    public static function ajouter($libelle) {
        $db = connectToDB();
        $stmt = $db->prepare("INSERT INTO specialite (libelle) VALUES (?)");
        $stmt->execute([$libelle]);
    }

    public static function modifier($id, $libelle) {
        $db = connectToDB();
        $stmt = $db->prepare("UPDATE specialite SET libelle = ? WHERE idSpecialite = ?");
        $stmt->execute([$libelle, $id]);
    }

    public static function supprimer($id) {
        $db = connectToDB();
        $stmt = $db->prepare("DELETE FROM specialite WHERE idSpecialite = ?");
        $stmt->execute([$id]);
    }

    public static function afficher() {
        $db = connectToDB();
        $stmt = $db->query("SELECT * FROM specialite");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function trouverParId($id) {
        $db = connectToDB();
        $stmt = $db->prepare("SELECT * FROM specialite WHERE idSpecialite = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function compterMedecins($idSpecialite) {
        $db = connectToDB();
        $stmt = $db->prepare("SELECT COUNT(*) FROM medecin WHERE idSpecialite = ?");
        $stmt->execute([$idSpecialite]);
        return $stmt->fetchColumn();
    }
 }
?>