<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if (!function_exists('_login_facebook')) {

    function _login_facebook() {

        $CI = &get_instance();

        $CI->load->library('facebook');

        $user = $CI->facebook->getUser();

        if ($user) {
            try {
                $data['user_profile'] = $CI->facebook->api('/me');
            } catch (FacebookApiException $e) {
                $user = null;
            }
        } else {
            $CI->facebook->destroySession();
        }
        
        return $user;

//        if ($user) {
//
//            $data['logout_url'] = site_url('welcome/logout'); // Logs off application
//            // OR 
//            // Logs off FB!
//            // $data['logout_url'] = $CI->facebook->getLogoutUrl();
//        } else {
//            $data['login_url'] = $CI->facebook->getLoginUrl(array(
//                'redirect_uri' => site_url('welcome/login'),
//                'scope' => array("email") // permissions here
//            ));
//        }
//
//        $CI->load->view('login', $data);
    }

}

if (!function_exists('_logout_facebook')) {

    function _logout_facebook() {

        $this->load->library('facebook');

        // Logs off session from website
        $this->facebook->destroySession();
        // Make sure you destory website session as well.

        //redirect('welcome/login');
    }

}