<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(FCPATH . 'vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Dompdf\Dompdf;
use Dompdf\Options;


class User extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('form_validation');

        // Proteksi halaman, pastikan user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index(){
        $data['users'] = $this->User_model->get_all_users();

        $this->load->view('layout/header');
        $this->load->view('users', $data);
        $this->load->view('layout/footer');
    }

    public function add(){
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

    public function edit($id){
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

    public function delete($id){
        // Hanya administrator yang bisa menghapus
        if ($this->session->userdata('role') !== 'administrator') {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk menghapus data!');
            redirect('user');
        }

        $this->User_model->delete_user($id);
        $this->session->set_flashdata('success', 'Data user berhasil dihapus.');
        redirect('user');
    }

    public function export_excel(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Membuat Header Tabel
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Username');
        $sheet->setCellValue('C1', 'Full Name');

        // Mengambil Data dari Database
        $users = $this->User_model->get_all_users();
        
        $row = 2;
        $no = 1;
        
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $user->username);
            $sheet->setCellValue('C' . $row, $user->full_name);
            $row++;
            $no++;
        }

        // Konfigurasi Header untuk Download
        $filename = "data-users.xlsx";
        
        // Perbaikan typo: ditambahkan tanda "-" setelah openxmlformats
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function export_pdf(){
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
        
        // Ambil data dan muat ke dalam view khusus PDF
        $users = $this->User_model->get_all_users();
        $html = $this->load->view("pdf_report", ["users" => $users], true);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        // Attachment: 0 untuk preview di browser, 1 untuk langsung download
        $dompdf->stream("laporan_users.pdf", array("Attachment" => 0));
    }
    
    public function generate_qrcode(){
        $this->load->library('ciqrcode'); 
        
        // Konfigurasi log agar tidak error permission
        $config['errorlog'] = false;
        $this->ciqrcode->initialize($config);
        
        // Parameter QR Code
        $params['data']  = site_url('user'); // Data yang akan di-encode
        $params['level'] = 'H';              // Kualitas (L, M, Q, H)
        $params['size']  = 10;               // Ukuran
        
        // Simpan di folder qrcode/ yang sudah dibuat (chmod 777)
        $file_name = 'qrcode_site.png';
        $params['savename'] = FCPATH . 'qrcode/' . $file_name;
        
        // Proses pembuatan QR Code
        $this->ciqrcode->generate($params);
        
        // Tampilkan hasil ke layar
        echo '<h3>QR Code Berhasil Dibuat:</h3>';
        echo '<img src="' . base_url('qrcode/' . $file_name) . '">'; 
        echo '<br><br><a href="' . site_url('user') . '">Kembali</a>';
    }
}