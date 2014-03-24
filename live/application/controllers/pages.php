<?php

class Pages extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('font_model');
		
		// Include the form helper
		$this->load->helper('form');

    }

	public function view($page = 'home') {

		if (!file_exists('application/views/pages/' . $page . '.php')) {
			show_404();
		}

		$data['title'] = ucfirst($page); // Capitalise the first letter
        if ($page == 'stats') {
            $data['fonts'] = $this->font_model->get_top_rated();
            $data['tags']  = $this->font_model->get_top_tags();
        }

        if ($page == 'search') {
            $this->load->helper('form');
            $data['results'] = $this->font_model->get_like($_POST['search']);
        }

		if ($page == 'home') {
            $this->load->view('pages/home', $data);
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer');
        }

	}

}

?>