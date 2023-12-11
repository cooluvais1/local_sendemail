<?php

require "../../config.php";
require "$CFG->libdir/tablelib.php";
require "$CFG->dirroot/local/sendemail/classes/report.php";
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/local/sendemail/report.php');

$download = optional_param('download', '', PARAM_ALPHA);

$table = new report_table('uniqueid');
$table->is_downloading($download, 'mailsendreport', 'mailsendreport');

if (!$table->is_downloading()) {
    // Only print headers if not asked to download data
    // Print the page header
    $PAGE->set_title(get_string('localsendemailstatus', 'local_sendemail'));
    $PAGE->set_heading(get_string('localsendemailstatus', 'local_sendemail'));
    $PAGE->navbar->add(get_string('localsendemailstatus', 'local_sendemail'), new moodle_url('/local/sendemail/report.php'));
    echo $OUTPUT->header();
}

// Work out the sql for the table.
$table->set_report_data();

$table->define_baseurl("$CFG->wwwroot/local/sendemail/report.php");

$table->out(10, true);

if (!$table->is_downloading()) {
    echo $OUTPUT->footer();
}