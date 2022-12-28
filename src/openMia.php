<?php
namespace openMia\openMia;

use openMia\openMia\FileSystem\Path;

//use openMia\composer\composer;

class openMia {
    private $rootDir = "";
    
    public function __construct() {
        /* use mergePath for correct DirectorySeparator */
        $this->rootDir = trim(Path::mergePath("",__DIR__."../../../../.."),DIRECTORY_SEPARATOR);


        echo $this->registerApps($this->rootDir);
//        $composer = new composer();
    }

    public function registerApps($rootDir) {
        $regPath = $rootDir.DIRECTORY_SEPARATOR."registry";
        if(!is_dir($regPath)) {
            mkdir($regPath);
            return false;
        }
        $appFile = $regPath.DIRECTORY_SEPARATOR."apps.json";
        if(!is_file($appFile)) {
            return false;
        }
        if($fileData = file_get_contents($appFile)) {
            $appData = json_decode($fileData);

        } else return false;
    }

}