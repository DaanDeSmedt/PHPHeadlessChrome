<?php 

require __DIR__ . '/../vendor/autoload.php';

use daandesmedt\PHPHeadlessChrome\HeadlessChrome;

$headlessChromer = new HeadlessChrome();
$headlessChromer->setUrl('http://www.google.be');
$headlessChromer->setBinaryPath('C:\Program Files (x86)\Google\Chrome\Application\chrome');
// or $headlessChromer = new HeadlessChrome('http://www.google.be','C:\Program Files (x86)\Google\Chrome\Application\chrome');

$headlessChromer->setOutputDirectory(__DIR__);
$headlessChromer->setWindowSize(375, 667);
$headlessChromer->toPDF('output.pdf');

print 'PDF generated to : ' . $headlessChromer->getFilePath();