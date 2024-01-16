<?php

// Import all modules
foreach (glob($CFG->dirroot."/local/users_courses/modules/*.php") as $filename)
{
    include $filename;
}


// Utils
require_once($CFG->dirroot."/local/users_courses/utils.php");


// External libs
require_once("$CFG->dirroot/local/users_courses/libs/vendor/autoload.php");