<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('upload_file')) {
    /**
     * 
     * @param string $directory
     * @param mixed $file
     * @param string|null $file_name [opsional]
     * 
     * @return string
     */
    function upload_file($directory, $file, $file_name = "")
    {
        $extensi  = $file->getClientOriginalExtension();
        $file_name = "{$file_name}_". date('Ymdhis') .".{$extensi}";

        Storage::disk('public')->putFileAs($directory, $file, $file_name);

        return "/{$directory}/{$file_name}";
    }

    if (! function_exists('load_file')) {
        /**
         * 
         * @param string $filepath
         * @return string
         */
        function load_file($filepath)
        {
            if ($filepath && Storage::disk('public')->exists($filepath)) {
                return url(Storage::disk('public')->url($filepath));
            }
    
            return "";
        }
    }

    /**
     * 
     * Convert HTML entities to UTF-8 while ignoring invalid characters
     * Match only valid UTF-8 characters
     * 
     * @param string $words
     * 
     * @return string
     */
    function utf8_cleaner($words) 
    {
        return mb_convert_encoding($words, 'UTF-8', 'HTML-ENTITIES');
    }
}