<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CarModel extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model("ajax_crud_model");
	}


	// +++++++++++++++++++++++++++++++ Car image Upload Crud ++++++++++++++++++++++++ 


	public function index()
	{
		$images = $this->ajax_crud_model->view_images();
		$data['images'] = $images;
		$this->load->view('car_image', $data);
	}

	public function image_upload()
	{
		$ori_filename = $_FILES['file']['name'];
		$insert_name = time() . "" . str_replace(' ', '-', $ori_filename);
		$config = [
			'upload_path' => './images/',
			'allowed_types' => 'gif|jpg|jpeg|png',
			// 'encrypt_name' => TRUE,
			'file_name' => $insert_name,
		];

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('file')) {
			$imageError = array('imageError' => $this->upload->display_errors());
			$this->load->view('car_image', $imageError);
		} else {
			$prod_filename = $this->upload->data('file_name');
			$table = "car_image";
			$data = [
				'image' => $prod_filename
			];

			$this->ajax_crud_model->data_insert_query($data, $table);
		}
	}

	// edit image 
	public function edit_image($image_id)
	{
		$table = 'car_image';
		$resultData = $this->ajax_crud_model->fetchSingleData($image_id, $table);
		echo json_encode($resultData);
	}

	//Edit Data Update
	public function update_image($image_id)
	{
		$old_filename = $this->input->post("old_file");
		$new_filename = $_FILES['file']['name'];
		if ($new_filename == TRUE) {
			$update_filename = time() . "" . str_replace(' ', '-', $new_filename);
			$config = [
				'upload_path' => './images/',
				'allowed_types' => 'gif|jpg|jpeg|png',
				// 'encrypt_name' => TRUE,
				'file_name' => $update_filename,
			];

			$this->load->library('upload', $config);
			if (!$this->upload->do_upload('file')) {
				//Form Error
				$imageError = array('imageError' => $this->upload->display_errors());
				$this->load->view('upload_form', $imageError);
			} else {
				if (file_exists("./images/" . $old_filename)) {
					unlink("./images/" . $old_filename);
				} else {
					$update_filename = $old_filename;
				}
			}
			$table = 'car_image';
			$data = [
				'image' => $update_filename,
			];

			$result = $this->ajax_crud_model->update_data_query($image_id, $table, $data);
		}
	}

	//Data Delete
	public function delete_image($image_id)
	{
		$table = "car_image";
		if ($this->ajax_crud_model->chack_product_image($table, $image_id)) {
			$data = $this->ajax_crud_model->chack_product_image($table, $image_id);

			if (file_exists("./images/" . $data->image)) {
				unlink("./images/" . $data->image);
			}
			$result = $this->ajax_crud_model->delete_data_query($image_id, $table);
		}
	}
}
