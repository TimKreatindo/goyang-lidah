<?php
defined('BASEPATH') or exit('No direct script access allowed');
class View extends CI_Controller
{

    // protected $user = null;

    public function __construct()
    {
        parent::__construct();

        // check_is_admin();
        // $this->user = get_user();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'view' => 'admin/dashboard',
            'env' => getenv()
            // 'user' => $this->user
        ];
        $this->load->view('admin/template', $data);
    }
}
