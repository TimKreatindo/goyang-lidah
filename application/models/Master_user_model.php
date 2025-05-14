<?php
defined('BASEPATH')or exit('No direct script access allowed');
class Master_user_model extends CI_Model {
    private function query_master_user(){
        $this->db->select('
            user.*,
            jurusan.nama_jurusan,
            user_role.nama_role
        ')
        ->from('user')
        ->join('jurusan', 'user.id_jurusan = jurusan.id')
        ->join('user_role', 'user.id_role = user_role.id');
    }


    private function filter_query_user(){
        $this->query_master_user();
        $search = ['nip', 'nama', 'nama_jurusan'];
        $i = 0;
        foreach ($search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }
    }

    public function get_master_user(){
        $this->filter_query_user();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filter_master_user(){
        $this->filter_query_user();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_master_user(){
        $this->query_master_user();
        return $this->db->count_all_results();
    }
}