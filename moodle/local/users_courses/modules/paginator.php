<?php

function paginator($limit, $currentPage){
   
    $allDataUsers = getAllUsersCourses();

    $pages = ceil(count($allDataUsers)/$limit);
    $page = $currentPage < 1 ? 1 : $currentPage;
    
    $pagination = "";
    for ($i=1; $i <=$pages ; $i++) { 
        $pageselected = $page === $i ? 'bg-light': '';
        $url = new moodle_url('/local/users_courses/view.php', ['page' => $i]);
        $pagination .= '<li class="page-item"><a class="page-link '.$pageselected.'" href="'.$url.'">'.$i.'</a></li>';
    }

    return  $pagination;
}

function paginationPrev($currentPage, $text){
    $page = $currentPage <=1 ? 1 : $currentPage-1;
    $pagination = "";
    $url = new moodle_url('/local/users_courses/view.php', ['page' => $page]);
    $pagination .= '<li class="page-item"><a class="page-link" href="'.$url.'">'.$text.'</a></li>';

    return $pagination;
}

function paginationNext($currentPage, $text){
    $page = $currentPage <=1 ? 2 : $currentPage+1;
    $pagination = "";
    $url = new moodle_url('/local/users_courses/view.php', ['page' => $page]);
    $pagination .= '<li class="page-item"><a class="page-link" href="'.$url.'">'.$text.'</a></li>';

    return $pagination;
}