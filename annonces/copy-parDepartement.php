<?php
    require_once '../include/header.php';
    require_once '../include/connect.php';

    
    // Compter le nombre d'annonces par département
    $sql = 'SELECT * FROM `announces`;';
    $query = $db->query($sql);
    $annonces = $query->fetchAll(PDO::FETCH_ASSOC);
?>


<div id="region">
<section>

        <h2>Liste des départements</h2>
        <ul>
<?php
        foreach($annonces as $annonce){
            $department = $annonce['departments_number'];
            $sql = "SELECT COUNT(*) as number FROM `announces` WHERE `departments_number`= $department;";
            $query = $db->query($sql);
            $adnumber = $query->fetchAll(PDO::FETCH_ASSOC);
            $adnumb = $adnumber[0]['number'];

            echo "<p> Département $department : $adnumb annonces </p>";

            $sql = 'SELECT * FROM `departments`;';
            $query = $db->query($sql);
            $departments = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($departments as $dept) :
                if($dept == $department):
?>
            <li>

                <?=$dept['number'] ?> - <?=$dept['name'] ?> (<?=$adnumb ?>)

            </li>
            <?php endif; ?>
            <?php endforeach; 
        }?>
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
</div>


