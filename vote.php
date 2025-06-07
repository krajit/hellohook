<?php
require_once(__DIR__ . '/../../config.php');
require_login();
require_sesskey();

$contextid = required_param('contextid', PARAM_INT);
$liked = required_param('liked', PARAM_BOOL);

$record = $DB->get_record('local_voting', ['contextid' => $contextid, 'userid' => $USER->id]);

if ($record) {
    $record->liked = $liked;
    $record->timecreated = time();
    $DB->update_record('local_voting', $record);
} else {
    $record = (object)[
        'contextid' => $contextid,
        'userid' => $USER->id,
        'liked' => $liked,
        'timecreated' => time(),
    ];
    $DB->insert_record('local_voting', $record);
}

redirect($_SERVER['HTTP_REFERER']);
