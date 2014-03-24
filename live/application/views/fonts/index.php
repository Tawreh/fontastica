<section>
<h1>Font list</h1>

<?php echo $pages; ?>

<?php foreach ($fonts as $font): ?>

    <h2><a href="/fonts/<?php echo $font['slug']; ?>"><?php echo $font['name']; ?></a></h2>
    <p style="font-family: <?php echo $font['name']; ?>;" contenteditable="true"><?php echo $paragraph; ?></p>

<?php endforeach; ?>

<?php echo $pages; ?>
</section>