<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Ajax_master_user extends CI_Controller
{
    public function datatable()
    {
        cek_ajax();
        $get_data = $this->master_user->get_master_user();
        $data = [];
        $no = 1;
        foreach ($get_data as $d) {
            $row = [];

            if ($d->is_active == 1) {
                $status = 'Aktif';
                $button =   form_open('admin/act-master-user', 'class="form_act_user"')
                    . '
                                <input type="hidden" name="act" value="status_nonaktif">
                                <input type="hidden" name="id" value="' . sha1($d->id) . '">
                                <button type="submit" class="btn btn-sm btn-warning w-100 my-1"><i class="fas fa-power-off"></i> Nonaktifkan</button>
                            ' .
                    form_close();
            } else {
                $status = 'Nonaktif';
                $button =   form_open('admin/act-master-user', 'class="form_act_user"')
                    . '
                                <input type="hidden" name="act" value="status_aktif">
                                <input type="hidden" name="id" value="' . sha1($d->id) . '">
                                <button type="submit" class="btn btn-sm btn-success w-100 my-1"><i class="fas fa-power-off"></i> Aktifkan</button>
                            ' .
                    form_close();
            }

            $row[] = $no++;
            $row[] = '<img src="' . base_url('assets/img/profile/') . $d->image . '" width="50px">';
            $row[] = $d->nip;
            $row[] = $d->nama;
            $row[] = $d->nama_role;
            $row[] = $d->nama_jurusan;
            $row[] = $status;
            $row[] =

                form_open('admin/act-master-user', 'class="form_act_user"')
                . '
                    <input type="hidden" name="act" value="edit">
                    <input type="hidden" name="id" value="' . sha1($d->id) . '">
                    <button type="submit" class="btn btn-sm btn-primary w-100 my-1"><i class="fas fa-edit"></i> Edit</button>
                ' .
                form_close()
                .
                form_open('admin/act-master-user', 'class="form_act_user"')
                . '
                    <input type="hidden" name="act" value="delete">
                    <input type="hidden" name="id" value="' . sha1($d->id) . '">
                    <button type="submit" class="btn btn-sm btn-danger w-100 my-1"><i class="far fa-trash-alt"></i> Hapus</button>
                ' .
                form_close()
                . $button;

            $data[] = $row;
        }


        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->master_user->count_master_user(),
            "recordsFiltered" => $this->master_user->get_filter_master_user(),
            "data" => $data,
        ];
        json_output($output, 200);
    }

    public function validasi_user()
    {
        cek_ajax();
        $act = $this->input->post('act');


        if ($act == 'add') {
            $this->form_validation->set_rules('nip', 'NIP', 'required|trim|numeric|min_length[17]|is_unique[user.nip]');
            $this->form_validation->set_rules('new_pass', 'Password Baru', 'required|trim|min_length[5]|matches[conf_new_pass]');
            $this->form_validation->set_rules('conf_new_pass', 'Konfirmasi Password Baru', 'required|trim|matches[new_pass]');
        } else if ($act == 'edit') {
            $this->form_validation->set_rules('nip', 'NIP', 'required|trim|numeric|min_length[17]|callback_check_nip');
        }
        $this->form_validation->set_rules('name', 'Nama Lengkap', 'required|trim|min_length[5]');


        $this->form_validation->set_message('min_length', '{field} min {param} karakter');
        $this->form_validation->set_message('matches', '{field} harus sama dengan {param}');
        $this->form_validation->set_message('numeric', '{field} harus angka');
        $this->form_validation->set_message('required', '{field} harap di isi');
        $this->form_validation->set_message('is_unique', '{field} sudah terdaftar');


        if ($this->form_validation->run() == false) {
            $params = [
                'type' => 'validation',
                'err_name' => form_error('name'),
                'err_nip' => form_error('nip'),
                'err_new_pass' => form_error('new_pass'),
                'err_conf_new_pass' => form_error('conf_new_pass'),
                'token' => get_token()
            ];
            json_output($params, 200);
        } else {
            $this->_act_user();
        }
    }


    private function _act_user()
    {
        $input_post = $this->input->post(null, true);
        $id = $input_post['id'];
        $act = $input_post['act'];


        switch ($act) {
            case 'add':
                $insert_data = [
                    'id_role' => $input_post['role'],
                    'id_jurusan' => $input_post['jurusan'],
                    'nip' => $input_post['nip'],
                    'nama' => $input_post['name'],
                    'password' => password_hash($input_post['new_pass'], PASSWORD_DEFAULT),
                    'is_active' => 1,
                    'create_at' => date('Y-m-d H:i:s'),
                    'last_update' => date('Y-m-d H:i:s')
                ];

                $this->db->insert('user', $insert_data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'type' => 'result',
                        'status' => true,
                        'msg' => 'User baru berhasil di tambahkan',
                        'token' => get_token()
                    ];
                } else {
                    $params = [
                        'type' => 'result',
                        'status' => false,
                        'msg' => 'User baru gagal di tambahkan',
                        'token' => get_token()
                    ];
                }

                json_output($params, 200);
                break;
            case 'edit':

                $update_data = [
                    'id_role' => $input_post['role'],
                    'id_jurusan' => $input_post['jurusan'],
                    'nip' => $input_post['nip'],
                    'nama' => $input_post['name'],
                    'last_update' => date('Y-m-d H:i:s')
                ];

                $this->db->where('sha1(id)', $id)->update('user', $update_data);

                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'type' => 'result',
                        'status' => true,
                        'msg' => 'User berhasil di update',
                        'token' => get_token()
                    ];
                } else {
                    $params = [
                        'type' => 'result',
                        'status' => false,
                        'msg' => 'User gagal di update',
                        'token' => get_token()
                    ];
                }

                json_output($params, 200);

                break;
        }
    }

    public function action()
    {
        cek_ajax();
        $act = $this->input->post('act', true);
        $id = $this->input->post('id', true);

        switch ($act) {
            case 'edit':
                $get_data = $this->db->select('
                    sha1(user.id) AS id_user,
                    user.id_role,
                    user.id_jurusan, 
                    user.nama,
                    user.nip
                ')
                    ->from('user')
                    ->where('sha1(id)', $id)
                    ->get()->row();
                if (isset($get_data)) {
                    $output = [
                        'status' => true,
                        'data' => $get_data,
                        'token' => get_token()
                    ];
                } else {
                    $output = [
                        'status' => false,
                        'msg' => 'Data not found',
                        'token' => get_token()
                    ];
                }
                json_output($output, 200);
                break;
            case 'delete':
                $this->db->where('sha1(id)', $id)->delete('user');
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'satus' => true,
                        'msg' => 'User berhasil di hapus',
                        'token' => get_token()
                    ];
                } else {
                    $params = [
                        'satus' => true,
                        'msg' => 'User berhasil di hapus',
                        'token' => get_token()
                    ];
                }
                json_output($params, 200);
                break;
            case 'status_aktif':
                $this->db->set('last_update', date('Y-m-d H:i:s'))->set('is_active', 1)->where('sha1(id)', $id)->update('user');
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'satus' => true,
                        'msg' => 'Status berhasil di update',
                        'token' => get_token()
                    ];
                } else {
                    $params = [
                        'satus' => true,
                        'msg' => 'Status gagal di update',
                        'token' => get_token()
                    ];
                }
                json_output($params, 200);
                break;
            case 'status_nonaktif':
                $this->db->set('last_update', date('Y-m-d H:i:s'))->set('is_active', 0)->where('sha1(id)', $id)->update('user');
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'satus' => true,
                        'msg' => 'Status berhasil di update',
                        'token' => get_token()
                    ];
                } else {
                    $params = [
                        'satus' => true,
                        'msg' => 'Status gagal di update',
                        'token' => get_token()
                    ];
                }
                json_output($params, 200);
                break;
            default:
                $params = [
                    'satus' => false,
                    'msg' => 'Action Unknow',
                    'token' => get_token()
                ];
                json_output($params, 200);
                break;
        }
    }
}
