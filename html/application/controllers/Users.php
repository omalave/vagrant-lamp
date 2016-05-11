<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Users extends CI_Controller {

  function __construct() {

    parent::__construct();
    $this->load->model('user', '', TRUE);
  }

  function index() {

    //This method will have the credentials validation
    $this->load->library('form_validation');

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

      $this->form_validation->set_message('check_database', 'Invalid username or password');
      return false;
    }

  }


  function createUser() {

    $username = $this->input->post('email');
    $password = $this->input->post('passwd');
    $fullname = $this->input->post('fullname');

    $this->load->library('email');

    $this->email->from('omalave@ncrossover.com', 'News Crossover');
    $this->email->to('omalave@gmail.com');

    $this->email->subject('Email Test');
    $this->email->message('Testing the email class.');

    if($this->email->send()) {
        echo 'Sent';
    } else {
        $this->email->print_debugger();
        die();
    }


    if (!$this->user->checkIfUserNoExist($username)) {

      $this->user->createUser($username, $password, $fullname);
    }

    return false;

  }


}


?>