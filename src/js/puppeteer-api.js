const puppeteer = require('puppeteer');

const requestParams = JSON.parse(process.argv[2]);

async function render() {
  const defaultParams = {
	cookies: [],
	scrollPage: false,
	emulateScreenMedia: true,
	ignoreHttpsErrors: false,
	html: null,
	viewport: {
	  width: 1024,
	  height: 1200,
	},
	goto: {
	  waitUntil: ['load', 'domcontentloaded', 'networkidle0', 'networkidle2']
	},
	pdf: {
	  format: 'A4',
      printBackground: true
    }
  };
  
  const params = Object.assign({}, defaultParams, requestParams);

  if (params.pdf.width && params.pdf.height) {
	  params.pdf.format = undefined;
  }

  const browser = await puppeteer.launch({
    ignoreHTTPSErrors: params.ignoreHttpsErrors,
    args: ['--disable-gpu', '--no-sandbox', '--disable-setuid-sandbox'],
  });
  const page = await browser.newPage();

  try {
    await page.setViewport(params.viewport);
    if (params.emulateScreenMedia) {
      await page.emulateMedia('screen');
    }
    params.cookies.map(async (cookie) => {
      await page.setCookie(cookie);
    });

    if (params.html) {
      await page.goto(`data:text/html,${params.html}`, params.goto);
    } else {
      await page.goto(params.url, params.goto);
    }

    await page.pdf(params.pdf);
  } catch (err) {
    throw err;
  } finally {
    await browser.close();
  }
}

render();