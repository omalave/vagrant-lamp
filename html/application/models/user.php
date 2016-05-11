<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class User extends CI_Model {

  function login($username, $password) {

    $this->db->select('id, username, password');
    $this->db->from('users');
    $this->db->where('username', $username);
    $this->db->where('password', sha1($password));
    $this->db->where('isActive', 1);
    $this->db->limit(1);

    $query = $this->db->get();

    if($query -> num_rows() == 1) {

      return $query->result();
    } else {

      return false;
    }

  }

  function createUser($username, $uName, $uPass) {

    $data = array(
            'username' => $username,
            'password' => $uPass,
            'fullName' => $uName
    );

    $this->db->insert('users', $data);


  }

  function checkIfUserNoExist($username) {

    $this->db->select('id');
    $this->db->from('users');
    $this->db->where('username', $username);

    $query = $this->db->get();

    if($query -> num_rows() == 1) {

      return $query->result();
    } else {

      return false;
    }

  }


}

?>