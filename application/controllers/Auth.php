<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index() 
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_eamil');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ( $this->form_validation->run() == false) {
            
            $this->load->view('templates/header');
            $this->load->view('auth/login');
            $this->load->view('templates/footer');
        } else {
            $this->_login();
        }
    }
    public function _index()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $eamil])->row_array ();

         if ($user) {
             //usere sukses
             if ($useer) {
                 if (password_verify($password, $user['password'])) {
                     $data =[
                         'email' => $user['email'],
                         //role_id => $user['role_id']
                     ];
                     $this->session->set_userdata($data);
                     redirect('dashboard');
                 }else{
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">wrong password</div>');
                    redirect('auth');
                 }
                 }else{
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">email has been not actived</div>');
                    redirect('auth');
                 }
                 }else{
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">email not reqistered</div>');
                    redirect('auth');
                 }
             }
             public function reqister()
             {
                 $this->form_validation->set_rules('name', 'Name', 'require|trim');
                 $this->form_validation->set_rules('email', 'Email', 'require|trim|valid_email|is_unique[user.email]');
                 $this->form_validation->set_rules('nik', 'niik', 'require|trim');
                 $this->form_validation->set_rules('password', 'Password', 'require|trim|min_length[5]|matches[password2]',[
                     'matches' => 'Password dont match',
                     'min_length' => 'password too shord!'
                 ]);
                 $this->form_validation->set_rules('password', 'Password', 'required|trim|matches[password');

                 if ($this->form_validation->run() == false) {
                    $this->load->view('templates/header');
                    $this->load->view('auth/regist');
                    $this->load->view('templates/footer');
                 }else{
                     $data = [
                     'name' => htmlspecialchars($this->input->post('name', true)),
                     'email' => htmlspecialchars($this->input->post('emial', true)),
                     'nik' => htmlspecialchars($this->input->post('nik', true)),
                     'image' => 'default.jpg',
                     'password' => password_hash(
                         $this->input->post('password'),
                         PASSWORD_DEFAULT
                     ),
                     'role_id' => 2,
                     'is_active' => 1,
                     'date_created' => time()
                    ];
                    $this->db->indert('user', $data);

                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Congratulation! your account has been created. Please</div> ');
                 }
             }
            }       