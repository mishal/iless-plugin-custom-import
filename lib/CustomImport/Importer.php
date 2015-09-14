<?php

/*
 * This file is part of the ILess Custom Import Plugin
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ILess\Plugin\CustomImport;

use ILess\FileInfo;
use ILess\ImportedFile;
use ILess\Importer\CallbackImporter;

/**
 * Importer
 *
 * @package ILess\Plugin\CustomImport
 */
class Importer extends CallbackImporter
{
    /**
     * @var array
     */
    private $directories = [];

    /**
     * Prefix regexp
     *
     * @var string
     */
    private $regexp = '~^([a-zA-Z0-9-]+)://(.*)$~';

    /**
     * @param callable $directories
     */
    public function __construct($directories)
    {
        $this->directories = (array)$directories;

        // setup the callbacks
        parent::__construct(
            // import callback
            function ($path, FileInfo $currentFileInfo) {
                if (preg_match($this->regexp, $path, $matches)) {
                    $dir = $matches[1];
                    $filePath = $matches[2];
                    if (array_key_exists($dir, $this->directories)) {
                        $importDirectory = $this->directories[$dir];
                        if(is_readable($file = $importDirectory . '/' . $filePath)) {
                            return new ImportedFile($file, file_get_contents($file), filemtime($file));
                        }
                    }
                }
                return false;
            },
            // last modified callback
            function ($path, FileInfo $currentFileInfo) {
                if (preg_match($this->regexp, $path, $matches)) {
                    $dir = $matches[1];
                    $filePath = $matches[2];
                    if (array_key_exists($dir, $this->directories)) {
                        $importDirectory = $this->directories[$dir];
                        if (is_readable($file = $importDirectory.'/'.$filePath)) {
                            return filemtime($file);
                        }
                    }
                }
                return false;
            });
    }

    /**
     * @return array
     */
    public function getDirectories()
    {
        return $this->directories;
    }

    /**
     * Sets the directories
     *
     * @param array $directories
     * @return $this
     */
    public function setDirectories($directories)
    {
        $this->directories = $directories;

        return $this;
    }

}
