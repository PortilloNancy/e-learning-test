<?php

function filterDowload(){
   
    // Obtenemos los valores de la configuración
    $downloadtypeconf =  get_config('local_users_courses', 'downloadtype');
    $downloadtype = explode(',',$downloadtypeconf);

    $dataTypes = [];
    foreach($downloadtype as $value){
        $dataTypes[$value] = $value;
    }
    // crea las opciones para el select
    $optionsTypes = getHTMLSelectOptions($dataTypes, false);

   return $optionsTypes;
}