<?php 

namespace daandesmedt\PHPHeadlessChrome;

use Exception;
use mikehaertl\shellcommand\Command;

class HeadlessChrome
{

    /**
     * Path to the Chrome binary
     * @var String
     */
    private $binaryPath;
    

    /**
     *  HeadlessChrome constructor
     * @param String $url           The URL to be convereted
     * @param String $binaryPath    Path to the Chrome binary
     */
    public function __construct($url = '', $binaryPath = ''){
        
        // provide default options

    }


    /**
     * Set path to the Chrome binary
     * @param String $binaryPath
     */
    public function setBinaryPath($binaryPath){
        $this->binaryPath = $binaryPath;
    }

}