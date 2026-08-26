<?php
    // Initialisation des variables
    $idRendezVous ='';
    $date = '';
    $heure = '';
    $idPatient = '';
    $idMedecin = '';
    $motif = '';
    $status = '';
    $estModification = false;
    //Le formulaire est en mode modification seulement si l'identifiant existe.
    if (isset($rdv) && is_array($rdv) && !empty($rdv['idRDV'])) {
        $estModification = true;
        
    }
    //recuperer les valeurs du rendez-vous.
    if(isset($rdv) && is_array($rdv)){
        $idRendezVous = $rdv['idRDV'] ?? '';
        $date = $rdv['date'] ?? '';
        $heure = $rdv['heure'] ?? '';
        $idPatient = $rdv['idPatient'] ?? '';
        $idMedecin = $rdv['idMedecin'] ?? '';
        $motif = $rdv['motif'] ?? '';
        $status = $rdv['status'] ?? '';
    }
    if ($estModification) {
        // Définir le titre et le texte du bouton pour la modification
        $titreFormulaire = 'Modifier un rendez-vous';
        $actionFormulaire = 'modifier';
        $texteBouton = 'Enregistrer les modifications';
    }else {
        // Définir le titre et le texte du bouton pour l'ajout
        $titreFormulaire = 'Ajouter un rendez-vous';
        $actionFormulaire = 'ajouter';
        $texteBouton = 'Ajouter le rendez-vous';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            <a href="../controllers/medecinController.php?action=liste">Médecins</a>
            <a href="../controllers/rendezVousController.php?action=liste" class="active">Rendez-vous</a>
        </nav>
    </header>
    <main class="main">
        <div classe="form-page">
            <?php if (!empty($erreurs)) : ?>
                <div class="form-erreurs">
                    <?php foreach ($erreurs as $erreur) : ?>
                        <p><?= htmlspecialchars($erreur,ENT_QUOTES,'UTF-8') ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="form-page-header">
                <a href="../controllers/rendezVousController.php?action=liste" class="back-link">← Retour à la liste</a>
                <h1>Formulaire de rendez-vous</h1>
            </div>
            <section class="form-card">
                <div class="form-card-header">
                    <h2>Informations du rendez-vous</h2>
                    <p>Tous les champs sont obligatoires.</p>
                </div>
                <form action="../controllers/rendezVousController.php" method="POST" class="form-content">
                    <input type="hidden" name="action" value="<?= htmlspecialchars($actionFormulaire,ENT_QUOTES,'UTF-8') ?>">
                    <?php if ($estModification) : ?>
                        <input type="hidden" name="idRendezVous" value="<?= htmlspecialchars($idRendezVous,ENT_QUOTES,'UTF-8') ?>">
                    <?php endif; ?>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="idMedecin">Nom du medecin</label>
                            <select name="idMedecin" id="idMedecin" required>
                                <option value="">Sélectionner un medecin</option>
                                <?php foreach ($medecins as $medecin) : ?>
                                    <option value="<?= htmlspecialchars($medecin['idMedecin'],ENT_QUOTES,'UTF-8') ?>"
                                        <?php if($idMedecin == $medecin['idMedecin']) : ?>
                                            selected
                                        <?php endif; ?>>
                                        <?= htmlspecialchars($medecin['nom'] .' '. $medecin['prenom'],ENT_QUOTES,'UTF-8') ?>
                                    </option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="idPatient">Nom du patient</label>
                            <select name="idPatient" id="idPatient" required>
                                <option value="">Sélectionner un patient</option>
                                <?php foreach ($patients as $patient) : ?>
                                    <option value="<?= htmlspecialchars($patient['idPatient'],ENT_QUOTES,'UTF-8') ?>"
                                        <?php if($idPatient == $patient['idPatient']) : ?>
                                            selected
                                        <?php endif; ?>>
                                        <?= htmlspecialchars($patient['nom'] .' '. $patient['prenom'],ENT_QUOTES,'UTF-8') ?>
                                    </option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="date">Date </label>
                            <input type="date" name="date" id="date" value="<?= htmlspecialchars($date,ENT_QUOTES,'UTF-8') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="heure">Heure</label>
                            <input type="time" name="heure" id="heure" value="<?= htmlspecialchars($heure,ENT_QUOTES,'UTF-8') ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="motif">Motif</label>
                        <input type="text" name="motif" id="motif" value="<?= htmlspecialchars($motif,ENT_QUOTES,'UTF-8') ?>" required>
                        <p class="form-note">* Le statut sera automatiquement "Planifié" à la création.</p>
                    </div>
                    <div class="form-actions">
                        <a href="../controllers/rendezVousController.php?action=liste" class="btn-cancel">Annuler</a>
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