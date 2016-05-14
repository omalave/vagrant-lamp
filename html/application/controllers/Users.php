<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Users extends CI_Controller {

  function __construct() {

    parent::__construct();
    $this->load->model('user', '', TRUE);
    $this->load->library('form_validation');
  }

  function index() {

    $this->form_validation->set_rules('username', 'Username', 'trim|required');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_checkDatabase');

    if($this->form_validation->run() == FALSE) {

      //Field validation failed.  User redirected to login page
      $this->load->view('login_view');

    } else {

      //Go to private area
      redirect('dashboard', 'refresh');
    }

  }

  function checkDatabase($password) {

    //Field validation succeeded.  Validate against database
    $username = $this->input->post('username');

    //query the database
    $result = $this->user->login($username, $password);

    if ($result) {

      $sess_array = array();

    foreach($result as $row) {

       $sess_array = array(
         'id'       => $row->id,
         'username' => $row->username
       );
       $this->session->set_userdata('logged_in', $sess_array);

    }

      return true;

    } else {

      $this->form_validation->set_message('checkDatabase', 'Invalid username or password');
      return false;
    }

  }


  function createUser() {

    $username   = $this->input->post('email');
    $password   = $this->input->post('passwd');
    $fullname   = $this->input->post('fullname');
    
    $secretCode = $this->createGUID();

    if (!$this->user->checkIfUserNoExist($username)) {

      $this->user->createUser($username, $password, $fullname, $secretCode);
      
      $this->load->library('email');
      $this->email->initialize(array(
        'protocol'  => 'smtp',
        'smtp_host' => 'smtp.sendgrid.net',
        'smtp_user' => 'newsCrossover',
        'smtp_pass' => 'crossover2016',
        'smtp_port' => 587,
        'crlf'      => "\r\n",
        'newline'   => "\r\n",
        'mailtype'  => 'html'
      ));

      $this->load->library('email');

      $this->email->from('omalave@ncrossover.com', 'News Crossover');
      $this->email->to($username);

      $this->email->subject('Account Activation');

      $link = $this->config->item('base_url') . "users/checkUID/?u=".$secretCode;
      $aLink = "<a href='".$link."'>Click Here!</a>";

      $this->email->message('Please click in this link in order to activate your account. '.$aLink);

      if(!$this->email->send()) {

          echo $this->email->print_debugger();
          die();
      }

      $this->load->view('success_registration_view');

    } else {

        $this->session->set_flashdata('msg_usr_exist', 'Error the user is already in our DB');
        $this->load->view('login_view');
        return false;

    }


  }

  function createGUID() {
      return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, time()), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535)); 
  }


  public function checkUID() {

    if ($this->user->checkUID($_GET["u"])) {
    
      $this->load->view('change_password');

    } else {

      $this->load->view('success_registration_view');
    }

  }

  public function changePassword() {

    $password1 = $this->input->post('password1');
    $password2 = $this->input->post('password2');
    $u         = $this->input->post('u');

    $this->form_validation->set_rules('password1', 'Password', 'required|matches[password2]');
    $this->form_validation->set_rules('password2', 'Password Confirmation', 'required');

    if ($this->form_validation->run() == FALSE) {

      $this->load->view('change_password');
    
    } else {

      $this->user->changePassword($u, $password1);

      //Go to private area
      redirect('dashboard', 'refresh');

    }


  }


}


?>