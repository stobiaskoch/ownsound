
<!doctype html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" href="horizontal.css">
	<script src="modernizr.js"></script>
</head>
<body>

			<div class="scrollbar">
				<div class="handle">
					<div class="mousearea"></div>
				</div>
			</div>

			<div class="frame effects" id="effects">
				<ul class="clearfix">
				<?php
				for ($i = 1; $i <= 200; $i++) { ?>
				<li><img src='../get.php?picid=<?php echo $i; ?>' width="196px" style="padding-left: 18px; padding-bottom:8px;"></li>
				<?php }
				?>
				</ul>
			</div>

		
			<!-- Scripts -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="sly.min.js"></script>
	<script src="horizontal.js"></script>