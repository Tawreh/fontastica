<?php

class Blogs extends CI_Controller {

	public function __construct() {

		parent::__construct();
		$this->load->model('blogs_model');
		
		// Load helpers
		$this->load->helper('form');
		
		// Load libraries
		$this->load->library('form_validation');

	}
	
	/**
	 * Blog index view.
	 */
	public function index() {

		$data['title'] = "Fontastica blog archive";
		$data['blogs'] = $this->blogs_model->get_blogs();

		$this->load->view('templates/header', $data);
		$this->load->view('blogs/index', $data);
		$this->load->view('templates/footer');

	}
	
	/**
	 * View single blog.
	 *
	 * @param string $slug The slug of the blog to view.
	 *
	 */
	public function view($slug) {

		if (!isset($slug)) {
			show_404();
		}

		$data['entry'] = $this->blogs_model->get_blogs($slug);
		$data['title'] = $data['entry']['title'];

		$this->load->view('templates/header', $data);
		$this->load->view('blogs/single', $data);
		$this->load->view('templates/footer');

	}
	
	/**
	 * Create a new blog.
	 *
	 */
	public function create() {
	
		$data['title'] = "Create new entry";
		
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('body', 'Body', 'required');
		
		if (count($_POST) > 0) {
			$this->blogs_model->add_blog();
		}
	
		$this->load->view('templates/header', $data);
		$this->load->view('blogs/create', $data);
		$this->load->view('templates/footer');
		
	}

}

?>