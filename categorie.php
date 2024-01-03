<?php
// inclure le fichier qui contient la connexion à la base de données
require_once 'db.php'; 

// Traitement du formulaire
if($_SERVER ['REQUEST_METHOD'] == 'POST') 
{
    // Je déclare un tableau qui contiendra toutes les erreurs
    $errors = [];

    if (empty($_POST['categorie'])) 
    {
        $errors['categorie'] = 'La categorie ne doit pas être vide';
    }

    if (strlen($_POST['categorie']) <= 3 || strlen($_POST['categorie']) > 30) 
    {
        $errors['categorie'] = 'La catégorie doit contenir entre 3 et 30 caractères';
    }

    $regex = '/^[a-zA-Z0-9_\- ]+$/';

    if (!preg_match($regex, $_POST['categorie'])) {
        $errors['categorie'] = "Le nom de la catégorie ne doit pas contenir de caractère spéciaux ou n'est pas valide";
    }

    $sqlCategorie = "SELECT * FROM categories WHERE nom = :nom";
    $reqCategorie = $bdd->prepare($sqlCategorie);
    $reqCategorie->bindValue(':nom', $_POST['categorie']);
    $reqCategorie->execute();

    if ($reqCategorie->rowCount() > 0) {
        $errors['categorie'] = "La categorie existe déjà <br>";
    }


    // Si le tableau des erreurs est vide alors je peux insérer la categorie dans la base de données
    if (empty($errors)) {

        $categorie = $_POST['categorie'];
      
        $insert = "INSERT INTO `categories`(`nom`) VALUES (:categorie)";
        $query = $bdd->prepare($insert);
        $query->bindValue(':categorie', $categorie);
        if ($query->execute()) {
            header('Location: ajout_projet.php');
        }
    }

}

?>

<?php  
require_once 'partials/header.php';
?>

<h1 class="text-center">Catégorie</h1>
<div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- le enctype gére tout les formats des images photos etc.. -->
                <form action="" method="post" enctype="multipart/form-data">  
                    <div class="form-group">
                        <label for="categorie">Catégorie</label>
                        <input type="text" name="categorie" id="categorie" class="form-control" placeholder="Nom de la categorie" value="<?= $_POST['categorie'] ?? '' ?>">
                        <div class="text-danger"><?= $errors['categorie'] ?? '' ?></div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3" >Ajouter
                    </button>
                </form>
            </div>
        </div>
    </div>

<?php require_once 'partials/footer.php';?>