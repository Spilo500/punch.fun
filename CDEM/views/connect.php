<?php
// Création d'un compte
if (isset($_POST['email']) and !empty($_POST['email']) and isset($_POST['pwd']) and !empty($_POST['pwd']) and isset($_POST['pwdCheck']) and !empty($_POST['pwdCheck'])) {

    $_POST['email'] = htmlspecialchars($_POST['email']);
    $_POST['pwd'] = htmlspecialchars($_POST['pwd']);
    $_POST['pwdCheck'] = htmlspecialchars($_POST['pwdCheck']);
    if (preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $_POST['email'])) { //vérification de la mise en forme de l'email

        if ($_POST['pwd'] == $_POST['pwdCheck']) { //vérification du mot de passe

            if (preg_match('#^(?=.{8,}$)(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$#', $_POST['pwd'])) { //vérification de la force du mot de passe

                $Player = new Player();
                if ($Player->newPlayer($_POST['email'], $_POST['pwd'])) { //si l'email n'est pas déjà inscrite on l'inscrit
                    $Player->connectPlayer($_POST['email'], $_POST['pwd']);
                    header('Location: /CDEM');
                    exit;
                } else {
                    $_SESSION['registerError'] = 'Email déjà utilisé';
                }
            } else {
                $_SESSION['registerError'] = 'Le mot de passe doit contenir au moins 1 majuscule, 1 minuscule, 1 chiffre et 8 caractères';
            }
        } else {
            $_SESSION['registerError'] = 'Les deux mot de passe ne sont pas identiques';
        }
    } else {
        $_SESSION['registerError'] = 'Email invalide';
    }
}

// Connexion à un compte
else if (isset($_POST['email']) and !empty($_POST['email']) and isset($_POST['pwd']) and !empty($_POST['pwd'])) {
    $_POST['email'] = htmlspecialchars($_POST['email']);
    $_POST['pwd'] = htmlspecialchars($_POST['pwd']);

    $Player = new Player();
    if (!$Player->connectPlayer($_POST['email'], $_POST['pwd'])) {
        $_SESSION['connectError'] = 'Email ou mot de passe incorrect';
    } else {
        header('Location: /CDEM');
        exit;
    }
}

$title = "Se connecter";
$css = "<link href=\"public/css/connexion.css\" rel=\"stylesheet\" />";

?>

<div class="connectBlocks">
    <form action="connect" method="post" class="connectblock">
        <div class="connectForm">
            <h1>Déjà membre ?</h1>
            <h2>
                <?php if (isset($_SESSION['connectError']) and !empty($_SESSION['connectError'])) {
                    echo ($_SESSION['connectError']);
                    unset($_SESSION['connectError']);
                }
                ?>
            </h2>
            <div class="inputBlocks">
                <div class="inputBlock">
                    <h2>Email</h2>
                    <input type="text" name="email" class="element" placeholder="Votre Email" maxlength="255" required />
                </div>
                <div class="inputBlock">
                    <h2>Mot de passe</h2>
                    <input type="password" name="pwd" class="element" placeholder="8 caractères min." maxlength="255" required />
                    <a href="forgotten-password">Mot de passe oublié ?</a>
                </div>
            </div>
        </div>

        <button class="button" type="submit" name="buttonCon">
            <p>Se connecter</p>
        </button>
    </form>

    <form action="connect" method="post" class="connectblock">
        <div class="connectForm">
            <h1>Pas encore membre ?</h1>
            <h2>
                <?php if (isset($_SESSION['registerError']) and !empty($_SESSION['registerError'])) {
                    echo ($_SESSION['registerError']);
                    unset($_SESSION['registerError']);
                }
                ?>
            </h2>
            <div class="inputBlocks">
                <div class="inputBlock">
                    <h2>Email</h2>
                    <input type="text" name="email" class="element" placeholder="Votre Email" maxlength="255" required />
                </div>
                <div class="inputBlock">
                    <h2>Mot de passe</h2>
                    <input type="password" name="pwd" class="element" placeholder="8 caractères min." maxlength="255" required />
                </div>
                <div class="inputBlock">
                    <h2>Confirmation de votre mot de passe</h2>
                    <input type="password" name="pwdCheck" class="element" placeholder="8 caractères min." maxlength="255" required />
                </div>
            </div>
        </div>

        <button class="button" type="submit" name="buttonIns">
            <p>S'inscrire</p>
        </button>
    </form>
</div>