<?php

class Rate_model extends CI_Model {

    public function __construct() {

        $this->load->database();

        $this->load->helper('url');

    }

    /**
     * Retrieve fonts from the database
     * 
     * @return array $query->result_array()
     */
    public function get_fonts() {

        $query = $this->db->get('fonts');
        return $query->result_array();

    }
    
    /* The following couple of functions are standard,
       reusable functions designed to be dropped in 
       whenever and wherever needed. */
    
    /**
     * Retrieve sample from the database
     * 
	 * @param int $id If set, lookup by a preset ID rather than random.
	 *
     * @return array $result
     */
    public function randomiser($id = FALSE) {

        $query  = $this->db->get('samples');
		if ($id == FALSE) {
			$max    = $query->num_rows();
			$arrkey = rand(1, $max);

			$result = $this->db->get_where('samples', array('id' => $arrkey));
		} else {
			$result = $this->db->get_where('samples', array('id' => $id));
		}

        $result = $result->result();

        return $result;

    }
    
    /**
     * Check URL to see which components it contains
     * 
     * @param string $url The URL to check.
     * 
     * @return array $id Position of the ID in the URL.
     */
    public function check_url($url) {
    
        $url   = explode('/', $url);
        $count = count($url);

        $id = array();

        if ($count < 4) { // just on the "rate" page
            return $id;
        } else if ($count > 4 && $count <= 6) { // rating with one fixed value
            if ($url[4] == '1') {
                $id['id1'] = $url[5];
            } else if ($url[4] == '2') {
                $id['id2'] = $url[5];
            } else {
                show_error('The first variable should be either \'1\' or \'2\'.', '500');
            }
            
            $id['pos'] = $url[4];

            return $id;
        } else if ($count > 6 && $count <= 8) { // rating with two fixed values
            return false;
        } else {
            return false;
        }
    
    }

    /**
     * Retrieve filler texts from a file and put into the database
     * Aesop's Fables from the Gutenberg Project
     * http://www.gutenberg.org/ebooks/18732
     */
    public function retrieve_filler() {

        $file = file_get_contents('./resources/18732-h.htm', 'r');

        if (!($file)) {
            show_404();
        } elseif ($file) {

            $query = $this->db->get('samples');
            
            if ($query->num_rows() == 0) {

                $entries = $this->parse_filler($file);
                
                foreach ($entries as $entry) {
                    $data = array(
                        'head' => $entry['head'],
                        'body' => $entry['body']
                    );

                    $this->db->insert('samples', $data);
                }

            } else {
                return false;
            }

        }

    }

    /**
     * Parse the filler to put it into the database. 
     * 
     * @param string $file The file to parse.
     * 
     * @return array $entries Array of entries ready to go into the database.
     */
    public function parse_filler($file) {

        $sections = preg_split("/<!-- -->/", $file);

        $i = 0;

        foreach ($sections as $section) {

            $parts = preg_split("/--/", $section);
            $entries[$i]['head'] = $parts[0];
            $entries[$i]['body'] = $parts[1];

            $i++;
        }

        return $entries;

    }
    
    /**
     * Reverse lookup: look up fonts by their name.
     * 
     * @param string $slug The slug to search by.
     * 
     * @return array $query->row_array()
     */
    public function reverse_lookup($slug) {

        $query = $this->db->get_where('fonts', array('slug' => $slug));

        return $query->row_array();
    
    }

    /**
     * Retrieve two random fonts. 
     * 
     * @param int $id1 The first ID to search for.
     * @param int $id2 The second ID to search for. 
     * 
     * @return array ($font1, $font2)
     */
    public function display_fonts($id1 = FALSE, $id2 = FALSE) {

        // This seems pretty gimmicky to me. Consider
        // sorting this so it only needs to be run once.

        // Random number
        $array   = $this->get_fonts();
        $max     = count($array);
        $max     = $max - 1; # Minus one: arrays start at 0

        if ($id1 === FALSE && $id2 === FALSE) {
            $id1 = rand(0, $max);
            $id2 = rand(0, $max);
        } elseif ($id1 !== FALSE && $id2 == FALSE) {
            $id1 = $id1;
            $id2 = rand(0, $max);
        } elseif ($id1 == FALSE && $id2 !== FALSE) {
            $id1 = rand(0, $max);
            $id2 = $id2;
        } elseif ($id1 !== FALSE && $id2 !== FALSE) {
            $id1 = $id1;
            $id2 = $id2;
        }

        // Get from get_fonts() where id = random number
        $query1 = $this->db->get_where('fonts', array('id' => $id1));
        $query2 = $this->db->get_where('fonts', array('id' => $id2));

        $font1  = $query1->row_array();
        $font2  = $query2->row_array();

        return array ($font1, $font2);

    }

    /**
     * Basic rating function
     * 
     * @param int $id1 The header font. 
     * @param int $id2 The body font.
     * @param string $opinion Set by $_POST, like or dislike.
     */
    public function do_rate($id1, $id2, $opinion) {

        $rating = array(
            'fid1'  => $id1,
            'fid2'  => $id2
        );

        // check to see if the record exists in the database 
        $check  = $this->db->get_where('rating', array('fid1' => $id1, 'fid2' => $id2));
        $number = $check->num_rows();

        if ($number > 0) {
            // if it does, score = score in database
            foreach ($check->result() as $result) {
                $score = $result->score;
            }
        } else {
            // otherwise, base score is 0
            $score = 0;
        }

        // Do some maths: 
        if ($opinion == "like") {
            // If the user liked it, add one to score
            $rating['score'] = $score + 1;
        } elseif ($opinion == "hate") {
            // If they hated it, minus one from the score
            $rating['score'] = $score - 1;
        }

        // Double check the result array: 
        if ($number > 0) {
            // If there was a result, update the record
            $this->db->update('rating', $rating, array('fid1' => $id1, 'fid2' => $id2));
        } else {
            // otherwise add a new one
            $this->db->insert('rating', $rating);
        }

    }

}

?>