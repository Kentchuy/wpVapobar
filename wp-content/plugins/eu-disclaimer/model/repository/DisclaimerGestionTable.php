<?php

// Définition du chemin d'accès à la classe DisclaimerOptions
define('MY_PLUGIN_PATH', plugin_dir_path(__FILE__));
include(MY_PLUGIN_PATH . '../entity/DisclaimerOptions.php');

class DisclaimerGestionTable {

    public function creerTable(){
        // Instanciation de la classe DisclaimerOptions
        $message = new DisclaimerOptions();
        // On set un message par défaut sur l'objet
        $message->setMessageDisclaimer("Au regard de la loi européenne, vous devez nous confirmer que vous avez plus de 18 ans pour visiter ce site");
        $message->setRedirectionko("https://google.fr/");
        global $wpdb;
        // global permet à peu importe l'instance d'une variable d'être toujours connectée (ex: On déclare une variable puis une fonction avec une variable de même nom => elles ne seront pas connectées mais si dans la fonction on la déclare comme globale elle prendra la valeur précédemment déclarée)
        $tableDisclaimer = $wpdb->prefix.'disclaimer_options';
        // table disclaimer_options sous variable
        if ($wpdb->get_var("SHOW TABLES LIKE $tableDisclaimer") != $tableDisclaimer) {
            // Si la table n'existe pas encore alors on créé la table :
            $sql = "CREATE TABLE $tableDisclaimer
                (id_disclaimer INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                message_disclaimer TEXT NOT NULL, 
                redirection_ko TEXT NOT NULL)
            ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
            // Message d'erreur
            if(!$wpdb->query($sql)){
                die("Une erreur est survenue; contactez le développeur du plugin...");
            }
            // Insertion du message par défaut 
            $wpdb->insert(
                $wpdb->prefix . 'disclaimer_options',
                array(
                    'message_disclaimer' => $message->getMessageDisclaimer(),
                    'redirection_ko' => $message->getRedirectionko(),
                ), array('%s', '%s')
            );
                $wpdb->query($sql);
        }
    }

    public function supprimerTable(){
        // $wpdb sert à récupérer l'objet contenant les informations relatives à la BDD
        global $wpdb;
        $table_disclaimer = $wpdb->prefix."disclaimer_options";
        $sql = "DROP TABLE $table_disclaimer";
        $wpdb->query($sql);
    }

    static function insererDansTable($contenu, $url) {
        global $wpdb;
        try{
        $table_disclaimer = $wpdb->prefix.'disclaimer_options';
        $sql = $wpdb->prepare(
            "
                UPDATE $table_disclaimer
                SET message_disclaimer = '%s', redirection_ko = '%s'
                WHERE id_disclaimer = '%s'
            ", $contenu, $url, 1
        );
        // %s permet simplement de préciser qu'une valeur string est attendue
        $wpdb->query($sql);
        // requête de mise à jour des données dans la table
        echo '<span style="color:green; font-size:16px;">Les données ont été correctement été mises à jour !</span>';
        // si succes message de succes
        } catch (Exception $e){
            echo '<span style="color:red; font-size:16px;">Une erreur est survenue !</span>';
            // si échec message d'échec
        }
    }

    static function AfficherDonneModal(){
        global $wpdb;
        $query = "SELECT * FROM " . $wpdb->prefix."disclaimer_options";
        $row = $wpdb->get_row($query);
        // Récupère chaque ligne de donnée de la table disclaimer_options en bdd
        // notamment elles message_disclaimer & redirection_ko
        $message_disclaimer = $row->message_disclaimer;
        $lien_redirection = $row->redirection_ko;
        return '<div id="monModal" class="modal">
        <p>Le vapobar, vous souhaite la bienvenue !</p>
        <p>'. $message_disclaimer.'</p><a href="'.$lien_redirection.'"
        type="button" class="btn-red">Non</a>
        <a href="#" type="button" rel="modal:close" class="btn-green" id="actionDisclaimer">Oui</a>
        </div>' ;
    }
// Même concept mais renvoi la valeur d'une seule ligne
    static function AfficherLien(){
        global $wpdb;
        $query = "SELECT * FROM " . $wpdb->prefix."disclaimer_options";
        $row = $wpdb->get_row($query);
        $lien_redirection = $row->redirection_ko;
        return $lien_redirection;
    }

    static function AfficherMessage(){
        global $wpdb;
        $query = "SELECT * FROM " . $wpdb->prefix."disclaimer_options";
        $row = $wpdb->get_row($query);
        $message_disclaimer = $row->message_disclaimer;
        return $message_disclaimer;
    }

}