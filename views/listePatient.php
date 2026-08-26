<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients - Panneau de Gestion</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/tables.css">
     <!-- Barre de navigation -->
    <header class="topnav">
        <div class="brand">Panneau de Gestion</div>
        <nav class="menu">
            <a href="../index.php">Accueil</a>
            <a href="specialiteController.php">Spécialités</a>
            <a href="patientController.php" class="active">Patients</a>
            <a href="medecinController.php">Médecins</a>
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
                <h1>Patients</h1>
                <p>Gérez les patients de votre établissement.</p>
            </div>
            <!-- Formulaire pour ajouter -->
            <form action="../controllers/patientController.php" method="GET">
                <input type="hidden" name="action" value="formulaire">
                <button type="submit" class="btn-primary">+ Ajouter un patient</button>
            </form>
        </div>
        <!-- Carte du tableau -->
        <section class="table-card">
            <div class="table-card-header">
                <h2>Liste des patients</h2>
                <p>Consultez et gérez les informations des patients.</p>
            </div>
            <div class="table-wrapper">
                <table class="data-table">
                    <colgroup>
                        <col class="col-id">
                        <col class="col-nom">
                        <col class="col-prenom">
                        <col class="col-telephone">
                        <col class="col-actions">
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="col-id">ID</th>
                            <th class="col-nom">Nom</th>
                            <th class="col-prenom">Prénom</th>
                            <th class="col-telephone">Téléphone</th>
                            <!-- En-tête vide pour les boutons -->
                             <th class="col-actions"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($patients)):?>
                        <?php foreach ($patients as $patient): ?>
                        <tr>
                            <td class="col-id"><?=htmlspecialchars($patient['idPatient'],ENT_QUOTES,'UTF-8'); ?></td>
                            <td class="col-nom"><?=htmlspecialchars($patient['nom'],ENT_QUOTES,'UTF-8'); ?></td>
                            <td class="col-prenom"><?=htmlspecialchars($patient['prenom'],ENT_QUOTES,'UTF-8'); ?></td>
                            <td class="col-telephone"><?=htmlspecialchars($patient['tele'],ENT_QUOTES,'UTF-8'); ?></td>
                            <td class="col-actions">
                                <!-- Modifier -->
                                 <form action="../controllers/patientController.php" methode="GET" class="action-form">
                                    <input type="hidden" name="action" value="formulaire">
                                    <input type="hidden" name="idPatient" value="<?=htmlspecialchars($patient['idPatient'],ENT_QUOTES,'UTF-8'); ?>">
                                    <button type="submit" class="btn-action btn-edit">Modifier</button>
                                </form>
                                <!-- Supprimer -->
                                 <form action="../controllers/patientController.php" method="POST" class="action-form"
                                 onsubmit="return confirm('Voulez-vous supprimer ce patient ?');">
                                    <input type="hidden" name="action" value="supprimer">
                                    <input type="hidden" name="idPatient" value="<?=htmlspecialchars($patient['idPatient'],ENT_QUOTES,'UTF-8'); ?>">
                                    <button type="submit" class="btn-action btn-delete">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>

                            <tr>
                                <td colspan="5" class="text-center">Aucun patient trouvé.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="table-footer">
                affichage de <?= count($patients) ?> patients
            </div>
        </section>
    </main> 
</head>
<body>
    
</body>
</html>