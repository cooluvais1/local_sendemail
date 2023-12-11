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
 * @package    local
 * @subpackage sendemail
 */
defined('MOODLE_INTERNAL') || die();

function process_uploaded_content($content) {
    global $DB;

    $table = new html_table();

    $counter = 0;
    foreach (preg_split("/((\r?\n)|(\r\n?))/", $content) as $line) {

        $counter++;
        $row = explode(',', $line);
        if ($counter == 1) {
            $fkey = array_search('firstname', $row);
            $lkey = array_search('lastname', $row);
            $ekey = array_search('email', $row);
            $table->head = $row;
            continue;
        }
        $table->data[] = $row;
        $record = new stdClass();
        $record->firstname = $row[$fkey];
        $record->lastname = $row[$lkey];
        $record->email = $row[$ekey];
        $record->uploadedtime = time();
       // print_object($record);
        $DB->insert_record('sendemail', $record);
    }
    return $table;
}
