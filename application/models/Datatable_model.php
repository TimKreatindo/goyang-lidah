<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Datatable_model extends CI_Model {
    private function query_kerjasama(){
        $this->db->select(
            'sh_kerjasama.*, sha1(sh_kerjasama.id) as id_encode'
        )
        ->from('sh_kerjasama');
    }

    private function filter_kerjasama(){
        $this->query_kerjasama();
        $search = ['judul', 'nama_mitra', 'level_mitra'];
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

    public function get_kerjasama(){
        $this->filter_kerjasama();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function filtered_kerjasama(){
        $this->filter_kerjasama();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_kerjasama(){
        $this->query_kerjasama();
        return $this->db->count_all_results();
    }





    ///main datatable


    public function get_data($from){
        $this->filter_data($from);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function filtered_data($from){
        $this->filter_data($from);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data($from){
        if($from == 'tridharma'){
            $this->q_tridharma();
        } else if($from === 'seminar'){
            $this->q_seminar();
        } else if($from === 'rekognisi'){
            $this->q_rekognisi();
        } else if($from === 'sertifikat'){
            $this->q_sertifikat();
        } else if($from === 'publikasi'){
            $this->q_publikasi();
        } else if($from === 'jurnal'){
            $this->q_jurnal();
        } else if($from === 'organisasi'){
            $this->q_organisasi();
        } else if($from === 'hki'){
            $this->q_hki();
        }
        return $this->db->count_all_results();
    }

    private function filter_data($from){
        if($from==='tridharma'){
            $this->q_tridharma();
            $search = ['nama', 'nip', 'tempat_kegiatan'];
        } else if($from === 'seminar'){
            $this->q_seminar();
            $search = ['nama', 'nip', 'jenis_kegiatan', 'jenis_partisipasi', 'judul_kegiatan', 'penyelenggara'];
        } else if($from === 'rekognisi'){ 
            $this->q_rekognisi();
            $search = ['nama', 'nip', 'jenis_rekognisi', 'jenis_kegiatan', 'level', 'penyelenggara', 'tahun'];
        } else if($from === 'sertifikat'){ 
            $this->q_sertifikat();
            $search = ['nama', 'nip', 'jenis_sertifikat', 'bidang', 'level', 'lembaga', 'tahun'];
        } else if($from === 'publikasi'){
            $search = ['nama', 'nip', 'judul', 'jurnal', 'tahun', 'indeks'];
            $this->q_publikasi();
        } else if($from === 'jurnal'){
            $search = ['nama', 'nip', 'jurnal', 'tahun', 'role'];
            $this->q_jurnal();
        } else if($from === 'organisasi'){
            $search = ['nama', 'nip', 'jurnal', 'tahun', 'organisasi'];
            $this->q_organisasi();
        } else if($from === 'hki'){
            $search = ['nama', 'nip', 'no_hki', 'judul'];
            $this->q_hki();
        } 
        
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



    //main query datatable tridhama menu
    private function q_tridharma(){
        $this->db->select('
        sh_kegiatan_tridharma.*,
        sha1(sh_kegiatan_tridharma.id) AS id_encode,
        user.nip,
        user.nama
        ')
        ->from('sh_kegiatan_tridharma')
        ->join('user', 'sh_kegiatan_tridharma.id_user = user.id')
        ->order_by('sh_kegiatan_tridharma.create_at' , 'DESC');
    }

    //main query datatable seminar menu
    private function q_seminar(){
        $this->db->select('
        sh_seminar.*,
        sha1(sh_seminar.id) AS id_encode,
        user.nip,
        user.nama
        ')
        ->from('sh_seminar')
        ->join('user', 'sh_seminar.id_user = user.id')
        ->order_by('sh_seminar.create_at' , 'DESC');
    }

    //main query datatable rekognisi menu
    private function q_rekognisi(){
        $this->db->select('
        sh_rekognisi.*,
        sha1(sh_rekognisi.id) AS id_encode,
        user.nip,
        user.nama
        ')
        ->from('sh_rekognisi')
        ->join('user', 'sh_rekognisi.id_user = user.id')
        ->order_by('sh_rekognisi.create_at' , 'DESC');
    }

    //main query datatable sertifikat kompetensi menu
    private function q_sertifikat(){
        $this->db->select('
        sh_sertifikat_kompetensi.*,
        sha1(sh_sertifikat_kompetensi.id) AS id_encode,
        user.nip,
        user.nama
        ')
        ->from('sh_sertifikat_kompetensi')
        ->join('user', 'sh_sertifikat_kompetensi.id_user = user.id')
        ->order_by('sh_sertifikat_kompetensi.create_at' , 'DESC');
    }

    //main query datatable publikasi menu
    private function q_publikasi(){
        $filter = $this->input->post('filter');
        

        $this->db->select('
        sh_publikasi.*,
        sha1(sh_publikasi.id) AS id_encode,
        user.nip,
        user.nama
        ')
        ->from('sh_publikasi')
        ->join('user', 'sh_publikasi.id_user = user.id')
        ->order_by('sh_publikasi.create_at' , 'DESC');


        if($filter){
            if($filter ==' scopus'){
                $scopus = ['Scopus Q1', 'Scopus Q2', 'Scopus Q3', 'Scopus Q4'];
                $this->db->where_in('indeks', $scopus);
            } else if($filter == 'scopus-q'){
                $scopus = ['Scopus Q1', 'Scopus Q2'];
                $this->db->where_in('indeks', $scopus);
            } else if($filter == 'nasional'){
                $this->db->where('level', 'Nasional');
            } else if($filter == 'internasional'){
                $this->db->where('level', 'Internasional');
            }
        }
    }

    //main query datatable pengelola jurnal menu
    private function q_jurnal(){
        $this->db->select('
        sh_pengelola_jurnal.*,
        sha1(sh_pengelola_jurnal.id) AS id_encode,
        user.nip,
        user.nama
        ')
        ->from('sh_pengelola_jurnal')
        ->join('user', 'sh_pengelola_jurnal.id_user = user.id')
        ->order_by('sh_pengelola_jurnal.create_at' , 'DESC');
    }

    //main query datatable menu organisasi
    private function q_organisasi(){
        $this->db->select('
        sh_organisasi.*,
        sha1(sh_organisasi.id) AS id_encode,
        user.nip,
        user.nama
        ')
        ->from('sh_organisasi')
        ->join('user', 'sh_organisasi.id_user = user.id')
        ->order_by('sh_organisasi.create_at' , 'DESC');
    }

    //main query datatable menu HKI
    private function q_hki(){
        $this->db->select("
            sh_hki.*,
            sha1(sh_hki.id) AS id_encode,
            user.nama AS user_create,
            user.nip AS user_nip,
            (SELECT JSON_ARRAYAGG(
                CONCAT('',user.nama,' (',user.nip,')')
            )
            FROM user
            WHERE user.id IN (SELECT id_user FROM dosen_hki WHERE dosen_hki.id_hki = sh_hki.id AND dosen_hki.id_user != sh_hki.id_user)) AS user_info,
            (SELECT JSON_ARRAYAGG(
            CONCAT(id_user)
            )FROM dosen_hki WHERE dosen_hki.id_hki = sh_hki.id AND dosen_hki.id_user != sh_hki.id_user) AS user_id_info
        ")
      ->from('sh_hki')
      ->join('dosen_hki', 'sh_hki.id = dosen_hki.id_hki')
      ->join('user', 'sh_hki.id_user = user.id')
      ->group_by('sh_hki.id')
      ->order_by('sh_hki.create_at', 'DESC');
    }
}