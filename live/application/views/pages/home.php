<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>fontasti.ca - <?php if ($title) { echo $title; } else { echo "Fontasti.ca"; } ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="/themes/base/css/normalize.css">
		<!-- change that to .min.css when you've finished editing normalise!!! -->
        <link rel="stylesheet" href="/themes/base/css/front.css">

        <script src="/themes/base/js/vendor/modernizr-2.6.1.min.js"></script>
        <script src="/themes/base/js/jquery-1.9.1.min.js"></script>
        <script src="/themes/base/js/main.js"></script>
		
		<!-- Typekit -->
		<script type="text/javascript" src="//use.typekit.net/rhy7iii.js"></script>
		<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
        
        <script type="text/javascript">
          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-36656904-1']);
          _gaq.push(['_setDomainName', 'fontasti.ca']);
          _gaq.push(['_trackPageview']);
          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();

        </script>
    </head>
	
	<body>
    
        <div class="wrap">
            <img src="/themes/global/images/logo_half_w.png" />
            <p class="tagline">the fantastic font finder</p>
            <h1>where would you like to begin?</h1>
            <nav>
                <ul>
                    <li><a class="intronav" href="/rate">rate combinations</a></li>
                    <li><a class="intronav" href="/fonts">browse fonts</a></li>
                </ul>
            </nav>
        </div>
        
        <div id="footer">
            <p>Copyright &copy; 2012-<?php echo date('Y'); ?> Sophie Shanahan-Kluth.</p>
        </div>

    </body>
</html>