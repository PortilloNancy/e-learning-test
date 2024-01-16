<?php
// Permiso de acceso al rol Gestor

$capabilities = array(
    'local/users_courses:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'manager' => CAP_ALLOW,
        ),
    ),
);