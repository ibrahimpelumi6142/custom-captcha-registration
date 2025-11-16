<?php
/*
Plugin Name: Custom CAPTCHA Registration
Description: Adjust CAPTCHA of registration page from validation provided by Wordfence to reduce spam registrations.
Version: 1.0
Author: ibrahimpelumi6142
Author URI: https://bestspotsolution.com
*/

// Your filter function here
add_filter( 'wordfence_ls_require_captcha', 'ibrahimpelumi6142_wfcaptcha' );

function ibrahimpelumi6142_wfcaptcha() {
    // Check if the current request is for the registration page
    $is_register = strpos( $_SERVER['REQUEST_URI'], 'register' ) !== false;

    // Additional checks to avoid spam registrations
    if ($is_register) {
        // Check for common spam indicators
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $is_bot = preg_match('/bot|crawl|spider|curl|wget|java|python/i', $user_agent);

        // You can also check for specific query parameters that might indicate spam
        $has_spam_query = isset($_GET['spammy_param']) || isset($_POST['spammy_param']);

        // If we detect a bot or spammy query parameters, we can set $is_register to false
        if ($is_bot || $has_spam_query) {
            $is_register = false;
        }
    }

    return $is_register;
}
