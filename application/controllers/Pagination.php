<?php
class Pagination extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pagination_model');
        $this->load->library(['pagination', 'session', 'form_validation']);
        $this->load->helper(['url', 'tgl_indo']);
    }

    private function _init_pagination($total_rows)
    {
        $config['base_url'] = site_url('pagination/ajax_list');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;

        // Styling Bootstrap 5 untuk Pagination
        $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';

        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);
    }

    public function index()
    {
        // Reset keyword pencarian saat pertama kali memuat halaman
        $this->session->unset_userdata('keyword');

        $data['keyword'] = '';
        $data['start'] = 0;
        $data['users'] = $this->Pagination_model->get_users(10, 0);

        $total_rows = $this->Pagination_model->get_count('');
        $this->_init_pagination($total_rows);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('pagination', $data);
    }

    public function ajax_list()
    {
        // Ambil keyword pencarian
        if ($this->input->post('submit')) {
            $data['keyword'] = trim((string)$this->input->post('keyword'));
            $this->session->set_userdata('keyword', $data['keyword']);
        } else {
            $data['keyword'] = ($this->session->userdata('keyword')) ? $this->session->userdata('keyword') : '';
        }

        if ($this->input->post('reset')) {
            $this->session->unset_userdata('keyword');
            $data['keyword'] = '';
        }

        $total_rows = $this->Pagination_model->get_count($data['keyword']);
        $this->_init_pagination($total_rows);

        $page = $this->uri->segment(3);
        $offset = ($page !== NULL) ? (int)$page : 0;

        $data['users'] = $this->Pagination_model->get_users(10, $offset, $data['keyword']);
        $data['pagination'] = $this->pagination->create_links();
        $data['start'] = $offset;

        $tabel_html = $this->load->view('partials/user_rows', $data, true);
        echo json_encode([
            'tabel_html' => $tabel_html,
            'pagination' => $data['pagination']
        ]);
    }

    public function export_pdf()
    {
        $this->load->library('pdf_gen');
        $data['users'] = $this->Pagination_model->get_all_users();
        $data['title'] = 'Laporan Data Users';
        $this->pdf_gen->generate('pdf_report', $data, 'Laporan_Users');
    }

    public function add_user()
    {
        if ($this->input->method() !== 'post') {
            redirect('pagination');
        }

        $this->form_validation->set_rules('username', 'Username', 'required|trim|max_length[50]|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');
        $this->form_validation->set_rules('full_name', 'Nama Lengkap', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[administrator,operator]');

        if ($this->form_validation->run() === FALSE) {
            $old_input = $this->input->post(NULL, true);
            unset($old_input['password']);

            $this->session->set_flashdata('error', validation_errors('', '<br>'));
            $this->session->set_flashdata('old_input', $old_input);
            $this->session->set_flashdata('show_add_modal', true);
            redirect('pagination');
        }

        $foto_profil = 'default.png';

        if (!empty($_FILES['foto_profil']['name'])) {
            $config['upload_path']   = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']      = 2048;
            $config['encrypt_name']  = TRUE;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto_profil')) {
                $uploadData = $this->upload->data();
                $foto_profil = $uploadData['file_name'];
            } else {
                $old_input = $this->input->post(NULL, true);
                unset($old_input['password']);

                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                $this->session->set_flashdata('old_input', $old_input);
                $this->session->set_flashdata('show_add_modal', true);
                redirect('pagination');
            }
        }

        $data = [
            'username' => $this->input->post('username', true),
            'password' => md5($this->input->post('password')),
            'full_name' => $this->input->post('full_name', true),
            'role' => $this->input->post('role', true),
            'foto_profil' => $foto_profil
        ];

        if ($this->Pagination_model->insert_user($data)) {
            $this->session->set_flashdata('success', 'User berhasil ditambahkan!');
        } else {
            $this->session->set_flashdata('error', 'User gagal ditambahkan.');
        }

        redirect('pagination');
    }

    public function update_user($id)
    {
        if ($this->input->method() !== 'post') {
            redirect('pagination');
        }

        $user = $this->Pagination_model->get_user_by_id($id);

        if (empty($user)) {
            show_404();
        }

        $this->form_validation->set_rules('username', 'Username', 'required|trim|max_length[50]');
        $this->form_validation->set_rules('full_name', 'Nama Lengkap', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[administrator,operator]');

        if ($this->input->post('password') !== '') {
            $this->form_validation->set_rules('password', 'Password', 'trim|min_length[6]');
        }

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors('', '<br>'));
            redirect('pagination');
        }

        $username = $this->input->post('username', true);

        if ($this->Pagination_model->username_exists($username, $id)) {
            $this->session->set_flashdata('error', 'Username sudah digunakan.');
            redirect('pagination');
        }

        $data = [
            'username' => $username,
            'full_name' => $this->input->post('full_name', true),
            'role' => $this->input->post('role', true)
        ];

        $password = $this->input->post('password');

        if (!empty($password)) {
            $data['password'] = md5($password);
        }

        $old_foto = $user->foto_profil;

        if (!empty($_FILES['foto_profil']['name'])) {
            $config['upload_path']   = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']      = 2048;
            $config['encrypt_name']  = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('foto_profil')) {
                $uploadData = $this->upload->data();
                $data['foto_profil'] = $uploadData['file_name'];
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                redirect('pagination');
            }
        }

        if ($this->Pagination_model->update_user($id, $data)) {
            if (isset($data['foto_profil']) && !empty($old_foto) && $old_foto !== 'default.png') {
                $old_foto_path = FCPATH . 'uploads/' . $old_foto;

                if (is_file($old_foto_path)) {
                    unlink($old_foto_path);
                }
            }

            $this->session->set_flashdata('success', 'User berhasil diupdate!');
        } else {
            $this->session->set_flashdata('error', 'User gagal diupdate.');
        }

        redirect('pagination');
    }

    public function delete_user($id)
    {
        $user = $this->Pagination_model->get_user_by_id($id);

        if (empty($user)) {
            show_404();
        }

        if ($this->Pagination_model->delete_user($id)) {
            if (!empty($user->foto_profil) && $user->foto_profil !== 'default.png') {
                $foto_path = FCPATH . 'uploads/' . $user->foto_profil;

                if (is_file($foto_path)) {
                    unlink($foto_path);
                }
            }

            $this->session->set_flashdata('success', 'User berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'User gagal dihapus.');
        }

        redirect('pagination');
    }
}
