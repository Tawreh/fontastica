<?php
class Fonts extends CI_Controller {

    public function __construct() {
    
        parent::__construct();
        $this->load->model('font_model');
        $this->load->model('rate_model');

        // Load helpers
        $this->load->helper('form');
        $this->load->helper('url');
        
        // Load libraries
        $this->load->library('pagination');
    }
    
    /**
     * Lists all of the fonts by ID and paginates them.
     */
    public function index($sort = FALSE) {
		if (isset($_POST)) {
			$postdata = $this->input->post();

			if (is_array($postdata)) { 
				$sort_by = key($postdata);
			} else if ($sort !== FALSE) {
				$sort_by = $sort;
			} else { 
				$sort_by = 'az';
			}

			$fontlist = $this->font_model->get_fonts($slug = FALSE, $sort_by = $sort_by);
		}

        $config['base_url']    = base_url() . 'fonts/by/' . $sort_by;
		$config['num_links']   = 4;
        $config['per_page']    = 7;
        $config['uri_segment'] = 4;

        // Get the offset for retrieving fonts
        $url   = explode('/', current_url());
        array_key_exists('6', $url) ? $offset = $url[6] : $offset = "0";

        $config['total_rows'] = count($fontlist);

        if ($config['total_rows'] > 1) {
            $data['fonts'] = array_slice($fontlist, $offset, $config['per_page']);
        } else {
            $data['fonts'] = $fontlist;
        }

        $this->pagination->initialize($config);

        $data['title']     = 'Fonts archive';
        $data['pages']     = $this->pagination->create_links();

        $paragraph = $this->rate_model->randomiser();
        $data['paragraph'] = substr($paragraph[0]->body, 0, 255) . "...";

        $this->load->view('templates/header', $data);
        $this->load->view('fonts/index', $data);
        $this->load->view('fonts/index_sidebar', $data);
        $this->load->view('templates/footer');

    }
    
    /**
     * View font(s).
	 * 
     * @param string $slug The slug of the font to display.
	 * @param string $slug2 The second slug.
     */
    public function view($slug, $slug2 = FALSE) {

        // Retrieve the data for this font.
        $data['fonts'] = $this->font_model->get_fonts($slug = $slug, $sort_by = FALSE);

        // If there is none, show a 404 page. 
        if (empty($data['fonts'])) {
            show_404();
        }

        // Set up the entry in the database with fonts. 
        $id = $data['fonts']['id'];
        $this->font_model->set_tags($id);
		
		// Get a persistent sample of text that will remain the same each time the font is loaded.
		// Only do this if there is no second slug, nor a sample set yet.
		if (($slug2 == FALSE) && ($data['fonts']['sample_id'] == 0)) { 
			$para = $this->rate_model->randomiser();
			$data['sample'] = $this->font_model->sample_assoc($id, $para[0]->id);
			$data['sample'] = $this->rate_model->randomiser($data['fonts']['sample_id']);
		} else if ($data['fonts']['sample_id'] != 0) {
			$data['sample'] = $this->rate_model->randomiser($data['fonts']['sample_id']);
		}


        // If the form gets posted, either update rating or update tags. 
        if (count($_POST) > 0) {
            if ($slug2) {
                $id1 = $_POST['id1'];
                $id2 = $_POST['id2'];
                
                if (array_key_exists('like', $_POST)) {
                    $opinion = "like";
                } elseif (array_key_exists('hate', $_POST)) {
                    $opinion = "hate";
                }
                
                $this->rate_model->do_rate($id1, $id2, $opinion);
            } else {
                $tags   = array('id' => $id);
                $posted = $this->input->post();

                if (count($posted) > 0) {
                    foreach ($posted as $key=>$value) {
                        $tags[$key] = $value;
                    }
                }

                // Update the tags array in the data
                $this->font_model->update_tags($tags);
            }
        } 

        $tags = array('id' => $id);
        $data['tags'] = $this->font_model->get_tags($id);
       
        // Add the rate bits and pieces
        $data['rate'] = $this->font_model->retrieve_combinations($id);

        // Check slug 2.
        if ($slug2 != FALSE) {
            $data['font2'] = $this->font_model->get_fonts($slug2);
            $data['title'] = "Viewing combination: " . $data['fonts']['name'] . " and " . $data['font2']['name'];

            $main    = 'fonts/dual_view';
            $sidebar = 'fonts/dual_sidebar';
        } else {
            $data['title'] = "Viewing font - " . $data['fonts']['name'];

            $main    = 'fonts/single_view';
            $sidebar = 'fonts/single_sidebar';
        }

        // Display the page.
        $this->load->view('templates/header', $data);
        $this->load->view($main, $data);
        $this->load->view($sidebar, $data);
        $this->load->view('templates/footer');

    }

    /**
     * Add new fonts.
     */
    public function create() {

        $data['title'] = 'Add a new font';

        $this->font_model->set_font();
        $this->load->view('templates/header', $data);
        $this->load->view('fonts/success');
        $this->load->view('templates/footer');

    }

}
?>