<?php
// inclure le fichier qui contient la connexion à la base de données
require_once 'db.php'; 

// Traitement du formulaire
if($_SERVER ['REQUEST_METHOD'] == 'POST') 
{
    // Je déclare un tableau qui contiendra toutes les erreurs
    $errors = [];

    if (empty($_POST['titre'])) 
    {
        $errors['titre'] = 'Le titre ne doit pas être vide';
    }

    if (strlen($_POST['titre']) <= 3 || strlen($_POST['titre']) > 50) 
    {
        $errors['titre'] = 'Le titre doit contenir entre 3 et 50 caractères';
    }

    if (empty($_POST['contenu'])) 
    {
        $errors['contenu'] = 'Le contenu ne doit pas être vide';
    }

    if (strlen($_POST['contenu']) <= 10) 
    {
        $errors['contenu'] = 'Le contenu doit contenir au moins 10 caractères';
    }

    if (empty($_POST['categorie'])) 
    {
        $errors['categorie'] = 'La categorie ne doit pas être vide';
    }


    // Traitement de l'image
    if (!empty($_FILES['image'])) {
        // Récupération de l'extenson du fichier
        $extension = strtolower(pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION));
        // Tableau des extensions autorisées
        $allowed_extension = ['jpg', 'jpeg', 'png', 'webp'];
        // Si l'extension du fichier n'est pas dans le tableau des extensions autorisées
        if (!in_array($extension, $allowed_extension)) {
            $errors[] = "l'extension du fichier n'est pas autorisée";
        }
        // Si le fichier est trop lourd
        if ($_FILES['image']['size'] > 10000000) {
            $errors[] = "L'image ne doit pas dépasser 1Mo";
        }
    }else {
        $errors[] = 'Vous devez ajouter un image';
    }

    // Si le tableau des erreurs est vide alors je peux insérer l'article dans la base de données
    if (empty($errors)) {

        define('UPLOAD_DIR', $_SERVER['DOCUMENT_ROOT'] . '/PORTFOLIO/photo/');

        $titre = $_POST['titre'];
        $contenu = $_POST['contenu'];
        $photo = time() . '_' . $_FILES['image']['name'];
        $id_categorie = $_POST['categorie'];

        $insert = "INSERT INTO `projets`(`titre`, `contenu`, `photo`, `id_categorie`) VALUES (:titre, :contenu, :photo, :categorie)";
        $query = $bdd->prepare($insert);
        $query->bindValue(':titre', $titre);
        $query->bindValue(':contenu', $contenu);
        $query->bindValue(':photo', $photo);
        $query->bindValue(':categorie', $id_categorie);
        if ($query->execute()) {
            // Ajout de l'image dans le dossier photo
            move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_DIR . $photo);
        }
    }
}

// Récupération des catégories 
$select = "SELECT DISTINCT * FROM categories";
$query2 = $bdd->prepare($select);
$query2->execute();
$categories = $query2->fetchAll(PDO::FETCH_ASSOC);

?>

<?php  
require_once 'partials/header.php';
?>

<h1 class="text-center">Ajouter un projet</h1>

    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- le enctype gére tout les formats des images photos etc.. -->
                <form action="" method="post" enctype="multipart/form-data">  
                    <div class="form-group">
                        <label for="titre">Titre</label>
                        <input type="text" name="titre" id="titre" class="form-control" placeholder="Titre du projet" value="<?= $_POST['titre'] ?? '' ?>">
                        <div class="text-danger"><?= $errors['titre'] ?? '' ?></div>
                    </div>
                    <!-- Affichage des catégories -->
                    <select name="categorie" class="form-select mb-3 mt-3">
                    <?php foreach ($categories as $categorie) : ?>
                        <option value="<?= $categorie['id_categorie'] ?>"><?= $categorie['nom'] ?></option>
                    <?php endforeach; ?>
                    </select>
                    <div class="form-group">
                        <label for="contenu">Contenu</label>
                        <textarea name="contenu" id="contenu" cols="38" rows="10" class="form-control" placeholder="Contenu du projet"><?= $_POST['contenu'] ?? '' ?></textarea>
                        <div class="text-danger"><?= $errors['contenu'] ?? '' ?></div>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary mt-3" >Ajouter
                    </button>
                </form>
            </div>
        </div>
    </div>

<?php require_once 'partials/footer.php';?>