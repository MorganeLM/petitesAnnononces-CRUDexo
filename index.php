<?php
    require_once 'include/header.php';
    require_once 'include/connect.php';

    // Afficher les annonces
    $sql = "SELECT  a.*, 
                    c.`name` as 'cat_name', 
                    u.`name` as 'user_name',
                    d.`name` as 'dpt_name'
                FROM `announces` a 
                LEFT JOIN `categories` c ON c.`id` = a.`categories_id`
                LEFT JOIN `users` u ON u.`id` = a.`users_id`
                LEFT JOIN `departments` d ON d.`number` = a.`departments_number`
                ORDER BY a.`created_at` DESC;";
    $query = $db->query($sql);
    $annonces = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<section>
    <h1>CRUD Annonces</h1>
    <?php foreach($annonces as $annonce): ?>
        <div class="ads">
            <h2><a class="headlink" href="annonces/detail.php?id=<?=$annonce['id'] ?>"><?=$annonce['title'] ?></a></h2>
            <img src="uploads/<?=$annonce['featured_image'] ?>" alt="<?=$annonce['title'] ?>">
            <p>par <?=$annonce['user_name'] ?> (<?=$annonce['dpt_name'] ?>)</p>
            <p>Catégorie : <?=$annonce['cat_name'] ?></p>
            <p><?=$annonce['content'] ?></p>
            <p>Prix : <?=$annonce['price'] ?> euros</p>
            <p><em>Annonce postée <?=formatDate($annonce['created_at']) ?></em></p>
        </div>
    <?php endforeach ?>
</section>

    
</body>
</html>