<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class App_model extends CI_Model
{
    public function upload_files($param_FILES, $prefix, $upload_path)
    {
        $files = $param_FILES;
        $cpt = count($files['name']);
        $upload_data = array();
        $error_upload = array();


        $config['upload_path'] = $upload_path;
        $config['file_name'] = $prefix . '-' . date('YmdHis');
        $config['allowed_types'] = 'svg|jpeg|jpg|png';
        $config['max_size'] = 4000;

        for ($i = 0; $i < $cpt; $i++) {
            $_FILES['bukti']['name'] = $files['name'][$i];
            $_FILES['bukti']['type'] = $files['type'][$i];
            $_FILES['bukti']['tmp_name'] = $files['tmp_name'][$i];
            $_FILES['bukti']['error'] = $files['error'][$i];
            $_FILES['bukti']['size'] = $files['size'][$i];

            $this->upload->initialize($config);
            if ($this->upload->do_upload('bukti')) {
                $res = $this->upload->data();
                $row = [
                    'status' => true,
                    'file_name' => $res['file_name'],
                    'file_type' => $res['file_type'],
                    'file_ext' => $res['file_ext'],
                    'file_size' => $res['file_size'],
                    'raw_name' => $res['raw_name'],
                    'ori_name' =>  $files['name'][$i],
                    'client_name' => $res['client_name']
                ];
                $upload_data[] = $row;
            } else {
                $row = [
                    'status' => false,
                    'error' => $this->upload->display_errors('', '') . ' (' . $files['name'][$i] . ')',
                ];
                $error_upload[] = $row;
            }
        }

        $output = [
            'success_upload' => $upload_data,
            'error_upload' => $error_upload
        ];

        return $output;
    }


    public function _diff_array_bukti_file($from_input, $from_db)
    {
        //get filename from new file
        $ofu = [];
        $a = 0;
        for ($i = 0; $i < count($from_input); $i++) {
            $ofu[] = $from_input[$i];
        }


        //get filename from old file
        $filtered_array = [];
        foreach ($from_db->data as $of) {
            foreach ($ofu as $ou) {
                if ($of->file_name == $ou) {
                    $filtered_array[] = $of;
                }
            }
        }

        return $filtered_array;
    }


    public function input_data($table, $data)
    {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() > 0) {
            $output = [
                'status' => true,
                'msg' => 'Data berhasil disimpan',
                'token' => get_token()
            ];
        } else {
            $output = [
                'status' => false,
                'msg' => 'Data gagal disimpan',
                'token' => get_token()
            ];
        }
        json_output($output, 200);
    }

    public function update_data($table, $data, $where, $param)
    {
        $this->db->where($where, $param)->update($table, $data);
        if ($this->db->affected_rows() > 0) {
            $output = [
                'status' => true,
                'msg' => 'Data berhasil diubah',
                'token' => get_token()
            ];
        } else {
            $output = [
                'status' => false,
                'msg' => 'Data gagal diubah',
                'token' => get_token()
            ];
        }
        json_output($output, 200);
    }

    public function delete_data($table, $where, $param)
    {
        $this->db->where($where, $param)->delete($table);
        if ($this->db->affected_rows() > 0) {
            $output = [
                'status' => true,
                'msg' => 'Data berhasil dihapus',
                'token' => get_token()
            ];
        } else {
            $output = [
                'status' => false,
                'msg' => 'Data gagal dihapus',
                'token' => get_token()
            ];
        }
        json_output($output, 200);
    }

    public function get_where_data($table, $where, $param)
    {
        $data = $this->db->where($where, $param)->get($table);
        return $data;
    }

    public function change_json_file($filename, $data_val)
    {
        $json_data = json_encode($data_val, JSON_PRETTY_PRINT);
        $file_path = './application/third_party/json/' . $filename;

        if (file_put_contents($file_path, $json_data) === false) {
            $params = [
                'status' => false,
                'msg' => 'Data gagal di simpan',
                'token' => get_token()
            ];
        } else {
            $params = [
                'status' => true,
                'msg' => 'Data berhasil di simpan',
                'token' => get_token()
            ];
        }
        json_output($params, 200);
    }

    public function get_json_file($filename)
    {
        $file_path = './application/third_party/json/' . $filename;

        $get_data = file_get_contents($file_path);
        if ($get_data === false) {
            $params = [
                'status' => false,
                'msg' => 'Error reading the file ' . $filename,
                'token' => get_token()
            ];
            echo json_encode($params);
            exit;
        } else {
            $decode_data = json_decode($get_data);
            return $decode_data;
        }
    }
}
