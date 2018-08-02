<?php

namespace MediactiveDigital\LaravelAssetAliases;

use \Illuminate\Support\Facades\Config;
use \Illuminate\Support\Facades\File;

class AssetManager {

    const CSS   = 'css';
    const JS    = 'js';

    /**
     * Generate CSS / JS tags
     * @param mixed $files Array or string
     * @param string $type
     * @return string
     */
    protected static function generateTag($files, $type): string
    {
        $files = (array)$files;
        $result = '';

        $startTag = $type == self::CSS ? '<link rel="stylesheet" type="text/css" href="' : '<script type="text/javascript" src="';
        $endTag = $type == self::CSS ? '">' : '"></script>';

        foreach ($files as $file) {

            $sri = '';

            if (!filter_var($file, FILTER_VALIDATE_URL)) {

                $values = (array)Config::get('laravel-asset-aliases.alias.'.$type.'.'.$file);
                $fileAlias = isset($values[0]) ? $values[0] : '';
                $isUrl = $fileAlias ? filter_var($fileAlias, FILTER_VALIDATE_URL) : false;
                $file = $fileAlias ? $fileAlias : $file;

                if (!$isUrl) {

                    $fileAlias = $type.'/'.$file;
                    $filePath = public_path().'/'.$fileAlias;
                    $timeStamp = File::exists($filePath) ? File::lastModified($filePath) : false;
                    $file = asset($fileAlias).($timeStamp ? '?time='.$timeStamp : '');
                }
                else if (isset($values[1]) && $values[1]) {

                    $sri = '" integrity="'.$values[1].'" crossorigin="'.(isset($values[2]) && $values[2] ? 'use-credentials' : 'anonymous');
                }
            }

            $result .= $startTag.$file.$sri.$endTag."\r\n";
        }

        return $result ? rtrim($result, "\r\n") : $result;
    }

    /**
     * Add CSS files
     * @param mixed $files Array or string
     * @return string
     */
    public static function addCss($files): string
    {
        return self::generateTag($files, self::CSS);
    }

    /**
     * Add JS files
     * @param mixed $files Array or string
     * @return string
     */
    public static function addJs($files): string
    {
        return self::generateTag($files, self::JS);
    }

}