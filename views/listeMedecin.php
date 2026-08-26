<!-- La variable medecins est envoyée par le controleur : medecinController.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médecins - Panneau de Gestion</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/tables.css">
</head>
<body>
    <!-- Barre de navigation -->
    <header class="topnav">
        <div class="brand">Panneau de Gestion</div>
        <nav class="menu">
            <a href="../index.php">Accueil</a>
            <a href="specialiteController.php">Spécialités</a>
            <a href="patientController.php">Patients</a>
            <a href="medecinController.php" class="active">Médecins</a>
            <a href="rendezVousController.php">Rendez-vous</a>
        </nav>
    </header>
    <!-- Contenu principal -->
    <main class="main">
        <?php if (!empty($erreurs)) : ?>
            <div class="form-erreurs">
                <?php foreach ($erreurs as $erreur) : ?>
                    <p><?= htmlspecialchars($erreur,ENT_QUOTES,'UTF-8') ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="page-header">
            <div>
                <h1>Médecins</h1>
                <p>Gérez les médecins de votre établissement.</p>
            </div>
            <!-- Formulaire pour ajouter -->
            <form action="../controllers/medecinController.php" method="GET">
                <input type="hidden" name="action" value="formulaire">
                <button type="submit" class="btn-primary">+ Ajouter un médecin</button>
            </form>
        </div>
        <!-- Carte du tableau -->
        <section class="table-card">
            <div class="table-card-header">
                <h2>Liste des médecins</h2>
                <p>Consultez et gérez les informations des médecins.</p>
            </div>
            <div class="table-wrapper">
                <table class="data-table">
                    <colgroup>
                        <col class="col-id">
                        <col class="col-nom">
                        <col class="col-prenom">
                        <col class="col-telephone">
                        <col class="col-specialite">
                        <col class="col-actions">
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="col-id">ID</th>
                            <th class="col-nom">Nom</th>
                            <th class="col-prenom">Prénom</th>
                            <th class="col-telephone">Téléphone</th>
                            <th class="col-specialite">Spécialité</th>
                            <!-- En-tête vide pour les boutons -->
                            <th class="col-actions"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($medecins)) : ?>
                            <?php foreach ($medecins as $medecin) : ?>
                                <tr>
                                    <td class="col-id"><?= htmlspecialchars($medecin['idMedecin'],ENT_QUOTES,'UTF-8') ?></td>
                                    <td class="col-nom"><?= htmlspecialchars($medecin['nom'],ENT_QUOTES,'UTF-8') ?></td>
                                    <td class="col-prenom"><?= htmlspecialchars($medecin['prenom'],ENT_QUOTES,'UTF-8') ?></td>
                                    <td class="col-telephone"><?= htmlspecialchars($medecin['tele'],ENT_QUOTES,'UTF-8') ?></td>
                                    <td class="col-specialite"><?= htmlspecialchars($medecin['nomSpecialite'],ENT_QUOTES,'UTF-8') ?></td>
                                    <td class="col-actions">
                                        <!-- Modifier -->
                                        <form action="../controllers/medecinController.php" method="GET" class="action-form">
                                            <input type="hidden" name="action" value="formulaire">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($medecin['idMedecin'],ENT_QUOTES,'UTF-8') ?>">
                                            <button type="submit" class="btn-action btn-edit">Modifier</button>
                                        </form>
                                        <!-- Supprimer -->
                                        <form action="../controllers/medecinController.php" method="POST" class="action-form"
                                            onsubmit="return confirm('Voulez-vous supprimer ce médecin ?');">
                                            <input type="hidden" name="action" value="supprimer">
                                            <input type="hidden" name="idMedecin" value="<?= htmlspecialchars($medecin['idMedecin'],ENT_QUOTES,'UTF-8') ?>">
                                            <button type="submit" class="btn-action btn-delete">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="6" class="empty-cell">Aucun médecin trouvé.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="table-footer">
                <?php $nombreMedecins = !empty($medecins) ? count($medecins) : 0;?>
                Affichage de <?= $nombreMedecins ?> médecin(s)
            </div>
        </section>
    </main>
</body>
</html>