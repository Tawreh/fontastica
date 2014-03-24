<h1>Stats</h1>

<h2>Top-rated combinations</h2>
<?php
	foreach ($fonts as $combo) { ?>
		<h3 class="headline" style="font-family: '<?php echo $combo['font1']['name']; ?>';"><?php echo $combo['font2']['head']; ?></h3>
		<p class="body" style="font-family: '<?php echo $combo['font2']['name']; ?>';"><?php echo $combo['font2']['body']; ?></p>
		
		<p class="info">Set in <strong><?php echo $combo['font1']['name']; ?></strong> and <strong><?php echo $combo['font2']['name']; ?></strong>. 
		<a href="/fonts/<?php echo $combo['font1']['slug']; ?>/<?php echo $combo['font2']['slug']; ?>">Have your say</a>.</p>

<?php
	}
?>

<h2>Browse by tag</h2>

<?php
	echo form_open('fonts', array('id' => 'sortform'));

    echo "<p>";
	echo form_submit("serif", "Serif fonts");
	echo form_submit("sans", "Sans-serif fonts");
	echo form_submit("slab", "Slab-serif fonts");
	echo form_submit("monotype", "Monotype fonts");
	echo form_submit("script", "Script fonts");
	echo form_submit("display", "Display fonts");
	echo "</p>";

	echo form_close();
?>