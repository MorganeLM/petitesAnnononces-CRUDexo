<?php
    require_once 'include/header.php';

    if(!empty($_POST)){
        if(
            isset($_POST['name']) && !empty($_POST['name'])
            && isset($_POST['email']) && !empty($_POST['email'])
            && isset($_POST['phone']) && !empty($_POST['phone'])
            && isset($_POST['pass']) && !empty($_POST['pass'])
            && isset($_POST['pass2']) && !empty($_POST['pass2'])
        ){
           
            // On nettoie les données
            $name = strip_tags($_POST['name']);
            // pour l'email :
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $_SESSION['message'][]="L\'email est invalide";
            }else{
                $email = ($_POST['email']);
            }
            $phone = strip_tags($_POST['phone']);
            // pour les mdp :
            if($_POST['pass'] != ($_POST['pass2'])){
                $_SESSION['message'][]='Les mots de passe ne sont pas identique';
            }else{
                $mdp = password_hash($_POST['pass'], PASSWORD_ARGON2I);
            }

            // S'il y a des messages d'erreur, on redirige
            if(!empty($_SESSION['message'])){
                header('Location: inscription.php');
                exit;
            }

            // Le formulaire est complet et les données nettoyées
            // On peut inscrire l'utilisateur    
            require_once 'include/connect.php';

            $sql = 'INSERT INTO `users`(`name`, `email`, `phone`, `password`) VALUES (:name, :email, :phone, :pass)';
            
            $query = $db->prepare($sql);

            $query->bindValue(':name', $name, PDO::PARAM_STR);
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->bindValue(':phone', $phone, PDO::PARAM_STR);
            $query->bindValue(':pass', $mdp, PDO::PARAM_STR);

            $query->execute();

            $num = $db->lastInsertId();

            $_SESSION['message'][]="Bienvenue $name, vous êtes inscrit(e) sous le numéro $num";

        }else{
            $_SESSION['message'][]='Le formulaire est incomplet';
        }
    }

?>

<section>
    <h1>Inscription</h1>
    <form method="post">
        <div>
            <label for="name">Nom :</label>
            <input type="text" name="name" id="name">
        </div>
        <div>
            <label for="email">Email :</label>
            <input type="email" name="email" id="email">
        </div>
        <div>
            <label for="phone">Téléphone :</label>
            <input type="tel" name="phone" id="phone">
        </div>
        <div>
            <label for="pass">Mot de passe :</label>
            <input type="password" name="pass" id="pass">
        </div>
        <div>
            <label for="pass2">Confirmer le mot de passe :</label>
            <input type="password" name="pass2" id="pass2">
        </div>
        <button>M'inscrire</button>
    </form>
    <?php
        if(isset($_SESSION['message']) && !empty($_SESSION['message'])){
            foreach($_SESSION['message'] as $message){
                echo "<p class='erreur'>$message</p>";
            }
            unset($_SESSION['message']);
        }
    ?>
</section>

