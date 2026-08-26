<?php
/*
    Le contrôleur envoie la variable $specialite.

    Si $specialite est null :
    le formulaire sert à ajouter une spécialité.

    Si $specialite contient des données :
    le formulaire sert à modifier une spécialité.
*/
$estModification = !empty($specialite);
if ($estModification) {
    $titre = "Modifier une spécialité";
    $actionFormulaire = "modifier";
    $texteBouton = "Enregistrer les modifications";

    $idSpecialite = $specialite['idSpecialite'];
    $libelle = $specialite['libelle'];
} else {
    $titre = "Ajouter une spécialité";
    $actionFormulaire = "ajouter";
    $texteBouton = "Ajouter la spécialité";

    $idSpecialite = "";
    $libelle = "";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titre ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/forms.css">
</head>
<body>
    <!-- Barre de navigation -->
    <header class="topnav">
        <div class="brand">Panneau de Gestion</div>
        <nav class="menu">
            <a href="../index.php">Accueil</a>
            <a href="../controllers/specialiteController.php?action=liste" class="active">Spécialités</a>
            <a href="../controllers/patientController.php?action=liste">Patients</a>
            <a href="../controllers/medecinController.php?action=liste">Médecins</a>
            <a href="../controllers/rendezVousController.php?action=liste">Rendez-vous</a>
        </nav>
    </header>
    <!-- Contenu principal -->
    <main class="main">
        <div class="form-page">
            <!-- En-tête -->
            <div class="form-page-header">
                <a href="../controllers/specialiteController.php?action=liste" class="back-link">
                    ← Retour à la liste
                </a>
                <h1><?= $titre ?></h1>
            </div>
            <!-- Carte du formulaire -->
            <section class="form-card">
                <div class="form-card-header">
                    <h2>Informations de la spécialité</h2>
                </div>
                <!-- Formulaire envoyé au contrôleur -->
                <form action="../controllers/specialiteController.php" method="POST" class="form-content">
                    <!-- Action utilisée par le contrôleur -->
                    <input type="hidden" name="action" value="<?= $actionFormulaire ?>">
                    <!-- ID utilisé seulement pour la modification -->
                    <?php if ($estModification) : ?>
                        <input type="hidden" name="idSpecialite" value="<?= htmlspecialchars($idSpecialite,ENT_QUOTES,'UTF-8') ?>">
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="libelle">Nom de la spécialité</label>
                        <input type="text" id="libelle" name="libelle"
                            value="<?= htmlspecialchars($libelle,ENT_QUOTES,'UTF-8') ?>"
                            placeholder="Exemple : Cardiologie" required maxlength="100">
                        <small>
                            Exemple : Médecine générale, Cardiologie,
                            Dermatologie ou Pédiatrie.
                        </small>
                    </div>
                    <div class="form-actions">
                        <a href="../controllers/specialiteController.php?action=liste" class="btn-cancel">Annuler</a>
                        <button type="submit" class="btn-save"><?= $texteBouton ?></button>
                    </div>
                </form>
            </section>
        </div>
    </main>
</body>
</html>