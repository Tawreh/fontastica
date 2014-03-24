<?php

class Blogs_model extends CI_Model {

	public function __construct() {

		$this->load->database();

		// load helpers
		$this->load->helper('url');

	}

	/**
	 * Retrieve all blogs from the database.
	 *
	 * @param string $slug The slug to retrieve
	 *
	 * @return array $query->result_array()
	 */
	public function get_blogs($slug = FALSE) {

		if ($slug == FALSE) { 

			$query = $this->db->select('*')
							  ->from('blog')
							  ->order_by('published', 'desc')
							  ->where(array('visible' => 1))
							  ->get();
			return $query->result_array();
		}

		$query = $this->db->get_where('blog', array('slug' => $slug, 'visible' => 1));

		return $query->row_array();

	}

	/** 
	 * Adds a new blog to the database.
	 */
	public function add_blog() {

		$slug = url_title($this->input->post('title', 'dash', TRUE));

		if ($this->input->post('summary') != '') {
			$summary = $this->input->post('summary');
		} else {
			$summary = substr($this->input->post('body'), 0, 250) . " ... ";
		}

		if ($this->input->post('visible') == TRUE) {
			$visible = 1;
		} else {
			$visible = 0;
		}
		
		$body = nl2br($this->input->post('body'));

		$data = array(
			'title'   => $this->input->post('title'),
			'slug'    => $slug,
			'body' 	  => $body,
			'summary' => $summary,
			'visible' => $visible
		);

		return $this->db->insert('blog', $data);

	}

}

?>