<h2>Add a font</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('fonts/create'); ?>

	<label for="name">Name</label>
	<input type="text" name="name" /><br />

	<input type="submit" name="submit" value="Add font" />

</form>