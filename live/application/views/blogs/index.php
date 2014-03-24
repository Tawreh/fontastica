<h1><?php echo $title; ?></h1>

<?php foreach ($blogs as $blog): ?>
	<h2><?php echo $blog['title']; ?></h2>
	<p><?php echo $blog['summary']; ?></p>
	<p><a href="/blog/<?php echo $blog['slug']; ?>">Read more</a></p>
<?php endforeach; ?>