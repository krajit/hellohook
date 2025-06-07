<?php

namespace local_hellohook;

use core\hook\output\after_standard_main_region_html_generation;
use local_hellohook\output;


class callbacks {
    public static function inject_hello_message_new(after_standard_main_region_html_generation $hook): void {
        
        global $PAGE, $USER;

        // Don't show if not logged in.
        if (!isloggedin() || isguestuser()) {
            return;
        }

        // Only show on activity pages (optional).
        if (!$PAGE->cm) {
            return;
        }

         // Get renderer for our plugin.
        //$output = $PAGE->get_renderer('local_hellohook');
        
        $hook->add_html('<div style="color:green !important;font-weight:bold;padding:1em;">Hello from hook!</div>');
    }

    public static function inject_like_dislike_button(after_standard_main_region_html_generation $hook): void {
        global $PAGE, $USER;

        // Don't show if not logged in.
        if (!isloggedin() || isguestuser()) {
            return;
        }

        // Only show on activity pages (optional).
        if (!$PAGE->cm) {
            return;
        }

        $contextid = $PAGE->context->id;
        $pageurl = $PAGE->url->out_as_local_url(false); // Identify page
        $userid = $USER->id;

        $html = <<<HTML
                <div style="margin: 1em 0; padding: 1em; border: 1px solid #ccc;">
                    <form method="post" action="/local/hellohook/like.php" style="display:inline;">
                        <input type="hidden" name="page" value="$pageurl">
                        <input type="hidden" name="vote" value="like">
                        <input type="hidden" name="sesskey" value="$sesskey">
                        <button type="submit">👍 Like</button>
                    </form>

                    <form method="post" action="/local/hellohook/like.php" style="display:inline;">
                        <input type="hidden" name="page" value="$pageurl">
                        <input type="hidden" name="vote" value="dislike">
                        <input type="hidden" name="sesskey" value="$sesskey">
                        <button type="submit">👎 Dislike</button>
                    </form>
                </div>
        HTML;


        $hook->add_html($html);
    }
}
