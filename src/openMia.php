<?php
namespace openMia\openMia;

use openMia\openMia\FileSystem\Path;

use openMia\composer\composer;

class openMia {
    private $rootDir = "";
    
    public function __construct() {
        /* use mergePath for correct DirectorySeparator */
        $this->rootDir = Path::mergePath("",__DIR__."../../../../..");

        
        echo $this->rootDir;
        $composer = new composer();
    }

}