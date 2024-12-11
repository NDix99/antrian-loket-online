<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// application/helpers/my_helper.php
function remaining_session_time()
{
    $CI = &get_instance();

    if ($CI->session->has_userdata('last_activity') && $CI->session->has_userdata('session_timeout')) {
        $last_activity = $CI->session->userdata('last_activity');
        $session_timeout = $CI->session->userdata('session_timeout');

        $remaining_time = $session_timeout - (time() - $last_activity);

        return max($remaining_time, 0); // Ensure a non-negative value
    }

    return 0; // Default value if session data is not set
}
