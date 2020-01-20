<?php

use daandesmedt\PHPHeadlessChrome\HeadlessChrome;
use PHPUnit\Framework\TestCase;

final class HeadlessChromeTestSuite extends TestCase
{

    protected $binaryPath = 'C:\Program Files (x86)\Google\Chrome\Application\chrome.exe';
    protected $url = 'http://www.google.be';
    protected $ouputDirectory = 'C:/output/headlesschrome';


    public function testConstructor()
    {
        $headlessChromer = new HeadlessChrome($this->url, $this->binaryPath);
        $this->assertEquals($this->url, $headlessChromer->getUrl());
        $this->assertEquals($this->binaryPath, $headlessChromer->getBinaryPath());
    }


    public function testSetBinaryPath()
    {
        $headlessChromer = new HeadlessChrome();
        $headlessChromer->setBinaryPath($this->binaryPath);
        $this->assertEquals($this->binaryPath, $headlessChromer->getBinaryPath());
    }


    public function testSetURL()
    {
        $headlessChromer = new HeadlessChrome();
        $headlessChromer->setUrl($this->url);
        $this->assertEquals($this->url, $headlessChromer->getUrl());
    }


    public function testSetOutputDirectory()
    {
        $headlessChromer = new HeadlessChrome();
        $headlessChromer->setOutputDirectory($this->ouputDirectory);
        $this->assertEquals(realpath($this->ouputDirectory), $headlessChromer->getOutputDirectory());
    }


    public function testSetArguments()
    {
        $arguments = [
            '--headless' => '',
            '--disable-gpu' => '',
            '--argument' => '',
            '----extra-argument=' => 'test-value'
        ];
        $headlessChromer = new HeadlessChrome();
        $headlessChromer->setArguments($arguments);
        foreach ($arguments as $argument => $value) {
            $this->assertArrayHasKey($argument, $headlessChromer->getArguments());
            $this->assertEquals($value, $headlessChromer->getArguments()[$argument]);
        }
    }


    public function testSetArgumentsEmpty()
    {
        $arguments = [
            '' => '',
            ' ' => '  ',
            ' ' => ' =',
            ' --argument-with-value' => ' ='
        ];
        $headlessChromer = new HeadlessChrome();
        $count = count($headlessChromer->getArguments());
        $headlessChromer->setArguments($arguments);
        $this->assertCount($count + 2, $headlessChromer->getArguments());
    }


    public function testSetArgument()
    {
        $arguments = [
            '--headless' => '',
            '--disable-gpu' => '',
            '--incognito' => '',
            '--enable-viewport' => '',
            '--added-argument=' => 'value',
        ];
        $headlessChromer = new HeadlessChrome();
        $headlessChromer->setArgument('--added-argument', 'value');
        foreach ($arguments as $argument => $value) {
            $this->assertArrayHasKey($argument, $headlessChromer->getArguments());
            $this->assertEquals($value, $headlessChromer->getArguments()[$argument]);
        }
    }


    public function testWindowSize()
    {
        $headlessChromer = new HeadlessChrome();
        $headlessChromer->setWindowSize(1024, 2048);
        $this->assertEquals('1024,2048', $headlessChromer->getArguments()['--window-size=']);
    }


    public function testSetHTML()
    {
        $HTML = 'test HTML content';
        $headlessChromer = new HeadlessChrome();
        $headlessChromer->setHTML($HTML);
        $this->assertEquals('data:text/html,' . rawurlencode($HTML), $headlessChromer->getUrl());
    }


    public function testSetHTMLFile()
    {
        $filePath = __DIR__ . '\..\examples\assets\HTMLFile.html';
        $headlessChromer = new HeadlessChrome();
        $headlessChromer->setHTMLFile($filePath);
        $this->assertEquals("file://$filePath", $headlessChromer->getUrl());
    }

    public function testSetHTMLFileException()
    {
        $filePath = __DIR__ . '\HTMLFile.html';
        $headlessChromer = new HeadlessChrome();
        $this->setExpectedException(Exception::class);
        $headlessChromer->setHTMLFile($filePath);
    }

    public function testUseMobile()
    {
        $headlessChromer = new HeadlessChrome();
        $headlessChromer->useMobile();
        $this->assertEquals('Mozilla/5.0 (Linux; U; Android 4.0.3; ko-kr; LG-L160L Build/IML74K) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', $headlessChromer->getArguments()['--user-agent=']);
    }

    public function testGetDOM()
    {
        $HTML = '<div>DOM</div>';
        $headlessChromer = new HeadlessChrome();
        $headlessChromer->setHTML($HTML);
        $this->assertEquals($headlessChromer->getDOM(), $HTML);
    }
}
