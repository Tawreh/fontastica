<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>fontasti.ca - <?php if (isset($title)) { echo $title; } else { echo "Rate and tag fonts woo hoo"; } ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="/themes/base/css/normalize.css">
		<!-- change that to .min.css when you've finished editing normalise!!! -->
        <link rel="stylesheet" href="/themes/base/css/main.css">

        <script src="/themes/base/js/vendor/modernizr-2.6.1.min.js"></script>

		<!-- Typekit -->
		<script type="text/javascript" src="//use.typekit.net/rhy7iii.js"></script>
		<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

        <?php include_once("styles.php") ?>
    </head>

	<body>
    <?php include_once("analytics.php") ?>
		<header>
			<p class="logo"><a href="/"><img src="/themes/global/images/logo_small_w.png" alt="fontastica" /></a></p>
            <div id="search" role="search">
                <?php include_once("searchform.php") ?>
            </div>
			<nav role="nav">
				<ul>
					<li> <a href="/fonts">fonts</a> </li>
					<li> <a href="/rate">rate</a> </li>
                    <li> <a href="/about">about</a> </li>
				</ul>
			</nav>
		</header>

		<div id="wrap">
