<?php
/*
 * This file is part of the ILess Custom Import Plugin
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ILess\Plugin\CustomImport;

use ILess\Parser;
use ILess\Plugin\PluginInterface;

/**
 * Plugin
 *
 * @package ILess\Plugin\CustomImport
 */
class Plugin implements PluginInterface
{
    /**
     * @var Importer
     */
    protected $importer;

    /**
     * Constructor
     *
     * @param array $directories Array of directories to search for
     */
    public function __construct($directories)
    {
        $this->importer = new Importer($directories);
    }

    /**
     * @inheritdoc
     */
    public function install(Parser $parser)
    {
        $parser->getImporter()->registerImporter($this->importer);
    }

    /**
     * @return Importer
     */
    public function getImporter()
    {
        return $this->importer;
    }

}
