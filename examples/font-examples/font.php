<?php 

use app\assets\AppAsset;

$asset = AppAsset::register($this);
?>
<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
        @font-face {
          font-family: 'Gloria Hallelujah';
          font-style: normal;
          font-weight: 400;
          src: local('Gloria Hallelujah'), local('GloriaHallelujah'), url(https://fonts.gstatic.com/s/gloriahallelujah/v9/CA1k7SlXcY5kvI81M_R28cNDay8z-hHR7F16xrcXsJw.woff2) format('woff2');
          unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2212, U+2215;
        }
        @font-face {
          font-family: 'Arial Local';
          font-style: normal;
          font-weight: 400;
          src: url(http://yii2-app.test<?= $asset->baseUrl?>/css/font/arial.ttf);
        }
	</style>
	<link href="https://fonts.googleapis.com/css?family=Abril+Fatface" rel="stylesheet">
	<link href="http://yii2-app.test<?= $asset->baseUrl?>/css/pdf.css" rel="stylesheet">
</head>
<body>
	<h1>
		Hi, How are you?
	</h1>
	<h2>
		Hi, How are you?
	</h2>
	<h3>
		Hi, How are you?
	</h3>
	<h4>
		Hi, How are you?
	</h4>
	<p class="arial-font">
		Hi, How are you?
	</p>	
	<p class="default-font">
		Hi, How are you?
	</p>
</body>

</html>