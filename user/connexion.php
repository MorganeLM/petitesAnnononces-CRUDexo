<?php
    require_once '../include/header.php';
    // On se connecte à la base de données
    require_once '../include/connect.php';
    
    // On vérifie que POST n'est pas vide
    if(!empty($_POST)){
        // On vérifie que tous les champs obligatoires sont remplis
        if(
            isset($_POST['email']) && !empty($_POST['email'])
            && isset($_POST['pass']) && !empty($_POST['pass'])
            ){
                // On récupère et on nettoie les données
                // On vérifie la validité de l'e-mail
                if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                    $_SESSION['message'][]='Entrez un email';
                    header('Location: connexion.php');
                    exit;
                }else{
                    $email = $_POST['email'];
                }
                $sql = 'SELECT * FROM `users` WHERE `email` = :email;';
                $query = $db->prepare($sql);
                $query->bindValue(':email', $email, PDO::PARAM_STR);
                $query->execute();
                $user = $query->fetch(PDO::FETCH_ASSOC);
        
                if(!$user){
                    $_SESSION['message'][]='Email et/ou mot de passe incorrect';
                    header('Location: connexion.php');
                    exit;
                }
        
                if(password_verify($_POST['pass'], $user['password'])){
                    // On ouvre la session
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'phone' => $user['phone'],
                        'roles' => $user['roles'],
                    ];
                    header('Location: '.URL.'');
                }
                else{
                    $_SESSION['message'][]='Email et/ou mot de passe incorrect';
                    header('Location: connexion.php');
                    exit;
                }
            }
    
        }else{
            $_SESSION['message'][]='Completez le formulaire';
        }
    
    ?>

    <section>
        <h1>Connexion</h1>
        
        <form method="post">
            <div>
                <label for="email">Email :</label>
                <input type="email" name="email" id="email">
            </div>
            <div>
                <label for="pass">Mot de passe :</label>
                <input type="password" name="pass" id="pass">
            </div>
         
            <button>Me connecter</button>
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
</body>
</html>