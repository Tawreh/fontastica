<?php

    echo form_open('search', array('id' => 'searchform'));

    echo form_label('Term', 'search');
    echo form_input('search', '');

    echo form_submit('submit', 'Search');

    echo form_close();

?>