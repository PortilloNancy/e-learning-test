<?php
defined('MOODLE_INTERNAL') || die();
// Agrega el acceso al plugin desde el bloque de navegación

function local_users_courses_extend_navigation($navigation) {

    if (has_capability('local/users_courses:view', context_system::instance())) {

        $node = navigation_node::create(
            get_string('pluginname', 'local_users_courses'),
            new moodle_url('/local/users_courses/view.php'), 
            navigation_node::NODETYPE_LEAF,
            null,
            'plugun-user-courses',
            new pix_icon('i/settings', '')
        );
        
        $node->showinflatnavigation = true;
        $navigation->add_node($node);
    }

}