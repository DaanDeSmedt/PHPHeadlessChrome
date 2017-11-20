<?php 

require __DIR__ . '/../vendor/autoload.php';

use daandesmedt\PHPHeadlessChrome\HeadlessChrome;

$headlessChromer = new HeadlessChrome();
$headlessChromer->setBinaryPath('C:\Program Files (x86)\Google\Chrome\Application\chrome');
// or $headlessChromer = new HeadlessChrome(null,'C:\Program Files (x86)\Google\Chrome\Application\chrome');

$headlessChromer->setOutputDirectory(__DIR__);
$headlessChromer->setHTML('<h1>Headless Chrome PHP example</h1><h3>HTML to PDF</h3>');
$headlessChromer->toScreenShot('output.jpg');

print 'Screenshot saved to : ' . $headlessChromer->getFilePath();