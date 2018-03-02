<?php 

namespace daandesmedt\PHPHeadlessChrome;

use Exception;
use mikehaertl\shellcommand\Command;


class HeadlessChrome {

    /**
     * Path to the Chrome binary
     * @var String
     */
    private $binaryPath;

    /**
     * Argument list to execute for Headless Chrome
     * @var String
     */
    private $arguments;    

    /**
     * Output directory for render
     * @var String
     */
    private $outputDirectory;

    /**
     * URL to be rendered
     * @var String
     */
    private $url;

    /**
     * Recerence to command
     * @var mikehaertl\shellcommand\Command;
     */
    private $command;

    /**
     * Reference to the last know filepath
     * @var String
     */
    private $filePath;


    /**
     *  HeadlessChrome constructor
     * @param String $url           The URL to be convereted
     * @param String $binaryPath    Path to the Chrome binary
     * 
     * Open chrome and type <chrome://version>
     * Check the value for <Executable Path>
     * 
     */
    public function __construct($url = null, $binaryPath = null, $outputDirectory = null){
        
        $this->setArguments([
            '--headless' => '',
            '--disable-gpu' => '',
            '--incognito' => '',
            '--enable-viewport' => ''
        ]);

        if(isset($binaryPath)) {
            $this->setBinaryPath($binaryPath);
        }
    
        if (isset($url)){
            $this->setUrl($url);
        }

        if(isset($outputDirectory)){
            $this->setOutputDirectory($outputDirectory);
        } else {
            $this->setOutputDirectory(sys_get_temp_dir());
        }
        
    }


    /**
     * Set a list of arguments
     * @param Array $arguments
     */
    public function setArguments(array $arguments) {
        foreach ($arguments as $argument => $value) {
            $this->setArgument($argument, $value);
        }
    }


    /**
     * Set single argument
     * @param String $argument
     * @param String $value
     */
    public function setArgument($argument, $value) {        
        if(!strlen(trim($argument)) && !strlen(trim($value))) return;
        $argument = trim($argument);
        if (!empty($value) && !strstr($argument, '=')) {
            $argument .= '=';
        }
        $this->arguments[$argument] = trim($value);
    }


    /**
     * Set path to the Chrome binary
     * @param String $binaryPath
     */
    public function setBinaryPath($binaryPath){
        $this->binaryPath = $binaryPath;
    }


    /**
     * Set the target URL
     * @param String $url
     */
    public function setUrl($url) {
        $this->url = trim($url);
    }


    /**
     * Set the directory for render output (PDF / Screenshot)
     * @param String $directory
     */
    public function setOutputDirectory($directory)
    {
        $this->outputDirectory = trim($directory);
        if (!file_exists($directory)) {
            @mkdir($directory);
        }
    }


    /**
     * Set the Chrome window size
     * @param integer $width
     * @param integer $height
     */
    public function setWindowSize($width, $height) {
        $this->setArgument('--window-size', $width . ',' . $height);
    }


    /**
     * Set raw HTML
     * @param String $html
     */
    public function setHTML($html) {
        $this->setUrl('data:text/html,' . rawurlencode($html));
    }


    /**
     * Set HTML file (file:// protocol)
     * @param  String       $filePath
     * @throws Exception    If the file is not found
     */
    public function setHTMLFile($filePath) {
        if (!file_exists($filePath)) {
            throw new Exception("$filePath not found");
        }
        $this->setUrl("file://$filePath");
    }


    /**
     * Sets the mobile mode
     */
    public function useMobile(){
        $this->setArgument('--user-agent', 'Mozilla/5.0 (Linux; U; Android 4.0.3; ko-kr; LG-L160L Build/IML74K) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30');
    }


    /**
     * 
     * Get path to the Chrome binary
     * @return String $binaryPath
     */
    public function getBinaryPath(){
        return $this->binaryPath;
    }


    /**
     * Get the target URL
     * @return String $url
     */
    public function getUrl() {
        return $this->url;
    }


    /**
     * Get the directory for render output (PDF / Screenshot)
     * @return String $directory
     */
    public function getOutputDirectory() {
        return $this->outputDirectory;
    }


    /**
     * Gets arguments list used for executing Headless Chrome
     * @return Array
     */
    public function getArguments(){
        return $this->arguments;
    }


    /**
     * Returns a unique filename with the given extension
     * @param  String $extension (pdf / html)
     * @return String unique filename
     */
    private function getUniqueName($extension) {
        return md5(date('Y-m-d H:i:s:u')) . '.' . $extension;
    }


    /**
     * To PDF for the specified URL
     * @param  String       $PDFfilename
     * @return String       $location
     * @throws Exception
     */
    public function toPDF($PDFFilename = null){
        
        if(!isset($PDFFilename)){
            $PDFfilename = $this->getUniqueName('pdf');
        }

        if ($PDFFilename && !strstr($PDFFilename, '.pdf')) {
            $PDFFilename .= '.pdf';
        }

        $location = $this->getOutputDirectory() . DIRECTORY_SEPARATOR . $PDFFilename;
        $this->filePath = $location;

        $specific_arguments = [
            '--print-to-pdf=' => $location
        ];

        $arguments = array_merge($specific_arguments, $this->getArguments());
        if (!$this->executeChrome($arguments)) {
            throw new Exception('An error occurred while creating PDF ; <' . $this->getExitCode() . '> with message "' . $this->getError() . '"');
        }

        return $location;

    }

    /**
     * Convert the provided url to image and return the image's location
     * @param  String       $imageFilename
     * @return String       $location
     * @throws Exception
     */
    public function toScreenShot($imageFilename = null) {

        if(!isset($imageFilename)){
            $imageFilename = $this->getUniqueName('jpg');
        }

        if ($imageFilename && !strstr($imageFilename, '.jpg') && !strstr($imageFilename, '.png')) {
            $imageFilename .= '.jpg';
        }

        $location = $this->getOutputDirectory() . DIRECTORY_SEPARATOR . $imageFilename;
        $this->filePath = $location;

        $specific_arguments = [
            '--screenshot=' => $location
        ];

        $arguments = array_merge($specific_arguments, $this->getArguments());
        if (!$this->executeChrome($arguments)) {
            throw new Exception('An error occurred while creating screenshot ; <' . $this->getExitCode() . '> with message "' . $this->getError() . '"');
        }

        return $location;

    }
    

    /**
     * Execute Chrome using all provided arguments
     * @param  Array $arguments
     * @return Boolean
     */
    private function executeChrome(array $arguments) {
        $this->command = new Command('' . $this->binaryPath . '');  
        foreach ($arguments as $argument => $value) {
            $this->command->addArg($argument, $value ? $value : null);
        }        
        $this->command->addArg($this->url, null);

        if (!$this->command->execute()) {
            return false;
        }
        return true;
    }


    /**
     * Get the last error message
     * @return String the error message, either stderr or internal message. Empty if none.
     */
    public function getError(){
        if(!$this->command) return;
        return $this->command->getError();
    }


    /**
     * Get the last command exit code
     * @return Int|null the exit code or null if command was not executed yet
     */
    public function getExitCode(){
        if(!$this->command) return;
        return $this->command->getExitCode();
    }


    /**
     * Get command string command
     * @return string the current command string to execute
     */
    public function getCommandString(){
        if(!$this->command) return;
        return $this->command->__toString();
    }


    /**
     * Get last know filePath location
     * @return string the current command string to execute
     */
    public function getFilePath(){
        if(!$this->command) return;
        return $this->filePath;
    }

}
