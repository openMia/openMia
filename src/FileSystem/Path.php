<?php


namespace openMia\openMia\FileSystem;


class Path {

    public static function mergePath($basePath, $subPath):string {
        /* replace backslash with slashes */
        $basePath = str_replace('\\',"/",$basePath);
        $subPath = self::removeDotSegmentsFromPath(str_replace('\\',"/",$subPath));
        $basePath = rtrim($basePath,'/').DIRECTORY_SEPARATOR.ltrim($subPath);
        return str_replace('/',DIRECTORY_SEPARATOR,$basePath);
    }
    
    
    public static function removeDotSegmentsFromPath(string $path): string {
        if ($path === '' || $path === '/') {
            return $path;
        }
        $output = '';
        $last_slash = 0;
        $len = strlen($path);
        $i = 0;
        while ($i < $len) {
            if ($path[$i] === '.') {
                $j = $i + 1;
                // search for .
                if ($j >= $len) {
                    break;
                }

                // search for ./
                if ($path[$j] === '/') {
                    $i = $j + 1;
                    continue;
                }

                // search for ../
                if ($path[$j] === '.') {
                    $k = $j + 1;
                    if ($k >= $len) {
                        break;
                    }
                    if ($path[$k] === '/') {
                        $i = $k + 1;
                        continue;
                    }
                }
            } elseif ($path[$i] === '/') {
                $j = $i + 1;
                if ($j >= $len) {
                    $output .= '/';
                    break;
                }
                // search for /.
                if ($path[$j] === '.') {
                    $k = $j + 1;
                    if ($k >= $len) {
                        $output .= '/';
                        break;
                    }
                    // search for /./
                    if ($path[$k] === '/') {
                        $i = $k;
                        continue;
                    }
                    // search for /..
                    if ($path[$k] === '.') {
                        $n = $k + 1;
                        if ($n >= $len) {
                            // keep the slash
                            $output = substr($output, 0, $last_slash + 1);
                            break;
                        }
                        // search for /../
                        if ($path[$n] === '/') {
                            $output = substr($output, 0, $last_slash);
                            $last_slash = (int)strrpos($output, '/');
                            $i = $n;
                            continue;
                        }
                    }
                }
            }
            $pos = strpos($path, '/', $i + 1);
            if ($pos === false) {
                $output .= substr($path, $i);
                break;
            }
            $last_slash = strlen($output);
            $output .= substr($path, $i, $pos - $i);
            $i = $pos;
        }
        return $output;
    }
}