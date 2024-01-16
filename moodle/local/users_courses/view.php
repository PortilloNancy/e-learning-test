<?php
require_once('../../config.php');
require_once('locallib.php');

// Require login.
require_login();
$context = context_system::instance();

// check_permissions
if (!has_capability('local/users_courses:view', $context)) {
    print_error('badpermissions');

	return;
}

$PAGE->set_context($context);
$PAGE->set_pagelayout('usercourses');
$PAGE->set_url('/local/users_courses/view.php');
$PAGE->set_title(get_string('pluginname', 'local_users_courses'));
$PAGE->set_heading(get_string('pluginname', 'local_users_courses'));
$PAGE->requires->jquery();
$PAGE->requires->js('/local/users_courses/amd/src/download.js');

echo $OUTPUT->header();

$limit = optional_param('limit', 5, PARAM_INT);// cuantos
$offset = optional_param('page', 0, PARAM_INT);// desde

// data de filtro de descarga
$filterDowloadData = filterDowload();

// data de la tabla
$tableData = printTable($offset, $limit);

// paginador
$pagination =[
	'principal' => paginator($limit, $offset),
	'prev'      => paginationPrev($offset, get_string('prev', 'local_users_courses')),
	'next'      => paginationNext($offset, get_string('next', 'local_users_courses'))

];

// textos dinámicos por diccionario
$texts = [
	'subtitle'    => get_string('subtitle', 'local_users_courses'),
	'label_filter'=> get_string('label_filter', 'local_users_courses'),
	'btn_text'    => get_string('btn_text', 'local_users_courses')
];

// textos tabla
$textsTable = [
	'username' => get_string('username', 'local_users_courses'),
	'fullname' => get_string('fullname', 'local_users_courses'),
	'course'   => get_string('course', 'local_users_courses')
];

// Messages
$messages = [
	'loading' => get_string('loadingMessage', 'local_users_courses'),
	'error'   => get_string('errorMessage', 'local_users_courses'),
	'success' => get_string('successMessage', 'local_users_courses')
];

// Print the HTML.
$templatecontext = [
	'filterDowload' => $filterDowloadData,
	'texts' 	    => $texts,
	'table'         => $tableData,
	'textsTable'    => $textsTable,
	'textsPaginator'=> $textsPaginator,
	'pagination'    => $pagination,
	'messages'      => $messages
];

echo $OUTPUT->render_from_template('local_users_courses/home', $templatecontext);

echo $OUTPUT->footer();



	