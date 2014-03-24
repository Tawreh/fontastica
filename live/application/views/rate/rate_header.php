<div class="rateheader">
<?php
    $name_1  = $fonts['stuck'][0]['slug'];
    $name_2  = $fonts['stuck'][1]['slug'];
	$name_3  = $fonts['ref'][0]['slug'];
    $name_4  = $fonts['ref'][1]['slug'];

    $stuck_1 = $fonts['stuck'][0]['id'];
    $stuck_2 = $fonts['stuck'][1]['id'];
    $ref_1   = $fonts['ref'][0]['id'];
    $ref_2   = $fonts['ref'][1]['id'];

    $hidden = array(
        'combo1' => array(
            'id1' => $stuck_1,
            'id2' => $stuck_2
        ),
        'combo2' => array(
            'id1' => $ref_1,
            'id2' => $ref_2,
			'slug1' => $name_3,
			'slug2' => $name_4
        )
    );

    if ($exist && $exist == TRUE) {
        echo form_open('rate/faceoff/' . $name_1 . '/' . $name_2, '', $hidden);
    } else {
        echo form_open('rate', '', $hidden);
    }

	echo "<div class=\"twofifths\">";
    echo form_submit('left', 'I prefer this one!');
	echo "</div><div class=\"onefifth\">";
    echo form_submit('eh', 'Load something different.');
	echo "</div><div class=\"twofifths\">";
    echo form_submit('right', 'I prefer this one!');
	echo "</div>";

    echo form_close();
?>
</div>