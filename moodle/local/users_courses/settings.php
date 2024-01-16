<?php
defined('MOODLE_INTERNAL') || die;
// Configuraciones del plugin
    
$settings = new admin_settingpage('local_users_courses', get_string('pluginname', 'local_users_courses'));
$ADMIN->add('localplugins', $settings);

// Resumen de cumplimiento
$name = 'local_users_courses/downloadtype';
$title = get_string('downloadtype', 'local_users_courses');
$desc = get_string('downloadtypedesc', 'local_users_courses');

$optionsTypes = [
    'excel' => 'Excel',
    'csv'   => 'CSV',
    'ods'   =>'ODS',
    'json'  => 'JSON',
    'html'  => 'HTML'
    
];

$setting = new admin_setting_configmultiselect($name, $title, $desc, ['csv'], $optionsTypes);
$settings->add($setting);


