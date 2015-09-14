# ILess Plugin - Custom Imports

Allows to create custom `schema like` import directives for LESS. Inspired by [less-plugin-custom-import](https://www.npmjs.com/package/less-plugin-custom-import).

## Installation

Install using composer:

    $ composer require mishal/iless-plugin-custom-import

## Programmatic Usage

    use ILess\Parser;
    use ILess\Plugin\CustomImport\Plugin;

    $directories = [
        'foo' => '/path/foo',
        'some-vendor-library-path' => '/path1/some-vendor',
    ];

    $parser = new Parser();
    // register the plugin
    $parser->getPluginManager()->addPlugin(new Plugin($directories));

    // now I can use schema like directives in my less
    $parser->parseFile('/example.less');

    $css = $parser->getCSS();

### Less Code – Example.less

    @import 'foo://import.less';
    @import (optional) 'foo://icons.less';
    @import (reference) 'some-vendor-library-path://subdir/foo.less';

## Usage From the Command Line

    Not supported.
