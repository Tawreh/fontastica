<aside>
<h2>Your thoughts</h2>
<?php
	if ($rate && (count($rate) > 0)) {
		echo "<p>A few people have said they like this combination.</p>";
	} else {
        echo "<p>Oh cool, you've stumbled upon a combination nobody knows about!";
    }

    echo "<p>What do you think?</p>";

    $hidden = array('id1' => $fonts['id'], 'id2' => $font2['id']);

	echo form_open('fonts/' . $fonts['slug'] . '/' . $font2['slug'], '', $hidden);

	echo form_submit('like', 'I like this!');
	echo form_submit('hate', 'This sucks!');

	echo form_close();
?>

<h2>Faceoff!</h2>
<p><a href="/rate/faceoff/<?php echo $fonts['slug']; ?>/<?php echo $font2['slug']; ?>">Rate this combination against others!</a></p>

<h2>Combination view</h2>
<p>You're currently looking at <a href="/fonts/<?php echo $fonts['slug']; ?>"><?php echo $fonts['name']; ?></a> and <a href="/fonts/<?php echo $font2['slug']; ?>"><?php echo $font2['name']; ?></a>.</p>
</aside>