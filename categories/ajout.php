<?php
    require_once '../include/header.php';
    require_once '../include/connect.php';

    if(!empty($_POST)){
        if(
            isset($_POST['name']) && !empty($_POST['name'])
        ){
           
            // On nettoie les données
            $name = strip_tags($_POST['name']);

            // Le formulaire est complet et les données nettoyées
            // On peut inscrire l'utilisateur    
            require_once '../include/connect.php';

            $sql = 'INSERT INTO `categories`(`name`) VALUES (:name);';
            
            $query = $db->prepare($sql);
            $query->bindValue(':name', $name, PDO::PARAM_STR);
            $query->execute();

            $num = $db->lastInsertId();

            $_SESSION['message'][]="Bienvenue $name, vous êtes inscrit(e) sous le numéro $num";

        }
    }

    $sql = 'SELECT * FROM `categories`;';
    $query = $db->query($sql);
    $categories = $query->fetchAll(PDO::FETCH_ASSOC);

     // Afficher les annonces
     if(!empty($_GET)){
        $catID = $_GET['id'];
        $sql = "SELECT  a.*, 
        c.`name` as 'cat_name', 
        u.`name` as 'user_name',
        d.`name` as 'dpt_name'
        FROM `announces` a 
        LEFT JOIN `categories` c ON c.`id` = a.`categories_id`
        LEFT JOIN `users` u ON u.`id` = a.`users_id`
        LEFT JOIN `departments` d ON d.`number` = a.`departments_number`
        WHERE c.`id` = $catID
        ORDER BY a.`created_at` DESC;";
        $query = $db->query($sql);
        $annonces = $query->fetchAll(PDO::FETCH_ASSOC);
     }
     

?>

<section>
    <h1>Catégories</h1>
        <h2>Ajouter une nouvelle catégorie</h2>
        <form method="post">
            <div>
                <label for="name">Nom :</label>
                <input type="text" name="name" id="name">
            </div>
            <button>Ajouter</button>
        </form>

        <h2>Liste des catégories</h2>
        <ul>
            <?php foreach($categories as $cat):?>
            <li><a href="ajout.php?id=<?=$cat['id']?>"><?=$cat['name'] ?></a></li>
            <?php endforeach; ?>

        </ul>

        <h2>Articles par catégorie</h2>
        <?php if(empty($_GET)) : ?>
            <p><em>Cliquez sur une catégorie pour afficher les articles correspondants</em></p>
        <?php endif ?>

        <?php if(!empty($_GET)) : ?>
        <?php foreach($annonces as $annonce): ?>
        <div class="ads">
            <h3><?=$annonce['title'] ?></h3>
            <img src="../uploads/<?=$annonce['featured_image'] ?>" alt="<?=$annonce['title'] ?>">
            <p>par <?=$annonce['user_name'] ?> (<?=$annonce['dpt_name'] ?>)</p>
            <p>Catégorie : <?=$annonce['cat_name'] ?></p>
            <p><?=$annonce['content'] ?></p>
            <p>Prix : <?=$annonce['price'] ?> euros</p>
            <p><em>Annonce postée <?=formatDate($annonce['created_at']) ?></em></p>
        </div>
        <?php endforeach ?>
        <?php endif ?>
        

</section>

