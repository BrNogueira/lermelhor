<?php
# Utilities file for testing read the session data written from sessionWrite.php

$sessPath = '/tmp';
/*
$sessPath = '/tmp/sessionTest';
if (!is_dir($sessPath)) {
    mkdir($sessPath);
}
*/

session_save_path($sessPath);
session_start();
$count = count($_SESSION);
if ($count > 0) {
    echo '<h2>Success</h2>';    
    echo '<pre>';
    print_r($_SESSION); 
    echo '</pre>';
} else {
    echo '<h2>Failed</h2>';
}

echo 'session.cookie_lifetime = ' . ini_get('session.cookie_lifetime') . '<br>';
echo 'session.cookie_path = ' .ini_get('session.cookie_path') . '<br>';
echo 'session.cookie_domain = ' .ini_get('session.cookie_domain') . '<br>';
echo 'session.cookie_secure = ' .ini_get('session.cookie_secure') . '<br>';
echo 'session.cookie_httponly = ' .ini_get('session.cookie_httponly') . '<br>';
echo 'session.serialize_handler = ' .ini_get('session.serialize_handler') . '<br>';
echo 'session.auto_start = ' .ini_get('session.auto_start') . '<br>';
echo 'session.bug_compat_42 = ' .ini_get('session.bug_compat_42') . '<br>';
echo 'session.bug_compat_warn = ' .ini_get('session.bug_compat_warn') . '<br>';
echo 'session.cache_expire = ' .ini_get('session.cache_expire') . '<br>';
echo 'session.cache_limiter = ' .ini_get('session.cache_limiter') . '<br>';
echo 'session.entropy_file = ' .ini_get('session.entropy_file') . '<br>';
echo 'session.entropy_length = ' .ini_get('session.entropy_length') . '<br>';
echo 'session.hash_bits_per_character = ' .ini_get('session.hash_bits_per_character') . '<br>';
echo 'session.hash_function = ' .ini_get('session.hash_function') . '<br>';
echo 'session.name = ' .ini_get('session.name') . '<br>';
echo 'session.referer_check = ' .ini_get('session.referer_check') . '<br>';
echo 'session.save_handler = ' .ini_get('session.save_handler') . '<br>';
echo 'session.save_path = ' .ini_get('session.save_path') . '<br>';
echo 'session.use_cookies = ' .ini_get('session.use_cookies') . '<br>';
echo 'session.use_only_cookies = ' .ini_get('session.use_only_cookies') . '<br>';
echo 'session.use_trans_sid = ' .ini_get('session.use_trans_sid') . '<br>';


$id = session_id();
$file = file($sessPath . '/sess_' . $id);
echo '<h2>Session raw session data:</h2>';
echo '<h3>'. $sessPath . '/sess_' . $id . '</h3>';
echo '<pre>';
print_r($file);
echo '</pre>';
?>