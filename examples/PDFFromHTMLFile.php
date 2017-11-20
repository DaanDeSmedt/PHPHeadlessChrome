<?php 

require __DIR__ . '/../vendor/autoload.php';

use daandesmedt\PHPHeadlessChrome\HeadlessChrome;

$headlessChromer = new HeadlessChrome();
$headlessChromer->setBinaryPath('C:\Program Files (x86)\Google\Chrome\Application\chrome');
// or $headlessChromer = new HeadlessChrome(null,'C:\Program Files (x86)\Google\Chrome\Application\chrome');

$headlessChromer->setOutputDirectory(__DIR__);
$headlessChromer->setHTMLFile(__DIR__ . '\assets\HTMLFile.html');
$headlessChromer->toPDF('output.pdf');

print 'PDF generated to : ' . $headlessChromer->getFilePath();