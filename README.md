PHPHeadlessChrome
===============

[![Latest Stable Version](https://poser.pugx.org/daandesmedt/phpheadlesschrome/v/stable)](https://packagist.org/packages/daandesmedt/phpheadlesschrome)
[![Total Downloads](https://poser.pugx.org/daandesmedt/phpheadlesschrome/downloads)](https://packagist.org/packages/daandesmedt/phpheadlesschrome)
[![License](https://poser.pugx.org/daandesmedt/phpheadlesschrome/license)](https://packagist.org/packages/daandesmedt/phpheadlesschrome)


Headless Chrome is shipping in Chrome 59. It's a way to run the Chrome browser in a headless environment. Essentially, running Chrome without chrome! It brings all modern web platform features provided by Chromium and the Blink rendering engine to the command line.

PHPHeadlessChrome provides a simple usage helper class to create PDF and / or screenshots using Headless Chrome.
Trigger PDF / Screenshots generation from local file / URL.

In order to use this PHPHeadlessChrome helper make sure Google Chrome is correctly installer from version 59 and onwards.


## Installation

Install the package through [composer](http://getcomposer.org):

```
composer require daandesmedt/phpheadlesschrome
```

Make sure, that you include the composer [autoloader](https://getcomposer.org/doc/01-basic-usage.md#autoloading) somewhere in your codebase.


## Usage

Use the `PHPHeadlessChrome` tool when you want to convert a webpage / HTML text or (local) HTML file to a PDF or image screenshot.


## Working examples

Working examples can be found in the `examples` folder.


## Webpage (URL) to PDF

```php
<?php 

require __DIR__ . '/../vendor/autoload.php';

use daandesmedt\PHPHeadlessChrome\HeadlessChrome;

$headlessChromer = new HeadlessChrome();
$headlessChromer->setUrl('http://www.google.be');
$headlessChromer->setBinaryPath('C:\Program Files (x86)\Google\Chrome\Application\chrome');
$headlessChromer->setOutputDirectory(__DIR__);
$headlessChromer->toPDF('output.pdf');

print 'PDF generated to : ' . $headlessChromer->getFilePath();
```


## Webpage (URL) to Screenshot (image)

```php
<?php 

require __DIR__ . '/../vendor/autoload.php';

use daandesmedt\PHPHeadlessChrome\HeadlessChrome;

$headlessChromer = new HeadlessChrome();
$headlessChromer->setUrl('http://www.google.be');
$headlessChromer->setBinaryPath('C:\Program Files (x86)\Google\Chrome\Application\chrome');
$headlessChromer->setOutputDirectory(__DIR__);
$headlessChromer->toScreenShot('output.jpg');

print 'Screenshot saved to : ' . $headlessChromer->getFilePath();
```


## HTML (String) to PDF

```php
<?php 

require __DIR__ . '/../vendor/autoload.php';

use daandesmedt\PHPHeadlessChrome\HeadlessChrome;

$headlessChromer = new HeadlessChrome();
$headlessChromer->setBinaryPath('C:\Program Files (x86)\Google\Chrome\Application\chrome');
$headlessChromer->setOutputDirectory(__DIR__);
$headlessChromer->setHTML('<h1>Headless Chrome PHP example</h1><h3>HTML to PDF</h3>');
$headlessChromer->toPDF('output.pdf');

print 'PDF generated to : ' . $headlessChromer->getFilePath();
```


## HTML (String) to Screenshot (image)

```php
<?php 

require __DIR__ . '/../vendor/autoload.php';

use daandesmedt\PHPHeadlessChrome\HeadlessChrome;

$headlessChromer = new HeadlessChrome();
$headlessChromer->setBinaryPath('C:\Program Files (x86)\Google\Chrome\Application\chrome');
$headlessChromer->setOutputDirectory(__DIR__);
$headlessChromer->setHTML('<h1>Headless Chrome PHP example</h1><h3>HTML to PDF</h3>');
$headlessChromer->toScreenShot('output.jpg');

print 'Screenshot saved to : ' . $headlessChromer->getFilePath();
```



## HTML local file to PDF

```php
<?php 

require __DIR__ . '/../vendor/autoload.php';

use daandesmedt\PHPHeadlessChrome\HeadlessChrome;

$headlessChromer = new HeadlessChrome();
$headlessChromer->setBinaryPath('C:\Program Files (x86)\Google\Chrome\Application\chrome');
$headlessChromer->setOutputDirectory(__DIR__);
$headlessChromer->setHTMLFile(__DIR__ . '\assets\HTMLFile.html');
$headlessChromer->toPDF('output.pdf');

print 'PDF generated to : ' . $headlessChromer->getFilePath();
```


## HTML local file to Screenshot (image)

```php
<?php 

require __DIR__ . '/../vendor/autoload.php';

use daandesmedt\PHPHeadlessChrome\HeadlessChrome;

$headlessChromer = new HeadlessChrome();
$headlessChromer->setBinaryPath('C:\Program Files (x86)\Google\Chrome\Application\chrome');
$headlessChromer->setOutputDirectory(__DIR__);
$headlessChromer->setHTMLFile(__DIR__ . '\assets\HTMLFile.html');
$headlessChromer->toScreenShot('output.jpg');

print 'Screenshot saved to : ' . $headlessChromer->getFilePath();
```


## Set mobile mode

```php
$headlessChromer->useMobile();
```

## Set window size

```php
$headlessChromer->setWindowSize(375, 667);
```