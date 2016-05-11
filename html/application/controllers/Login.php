<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Login extends CI_Controller {

  function index() {

    $this->load->helper(array('form'));
    $this->load->view('login_view');
  }  

}

?>