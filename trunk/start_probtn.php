<?php
header("content-type: application/javascript");
?>
jQuery(document).ready(function() {
	jQuery(document).StartButton({
		"mainStyleCss": "https://pizzabtn.herokuapp.com/stylesheets/probtn.css",
		"jqueryPepPath": "<?php echo $_GET["jqueryPepPath"]; ?>",
	});
});
