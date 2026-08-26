<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spécialités médicales</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/tables.css">
</head>
<body>
    <header class="topnav">
        <div class="brand">
            Paneau de gestion
        </div>
        <nav class="menu">
            <a href="../index.php">Accueil</a>
            <a href="specialiteController.php" class="active">Spécialités</a>
            <a href="patientController.php">Patients</a>
            <a href="medecinController.php">Médecins</a>
            <a href="rendezVousController.php">Rendez-vous</a>
        </nav>
    </header>
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
                <h1>Spécialités médicales</h1>
                <p>
                    Gérez les spécialités disponibles dans votre établissement.
                </p>
            </div>
            <form action="../controllers/specialiteController.php" method="GET">
                <input type="hidden" name="action" value="formulaire">
                <button type="submit" class="btn-primary">+ Ajouter une spécialité</button>
            </form>
        </div>
        <section class="table-card">
            <div class="table-card-header">
                <h2>Liste des spécialités</h2>
                <p>Consultez et gérez les spécialités médicales.</p>
            </div>
            <div class="table-wrapper">
                <table class="data-table">
                    <colgroup>
                        <col class="col-id">
                        <col class="col-nom">
                        <col class="col-medecins">
                        <col class="col-actions">
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="col-id">ID</th>
                            <th class="col-nom">Spécialité</th>
                            <th class="col-medecins">Médecins</th>
                            <th class="col-actions"></th><!-- En-tête vide -->
                        </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($specialites)) : ?>
                        <?php foreach ($specialites as $specialite) : ?>
                          <tr>
                            <td class="col-id"><?=$specialite['idSpecialite']?></td>
                            <td class="col-nom"><?=$specialite['libelle']?></td>
                            <td class="col-medecins"><?= Specialite::compterMedecins($specialite['idSpecialite']) ?> médecins</td>
                            <td class="col-actions">
                              <form action="../controllers/specialiteController.php" method="GET" class="action-form">
                                <input type="hidden" name="action" value="formulaire">
                                <input type="hidden" name="id" value="<?= $specialite['idSpecialite']?>">
                                <button type="submit" class="btn-action btn-edit">Modifier</button>
                              </form>
                              <form action="../controllers/specialiteController.php" method="POST" class="action-form"
                                onsubmit="return confirm('Voulez-vous supprimer cette spécialité ?');">

                                <input type="hidden" name="action" value="supprimer">
                                <input type="hidden" name="idSpecialite" value="<?= $specialite['idSpecialite']?>">
                                <button type="submit" class="btn-action btn-delete">Supprimer</button>
                              </form>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else : ?>
                          <tr>
                                <td colspan="4" class="empty-cell">Aucune spécialité trouvée.</td>
                          </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
            </div>
            <div class="table-footer">
              <?php $nombreSpecialites = !empty($specialites)? count($specialites): 0;?>
                Affichage de <?= $nombreSpecialites ?> spécialité(s)
            </div>
        </section>
    </main>
</body>
</html>