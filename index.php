<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Panneau de Gestion</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/accueil.css">
</head>
<body>
    <header class="topnav">
      <div class="brand">
        Panneau de Gestion
      </div>
      <nav class="menu">
        <a href="index.php" class="active">Accueil</a>
        <a href="controllers/specialiteController.php">Spécialités</a>
        <a href="controllers/patientController.php">Patients</a>
        <a href="controllers/medecinController.php">Médecins</a>
        <a href="controllers/rendezVousController.php">Rendez-vous</a>
        </nav>
    </header>
    <main class="main">
      <div class="home-content">
        <section class="home-introduction">
          <h1>Bienvenue dans votre espace de gestion médicale</h1>
          <p>
            Cette application vous permet de gérer simplement les
            patients, les médecins, les spécialités médicales et les
            rendez-vous. Utilisez les services ci-dessous pour accéder
            rapidement aux différentes fonctionnalités de l'application.
          </p>
        </section>
        <section class="services-section">
          <h2 class="services-title">Accès rapide aux services</h2>
          <div class="services-grid">
            <a href="controllers/specialiteController.php"class="service-card">
              <div class="service-icon">✚</div>
              <div class="service-content">
                <h3>Spécialités médicales</h3>
                <p>
                  Ajoutez, modifiez, supprimez et consultez
                  les spécialités médicales.
                </p>
                <span class="service-link">Accéder aux spécialités →</span>
              </div>
            </a>
            <a href="controllers/medecinController.php" class="service-card">
              <div class="service-icon">⚕</div>
              <div class="service-content">
                <h3>Médecins</h3>
                <p>
                  Gérez les médecins et leurs spécialités
                  médicales.
                </p>
                <span class="service-link">Accéder aux médecins →</span>
              </div>
            </a>
            <a href="controllers/patientController.php" class="service-card">
              <div class="service-icon">♙</div>
              <div class="service-content">
                <h3>Patients</h3>
                <p>
                  Consultez et gérez les informations
                  des patients.
                </p>
                 <span class="service-link">Accéder aux patients →</span>
              </div>
            </a>
            <a href="controllers/rendezVousController.php" class="service-card">
              <div class="service-icon">◷</div>
              <div class="service-content">
                <h3>Rendez-vous</h3>
                <p>
                  Planifiez, modifiez, annulez et consultez
                  les rendez-vous.
                </p>
                <span class="service-link">Accéder aux rendez-vous →</span>
              </div>
            </a>
          </div>
        </section>
      </div>
    </main>
</body>
</html>