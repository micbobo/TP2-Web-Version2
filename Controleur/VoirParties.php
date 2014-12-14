<?php
class VoirParties {
    function __construct($path,$pos,$post,$bd)
    {
        $idBouton = 1;
        $TotalString = "";
        $NewString = "";
        session_start();
        $this->vue = new FacadeVue();
        $query = "SELECT * FROM Parties";
        foreach($bd->query($query)as $row) {
            $NomHote = $row['PartieNomHote'];
            $NomVisiteur = $row['PartieNomVisiteur'];
            $PointsHote = $row['PartiePointsHote'];
            $PointsVisiteur = $row['PartiePointsVisiteur'];
            $Date = $row['PartieDate'];
            $NewString = '<tr><td>' . $NomHote . '</td><td>' . $NomVisiteur . '</td><td>' . $PointsHote . '</td><td>' . $PointsVisiteur . '</td><td>' . $Date . '</td><td><input class="buttonmise" type="submit" name=' . "Mise" . $idBouton . ' value="Miser"></td></tr>';
            $TotalString = $TotalString . $NewString;
            $idBouton = $idBouton + 1;
        }
        $data = array(
                'Parties' => $TotalString
            );

        $this->ShowParties($data);
    }


    function ShowParties($data){
        $this->vue->ShowContent('VueMises',$data);
    }

    function Load_Modele()
    {
        include_once("Modele/Login.php");
        $this->Modele = new LoginModele();
    }

    function ConnectUsager($bd){
        include_once("Modele/Login.php");
        $this->Modele = new LoginModele('Connection',$bd);
    }
}