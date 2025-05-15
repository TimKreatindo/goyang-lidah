<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class View extends CI_Controller {
    public function index(){
        $data = [
            'view' => 'customer/home',
        ];
        $this->load->view('customer/template', $data);
    }

     public function detail(){
        $data = [
            'view' => 'customer/detail',
        ];
        $this->load->view('customer/template', $data);
    }
}