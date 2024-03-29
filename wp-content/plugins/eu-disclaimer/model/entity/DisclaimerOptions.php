<?php
// Création de classe avec __construct puis getter et setter
class DisclaimerOptions {

private $id_disclaimer;
private $message_disclaimer;
private $redirection_ko;

function __construct($id_disclaimer = "Nc", $message_disclaimer = "Nc", $redirection_ko = "Nc" ){
    $this->id_disclaimer = $id_disclaimer;
    $this->message_disclaimer = $message_disclaimer;
    $this->redirection_ko = $redirection_ko;
}

// Get value of id_disclaimer
public function getIdDisclaimer(){
    return $this->id_disclaimer;
}

// Get value of message_disclaimer
public function getMessageDisclaimer(){
    return $this->message_disclaimer;
}

// Set value if message disclaimer
public function setMessageDisclaimer($message_disclaimer){
    $this->message_disclaimer = $message_disclaimer;
    return $this;
}

// Get value of redirection_ko
public function getRedirectionko(){
    return $this->redirection_ko;
}

// Set value if redirection_ko
public function setRedirectionko($redirection_ko){
    $this->redirection_ko = $redirection_ko;
    return $this;
}
}
?>