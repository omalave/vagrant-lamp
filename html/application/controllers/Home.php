<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use \Dompdf\Dompdf;

Class Home extends CI_Controller {

  function __construct() {

    parent::__construct();
    $this->load->model('news', '', TRUE);
    include("./vendor/autoload.php");
    $this->load->helper('xml');

  }
  public function index() {

    $data["news10"] = $this->news->getLast10News();

    $this->load->view('home_view', $data);

  }

  public function getNewsDetail($id) {

    $data["news"] = $this->news->getArticleDetail($id);
    $this->load->view('news_detail', $data);

  }


  public function download_pdf($id) {

    if($this->session->userdata('logged_in')) {

      $dompdf = new Dompdf();

      $data["news"] = $this->news->getArticleDetail($id);
      $html = $this->load->view('news_detail', $data,true);
  
      $dompdf->loadHtml($html);
      $dompdf->render();
      $dompdf->stream();


    } else {

      redirect('login', 'refresh');
    }


  }

  public function rss_feed() {

    $data['feed_name'] = 'newsCrossover';
    $data['encoding'] = 'utf-8';
    $data['feed_url'] = 'http://newscrossover.com/home/rss_feed';
    $data['page_language'] = 'en';
    $data['page_description'] = 'News';
    $data['creator_email'] = 'omalave@gmail.com';
    $data['feeds'] = $this->news->getLast10NewsRss();

    $this->output->set_header("Content-Type: application/rss+xml");

    $this->load->view('feed_view', $data);


  }

}
