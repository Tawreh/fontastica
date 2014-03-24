<aside>
    <div class="arrow"></div>
    <div class="callout">
        <h2>What do you think?</h2>
        <?php
            $hidden = array('id1' => $fonts[0]['id'], 'id2' => $fonts[1]['id']);

            if ($exist && $exist == TRUE) {
                echo form_open('rate/' . $pos . '/' . $id, '', $hidden);
            } else {
                echo form_open('rate', '', $hidden);
            }

            echo form_submit('like', 'I like this!');
            echo form_submit('hate', 'This sucks!');

            echo form_close();
        ?>
    </div>

    <h2>Font information</h2>
    <p>The demo headline is set in <strong><a href="/fonts/<?php echo $fonts[0]['slug']; ?>"><?php echo $fonts[0]['name']; ?></a></strong>.<br />
    The body is set in <strong><a href="/fonts/<?php echo $fonts[1]['slug']; ?>"><?php echo $fonts[1]['name']; ?></a></strong>.</p>

    <h2>Faceoff!</h2>
    <p>Like this? Want to compare it to other combinations? <a href="/rate/faceoff/<?php echo $fonts[0]['slug']; ?>/<?php echo $fonts[1]['slug']; ?>">Try the faceoff!</a></p>

    <h2>Get the CSS</h2>
    <p><a href="#" id="clicktosee">Click to grab the CSS for this combination!</a></p>
    <div id="stylewrap">
        <div id="styling"><?php include_once('rate_styling.php'); ?></div>
    </div>

    <h2 class="small">Did you know?</h2>
    <p class="small">You can edit the sample text if you want! Just click and modify it to try out your own text.</p>
</aside>