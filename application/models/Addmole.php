<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Addmole extends CI_Model
{
    public function insert($data, $table)
    {
        $this->db->insert($table, $data);
        
    }
}