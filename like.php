<?php

require_once(__DIR__ . '/../../config.php');

require_login();

$vote = required_param('vote', PARAM_ALPHA);
$pageurl = required_param('page', PARAM_RAW);
#require_sesskey();

// Optional: Validate $vote
if (!in_array($vote, ['like', 'dislike'])) {
    throw new moodle_exception('Invalid vote.');
}

$record = new stdClass();
$record->userid = $USER->id;
$record->pageurl = $pageurl;
$record->vote = $vote;
$record->timecreated = time();

$DB->insert_record('local_hellohook_votes', $record);

// Redirect back to the original page with a success message
redirect(new moodle_url($pageurl), get_string('thanksforvoting', 'local_hellohook'));
