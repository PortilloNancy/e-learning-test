<?php

function printTable($offset, $limit){
   
   // Lista de todos los usuarios en el sitio
   $allDataUsers = getAllUsersCourses();
   
   $offset = $offset <= 1 ? 0 : ($offset-1) * $limit;

   // Obtener el segmento del array
    $dataUsersPagination = array_slice($allDataUsers, $offset, $limit);


    $dataUsers = '';
    foreach ($dataUsersPagination as $user) {

        $dataUsers .= '<tr>';
        
        $dataUsers .= '<td>'.$user['username'].'</td>';
        $dataUsers .= '<td>'.$user['fullname'].'</td>';
        $dataUsers .= '<td>'.$user['course'].'</td>';
        
        $dataUsers .= '</tr>';
       
    }
    return  $dataUsers;
}