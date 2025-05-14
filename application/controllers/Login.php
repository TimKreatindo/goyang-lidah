<?php
defined('BASEPATH')or exit('No direct script access allowed');
class Login extends CI_Controller {
    public function index(){
        check_is_login();
        $this->load->view('login/login');
    }

    public function validation(){
        cek_ajax();
        $nip = $this->input->post('account_nip', true);
        $password = $this->input->post('account_pass', true);

        $get_user = $this->db->get_where('user', ['nip' => $nip])->row();

        if($get_user){
            if(password_verify($password, $get_user->password)){
                if($get_user->is_active == 1){

                    $set_session = [
                        'nip' => $get_user->nip,
                        'status' => $get_user->is_active,
                        'role' => $get_user->id_role
                    ];

                    $this->session->set_userdata($set_session);

                    if($get_user->id_role == 1){
                        $redirect = base_url('admin');
                    } else {
                        $redirect = base_url('client');
                    }

                    $params = [
                        'status' => true,
                        'redirect' => $redirect,
                        'token' => get_token()
                    ];

                } else {
                    $params = [
                        'status' => false,
                        'msg' => 'Akun anda tidak aktif',
                        'token' => get_token()
                    ];
                }
            } else {
                $params = [
                    'status' => false,
                    'msg' => 'Password salah',
                    'token' => get_token()
                ];
            }
        } else {
            $params = [
                'status' => false,
                'msg' => 'NIP tidak terdaftar',
                'token' => get_token()
            ];
        }


        json_output($params, 200);
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect('login');
    }
}