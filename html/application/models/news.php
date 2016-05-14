<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class News extends CI_Model {

  function saveNews($news_title, $news_photo, $news_text, $news_date, $news_author) {

    $data = array(
      'newsTitle'  => $news_title,
      'newsPhoto'  => $news_photo,
      'newsText'   => $news_text,
      'newsDate'   => $news_date,
      'newsAuthor' => $news_author,
      'isActive'   => 1
    );

    $this->db->insert('news', $data);    

  }

  public function getLast10News() {

    $query = $this->db->query('SELECT newsId, newsTitle, newsDate, newsPhoto FROM news WHERE isActive = 1 ORDER BY newsID DESC LIMIT 10');
    return $query->result_array();

  }

  public function getLast10NewsRss() {

    $query = $this->db->query('SELECT * FROM news  WHERE isActive = 1 ORDER BY newsID DESC LIMIT 10');
    return $query->result_array();

  }

  public function get_news_by_id() {

    $id = $_SESSION["logged_in"]["id"];

    $query = $this->db->query('SELECT newsId, newsTitle, newsDate FROM news WHERE isActive = 1 AND newsAuthor = '.$id);
    return $query->result_array();
  }

  public function getArticleDetail($id) {

    $query = $this->db->query('SELECT newsId, newsTitle, newsPhoto, newsDate, newsDate, newsText FROM news WHERE isActive = 1 AND newsId = '.$id);
    return $query->row();

  }


}

?>