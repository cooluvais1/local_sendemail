<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Bulk user registration script from a comma separated file
 *
 * @package    local
 * @subpackage sendemail
 */
require('../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->libdir . '/csvlib.class.php');
require_once($CFG->dirroot . '/local/sendemail/locallib.php');
require_once($CFG->dirroot . '/local/sendemail/uploadcsvform.php');

core_php_time_limit::raise(60 * 60); // 1 hour should be enough.
raise_memory_limit(MEMORY_HUGE);

if (empty($iid)) {
    $mform1 = new admin_uploadcsv();

    if ($formdata = $mform1->get_data()) {

        $content = $mform1->get_file_content('csvfile');

        $table = process_uploaded_content($content);
      
    } else {
        echo $OUTPUT->header();

        echo $OUTPUT->heading_with_help(get_string('pluginname', 'local_sendemail'), 'sendemail', 'local_sendemail');

        $mform1->display();
        echo $OUTPUT->footer();
        die;
    }
} else {
    $cir = new csv_import_reader($iid, 'uploaduser');
}

// Print the header.
echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('pluginname', 'local_sendemail'));

echo html_writer::tag('div', html_writer::table($table), ['class' => 'flexible-wrap']);
echo html_writer::link('index.php', get_string('uploadnew', 'local_sendemail'), ['class' => 'btn btn-primary']);

echo $OUTPUT->footer();
die;
