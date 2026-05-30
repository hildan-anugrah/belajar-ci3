<?php
class Upload_file extends CI_Controller
{
    public function index()
    {
        $this->load->view('upload_file');
    }

    public function do_upload()
    {
        $config['upload_path']   = './uploads/profil';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('image_file')) {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            redirect('upload_file');
        } else {
            $upload_data = $this->upload->data();
            $filename = $upload_data['file_name'];

            // Image Resize
            $config_resize['image_library']  = 'gd2';
            $config_resize['source_image']   = './uploads/profil/' . $filename;
            $config_resize['maintain_ratio'] = TRUE;
            $config_resize['width']          = 300;
            $config_resize['height']         = 300;

            $this->load->library('image_lib', $config_resize);
            
            if ($this->image_lib->resize()) {
                
                $user_id = $this->session->userdata('user_id');
                if ($user_id) {
                    $this->load->model('User_model');
                    
                    $old_user = $this->User_model->get_user_by_id($user_id);
                    if ($old_user && $old_user->foto_profil && $old_user->foto_profil !== 'default.png') {
                        $old_file = FCPATH . 'uploads/profil/' . $old_user->foto_profil;
                        if (file_exists($old_file)) {
                            unlink($old_file);
                        }
                    }

                    $this->User_model->update_user($user_id, ['foto_profil' => $filename]);
                }
                
                $this->session->set_flashdata('success', 'Berhasil Upload, Resize, & Disimpan ke Database!');
            } else {
                $this->session->set_flashdata('error', $this->image_lib->display_errors());
            }

            $this->session->set_flashdata('file_name', $filename);
            redirect('upload_file');
        }
    }
}