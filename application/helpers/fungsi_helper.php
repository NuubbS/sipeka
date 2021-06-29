<?php

function check_already_login(){
    $ci =& get_instance();
    $user_session = $ci->session->userdata('user_id');
    if($user_session) {
        redirect('pages/dashboard');
    }
}

function check_not_login(){
    $ci =& get_instance();
    $user_session = $ci->session->userdata('user_id');
    if(!$user_session) {
        redirect('auth');
    }
}

function check_admin()
{
    $ci =& get_instance();
    $ci->load->library('sesi');
    if($ci->sesi->user_login()->level_id != 1){
        // redirect('pages/dashboard_m');
        echo "<script>
                alert('Mohon maaf, anda tidak bisa mengakses halaman ini sekarang !');
                window.location='".site_url('member')."';
            </script>";
    }
}

function check_member()
{
    $ci =& get_instance();
    $ci->load->library('sesi');
    if($ci->sesi->user_login()->level_id == 1){
        // redirect('administrator');
        echo "<script>
                alert('Mohon maaf, anda tidak bisa mengakses halaman ini sekarang !');
                window.location='".site_url('administrator')."';
            </script>";
    }
}