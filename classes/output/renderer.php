<?php
// File: local/hellohook/classes/output/renderer.php

namespace local_hellohook\output;

defined('MOODLE_INTERNAL') || die();

use plugin_renderer_base;
use html_writer;
use moodle_url;

class renderer extends plugin_renderer_base {

    public function render_like_buttons(int $contextid, int $userid): string {
        global $DB;

        // Count current likes/dislikes.
        $likes = $DB->count_records('local_hellohook', ['contextid' => $contextid, 'liked' => 1]);
        $dislikes = $DB->count_records('local_hellohook', ['contextid' => $contextid, 'liked' => 0]);

        // Check if user has voted.
        $vote = $DB->get_record('local_hellohook', ['contextid' => $contextid, 'userid' => $userid]);

        $alreadyvoted = ($vote !== false);
        $likeurl = new moodle_url('/local/hellohook/vote.php', ['contextid' => $contextid, 'liked' => 1, 'sesskey' => sesskey()]);
        $dislikeurl = new moodle_url('/local/hellohook/vote.php', ['contextid' => $contextid, 'liked' => 0, 'sesskey' => sesskey()]);

        $html = html_writer::start_div('voting-buttons', ['style' => 'margin-top:20px;']);

        if ($alreadyvoted) {
            $html .= html_writer::tag('p', 'You voted: ' . ($vote->liked ? '👍 Like' : '👎 Dislike'));
        } else {
            $html .= html_writer::link($likeurl, "👍 Like ({$likes})", ['class' => 'btn btn-success', 'style' => 'margin-right:10px']);
            $html .= html_writer::link($dislikeurl, "👎 Dislike ({$dislikes})", ['class' => 'btn btn-danger']);
        }

        $html .= html_writer::end_div();

        return $html;
    }
}
