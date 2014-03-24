<?php

class Font_model extends CI_Model {

    public function __construct() {

        $this->load->database();

        $this->load->helper('url');

    }

    /**
     * Retrieve a list of fonts from Google.
	 *
     * @return string $data Decoded JSON array.
     */
    public function retrieve_list() {

        // Set these up separately, so that I can change one or other easily.
        $api_key    = "AIzaSyDRW7JV4Cpbm8sQ4dDpUZLdOhhv-Swx6jU";
        $google_url = "https://www.googleapis.com/webfonts/v1/webfonts?key=";

        // Grab the JSON file.
        $json       = file_get_contents($google_url . $api_key);

        // Decode the JSON file.
        $data       = json_decode($json, true);

        return $data;

    }

    /**
     * Retrieve fonts from the database.
	 *
     * @param string $slug The slug to search for.
	 * @param string $sort_by How to sort the fonts, if a sort has been set.
	 *
     * @return array $query->row_array()
     */
    public function get_fonts($slug = FALSE, $sort_by = FALSE) {

		if ($sort_by !== FALSE) {

			switch ($sort_by) {

				case "az":
					$query = $this->db->select('*')
									  ->from('fonts')
									  ->order_by('name', 'asc')
									  ->get();
				break;
				case "za":
					$query = $this->db->select('*')
									  ->from('fonts')
									  ->order_by('name', 'desc')
									  ->get();
				break;
				case "serif":
					$query = $this->db->select('*')
									  ->from('fonts')
									  ->join('tags', 'tags.id = fonts.id')
									  ->where('serif >', '0')
									  ->order_by('serif', 'desc')
									  ->get();
				break;
				case "sans":
					$query = $this->db->select('*')
									  ->from('fonts')
									  ->join('tags', 'tags.id = fonts.id')
									  ->where('sans >', '0')
									  ->order_by('sans', 'desc')
									  ->get();
				break;
				case "slab":
					$query = $this->db->select('*')
									  ->from('fonts')
									  ->join('tags', 'tags.id = fonts.id')
									  ->where('slab >', '0')
									  ->order_by('slab', 'desc')
									  ->get();
				break;
				case "monotype":
					$query = $this->db->select('*')
									  ->from('fonts')
									  ->join('tags', 'tags.id = fonts.id')
									  ->where('mono >', '0')
									  ->order_by('mono', 'desc')
									  ->get();
				break;
				case "script":
					$query = $this->db->select('*')
									  ->from('fonts')
									  ->join('tags', 'tags.id = fonts.id')
									  ->where('script >', '0')
									  ->order_by('script', 'desc')
									  ->get();
				break;
				case "display":
					$query = $this->db->select('*')
									  ->from('fonts')
									  ->join('tags', 'tags.id = fonts.id')
									  ->where('display >', '0')
									  ->order_by('display', 'desc')
									  ->get();
				break;
				default:
					$query = $this->db->get('fonts');
				break;
			}

            return $query->result_array();

        } else if ($slug === FALSE) {

			$query = $this->db->get('fonts');
            return $query->result_array();

		} else {

			$query = $this->db->get_where('fonts', array('slug' => $slug));
			return $query->row_array();

		}

        if ($query->num_rows() == 0) {
            show_404();
        }

    }

    /**
     * Retrieve top-rated combination.
	 *
     * @return array $top_combo
     */
    public function get_top_rated() {

        $query1 = $this->db->select('*')
                           ->from('rating')
                           ->join('fonts', 'fonts.id = rating.fid1')
                           ->order_by("score", "desc")
                           ->limit(3)
                           ->get();

        $query2 = $this->db->select('*')
                           ->from('rating')
                           ->join('fonts', 'fonts.id = rating.fid2')
						   ->join('samples', 'samples.id = fonts.sample_id')
                           ->order_by("score", "desc")
                           ->limit(3)
                           ->get();

        $top_combo = array();
		$i = 0;

		while ($i < $query1->num_rows()) {
			$top_combo[$i]['font1'] = $query1->row_array($i);
			$top_combo[$i]['font2'] = $query2->row_array($i);
			$i++;
		}

        return $top_combo;

    }

	/**
     * Retrieve a font's tags
	 *
     * @param int $id The font ID to search by.
	 *
     * @return array $query->result_array()
     */
	public function get_tags($id) {

		$query = $this->db->get_where('tags', array('id' => $id));
        if ($query->num_rows() == 0) {
            show_error('There were no tags returned', '500');
        }

		return $query->row_array();

	}

	/**
     * Retrieve the top tagged items.
	 *
     * @return array $list
     */
    public function get_top_tags() {

        $list['serifq']   = $this->db->select('*')
                                     ->from('tags')
                                     ->join('fonts', 'fonts.id = tags.id')
                                     ->order_by('serif', 'DESC')
                                     ->limit(3)
                                     ->get()
                                     ->result_array();
        $list['serifq']['type'] = "Serif";

        $list['sansq']    = $this->db->select('*')
                                     ->from('tags')
                                     ->join('fonts', 'fonts.id = tags.id')
                                     ->order_by('sans', 'DESC')
                                     ->limit(3)
                                     ->get()
                                     ->result_array();
        $list['sansq']['type'] = "Sans-serif";

        $list['slabq']    = $this->db->select('*')
                                     ->from('tags')
                                     ->join('fonts', 'fonts.id = tags.id')
                                     ->order_by('slab', 'DESC')
                                     ->limit(3)
                                     ->get()
                                     ->result_array();
        $list['slabq']['type'] = "Slab-serif";

        $list['monoq']    = $this->db->select('*')
                                     ->from('tags')
                                     ->join('fonts', 'fonts.id = tags.id')
                                     ->order_by('mono', 'DESC')
                                     ->limit(3)
                                     ->get()
                                     ->result_array();
        $list['monoq']['type'] = "Monotype";

        $list['scriptq']  = $this->db->select('*')
                                     ->from('tags')
                                     ->join('fonts', 'fonts.id = tags.id')
                                     ->order_by('script', 'DESC')
                                     ->limit(3)
                                     ->get()
                                     ->result_array();
        $list['scriptq']['type'] = "Script";

        $list['displayq'] = $this->db->select('*')
                                     ->from('tags')
                                     ->join('fonts', 'fonts.id = tags.id')
                                     ->order_by('display', 'DESC')
                                     ->limit(3)
                                     ->get()
                                     ->result_array();
        $list['displayq']['type'] = "Display";

        return $list;

    }

    /**
     * Add new fonts to the database.
	 *
     */
    public function set_font() {

        $data = $this->retrieve_list();

        if (empty($data)) {
            show_error('There were no fonts found', '500');
        }

        foreach ($data['items'] as $font) {

			// Before doing anything, check and see it has a
            // "regular" variant, and that it has a "latin" subset
            $subsets  = $font['subsets'];
            $variants = $font['variants'];

            if ((in_array('regular', $variants)) && (in_array('latin', $subsets))) {
                $name    = $font['family'];
                $lower   = strtolower($name);
                $slug    = url_title($lower);
                $api_url = url_title($name, '+');

                $data = array(
                    'name'    	=> $name,
                    'slug'    	=> $slug,
                    'api_url' 	=> $api_url,
					'sample_id' => '' // this space intentionally left blank
                );

                $query = $this->db->get_where('fonts', array('name' => $name));

                if ($query->num_rows() == 0) {
                    $this->db->insert('fonts', $data);
                }
            } else {
                next($font);
            }

        }

    }

    /**
     * Set tags in the database if there is no entry already.
	 *
     * @param int $id The ID to search for.
     */
    public function set_tags($id) {

        $query = $this->db->get_where('tags', array('id' => $id));

        if ($query->num_rows() == 0) {
            $this->db->insert('tags', array('id' => $id));
        } else {
            return false;
        }

    }

    /**
     * Update font records.
	 *
     * @param string $tags The tags to update.
	 */
    public function update_tags($tags) {

        // get the tags from the thingy
		$id = $tags['id'];

        // Run a query to see if there's an entry with the id already
        $query = $this->db->get_where('tags', array('id' => $id));

        // If there is, then update that record
        if ($query->num_rows() > 0) {
			$this->db->where('id', $id);

			foreach ($tags as $key => $value) {
				$update = $key;
			}

			$this->db->set($update, $update . ' +1', FALSE);
			$this->db->set('total', 'total +1', FALSE);
			$this->db->update('tags');

        } else {
            // otherwise insert a record (which should have already
			// been done in the set_tags() function)
			foreach ($tags as $key => $value) {
				if ($key !== "id") {
                    $tags[$key] = '1';
                }
            }

			$this->db->insert('tags', $tags);
        }

    }

    /**
     * Retrieve font combinations by best-rated.
	 *
     * @param int $id The ID to search by.
	 *
     * @return array $combo
     */
    public function retrieve_combinations($id) {

        // check the headers for the font we're looking at
		$hquery = $this->db->select('*')
				  		   ->from('rating')
						   ->order_by('score', 'DESC')
						   ->where(array('fid1' => $id))
						   ->limit(3)
						   ->get();

        // check the bodies for the font we're looking at
		$bquery = $this->db->select('*')
				  		   ->from('rating')
						   ->order_by('score', 'DESC')
						   ->where(array('fid2' => $id))
						   ->limit(3)
						   ->get();

		// Set up our combination array, ready to be returned later
		$combo = array();

        // if there is a positive on the header font, look for body font matches
        if ($hquery->num_rows() > 0) {
			foreach ($hquery->result() as $h_combo) {
				$fid2  = $h_combo->fid2;
				$score = $h_combo->score;

				if ($score > 0) {
					$bodyfont = $this->db->get_where('fonts', array('id' => $fid2));
					$bodyfont = $bodyfont->result();

					array_slice($bodyfont, 0, 3);

					foreach ($bodyfont as $comb) {
						$combo['ashead'][] = (array)$comb;
					}
				}
			}

        // if there is a positive on the body font, look for header font matches
        } if ($bquery->num_rows() > 0) {
            foreach ($bquery->result() as $b_combo) {
				$fid1  = $b_combo->fid1;
				$score = $b_combo->score;

				if ($score > 0) {
					$headfont = $this->db->get_where('fonts', array('id' => $fid1));
					$headfont = $headfont->result();

					array_slice($headfont, 0, 3);

					foreach ($headfont as $comb) {
						$combo['asbody'][] = (array)$comb;
					}
				}
			}
        } elseif (($hquery->num_rows() <= 0) && ($bquery->num_rows() <= 0)) {
		    return false;
		}

		return $combo;
    }

	/**
     * Associate a sample with a font.
	 *
     * @param int $id The ID to associate the sample with.
	 * @param int $random The random ID to get from the database.
     */
	public function sample_assoc($id, $random) {

		$query = $this->db->get_where('fonts', array('id' => $id));

		if ($query->num_rows() > 0) {

			$result = $query->result_array();
			if ($result[0]['sample_id'] == 0) {
				$this->db->where('id', $id)
						 ->update('fonts', array('sample_id' => $random));
			}

		}

	}

}
?>