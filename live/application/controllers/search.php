<?php

class Search extends CI_Controller {

	public function __construct() {
	
		parent::__construct();
		$this->load->model('search_model');
		$this->load->model('rate_model');
		
		// Load helpers
		$this->load->helper('form');
	
	}
	
	public function view() {
	
		$data['results'] = $this->search_model->get_like($_POST['search']);
		$data['title']   = 'Search results';

		$random       = $this->rate_model->randomiser();
		$data['demo'] = substr($random[0]->body, 0, 255) . '...';
		
		$this->load->view('templates/header', $data);
		$this->load->view('search/search_results', $data);
		$this->load->view('templates/footer');
	
	}

}

?>