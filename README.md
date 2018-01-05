PHP Puppeteer
===========
This project provides the ability to generate PDF/PNG with [Puppeteer](https://github.com/GoogleChrome/puppeteer) in PHP

# Dependencies
The library is running based on [Nodejs](https://nodejs.org/en/)(7.6 above) and [Puppeteer](https://github.com/GoogleChrome/puppeteer)
It is tested under NodeJS 8.

Installation on CentOS 7:

```
sudo curl --silent --location https://rpm.nodesource.com/setup_8.x | sudo bash -
sudo yum install -y nodejs pango.x86_64 libXcomposite.x86_64 libXcursor.x86_64 libXdamage.x86_64 libXext.x86_64 libXi.x86_64 libXtst.x86_64 cups-libs.x86_64 libXScrnSaver.x86_64 libXrandr.x86_64 GConf2.x86_64 alsa-lib.x86_64 atk.x86_64 gtk3.x86_64 ipa-gothic-fonts xorg-x11-fonts-100dpi xorg-x11-fonts-75dpi xorg-x11-utils xorg-x11-fonts-cyrillic xorg-x11-fonts-Type1 xorg-x11-fonts-misc
sudo npm install --global --unsafe-perm puppeteer
sudo chmod -R o+rx /usr/lib/node_modules/puppeteer/.local-chromium
```

Installation on Ubuntu 16.04:

```
curl -sL https://deb.nodesource.com/setup_8.x | sudo -E bash -
sudo apt-get install -y nodejs gconf-service libasound2 libatk1.0-0 libc6 libcairo2 libcups2 libdbus-1-3 libexpat1 libfontconfig1 libgcc1 libgconf-2-4 libgdk-pixbuf2.0-0 libglib2.0-0 libgtk-3-0 libnspr4 libpango-1.0-0 libpangocairo-1.0-0 libstdc++6 libx11-6 libx11-xcb1 libxcb1 libxcomposite1 libxcursor1 libxdamage1 libxext6 libxfixes3 libxi6 libxrandr2 libxrender1 libxss1 libxtst6 ca-certificates fonts-liberation libappindicator1 libnss3 lsb-release xdg-utils wget
sudo npm install --global --unsafe-perm puppeteer
sudo chmod -R o+rx /usr/lib/node_modules/puppeteer/.local-chromium
```

# Installation
Install `its404/php-puppeteer` using Composer.
~~~
composer require its404/php-puppeteer
~~~
# Usage
## Parameters
The library has set some default parameter values to support basic features, you can set the customized parameters to override the default ones, it supports all parameters of [Puppeteer API](https://github.com/GoogleChrome/puppeteer/blob/master/docs/api.md)

__Sample parameter array:__

~~~
$pamaters = [
	"url" => "https://google.com",
	"displayHeaderFooter" => true,
	"margin" => [
		'top' => '10mm',
     	'right' => '10mm',
     	'bottom' => '10mm',
     	'left' => '10mm',
	],
	"printBackground" => true
];
~~~

## Import
You need to import this namespace at the top of your PHP class

~~~
use Its404\PhpPuppeteer\Browser;
~~~


__PDF by URL__

You can generate PDF by URL through `pdf` function:

~~~
	public function actionTest1()
    {
        $params = [
            "url" => "https://www.highcharts.com/demo/line-basic",
        ];
        $browser = new Browser();
        $browser->isDebug = true;
        $content = $browser->pdf($params);
        
        header("Content-type:application/pdf");
        echo $content;
    }
~~~

You can set any parameter in `$params` to override the default values

__PDF by HTML__

You can generate PDF by html code through `pdf` function:

~~~
	public function actionTest2()
    {
        $params = [
            "html" => "<h1>Hello Wolrd</h1>"
        ];
        $browser = new Browser();
        $content = $browser->pdf($params);
        
        header("Content-type:application/pdf");
        echo $content;
    }
~~~
> **Debug** The class `Browser` has one parameter `$isDebug`, it would be debug mode if it's `true`, detailed error messages would be returned from `pdf` function if an error happened during Puppeteer running.



