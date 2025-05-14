<?php
defined('BASEPATH') or exit ('No direct script access allowed');
class Client_model extends CI_Model {
    protected $user;
    public function __construct(){
        parent::__construct();
        $this->user = get_user();
    }

    public function get_kegiatan_tridharma($id = null){
        $this->db->select('sh_kegiatan_tridharma.*, sha1(sh_kegiatan_tridharma.id) as id_encode')
        ->from('sh_kegiatan_tridharma')
        ->where('id_user', $this->user->id);

        if($id){
            $this->db->where('sha1(sh_kegiatan_tridharma.id)', $id);
        }
        $this->db->order_by('sh_kegiatan_tridharma.create_at', 'desc');

        return $this->db->get();
    }

    public function get_seminar($id = null){
        $this->db->select('sh_seminar.*, sha1(sh_seminar.id) as id_encode')
        ->from('sh_seminar')
        ->where('id_user', $this->user->id);

        if($id){
            $this->db->where('sha1(sh_seminar.id)', $id);
        }
        $this->db->order_by('sh_seminar.create_at', 'desc');

        return $this->db->get();
    }

    public function get_rekognisi($id = null){
        $this->db->select('sh_rekognisi.*, sha1(sh_rekognisi.id) as id_encode')
        ->from('sh_rekognisi')
        ->where('id_user', $this->user->id);

        if($id){
            $this->db->where('sha1(sh_rekognisi.id)', $id);
        }
        $this->db->order_by('sh_rekognisi.create_at', 'desc');

        return $this->db->get();
    }

    public function get_sertifikat($id = null){
        $this->db->select('sh_sertifikat_kompetensi.*, sha1(sh_sertifikat_kompetensi.id) as id_encode')
        ->from('sh_sertifikat_kompetensi')
        ->where('id_user', $this->user->id);

        if($id){
            $this->db->where('sha1(sh_sertifikat_kompetensi.id)', $id);
        }
        $this->db->order_by('sh_sertifikat_kompetensi.create_at', 'desc');

        return $this->db->get();
    }

    public function get_publikasi($id = null){
        $this->db->select('sh_publikasi.*, sha1(sh_publikasi.id) as id_encode')
        ->from('sh_publikasi')
        ->where('id_user', $this->user->id);

        if($id){
            $this->db->where('sha1(sh_publikasi.id)', $id);
        }
        $this->db->order_by('sh_publikasi.create_at', 'desc');

        return $this->db->get();
    }

    public function get_jurnal($id = null){
        $this->db->select('sh_pengelola_jurnal.*, sha1(sh_pengelola_jurnal.id) as id_encode')
        ->from('sh_pengelola_jurnal')
        ->where('id_user', $this->user->id);

        if($id){
            $this->db->where('sha1(sh_pengelola_jurnal.id)', $id);
        }
        $this->db->order_by('sh_pengelola_jurnal.create_at', 'desc');

        return $this->db->get();
    }

    public function get_organisasi($id = null){
        $this->db->select('sh_organisasi.*, sha1(sh_organisasi.id) as id_encode')
        ->from('sh_organisasi')
        ->where('id_user', $this->user->id);

        if($id){
            $this->db->where('sha1(sh_organisasi.id)', $id);
        }
        $this->db->order_by('sh_organisasi.create_at', 'desc');

        return $this->db->get();
    }

    public function get_hki($id = null, $id_user = null){
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
      ->group_by('sh_hki.id');
      if($id){
        $this->db->where('sha1(sh_hki.id)', $id);
      }

      if($id_user){
        $this->db->where('dosen_hki.id_user', $id_user);
      }
      $this->db->order_by('sh_hki.create_at', 'DESC');
      return $this->db->get();
    }

    public function get_hibah_penelitian($id = null, $id_user = null){
        $this->db->select("
            sh_hibah_penelitian.*,
            user.nama AS user_create,
            user.nip AS user_nip,
           

           (SELECT JSON_ARRAYAGG(CONCAT('',user.nama,' (',user.nip,')')) FROM user WHERE user.id IN (SELECT id_user FROM ds_hibah_penelitian WHERE ds_hibah_penelitian.id_data = sh_hibah_penelitian.id AND ds_hibah_penelitian.id_user = sh_hibah_penelitian.id_user)) AS user_info,


            (SELECT JSON_ARRAYAGG(
            CONCAT(id_user)
            )
            FROM ds_hibah_penelitian WHERE ds_hibah_penelitian.id_data = sh_hibah_penelitian.id AND ds_hibah_penelitian.id_user != sh_hibah_penelitian.id_user) AS user_id_info
        ")
        ->from('sh_hibah_penelitian')
        ->join('ds_hibah_penelitian', 'ds_hibah_penelitian.id_data = sh_hibah_penelitian.id')
        ->join('user', 'sh_hibah_penelitian.id_user = user.id');

        if($id){
            $this->db->where('sh_hibah_penelitian.id', $id);
        }

        if($id_user){
            $this->db->where('ds_hibah_penelitian.id_user', $id_user);
        }

        $this->db->order_by('sh_hibah_penelitian.create_at', 'DESC');
        return $this->db->get();
    }
}


   