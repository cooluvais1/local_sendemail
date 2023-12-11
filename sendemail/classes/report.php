<?php

class report_table extends table_sql {

    function __construct($uniqueid) {
        parent::__construct($uniqueid);
        // Define the list of columns to show.
        $columns = array('firstname', 'lastname', 'email', 'uploadedtime', 'email_sent', 'email_sent_time');
        $this->define_columns($columns);

        // Define the titles of columns to show in header.
        $headers = array('First name', 'Last name', 'Email', 'Uploaded time', 'Email sent', 'Email sent time');
        $this->define_headers($headers);
    }

    function col_uploadedtime($values) {

        return date('d-m-Y H:i', $values->uploadedtime);
    }

    function col_email_sent($values) {

        return ($values->email_sent == 1) ? 'Yes' : 'No';
    }

    function col_email_sent_time($values) {

        return ($values->email_sent_time > 0) ? date('d-m-Y H:i', $values->email_sent_time) : '';
    }

    function set_report_data() {
        $this->set_sql('*', "{sendemail}", '1=1');
    }

}
