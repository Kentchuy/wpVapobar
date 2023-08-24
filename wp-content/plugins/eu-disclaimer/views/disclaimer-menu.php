<!-- Vue de la page des paramètres du plug-in -->
<?php
if (!empty($_POST['message_disclaimer']) && !empty($_POST['url_redirection'])) {
    // Si rien des les champs message et lien de redirection
    $text = new DisclaimerOptions();
    // On prend le modèle constructeur
    $text->setMessageDisclaimer(htmlspecialchars($_POST['message_disclaimer']));
    // Dans ce modèle on établi le message disclaimer par ce qui est posté
    $text->setRedirectionko(htmlspecialchars($_POST['url_redirection']));
    // Pareillement avec l'url de redirection
    DisclaimerGestionTable::insererDansTable($text->getMessageDisclaimer(),$text->getRedirectionko());
    // On fait appel à la classe DisclaimerGestionTable et sa fonction insererDansTable avec les 2 valeurs précédemment établies
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disclaimer view</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
    <h1>EU DISCLAIMER</h1>
    <br>
    <h2>Configuration</h2>
    <p><?php echo @$message; ?></p>
    <form method="post" action="" novalidate="novalidate">
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="message_disclaimer">Message du disclaimer</label>
                </th>
                <td>
                    <input type="text" name="message_disclaimer" id="message_disclaimer" value="<?php echo @$message_disclaimer; ?>" class="regular-text" />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="url_redirection">Url de redirection</label>
                </th>
                <td>
                    <input type="text" name="url_redirection" id="url_redirection" value="<?php echo @$lien_redirection; ?>" class="regular-text" />
                </td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary" value="Enregistrer les modififcations" />
        </p>
    </form>
    <br>
    ACTUELLEMENT dans la BDD<br/>
    Message dans la BDD : <?php echo @$message_disclaimer; ?>
    <br>
    Lien dans la BDD : <?php echo @$lien_redirection; ?>
    <p>
        Exemple : La législation nous impose de vous informer sur la nocivité des produits à base de nicotine, 
        vous devez avoir plus de 18 ans pour consulter ce site !
    </p>
    <br>
    <!-- Message confirmant la màj -->
    <p><?php if(isset($message)) echo $message; ?></p>
    <br>
    <h3>
        Centre AFPA / session DWWM
    </h3>
    <img src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'assets/img/layout_set_logo.png'; ?>" width="10%" />
    </body>
</html>
