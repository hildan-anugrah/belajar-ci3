<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');

        // Proteksi halaman, pastikan user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['users'] = $this->User_model->get_all_users();
        $this->load->view('users', $data);
    }

    public function add()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('full_name', 'Full Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('users_add');
        } else {
            $data = array(
                'username'  => $this->input->post('username'),
                'password'  => md5($this->input->post('password')),
                'full_name' => $this->input->post('full_name')
            );

            $this->User_model->insert_user($data);
            $this->session->set_flashdata('success', 'Data user berhasil ditambahkan.');
            redirect('user');
        }
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('full_name', 'Full Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['user'] = $this->User_model->get_user_by_id($id);
            
            if (empty($data['user'])) {
                show_404();
            }
            
            $this->load->view('users_edit', $data);
        } else {
            $data = array(
                'username'  => $this->input->post('username'),
                'full_name' => $this->input->post('full_name')
            );

            $password = $this->input->post('password');
            if (!empty($password)) {
                $data['password'] = md5($password);
            }

            $this->User_model->update_user($id, $data);
            $this->session->set_flashdata('success', 'Data user berhasil diupdate.');
            redirect('user');
        }
    }

    public function delete($id)
    {
        // Hanya administrator yang bisa menghapus
        if ($this->session->userdata('role') !== 'administrator') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk menghapus data!');
            redirect('user');
        }

        $this->User_model->delete_user($id);
        $this->session->set_flashdata('success', 'Data user berhasil dihapus.');
        redirect('user');
    }
}