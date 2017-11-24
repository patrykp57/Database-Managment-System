<?php

    // Functions for get lang/style etc.

    function getLangCookie() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if(!isset($_COOKIE['lang'])) {
            $langHead = explode(",",$_SERVER['HTTP_ACCEPT_LANGUAGE']);
            $lang = substr($langHead[0],0,2);
            return $lang;
        }
        else
            return $_COOKIE['lang'];
    }

    function getLang($lang_cookie, $text) {
        if(isset($lang_cookie) && !empty($lang_cookie)):
            include($_SERVER['DOCUMENT_ROOT'] .'/lang/'.$lang_cookie.'.php');
        else:
            $lang_cookie = 'pl';
            include($_SERVER['DOCUMENT_ROOT'] .'/lang/'.$lang_cookie.'.php');
        endif;

        if(!empty($lang[$text])):
            return $lang[$text];
        else:
            return '';
        endif;
    }


    




?>