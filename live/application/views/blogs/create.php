<h1>Add blog</h1>
<div class="newblog">
<?php 
	echo validation_errors();
	echo form_open('blog/create');
	
	echo form_label('Title', 'title');
	echo form_input('title', '');
	
	echo "<br />";
	
	echo form_label('Body', 'body');
	echo form_textarea('body', '');
	
	echo "<br />";
	
	echo form_label('Summary', 'summary');
	echo form_textarea('summary', '');
	
	echo "<br />";
	
	echo form_label('Immediately visible?', 'visible');
	echo form_checkbox('visible', 'visible', TRUE);
	
	echo "<br />";
	
	echo form_submit('submit', 'Add blog');
	
	echo form_close();
?>
</div>