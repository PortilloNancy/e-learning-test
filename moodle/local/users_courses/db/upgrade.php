<?php

/**

 * @package local_users_courses
 */
// actualizar plugina
defined('MOODLE_INTERNAL') || die();

/**
 * Handles upgrading instances of this block.
 *
 * @param int $oldversion
 */
function xmldb_local_users_courses_upgrade($oldversion) {
    global $CFG;

    return true;
}