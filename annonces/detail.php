<?php
    require_once '../include/header.php';
    require_once '../include/connect.php';

    // Afficher l'annonce sélectionnée
    $adID = $_GET['id'];
    $sql = "SELECT  a.*, 
                    c.`name` as 'cat_name', 
                    u.`name` as 'user_name',
                    u.`phone` as 'user_phone',
                    d.`name` as 'dpt_name'
                FROM `announces` a 
                LEFT JOIN `categories` c ON c.`id` = a.`categories_id`
                LEFT JOIN `users` u ON u.`id` = a.`users_id`
                LEFT JOIN `departments` d ON d.`number` = a.`departments_number`
                WHERE a.`id`=$adID;";
    $query = $db->query($sql);
    $annonce = $query->fetch(PDO::FETCH_ASSOC);

?>

<section>
    <h1>Détail de l'annonce</h1>
        <div class="ads">
            <h2><a class="headlink" href="#"><?=$annonce['title'] ?></a></h2>
            <img src="../uploads/<?=$annonce['featured_image'] ?>" alt="<?=$annonce['title'] ?>">
            <p>par <?=$annonce['user_name'] ?> (<?=$annonce['dpt_name'] ?>)</p>
            <p>Catégorie : <?=$annonce['cat_name'] ?></p>
            <p><?=$annonce['content'] ?></p>
            <p>Prix : <?=$annonce['price'] ?> euros</p>
            <p><em>Annonce postée <?=formatDate($annonce['created_at']) ?></em></p>

            <button class='button' type="button"><a href="detail.php?id=<?=$annonce['id']?>&amp;click=true">acheter</a></button>
                <?php 
                if(isset($_GET['click'])){
                    if($_GET['click']=='true'){
                        echo "<p id='contact'> Contactez le vendeur au {$annonce['user_phone']} </p>";
                    }
                }
                ?>

            <p id="modif"><a href="modif.php?id=<?=$adID?>"><i class="las la-pen"></i>Modifier l'annonce</a></p>
        </div>

        <a href="<?= URL ?>">Retour</a>

        <p>
        <?php if(!isset($_GET['voir_plus'])) :?>
            <a href="detail.php?id=<?=$annonce['id']?>&amp;userID=<?=$annonce['users_id']?>&amp;voir_plus=true">Voir toutes les annonces de <?=$annonce['user_name']?> </a>
        <?php endif ?>
        </p>
        <?php
            if(isset($_GET['voir_plus'])){
                if($_GET['voir_plus']=='true'){
                    $userID = $_GET['userID'];
                    $sql = "SELECT  a.*, 
                                    c.`name` as 'cat_name', 
                                    u.`name` as 'user_name',
                                    u.`phone` as 'user_phone',
                                    d.`name` as 'dpt_name'
                                FROM `announces` a 
                                LEFT JOIN `categories` c ON c.`id` = a.`categories_id`
                                LEFT JOIN `users` u ON u.`id` = a.`users_id`
                                LEFT JOIN `departments` d ON d.`number` = a.`departments_number`
                                WHERE a.`users_id`=$userID;";
                    $query = $db->query($sql);
                    $annonces = $query->fetchAll(PDO::FETCH_ASSOC); 

                }
            }
        ?>
        <?php if(isset($_GET['voir_plus'])) : foreach($annonces as $annonce): ?>
        <div class="ads">
            <h2><a class="headlink" href="detail.php?id=<?=$annonce['id'] ?>"><?=$annonce['title'] ?></a></h2>
            <img src="../uploads/<?=$annonce['featured_image'] ?>" alt="<?=$annonce['title'] ?>">
            <p>par <?=$annonce['user_name'] ?> (<?=$annonce['dpt_name'] ?>)</p>
            <p>Catégorie : <?=$annonce['cat_name'] ?></p>
            <p><?=$annonce['content'] ?></p>
            <p>Prix : <?=$annonce['price'] ?> euros</p>
            <p><em>Annonce postée <?=formatDate($annonce['created_at']) ?></em></p>
        </div>
        <?php endforeach ;?>
        <?php endif; ?>
</section>

    
</body>
</html>