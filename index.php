<?php 
require_once 'db.php'; 

// Récupération des projets dans la BDD
$req3 = "SELECT DISTINCT * FROM projets";
$stmt3 = $bdd->prepare($req3);
$stmt3->execute();
$projects = $stmt3->fetchAll(PDO::FETCH_ASSOC);

?>

<?php require_once 'partials/header.php';?>
    <h1 class="text-center">Bienvenu sur mon Portfolio</h1>

<div class="container">
    <div class="row">
        <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($projects as $project) : ?>
            <div class="col">
                <div class="card">
                    <img src="/PORTFOLIO/photo/<?=$project['photo'] ?>" class="card-img-top" alt="<?= $project['titre'] ?>" height="220">
                        <div class="card-body">
                         <h5 class="card-title"><?= $project['titre'] ?></h5>
                         <p class="card-text"><?= $project['contenu'] ?></p>
                        </div>
                </div>   
            </div>
        <?php endforeach; ?> 
        </div>
    </div>
</div>

<?php require_once 'partials/footer.php';?>