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

namespace local_sendemail\task;

use \stdClass;

class sendrandomemail extends \core\task\scheduled_task {

    /**
     * Get a descriptive name for this task (shown to admins).
     *
     * @return string
     */
    public function get_name() {
        return get_string('sendrandomemailcron', 'local_sendemail');
    }

    /**
     * send email
     */
    public function execute() {
        global $DB, $CFG;

        $records = $DB->get_records('sendemail', ['email_sent' => 0]);

        $from = get_admin();
        $subject = get_string('email_subject', 'local_sendemail');
        foreach ($records as $record) {
            $messagehtml = get_string('email_body', 'local_sendemail', $record);
            //$record->id = $from->id;
            // if(email_to_user($record, $from, $subject, '', $messagehtml)) {
                $update = new stdClass();
                $update->id = $record->id;
                $update->email_sent = 1;
                $update->email_sent_time = time();
                $DB->update_record('sendemail', $update);
            //}
        }
    }

}
