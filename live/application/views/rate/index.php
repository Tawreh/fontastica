<section>
<style type="text/css">
    h1.rate-title {
        font-family: <?php echo $fonts[0]['name']; ?>;
    }
    
    div.rate-body {
        font-family: <?php echo $fonts[1]['name']; ?>;
    }
</style>

<h1 class="rate-title" contenteditable="true"><?php echo $file[0]->head; ?></h1>

<div class="rate-body" contenteditable="true"><p><?php echo $file[0]->body; ?></p></div>
</section>