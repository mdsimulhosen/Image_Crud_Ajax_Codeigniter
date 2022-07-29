<?php

use LDAP\Result;

defined('BASEPATH') or exit('No direct script access allowed');

class Ajax_crud_model extends CI_Model
{
	// =++++++++++++++++++++++++++++++ Image Crud ++++++++++++++++++++++++?
	//Data Insert Query
	public function data_insert_query($data, $table)
	{
		$query = $this->db->insert($table, $data);
		return $query;
	}
	// viewing images 
	public function view_images()
	{
		$query = $this->db->get('car_image');
		return $query->result();
	}

	//Get Data on Edit Page
	public function fetchSingleData($image_id, $table)
	{
		$this->db->where('image_id', $image_id);
		$query = $this->db->get($table);
		if ($query) {
			return $query->row();
		}
	}

	//Data Update
	public function update_data_query($image_id, $table, $data)
	{
		$this->db->set($data);
		$this->db->where('image_id', $image_id);
		if ($this->db->update($table)) {
			return TRUE;
		}
		return FALSE;
	}

	//Delete with image
	public function chack_product_image($table, $image_id)
	{
		$this->db->where("image_id", $image_id);
		$result =  $this->db->get($table);
		return $result->row();
	}

	//Data Delete
	public function delete_data_query($image_id, $table)
	{
		$this->db->where('image_id', $image_id);
		if ($this->db->delete($table)) {
			return TRUE;
		}
		return FALSE;
	}
}
