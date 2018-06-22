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
        $files = is_array($files) ? $files : [$files];
        $result = '';

        $startTag = $type == self::CSS ? '<link rel="stylesheet" type="text/css" href="' : '<script type="text/javascript" src="';
        $endTag = $type == self::CSS ? '">' : '"></script>';

        foreach ($files as $file) {

            if (!filter_var($file, FILTER_VALIDATE_URL)) {

                $fileAlias = Config::get('laravel-asset-aliases.alias.'.$type.'.'.$file);
                $isUrl = $fileAlias ? filter_var($fileAlias, FILTER_VALIDATE_URL) : false;
                $file = $fileAlias ? $fileAlias : $file;

                if (!$isUrl) {

                    $fileAlias = $type.'/'.$file;
                    $filePath = public_path().'/'.$fileAlias;
                    $timeStamp = File::exists($filePath) ? File::lastModified($filePath) : false;
                    $file = asset($fileAlias).($timeStamp ? '?time='.$timeStamp : '');
                }
            }

            $result .= $startTag.$file.$endTag."\r\n";
        }

        return rtrim($result,"\r\n");
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
