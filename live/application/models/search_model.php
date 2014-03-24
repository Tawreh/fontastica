<?php

class Search_model extends CI_Model {
	
	public function __construct() {
	
		$this->load->database();
	
	}
	
	/**
     * Basic search function
	 * 
     * @param string $string The string to search for.
	 * 
     * @return array $query->result_array()
     */
    public function get_like($string) {
    
        if (strlen($string) < 3) {
            show_error('Please enter a search term longer than 3 characters', '500');
        } else {
            $query = $this->db->select('*')
                              ->from('fonts')
                              ->like('name', $string)
                              ->get();
            
            return $query->result_array();
        }
    
    }
	
	/** 
     * Advanced search function
	 * 
     * @param string $string Optional string to search for.
	 * @param string $tag Optional tag to search by.
	 * @param string $combwith Optional font combined with.
	 * 
     * @return array $query->result_array()
     */
	public function advanced_search($string = FALSE, $tag = FALSE, $combwith = FALSE) {

		if ((isset($string)) && (strlen($string) < 3)) {
			show_error('Please enter a search term longer than 3 characters', '500');
		}

		$base_query = $this->db->select('*')
							   ->from('fonts');

		if (isset($string)) {
			$string_query = $base_query->like('name', $string)->get();
		}
		
		if (isset($tag)) {
			$tag_query = $this->tag_search($tag);
		}
		
		if (isset($combwith)) {
			$comb_query = $this->comb_search($combwith);
		}

	}
	
	/** 
     * Search for most-rated tagged items
	 * 
     * @param string $tag The tag to search by. 
	 * 
     * @return array $query->result_array()
     */
	public function tag_search($tag) {
	
		if (!isset($tag)) {
			show_error('Please select a tag to search by', '500');
		}
	
	}

}

?>