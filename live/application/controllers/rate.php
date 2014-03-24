<?php

class Rate extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('rate_model');

        // Load helpers
        $this->load->helper('form');
        $this->load->helper('url');
    }

    /**
     * Basic rating view. Shows two random fonts each time.
     */
    public function index() {

        $data['title'] = "Rate fonts";

        $data['fonts'] = $this->rate_model->display_fonts();
        $data['file']  = $this->rate_model->randomiser();
        $data['exist'] = FALSE;

        if (empty($data['fonts'])) {
            show_404();
        }

        if(isset($_POST['like']) || isset($_POST['hate'])) {
            if (array_key_exists('like', $_POST)) {
                $opinion = "like";
            } elseif (array_key_exists('hate', $_POST)) {
                $opinion = "hate";
            }

            $id1 = $_POST['id1'];
            $id2 = $_POST['id2'];

            $this->rate_model->do_rate($id1, $id2, $opinion);
        }

        $this->load->view('templates/header', $data);
        $this->load->view('rate/index', $data);
        $this->load->view('rate/sidebar', $data);
        $this->load->view('templates/footer');

    }

	/**
     * Shows two fonts, one or the other is specified.
     */
    public function view() {

        $data['title'] = "Rate fonts";

        $url = current_url();

        $id_array = $this->rate_model->check_url($url);
        
        array_key_exists('id1', $id_array) ? $id1 = $id_array['id1'] : $id1 = false;
        array_key_exists('id2', $id_array) ? $id2 = $id_array['id2'] : $id2 = false;

        $data['fonts'] = $this->rate_model->display_fonts($id1, $id2);

        if ($id1 !== FALSE) { $id = $id1; }
        if ($id2 !== FALSE) { $id = $id2; }

        $data['id']    = $id;
        $data['exist'] = TRUE;
        $data['pos']   = $id_array['pos'];

        $data['file']  = $this->rate_model->randomiser();

        if (empty($data['fonts'])) {
            show_404();
        }

        if(isset($_POST['like']) || isset($_POST['hate'])) {
            if (array_key_exists('like', $_POST)) {
                $opinion = "like";
            } elseif (array_key_exists('hate', $_POST)) {
                $opinion = "hate";
            }

            if ($id1 === FALSE) {
                $id1 = $_POST['id1'];
            } elseif ($id2 === FALSE) {
                $id2 = $_POST['id2'];
            }

            $this->rate_model->do_rate($id1, $id2, $opinion);
        }

        $this->load->view('templates/header', $data);
        $this->load->view('rate/index', $data);
        $this->load->view('rate/sidebar', $data);
        $this->load->view('templates/footer');

    }
    
    /**
     * Dual rating! 
	 * 
     * @param string $id1 The slug of the first font.
	 * @param string $id2 The slug of the second font.
     */
    public function dual_view($id1, $id2) {
    
        if (!$id1 || !$id2) {
            show_error('You\'re missing a font, please try again', 500);
            return false;
        } else {
			if (isset($_POST) && array_key_exists('right', $_POST)) {
				$id1 = $_POST['combo2']['slug1'];
				$id2 = $_POST['combo2']['slug2'];
			}

			$font1 = $this->rate_model->reverse_lookup($id1);
			$font2 = $this->rate_model->reverse_lookup($id2);
			// echo "<pre>"; print_r($font1); echo "</pre>";

            $data['title'] = "Faceoff!";
            $data['exist'] = TRUE;

            $data['fonts']['stuck'] = $this->rate_model->display_fonts($font1['id'], $font2['id']);
            $data['fonts']['ref']   = $this->rate_model->display_fonts(FALSE, FALSE);

            $data['file'] = $this->rate_model->randomiser();

            $this->load->view('templates/header', $data);
            $this->load->view('rate/faceoff', $data);
            $this->load->view('templates/footer');

			if (isset($_POST['left']) || isset($_POST['right'])) {
				if (array_key_exists('left', $_POST)) {
					$opinion = "like";
					$id1 = $_POST['combo1']['id1'];
					$id2 = $_POST['combo1']['id2'];
				} elseif (array_key_exists('right', $_POST)) {
					$opinion = "like";
					$id1 = $_POST['combo2']['id1'];
					$id2 = $_POST['combo2']['id2'];
				}

				$this->rate_model->do_rate($id1, $id2, $opinion);
			}
			
			if (isset($_POST['right'])) {
				
			}
        }


    }

}

?>