<?php
    require_once '../include/header.php';
    require_once '../include/connect.php';

    
    // Compter le nombre d'annonces par département
    $sql = 'SELECT * FROM `departments`;';
    $query = $db->query($sql);
    $departments = $query->fetchAll(PDO::FETCH_ASSOC);

    // Afficher les annonces en cliquant sur le département
    if(!empty($_GET)){
        $depID = $_GET['id'];
        $sql = "SELECT  a.*, 
        c.`name` as 'cat_name', 
        u.`name` as 'user_name',
        d.`name` as 'dpt_name'
        FROM `announces` a 
        LEFT JOIN `categories` c ON c.`id` = a.`categories_id`
        LEFT JOIN `users` u ON u.`id` = a.`users_id`
        LEFT JOIN `departments` d ON d.`number` = a.`departments_number`
        WHERE d.`number` = $depID
        ORDER BY a.`created_at` DESC;";
        $query = $db->query($sql);
        $annonces = $query->fetchAll(PDO::FETCH_ASSOC);
     }
?>


<div id="region">
<section>

        <h2>Liste des départements</h2>
        <ul>
            <?php
            foreach($departments as $department):
                $depID = $department['number'];
                $sql = "SELECT COUNT(*) as number FROM `announces` WHERE `departments_number`= '{$depID}';";
                $query = $db->query($sql);
                $adnumber = $query->fetch(PDO::FETCH_ASSOC);
                $adnumb = $adnumber['number'];
            ?>
            <li>

                    <?php if($adnumb != 0): ?>
                    <a class='deplink' href="parDepartement.php?id=<?=$department['number']?>">
                    <?php endif ?>
                        <?=$department['name'] ?> (<?=$department['number'] ?>) :
                        
                        <?=$adnumb ?>
                    <?php if($adnumb != 0): ?>
                    </a>
                    <?php endif ?>

            </li>
            <?php endforeach; ?>
        </ul>

</section>
<section>
<h2>Annonces par département</h2>
        <?php if(empty($_GET)) : ?>
            <p><em>Cliquez sur un département pour afficher les annonces correspondantes</em></p>
        <?php endif ?>

        <?php if(!empty($_GET)) : ?>
            <?php foreach($annonces as $annonce): ?>
            <div class="ads">
                <h3><a href="detail.php?id=<?=$annonce['id']?>"><?=$annonce['title'] ?></a></h3>
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
</div>


