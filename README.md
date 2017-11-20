PHPHeadlessChrome
===============

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
// or $headlessChromer = new HeadlessChrome('http://www.google.be','C:\Program Files (x86)\Google\Chrome\Application\chrome');

$headlessChromer->setOutputDirectory(__DIR__);
$headlessChromer->toPDF('output.pdf');

print 'PDF generated to : ' . $headlessChromer->getFilePath();
```