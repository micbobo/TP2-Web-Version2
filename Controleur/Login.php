<?php
class Login {
    function __construct($method,$pos,$post,$bd){
        session_start();
        $this->vue = new FacadeVue();
        if($post){
            $this->ConnectUsager($bd);
        }else{
            $this->ShowLogin();
        }

    }
    function ShowLogin(){
        $this->vue->ShowContent('VueLogin');
    }

    function Load_Modele()
    {
        include_once("Modele/Login.php");
        $this->Modele = new LoginModele();
    }

    function ConnectUsager($bd)
    {
        include_once("Modele/Login.php");
        $this->Modele = new LoginModele('Connection', $bd);
        if ($_SESSION['UID'] > 0 && password_verify($_POST['txtPassword'], $_SESSION['UMDP'])) {
            if ($_SESSION['URole'] == 0) {
                header("Location:GererUtilisateurs");
                $this->vue->ShowContent('VueGererUtilisateurs');
            } else {
                header("Location:VoirParties");
                $this->vue->ShowContent('VueMises');
            }
        }else{
            $this->vue->ShowContent('VueLogin');
        }
    }
}

