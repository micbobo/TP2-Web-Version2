<?php
    class GererUtilisateursModele
    {
        function __construct($method,$bd)
        {
            $this->$method($bd);
        }

        function AjouterUtilisateur($bd)
        {
            $NbJetons = 20;
            //Ajouter un usager
            if (isset($_POST['txtUsernameAdd']) && $_POST['txtUsernameAdd'] != "" && $_POST['txtPasswordAdd'] != "" && isset($_POST['txtPasswordAdd'])) {
                // Ajouter un utilisateur
                $query = $bd->prepare("INSERT INTO Utilisateurs (UtilisateurEmail,UtilisateurMDP,UtilisateurNbJetons,UtilisateurRole) VALUES(:UtilisateurEmail,:UtilisateurMDP,:UtilisateurNbJetons,:UtilisateurRole)");
                $PassEncrypte = password_hash($_POST['txtPasswordAdd'], PASSWORD_BCRYPT);
                $query->bindparam(":UtilisateurEmail", $_POST['txtUsernameAdd']);
                $query->bindparam(":UtilisateurMDP", $PassEncrypte);
                $query->bindparam(":UtilisateurNbJetons", $NbJetons);
                $query->bindparam(":UtilisateurRole", $_POST['cmbTypeAjout']);
                $query->execute();

            }

        }


        function ModifierUtilisateur($bd)
        {

            //Si le nom à été changé
            if ($_POST['txtPasswordModif'] == "" &&  $_POST['txtUsernameModif'] != "") {
                $query = $bd->prepare("UPDATE Utilisateurs SET UtilisateurEmail = :Email, UtilisateurRole = :Role WHERE UtilisateurID = :ID");

                $query->bindparam(":ID", $_POST['cmbUtilisateurModif']);
                $query->bindparam(":Email", $_POST['txtUsernameModif']);
                $query->bindparam(":Role", $_POST['cmbTypeModif']);
                $query->execute();
            } else {
                //Si le mot de passe à été changé

                if ($_POST['txtUsernameModif'] == "" && $_POST['txtPasswordModif'] != "") {
                    $query = $bd->prepare("UPDATE Utilisateurs SET UtilisateurMDP = :Password, UtilisateurRole = :Role  WHERE UtilisateurID = :ID");
                    $PassEncrypte = password_hash($_POST['txtPasswordModif'], PASSWORD_BCRYPT);
                    $query->bindparam(":ID", $_POST['cmbUtilisateurModif']);
                    $query->bindparam(":Password", $PassEncrypte);
                    $query->bindparam(":Role", $_POST['cmbTypeModif']);
                    $query->execute();
                } else {

                    //Si seulement le rôle à été changé
                    if ($_POST['txtUsernameModif'] == "" && $_POST['txtPasswordModif'] == "") {
                        echo $_POST['cmbUtilisateurModif'];
                        echo $_POST['txtUsernameModif'];
                        echo $_POST['cmbUtilisateurModif'];
                        echo $_POST['cmbTypeModif'];
                        $query = $bd->prepare("UPDATE Utilisateurs SET UtilisateurRole = :Role  WHERE UtilisateurID = :ID");
                        $query->bindparam(":ID", $_POST['cmbUtilisateurModif']);
                        $query->bindparam(":Role", $_POST['cmbTypeModif']);
                        $query->execute();
                    } else {

                        //Si tout à été changé
                        $query = $bd->prepare("UPDATE Utilisateurs SET UtilisateurEmail = :Email, UtilisateurMDP = :Password, UtilisateurRole = :Role  WHERE UtilisateurID = :ID");
                        $PassEncrypte = password_hash($_POST['txtPasswordModif'], PASSWORD_BCRYPT);

                        $query->bindparam(":ID", $_POST['cmbUtilisateurModif']);
                        $query->bindparam(":Email", $_POST['txtUsernameModif']);
                        $query->bindparam(":Password", $PassEncrypte);
                        $query->bindparam(":Role", $_POST['cmbTypeModif']);
                        $query->execute();

                    }
                }


            }

        }
        function SupprimerUtilisateur($bd)
        {
            //Supprimer un usager
                $query = $bd->prepare("DELETE FROM Utilisateurs WHERE UtilisateurID = :ID");
                $query->bindparam(":ID", $_POST['cmbUtilisateurSupp']);
                $query->execute();


        }
    }


?>