<!-- La variable tabRDV est envoyée par le controleur : RdvController.php -->
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rendez vous</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/tables.css">
    <link rel="stylesheet" href="../assets/css/formFiltre.css">
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
    <!-- Contenu principal -->
    <main class="main">
        <div class="page-header">
            <div>
                <h1>Rendez-vous</h1>
                <p>Gérez les rendez-vous de votre établissement.</p>
            </div> 
            <!-- Formulaire pour ajouter -->
            <form action="../controllers/rendezVousController.php" method="GET">
                <input type="hidden" name="action" value="formulaire">
                <button type="submit" class="btn-primary">+ Ajouter un rendez-vous</button>
            </form>
        </div>
        <!-- Carte du tableau -->
        <section class="table-card">
            <div class="table-card-header">
                <div class="header-content">
                    <div class="header-text">
                        <h2>Liste des rendez-vous</h2>
                        <p>Consultez et gérez les informations des rendez-vous.</p>
                    </div>
                    <!-- Filtre -->
                    <form method="GET" action="../controllers/rendezVousController.php" class="filters-form">
                        <input type="hidden" name="action" value="liste">
                        <div class="filters-row">
                            <div class="filter-group">
                                <label for="idPatient">Patient</label>
                                <select name="idPatient" id="idPatient">
                                    <option value="">Tous les patients</option>
                                    <?php foreach ($patients as $patient) : ?>
                                        <option value="<?= htmlspecialchars($patient['idPatient'], ENT_QUOTES, 'UTF-8') ?>"
                                            <?= (isset($_GET['idPatient']) && $_GET['idPatient'] == $patient['idPatient']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($patient['nom'] . ' ' . $patient['prenom'], ENT_QUOTES, 'UTF-8') ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label for="idMedecin">Médecin</label>
                                <select name="idMedecin" id="idMedecin">
                                    <option value="">Tous les médecins</option>
                                    <?php foreach ($medecins as $medecin) : ?>
                                        <option value="<?= htmlspecialchars($medecin['idMedecin'], ENT_QUOTES, 'UTF-8') ?>"
                                            <?= (isset($_GET['idMedecin']) && $_GET['idMedecin'] == $medecin['idMedecin']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($medecin['nom'] . ' ' . $medecin['prenom'], ENT_QUOTES, 'UTF-8') ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="filter-group">
                                <label for="date">Date</label>
                                <input type="date" name="date" id="date" value="<?= htmlspecialchars($date,ENT_QUOTES,'UTF-8') ?>">
                            </div>

                            <div class="filter-actions">
                                <button type="submit" class="btn-filtre">Filtrer</button>
                                <a href="../controllers/rendezVousController.php?action=liste" class="btn-filtre">Réinitialiser</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-wrapper">
                <table class="data-table">
                    <colgroup>
                        <col class="col-id">
                        <col class="col-date">
                        <col class="col-heure">
                        <col class="col-motif">
                        <col class="col-status">
                        <col class="col-medecin">
                        <col class="col-patient">
                        <col class="col-actions">
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="col-id">ID</th>
                            <th class="col-date">Date</th>
                            <th class="col-heure">Heure</th>
                            <th class="col-motif">Motif</th>
                            <th class="col-status">Status</th>
                            <th class="col-medecin">Médecin</th>
                            <th class="col-patient">Patient</th>
                            <!-- En-tête vide pour les boutons -->
                             <th class="col-actions"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tabRDV)):?>
                        <?php foreach ($tabRDV as $rdv): ?>
                        <tr>
                            <td class="col-id"><?=htmlspecialchars($rdv['idRDV'],ENT_QUOTES,'UTF-8'); ?></td>
                            <td class="col-date"><?=htmlspecialchars($rdv['date'],ENT_QUOTES,'UTF-8'); ?></td>
                            <td class="col-heure"><?=htmlspecialchars($rdv['heure'],ENT_QUOTES,'UTF-8'); ?></td>
                            <td class="col-motif"><?=htmlspecialchars($rdv['motif'],ENT_QUOTES,'UTF-8'); ?></td>
                            <td class="col-status"><?=htmlspecialchars($rdv['status'],ENT_QUOTES,'UTF-8'); ?></td>
                            <td class="col-medecin"><?=htmlspecialchars($rdv['nomMedecin'] . ' ' . $rdv['prenomMedecin'],ENT_QUOTES,'UTF-8'); ?></td>
                            <td class="col-patient"><?=htmlspecialchars($rdv['nomPatient'] . ' ' . $rdv['prenomPatient'],ENT_QUOTES,'UTF-8'); ?></td>
                            <td class="col-actions">
                                <?php if($rdv['status']=='PLANIFIE'):?>
                                <!-- Modifier -->
                                 <form action="../controllers/rendezVousController.php" method="GET" class="action-form">
                                    <input type="hidden" name="action" value="formulaire">
                                    <input type="hidden" name="idRendezVous" value="<?=htmlspecialchars($rdv['idRDV'],ENT_QUOTES,'UTF-8'); ?>">
                                    <button type="submit" class="btn-action btn-edit">Modifier</button>
                                </form>
                                <!-- Marquer comme réalisé -->
                                <form action="../controllers/rendezVousController.php" method="POST" class="action-form">
                                    <input type="hidden" name="action" value="marquerRealise">
                                    <input type="hidden" name="idRendezVous" value="<?=htmlspecialchars($rdv['idRDV'],ENT_QUOTES,'UTF-8'); ?>">
                                    <button type="submit" class="btn-action btn-edit">Marquer comme réalisé</button>
                                </form>
                                <!-- Annuler -->
                                 <form action="../controllers/rendezVousController.php" method="POST" class="action-form">
                                    <input type="hidden" name="action" value="annuler">
                                    <input type="hidden" name="idRendezVous" value="<?=htmlspecialchars($rdv['idRDV'],ENT_QUOTES,'UTF-8'); ?>">
                                    <button type="submit" class="btn-action btn-delete">Anuuler</button>
                                 </form>
                                <?php endif;?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Aucun rendez-vous trouvé.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>  
            </div>  
            <div class="table-footer">
                affichage de <?= count($tabRDV) ?> rendez-vous
            </div>
        </section>
    </main>
</body>
</html>