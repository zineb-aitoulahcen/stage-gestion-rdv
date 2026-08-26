<?php
$idMedecin = '';
$nom = '';
$prenom = '';
$tele = '';
$idSpecialite = '';
$estModification = false;
//Le formulaire est en mode modification seulement si l'identifiant existe.
if (isset($medecin) && is_array($medecin) && !empty($medecin['idMedecin'])) {
    $estModification = true;
}
//Récupérer les valeurs du médecin.
if (isset($medecin) && is_array($medecin)) {
    $idMedecin = $medecin['idMedecin'] ?? '';
    $nom = $medecin['nom'] ?? '';
    $prenom = $medecin['prenom'] ?? '';
    $tele = $medecin['tele'] ?? '';
    $idSpecialite = $medecin['idSpecialite'] ?? '';
}
if ($estModification) {
    $titre = "Modifier un médecin";
    $actionFormulaire = "modifier";
    $texteBouton = "Enregistrer les modifications";
} else {
    $titre = "Ajouter un médecin";
    $actionFormulaire = "ajouter";
    $texteBouton = "Ajouter le médecin";
}
if (!isset($specialites) || !is_array($specialites)) {
    $specialites = [];
}
if (!isset($erreurs) || !is_array($erreurs)) {
    $erreurs = [];
} ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titre,ENT_QUOTES,'UTF-8') ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/forms.css">
</head>
<body>
    <header class="topnav">
        <div class="brand">Panneau de Gestion</div>
        <nav class="menu">
            <a href="../index.php">Accueil</a>
            <a href="../controllers/specialiteController.php?action=liste">Spécialités</a>
            <a href="../controllers/patientController.php?action=liste">Patients</a>
            <a href="../controllers/medecinController.php?action=liste" class="active">Médecins</a>
            <a href="../controllers/rendezVousController.php?action=liste">Rendez-vous</a>
        </nav>
    </header>
    <main class="main">
        <div class="form-page">
            <?php if (!empty($erreurs)) : ?>
                <div class="form-erreurs">
                    <?php foreach ($erreurs as $erreur) : ?>
                        <p><?= htmlspecialchars($erreur,ENT_QUOTES,'UTF-8') ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="form-page-header">
                <a href="../controllers/medecinController.php?action=liste" class="back-link">← Retour à la liste</a>
                <h1><?= htmlspecialchars($titre,ENT_QUOTES,'UTF-8') ?></h1>
            </div>
            <section class="form-card">
                <div class="form-card-header">
                    <h2>Informations du médecin</h2>
                    <p>Tous les champs sont obligatoires.</p>
                </div>
                <form action="../controllers/medecinController.php" method="POST" class="form-content">
                    <input type="hidden" name="action" value="<?= htmlspecialchars($actionFormulaire,ENT_QUOTES,'UTF-8') ?>">
                    <?php if ($estModification) : ?>
                        <input type="hidden" name="idMedecin" value="<?= htmlspecialchars( $idMedecin,ENT_QUOTES,'UTF-8' ) ?>">
                    <?php endif; ?>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nom">Nom</label>
                            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($nom,ENT_QUOTES,'UTF-8') ?>"
                                placeholder="Exemple : Benali" required>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prénom</label>
                            <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($prenom,ENT_QUOTES,'UTF-8') ?>"
                                placeholder="Exemple : Amine" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="tele">Téléphone</label>
                            <input type="tel" id="tele" name="tele" value="<?= htmlspecialchars($tele,ENT_QUOTES,'UTF-8') ?>"
                                placeholder="Exemple : 0612345678" required>
                        </div>
                        <div class="form-group">
                            <label for="idSpecialite">Spécialité</label>
                            <select id="idSpecialite" name="idSpecialite" required>
                                <option value="">Sélectionner une spécialité</option>
                                <?php foreach ($specialites as $specialite) : ?>
                                    <option value="<?= htmlspecialchars($specialite['idSpecialite'],ENT_QUOTES,'UTF-8') ?>"
                                        <?php if ($idSpecialite == $specialite['idSpecialite']) : ?>
                                            selected
                                        <?php endif; ?>>
                                        <?= htmlspecialchars( $specialite['libelle'],ENT_QUOTES,'UTF-8') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-actions">
                        <a href="../controllers/medecinController.php?action=liste" class="btn-cancel">Annuler</a>
                        <button type="submit" class="btn-save">
                            <?= htmlspecialchars($texteBouton,ENT_QUOTES,'UTF-8') ?>
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </main>
</body>
</html>