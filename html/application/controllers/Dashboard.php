<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Dashboard extends CI_Controller {

  function __construct() {

    parent::__construct();
    $this->load->model('news', '', TRUE);
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');

  }

  function index() {

    if($this->session->userdata('logged_in')) {

      $data['news'] =  $this->news->get_news_by_id();

      $this->load->view('dashboard_view', $data);

    } else {

      //If no session, redirect to login page
      redirect('login', 'refresh');

    }

  }

  function logout() {

    $this->session->unset_userdata('logged_in');
    session_destroy();
    redirect('home', 'refresh');

  }


  public function addnews_view() {

    if($this->session->userdata('logged_in')) {

      $this->load->view('addnews_view', array('error' => ' ' ));

    } else {

      redirect('login', 'refresh');
    }

  }


  function do_upload() {

    if(!$this->session->userdata('logged_in')) {

      redirect('login', 'refresh');

    } 


    $this->form_validation->set_rules('news_title', 'News Title', 'trim|required');
    $this->form_validation->set_rules('news_photo', 'News Photo', 'trim|required');
    $this->form_validation->set_rules('newsText', 'News Text', 'trim|required');

    if($this->form_validation->run() == FALSE) {

      $this->load->view('addnews_view');

    }

    $config['upload_path'] = './uploads/';
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_size'] = '1024';
    $config['max_width']  = '1024';
    $config['max_height']  = '768';

    $this->load->library('upload', $config);

    if ( ! $this->upload->do_upload('news_photo')) {

      $error = array('error' => $this->upload->display_errors());

      $this->load->view('addnews_view', $error);
    
    } else {

      $news_title  = $this->input->post('news_title');
      $news_photo  = $this->upload->data('file_name');
      $news_text   = $this->input->post('news_text');
      $news_date   = date('Y-m-d H:i:s');
      $news_author = $_SESSION["logged_in"]["id"];

      $this->news->saveNews($news_title, $news_photo, $news_text, $news_date, $news_author);

      redirect('dashboard', 'refresh');
    
    }
  }

  public function getNewsDetail($id) {

    if($this->session->userdata('logged_in')) {

      $data["news"] = $this->news->getArticleDetail($id);
      $this->load->view('news_detail', $data);

    } else {

      redirect('login', 'refresh');
    }



  }

}

?>
