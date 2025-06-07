<?php

$callbacks = [
    [
        'hook' => \core\hook\output\after_standard_main_region_html_generation::class,
        'callback' => [\local_hellohook\callbacks::class, 'inject_hello_message_new'],
        'priority' => 100,
    ],

    [
        'hook' => \core\hook\output\after_standard_main_region_html_generation::class,
        'callback' => [\local_hellohook\callbacks::class, 'inject_like_dislike_button'],
        'priority' => 100,
    ],


];
