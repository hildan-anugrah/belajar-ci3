<?php
class Pagination extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pagination_model');
        $this->load->library(['pagination', 'session']);
        $this->load->helper(['url', 'tgl_indo']);
    }

    public function index()
    {
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

        $config['base_url'] = site_url('pagination/index');
        $config['total_rows'] = $this->Pagination_model->get_count($data['keyword']);
        $config['per_page'] = 10;

        $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');

        $page = $this->uri->segment(3);
        $offset = ($page !== NULL) ? (int)$page : 0;

        $this->pagination->initialize($config);

        $data['users'] = $this->Pagination_model->get_users($config['per_page'], $offset, $data['keyword']);
        $data['pagination'] = $this->pagination->create_links();
        $data['total_rows'] = $config['total_rows'];
        $data['start'] = $offset;

        $this->load->view('pagination', $data);
    }

    public function export_pdf()
    {
        $this->load->library('pdf_gen');
        $data['users'] = $this->Pagination_model->get_all_users();
        $data['title'] = 'Laporan Data Users';
        $this->pdf_gen->generate('pdf_report', $data, 'Laporan_Users');
    }
}