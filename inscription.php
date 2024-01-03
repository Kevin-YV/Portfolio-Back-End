<?php
// inclure le fichier qui contient la connexion à la base de données
require_once 'db.php'; 

// Traitement du formulaire
if($_SERVER ['REQUEST_METHOD'] == 'POST') 
{
    // Je déclare un tableau qui contiendra toutes les erreurs
    $errors = [];

    if (empty($_POST['username'])) 
    {
        $errors['username'] = "Le nom de l'utilisateur ne doit pas être vide";
    }

    if (strlen($_POST['username']) <= 3 || strlen($_POST['username']) > 20) 
    {
        $errors['username'] = "Le nom de l'utilisateur doit contenir entre 3 et 20 caractères";
    }

    if (empty($_POST['password'])) 
    {
        $errors['password'] = 'Le password ne doit pas être vide';
    }

    // Dans la base de données un mot de passe doit être à 255 VARCHAR pour être hasher
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    if (strlen($_POST['password']) <= 4 || strlen($_POST['password']) > 20) 
    {
        $errors['password'] = 'Le password doit contenir entre 4 et 20 caractères';
    }

    // Vérification si l'email existe déjà dans la bdd
    $sqlUsername = "SELECT * FROM portfolio WHERE username = :username";
    $reqUsername = $bdd->prepare($sqlUsername);
    $reqUsername->bindValue(':username', $_POST['username']);
    $reqUsername->execute();
    
    if ($reqUsername->rowCount() > 0) {
        $errors['username'] = "Le nom d'utilisateur existe déjà <br>";
    }
   
    if (empty($errors)) {

        $username = $_POST['username'];
        $password = $_POST['password'];
          
        $insert = "INSERT INTO `utilisateur`(`username`, `password`) VALUES (:username, :password)";
        $query = $bdd->prepare($insert);
        $query->bindValue(':username', $username);
        $query->bindValue(':password', $hash);
        if ($query->execute()) {
            header('Location: index.php');
        }
    }
}

?>

<?php  
require_once 'partials/header.php';
?>
<h1 class="text-center">
    S'inscrire
</h1>
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nom">Nom d'utilisateur</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Entrez votre nom d'utilisateur" value="<?= $_POST['username'] ?? '' ?>">
                    <div class="text-danger"><?= $errors['username'] ?? '' ?></div>
                </div>
                <div class="form-group">
                    <label for="password">mot de passe</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Entrez votre mot de passe" value="<?= $_POST['password'] ?? '' ?>">
                    <div class="text-danger"><?= $errors['password'] ?? '' ?></div>
                </div>
                <button type="submit" class="btn btn-success mt-3">S'inscrire</button>

            </form>
        </div>
    </div>
</div>

<?php require_once 'partials/footer.php';?>