<?php
    require_once '../include/header.php';
    require_once '../include/connect.php';
    
// Afficher l'annonce sélectionnée
$adID = $_GET['id'];
$sql = "SELECT  a.*, 
                c.`name` as 'cat_name', 
                u.`name` as 'user_name',
                d.`name` as 'dpt_name'
            FROM `announces` a 
            LEFT JOIN `categories` c ON c.`id` = a.`categories_id`
            LEFT JOIN `users` u ON u.`id` = a.`users_id`
            LEFT JOIN `departments` d ON d.`number` = a.`departments_number`
            WHERE a.`id`=$adID;";
$query = $db->query($sql);
$annonce = $query->fetch(PDO::FETCH_ASSOC);  

// Poster l'annonce
if(empty($_SESSION['user'])){
    $_SESSION['message'][] = "Vous devez être connecté pour modifier une annonce";
}else{
    // On vérifie que POST n'est pas vide
    if(!empty($_POST)){
        $_SESSION['form'] = $_POST;

        // On vérifie que tous les champs obligatoires sont remplis
        if(
            isset($_POST['title']) && !empty($_POST['title'])
            && isset($_POST['content']) && !empty($_POST['content'])
            && isset($_POST['categorie']) && !empty($_POST['categorie'])
            && isset($_POST['department']) && !empty($_POST['department'])
            && isset($_POST['price']) && !empty($_POST['price']) && $_POST['price']>0
        ){
            // On récupère et on nettoie les données
            $title = strip_tags($_POST['title']);
            $content = htmlspecialchars($_POST['content']);
            $categorie = $_POST['categorie'];
            $department = $_POST['department'];

            if(!is_numeric($_POST['price'])){
                $_SESSION['message'][] = "Le prix est incorrect !";
            }else{
                $price = $_POST['price'];
            }

            if(isset($_FILES['image']) && !empty($_FILES['image'])
            && $_FILES['image']['error'] != UPLOAD_ERR_NO_FILE){
                // On vérifie qu'on n'a pas d'erreur
                if($_FILES['image']['error'] != UPLOAD_ERR_OK){
                    // On ajoute un message de session
                    $_SESSION['message'][] = "Une erreur est survenue lors du transfert du fichier";
                }
    
                // On génère un nouveau nom de fichier
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $nomImage = md5(uniqid()).'.'.$extension;
    
                $extensions = ['png', 'jpg', 'jpeg', 'jfif', 'pjpeg', 'pjp'];
                $types = ['image/png', 'image/jpeg'];
    
                // On vérifie si l'extension et le type sont absents des tableaux
                if(
                    !in_array(strtolower($extension), $extensions)
                    || !in_array($_FILES['image']['type'], $types)
                ){
                    $_SESSION['message'][] = "Le type de l'image est incorrect (PNG ou JPG uniquement)";
                }
    
                $tailleMax = 1048576; // 1024*1024
    
                // On vérifie si la taille dépasse le maximum
                if($_FILES['image']['size'] > $tailleMax){
                    $_SESSION['message'][] = "L'image est trop volumineuse (1Mo maximum)";
                }
    
                if(isset($_SESSION['message']) && !empty($_SESSION['message'])){
                    // Si au moins 1 erreur, on redirige vers le formulaire
                    header('Location: ajout.php');
                    exit;
                }
    
                // On transfère le fichier
                if(!move_uploaded_file(
                        $_FILES['image']['tmp_name'],
                        __DIR__.'/../uploads/'.$nomImage
                    )
                ){
                    // Transfert échoué
                    header('Location: ajout.php');
                    exit;
                }

                $nomImageO = $annonce['featured_image'];
                $cheminImage = __DIR__.'/../uploads/'.$nomImageO;
                $chemin = pathinfo($cheminImage, PATHINFO_DIRNAME); 
                $nomFichier = pathinfo($cheminImage, PATHINFO_FILENAME); 
                $extension = pathinfo($cheminImage, PATHINFO_EXTENSION); 

                unlink(__DIR__.'/../uploads/'.$nomImageO);
                unlink(__DIR__.'/../uploads/'.$nomFichier.'-300x300.'.$extension);
                
                
                mini(__DIR__.'/../uploads/'.$nomImage, 300);

            }else{
                $nomImage = $annonce['featured_image'];
            }


            // On écrit la requête
            $sql = "UPDATE `announces` SET `title`=:title,`content`=:content,`price`=:price,`featured_image`=:nomimage, `categories_id`=:categorie,`departments_number`=:department WHERE `announces`.`id`={$_GET['id']}";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On injecte les valeurs dans les paramètres
            $query->bindValue(':title', $title, PDO::PARAM_STR);
            $query->bindValue(':content', $content, PDO::PARAM_STR);
            $query->bindValue(':categorie', $_POST['categorie'], PDO::PARAM_INT);
            $query->bindValue(':department', $_POST['department'], PDO::PARAM_STR);
            $query->bindValue(':nomimage', $nomImage, PDO::PARAM_STR);
            $query->bindValue(':price', $price, PDO::PARAM_STR);

            // On exécute la requête
            $query->execute();

            header('Location: ../index.php');   
        }else{
            $_SESSION['message'][] = "Le formulaire est incomplet.";
        }
    }
}

    // Afficher les catégories
    $sql = 'SELECT * FROM `categories` ORDER BY `name` ASC;';
    $query = $db->query($sql);
    $categories = $query->fetchAll(PDO::FETCH_ASSOC);

    // Afficher les départements
    $sql = 'SELECT * FROM `departments` ORDER BY `number` ASC;';
    $query = $db->query($sql);
    $departments = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<section>
            <h1>Modifier annonce "<?=$annonce['title'] ?>" de <?=$annonce['user_name'] ?> </h1>
            <form method="post" enctype="multipart/form-data">
                <div>
                    <label for="title">Titre : </label>
                    <input type="text" name="title" id="title"
                    value="<?=$annonce['title'] ?>">
                </div>
                <div>
                    <label for="content">Contenu : </label>
                    <textarea name="content" id="content"><?=$annonce['content'] ?></textarea>
                </div>
                <div>
                    <label for="categorie">Catégorie : </label>
                    <select name="categorie" id="categorie" required>
                        <option value="">-- Choisir une catégorie --</option>
                        <?php foreach($categories as $categorie): ?>
                            <option value="<?= $categorie['id'] ?>"
                            <?php
                                if($annonce['cat_name'] == $categorie['name']){
                                    echo "selected";
                                }
                            ?>
                            >
                                <?= $categorie['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="department">Département : </label>
                    <select name="department" id="department" required>
                        <option value="">-- Choisir le département --</option>
                        <?php foreach($departments as $department): ?>
                            <option value="<?= $department['number'];?>"
                            <?php
                                if($annonce['dpt_name'] == $department['name']){
                                    echo "selected";
                                }
                            ?>
                            >
                                <?= $department['number'].' - '.$department['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="price">Prix : </label>
                    <input type="number" name="price" id="price" min=0 step=0.05
                    value="<?=$annonce['price'] ?>">
                </div>
                <div>
                    <label for="image">Image : </label>
                    <input type="file" name="image" id="image" accept="image/png, image/jpeg">
                </div>
                <button>Modifier l'annonce</button>
            </form>
            <?php unset($_SESSION['form']); ?>

        </section>
        <section>
            <?php
            if(isset($_SESSION['message']) && !empty($_SESSION['message'])){
                foreach($_SESSION['message'] as $message){
                    echo "<p class='erreur'>$message</p>";
                }
                unset($_SESSION['message']);
            }

            if(empty($_SESSION['user'])):?>
                <a href="<?=URL.'/user/connexion.php'?>">Se connecter</a>
            <?php endif ?>
        </section>

    
</body>
</html>