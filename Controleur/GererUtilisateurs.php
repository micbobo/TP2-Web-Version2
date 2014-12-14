<?php
class GererUtilisateurs {
    function __construct($method,$pos,$post,$bd){
        session_start();
        $this->vue = new FacadeVue();
        if($post){
            if(isset($_POST['btnAddMember'])){
                $this->AjouterUtilisateur($bd);
            }
            if(isset($_POST['btnModifMember'])){
                $this->ModifierUtilisateur($bd);
            }
            if(isset($_POST['btnSupMember'])){
                $this->SupprimerUtilisateur($bd);
            }
        }
        $TotalString = "";
        $query = "SELECT * FROM Utilisateurs";
        foreach($bd->query($query)as $row) {
            $IDUtilisateur = $row['UtilisateurID'];
            $EmailUtilisateur = $row['UtilisateurEmail'];
            $NewString = '<option value= "' . $IDUtilisateur . '">' . $EmailUtilisateur . '</option>';
            $TotalString = $TotalString . $NewString;
        }
        $data = array(
            'Utilisateurs' => $TotalString
        );

        $this->ShowGestion($data);
    }

    function ShowGestion($data){
        $this->vue->ShowContent('VueGererUtilisateurs',$data);
    }



    function AjouterUtilisateur($bd){
        include_once("Modele/GererUtilisateurs.php");

        $this->Modele = new GererUtilisateursModele('AjouterUtilisateur',$bd);
        header("Location:../GererUtilisateurs");
        $this->vue->ShowContent('VueGererUtilisateurs');
    }

    function ModifierUtilisateur($bd){
        include_once("Modele/GererUtilisateurs.php");

        $this->Modele = new GererUtilisateursModele('ModifierUtilisateur',$bd);
        header("Location:../GererUtilisateurs");
        $this->vue->ShowContent('VueGererUtilisateurs');
    }

    function SupprimerUtilisateur($bd){
        include_once("Modele/GererUtilisateurs.php");

        $this->Modele = new GererUtilisateursModele('SupprimerUtilisateur',$bd);
        header("Location:../GererUtilisateurs");
        $this->vue->ShowContent('VueGererUtilisateurs');
    }
}