<p>Use the following code to add this combination to your site:</p>
<p>In your &lt;head&gt; tag:</p>
<blockquote>
    <pre>&lt;link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $fonts[0]['api_url']; ?>"&gt;
&lt;link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $fonts[1]['api_url']; ?>"&gt;</pre>
</blockquote>
    
<p>In your CSS:</p>
<blockquote>
    <pre>h1 {
    font-family: '<?php echo $fonts[0]['name']; ?>';
}

body, p {
    font-family: '<?php echo $fonts[1]['name']; ?>';
}</pre>
</blockquote>