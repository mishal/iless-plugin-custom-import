<?php

namespace ILess\Test\Plugin\CustomImport;

use ILess\Cache\CacheInterface;
use ILess\Cache\FileSystemCache;
use ILess\Parser;
use ILess\Plugin\CustomImport\Plugin;

class PluginTest extends \PHPUnit_Framework_TestCase
{
    protected function getParser(CacheInterface $cache = null)
    {
        $parser = new Parser([], $cache);

        $parser->getPluginManager()->addPlugin(new Plugin([
            'foo' => __DIR__ . '/_fixtures/custom_import',
            'some-vendor-library-path' => __DIR__ . '/_fixtures/vendor'
        ]));

        return $parser;
    }

    public function testPlugin()
    {
        $parser = $this->getParser();
        $this->doParsingTest($parser);
    }

    public function testPluginWithCache()
    {
        $parser = $this->getParser(new FileSystemCache(ILESS_TEST_CACHE_DIR));
        $this->doParsingTest($parser);
        // we do it twice so the second time the cache is used
        $parser = $this->getParser(new FileSystemCache(ILESS_TEST_CACHE_DIR));
        $this->doParsingTest($parser);
    }

    protected function doParsingTest(Parser $parser)
    {
        $parser->parseFile(__DIR__.'/_fixtures/test.less');
        $expected = <<< EXPECTED
body {
  color: red;
}
#foo {
  border: 10px solid blue;
}

EXPECTED;

        $css = $parser->getCSS();

        $this->assertEquals($expected, $css, 'The file was imported.');
    }

}
