PHP-Puppeteer Font Example
===========
Here is an example to show how to apply different font-families for html elements

# Explanations
The example is developed based on [Yii2](https://github.com/yiisoft/yii2), but I think it's easy to understand and convert to your own PHP code.

# Controller/Action
```php
use Its404\PhpPuppeteer\Browser;

public function actionPdf()
{
	$params = [
		"html" => $this->renderPartial("font")	// get html code from font.php
	];
	$browser = new Browser();
	$browser->isDebug = true;
	$content = $browser->pdf($params);
	
	header("Content-type:application/pdf");
	echo $content;
}
```
# HTML page
In `font.php`, 3 kind of font files are imported
+ Google fonts
+ Font file from Internet
+ Font file from local web server(apache)

```
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
```

# Output
Here is the [output PDF file](https://github.com/its404/php-puppeteer/blob/master/examples/font-example/font.pdf)

# Troubleshooting

### 1. Couldn't load font file from local apache web server
If you couldn't load font file from local apache web server, please put below configuration into your `.htaccess` file:
`Access-Control-Allow-Origin "*"` allows you to access all resources and webfonts from all domains.
```
<IfModule mod_headers.c>
  <FilesMatch "\.(ttf|ttc|otf|eot|woff|woff2|font.css|css|js)$">
    Header set Access-Control-Allow-Origin "*"
  </FilesMatch>
</IfModule>
```
__Reference__: http://crunchify.com/how-to-fix-access-control-allow-origin-issue-for-your-https-enabled-wordpress-site-and-maxcdn/

