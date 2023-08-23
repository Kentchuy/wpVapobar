<?php
/**
 * Plugin Name: eu-disclaimer
 * Plugin URI: http://rienPourLInstant
 * Description: Plugin sur la législation des produits à base de nicotine.
 * Version: 1.0
 * Author: Thomas AFPA
 * Author URI: http://afpa.fr
 * License: (lien de la license)
 */

require_once ('model/repository/DisclaimerGestionTable.php');

if (class_exists("DisclaimerGestionTable")){
    $gerer_table = new DisclaimerGestionTable();
}
if (isset($gerer_table)){
    register_activation_hook(__FILE__, array($gerer_table,'creerTable'));
    // Sur activation du plugin - creation bdd
    register_deactivation_hook(__FILE__, array($gerer_table,'supprimerTable'));
    // Sur désactivation du plugin - suppression bdd
}


// Création de la fonction ajouter au menu, 
// on prend les paramètres du hook qu'on précise en amont qu'on intègre par la suite
function ajouterAuMenu(){
    $page = 'eu-disclaimer';
    $menu = 'eu-disclaimer';
    $capability = 'edit_pages';
    $slug = 'eu-disclaimer';
    $function = 'disclaimerFonction';
    $icon = '';
    $position = 80; // position 80 = réglages
    if(is_admin()){
        add_menu_page($page, $menu, $capability, $slug, $function, $icon, $position);
    }
}


add_action("admin_menu", "ajouterAuMenu", 10); 
// Le 10 vient de $priority qui précise l'ordre dans lequel les fonctions sont exécutées (défaut:10)
// Le hook fonctionne comme : add_action ("emplacement", "fonction appelée", priorité)

// fonction à appeler lorsque l'on clique sur le menu
function disclaimerFonction(){
    require_once('views/disclaimer-menu.php');
}



add_action('init', 'inserer_js_dans_footer');
// Ajout du JS JQuery par CDN avec le modal
    function inserer_js_dans_footer() {
    if (!is_admin()) :
        wp_register_script('jQuery', 
        'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js',
        null, null, true);
        wp_enqueue_script('jQuery');
        wp_register_script('jQuery_modal', 
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js', 
        null, null, true);
        wp_enqueue_script('jQuery_modal');
        wp_register_script('jQuery_eu', 
        plugins_url('assets/js/eu-disclaimer.js', __FILE__), 
        array('jquery'), '1.1', true);
        wp_enqueue_script('jQuery_eu');
    endif;
}

add_action('wp_head', 'ajouter_css',1);
// Ajout du CSS par CDN
function ajouter_css() {
    if (!is_admin()) :
        wp_register_style('eu-disclaimer-css', 
        plugins_url('assets/css/eu-disclaimer-css.css', __FILE__), 
        null, null, false);
        wp_enqueue_style('eu-disclaimer-css');
        wp_register_style('modal', 
        'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css', 
        null, null, false);
        wp_enqueue_style('modal');
    endif;
}

// Active le modal sans utiliser de shortcode
// Utilisation : add_action ('hook', 'fonction');
add_action('wp_body_open', 'afficheModalDansBody');

function afficheModalDansBody() {
    echo DisclaimerGestionTable::AfficherDonneModal();
}

// Ajout du modal et du shortcode ----- 
// Déprécié car pour l'utilisation du plugin la personne doit insérer le shortcode dans les fichiers du thème ou de l'article

// add_shortcode('eu-disclaimer', 'afficheModal');
// function afficheModal() {
//     return DisclaimerGestionTable::AfficherDonneModal();
// }

?>