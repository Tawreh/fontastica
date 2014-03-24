<h1>Search results</h1>

<?php
if (count($results) > 0) { ?>
<p>The following fonts matched your query:</p>
<?php } else { ?>
<p>There were no fonts that matched your query. Try again.</p>
<?php } ?>

<?php foreach ($results as $result) { ?>

	<div class="result">
		<h2><a href="/fonts/<?php echo $result['slug']; ?>"><?php echo $result['name']; ?></a></h2>
		<p style="font-family: '<?php echo $result['name']; ?>';"><?php echo $demo; ?></p>
	</div>

<? } ?>

<?php #include_once('advsearch.php'); ?>