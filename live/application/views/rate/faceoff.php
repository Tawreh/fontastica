<style type="text/css">
    h2.rate-title-1 { font-family: <?php echo $fonts['stuck'][0]['name']; ?>; }
    p.rate-body-1 { font-family: <?php echo $fonts['stuck'][1]['name']; ?>; }

    h2.rate-title-2 { font-family: <?php echo $fonts['ref'][0]['name']; ?>; }
    p.rate-body-2 { font-family: <?php echo $fonts['ref'][1]['name']; ?>; }
</style>

<?php include_once('rate_header.php'); ?>

<div class="half">
<h2 class="rate-title-1"><?php echo $file[0]->head; ?></h2>
<p class="rate-body-1"><?php echo $file[0]->body; ?></p>
<p class="small">Set in <strong><a href="/fonts/<?php echo $fonts['stuck'][0]['slug']; ?>"><?php echo $fonts['stuck'][0]['name']; ?></a></strong> and <strong><a href="/fonts/<?php echo $fonts['stuck'][1]['slug']; ?>"><?php echo $fonts['stuck'][1]['name']; ?></a></strong>.
<a href="/fonts/<?php echo $fonts['stuck'][0]['slug']; ?>/<?php echo $fonts['stuck'][1]['slug']; ?>">View separately.</a></p>
</div>

<div class="half">
<h2 class="rate-title-2"><?php echo $file[0]->head; ?></h2>
<p class="rate-body-2"><?php echo $file[0]->body; ?></p>
<p class="small">Set in <strong><a href="/fonts/<?php echo $fonts['ref'][0]['slug']; ?>"><?php echo $fonts['ref'][0]['name']; ?></a></strong> and <strong><a href="/fonts/<?php echo $fonts['ref'][1]['slug']; ?>"><?php echo $fonts['ref'][1]['name']; ?></a></strong>.
<a href="/fonts/<?php echo $fonts['ref'][0]['slug']; ?>/<?php echo $fonts['ref'][1]['slug']; ?>">View separately.</a></p>
</div>