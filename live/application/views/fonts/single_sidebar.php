<aside>
<h2>Font information</h2>

<p><?php
	echo form_open('fonts/' . $fonts['slug'], array('id' => 'tagform'));

	foreach ($tags as $onetag => $count) {
		if (($onetag != "id") && ($onetag != "total")) {
			$title = ucfirst($onetag) . " (" . $count . ")";

			echo form_submit($onetag, $title);
		}
	}

	echo form_close();
?></p>

<p><strong><?php echo $fonts['name']; ?></strong> is available from <a href="http://google.com/webfonts">Google Webfonts</a>. <a href="#" id="clicktosee">Click to grab the CSS.</a></p>
<div id="stylewrap">
    <div id="styling"><?php include_once('single_styling.php'); ?></div>
</div>

<h2>Rate this</h2>
<p><a href="/rate/1/<?php echo $fonts['id']; ?>">As a headline</a> or 
<a href="/rate/2/<?php echo $fonts['id']; ?>">as body text</a>.</p>

<?php
	if ($rate && (count($rate) > 0)) {
        echo "<h2>Suggestions</h2>";

		if (array_key_exists('ashead', $rate) && (count($rate['ashead']) > 0)) {
			echo "<p>If you like this as a headline, try these fonts for the body:</p>";
			echo "<ul>";
			foreach ($rate['ashead'] as $bodyfont) {
				echo "<li>";
				echo "<a href=\"/fonts/" . $fonts['slug'] . "/" . $bodyfont['slug'] . "\">" . $bodyfont['name'] . "</a>";
				echo "</li>";
			}
			echo "</ul>";
		}

		if (array_key_exists('asbody', $rate) && (count($rate['asbody']) > 0)) {
			echo "<p>If you like this as body text, try these headline fonts:</p>";
			echo "<ul>";
			foreach ($rate['asbody'] as $headfont) {
				echo "<li>";
				echo "<a href=\"/fonts/" . $headfont['slug'] . "/" . $fonts['slug'] . "\">" . $headfont['name'] . "</a>";
				echo "</li>";
			}
			echo "</ul>";
		}
	} 
?>

</aside>