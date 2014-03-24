<?php 

/*
 * A file to load the right stylesheets into the body. 
 */

// debugging, sigh
// echo "<pre>";
// print_r($fonts);
// echo "</pre>";
 
if (isset($fonts)) {

    if (count($fonts) == 5) {
        echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://fonts.googleapis.com/css?family=" . $fonts['api_url'] . "\">";
        echo "\n";
    } else if (count($fonts) == 2) {
        foreach ($fonts as $combo) {
            if ((is_array($combo)) && (array_key_exists('stuck', $fonts))) {
				foreach ($combo as $font) {
                    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://fonts.googleapis.com/css?family=" . $font['api_url'] . "\">";
                    echo "\n";
                }
            } else if (array_key_exists('font1', $fonts)) {
				foreach ($combo as $font) {
                    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://fonts.googleapis.com/css?family=" . $font['api_url'] . "\">";
                    echo "\n";
                }
			} else {
                echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://fonts.googleapis.com/css?family=" . $combo['api_url'] . "\">";
                echo "\n";
            }
        }
    } else if (count($fonts) > 5) {
		foreach ($fonts as $font) {
			echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://fonts.googleapis.com/css?family=" . $font['api_url'] . "\">";
			echo "\n";
		}

	} else if (array_key_exists('font2', $fonts[0])) {
		foreach ($fonts as $font) {
			echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://fonts.googleapis.com/css?family=" . $font['font1']['api_url'] . "\">";
			echo "\n";
			echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://fonts.googleapis.com/css?family=" . $font['font2']['api_url'] . "\">";
			echo "\n";
		}
	}

}

if (isset($font2)) {

    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://fonts.googleapis.com/css?family=" . $font2['api_url'] . "\">";
    echo "\n";

}

if (isset($results)) {

	foreach ($results as $result) {
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://fonts.googleapis.com/css?family=" . $result['api_url'] . "\">";
		echo "\n";
	}

}


?>