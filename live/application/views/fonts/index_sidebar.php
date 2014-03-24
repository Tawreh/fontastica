<aside>
<h2>Show me..</h2>
<?php
	echo form_open('fonts', array('id' => 'sortform'));

	echo "<p>";
	// echo form_submit("top", "Top rated");
	echo form_submit("az", "A-Z");
	echo form_submit("za", "Z-A");
	echo "</p>";
	
	echo "<p>";
	echo form_submit("serif", "Serif fonts");
	echo form_submit("sans", "Sans-serif fonts");
	echo form_submit("slab", "Slab-serif fonts");
	echo form_submit("monotype", "Monotype fonts");
	echo form_submit("script", "Script fonts");
	echo form_submit("display", "Display fonts");
	echo "</p>";
	
	// echo "<p>";
	// echo form_submit("wildcard", "Show me anything!");
	// echo "</p>";

	echo form_close();
?>
<p class="small"><strong>Remember!</strong> Anyone can tag fonts however they like, so you might notice a few in the "wrong section". If you think they're really, <em>really</em> out of place, <a href="mailto:ssk@herbal-jazz.net">drop me a line.</a></p>
</aside>