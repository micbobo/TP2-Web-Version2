<?php
session_start();
class FacadeVue{
    public function ShowContent($NomPage,$data = null){
        $pageToRender = file_get_contents('Vue/' . $NomPage . '.html');

        // Boucler à travers les enregistrements de $data
        foreach ($data as $key => $value) {
            $pageToRender = str_replace('__' . $key . '__', $value,$pageToRender);
        }

        echo $pageToRender;


    }

}