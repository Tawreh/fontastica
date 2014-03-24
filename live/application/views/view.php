<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $font['api_url']; ?>">

<h1 style="font-family: '<?php echo $font['name']; ?>'"><?php echo $font['name']; ?></h1>
<p>there will follow a paragraph all about <strong><?php echo $font['name']; ?></strong> here.</p>

<?php echo form_open('fonts/add_tags'); ?>

	<label for="tags">Tags</label>
	<input type="checkbox" name="serif" value="serif" />Serif<br>
	<input type="checkbox" name="sans-serif" value="sans-serif" />
	
	<input type="submit" name="submit" value="Update tags" />

</form>

<blockquote style="overflow: auto; height: 250px;">
<pre><?php print_r($font); ?></pre>
</blockquote>