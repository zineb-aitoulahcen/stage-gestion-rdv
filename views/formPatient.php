<?php
    $idPatient = '';
    $nom = '';
    $prenom = '';
    $telephone = '';
    $estModification = false;
    //le formulaire est en mode modification seulement si l'identifiant existe.
    if (isset($patient) && is_array($patient) && !empty($patient['idPatient'])) {
        $estModification = true;
    }
    //Récupérer les valeurs du patient.
    if (isset($patient) && is_array($patient)) {
        $idPatient = $patient['idPatient'] ?? '';
        $nom = $patient['nom'] ?? '';
        $prenom = $patient['prenom'] ?? '';
        $telephone = $patient['tele'] ?? '';
    }
    if ($estModification) {
        $titre = "Modifier un patient";
        $actionFormulaire = "modifier";
        $texteBouton = "Enregistrer les modifications";
    } else {
        $titre = "Ajouter un patient";
        $actionFormulaire = "ajouter";
        $texteBouton = "Ajouter le patient";
    }
?>
<!DOCTYPE html>
<html lang="en">
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
            <a href="../controllers/patientController.php?action=liste" class="active">Patients</a>
            <a href="../controllers/medecinController.php?action=liste">Médecins</a>
            <a href="../controllers/rendezVousController.php?action=liste">Rendez-vous</a>
        </nav>
    </header>
    <main class="main">
        <div class="form-page">
            <?php if (!empty($erreurs)) :?>
                <div class="form-erreurs">
                    <?php foreach ($erreurs as $erreur) : ?>
                        <p><?= htmlspecialchars($erreur,ENT_QUOTES,'UTF-8') ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="form-page-header">
                <a href="../controllers/patientController.php?action=liste" class="back-link">← Retour à la liste</a>
                <h1><?= htmlspecialchars($titre,ENT_QUOTES,'UTF-8') ?></h1>
            </div>
            <section class="form-card">
                <div class="form-card-header">
                    <h2>Informations du patient</h2>
                    <p>Tous les champs sont obligatoires.</p>
                </div>
                <form action="../controllers/patientController.php" method="POST" class="form-content">
                    <input type="hidden" name="action" value="<?= htmlspecialchars($actionFormulaire,ENT_QUOTES,'UTF-8') ?>">
                    <?php if ($estModification) : ?>
                        <input type="hidden" name="idPatient" value="<?= htmlspecialchars($idPatient,ENT_QUOTES,'UTF-8') ?>">
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="nom">Nom</label>
                            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($nom,ENT_QUOTES,'UTF-8') ?>"
                                placeholder="Exemple : Nabil" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="prenom">Prénom</label>
                            <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($prenom,ENT_QUOTES,'UTF-8') ?>"
                            placeholder="Exemple : Amine" required>
                    </div>
                    <div class="form-group">
                        <label for="tele">Téléphone</label>
                        <input type="text" id="telephone" name="telephone" value="<?= htmlspecialchars($telephone,ENT_QUOTES,'UTF-8') ?>"
                            pattern="0[5-7][0-9]{8}" placeholder="Exemple : 06 00 00 00 00" required>
                    </div>
                    <div class="form-actions">
                        <a href="../controllers/patientController.php?action=liste" class="btn-cancel">Annuler</a>
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