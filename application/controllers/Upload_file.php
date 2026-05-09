<?php
class Upload_file extends CI_Controller
{
    public function index()
    {
        $this->load->view('upload_file');
    }

    public function do_upload()
    {
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['encrypt_name']  = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('image_file')) {
            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
            redirect('upload_file');
        } else {
            $upload_data = $this->upload->data();

            // Image Resize
            $config_resize['image_library']  = 'gd2';
            $config_resize['source_image']   = './uploads/' . $upload_data['file_name'];
            $config_resize['maintain_ratio'] = TRUE;
            $config_resize['width']          = 300;
            $config_resize['height']         = 300;

            $this->load->library('image_lib', $config_resize);
            
            if ($this->image_lib->resize()) {
                $this->session->set_flashdata('success', 'Berhasil Upload & Resize!');
            } else {
                $this->session->set_flashdata('error', $this->image_lib->display_errors());
            }

            $this->session->set_flashdata('file_name', $upload_data['file_name']);
            redirect('upload_file');
        }
    }
}