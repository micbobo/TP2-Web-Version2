<?php
    class LoginModele
    {
        function __construct($method,$bd)
        {
            $this->$method($bd);
        }

        function Connection($bd)
        {
            $username = $_POST['txtUsername'];
            $password = $_POST['txtPassword'];
            $_SESSION['UID'] =  -1;
            $_SESSION['URole'] = -1;
            $_SESSION['UNbJetons'] = -1;
            if ((isset($_POST['txtPassword'])) && (isset($_POST['txtUsername']))){
                $query = "SELECT * FROM Utilisateurs";
                foreach($bd->query($query)as $row){
                    if ($row['UtilisateurMDP' === $password] && $row['UtilisateurEmail'] === $username){
                        $_SESSION['UID'] = $row['UtilisateurID'];
                        $_SESSION['UMDP'] = $row['UtilisateurMDP'];
                        $_SESSION['URole'] = $row['UtilisateurRole'];
                        $_SESSION['UNbJetons'] = $row['UtilisateurNbJetons'];
                    }
                }
            }
        }

    }


?>