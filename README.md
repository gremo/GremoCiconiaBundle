# GremoCiconiaBundle
[![Latest stable](https://img.shields.io/packagist/v/gremo/ciconia-bundle.svg?style=flat-square)](https://packagist.org/packages/gremo/ciconia-bundle) [![Downloads total](https://img.shields.io/packagist/dt/gremo/ciconia-bundle.svg?style=flat-square)](https://packagist.org/packages/gremo/ciconia-bundle) [![GitHub issues](https://img.shields.io/github/issues/gremo/CiconiaBundle.svg?style=flat-square)](https://github.com/gremo/CiconiaBundle/issues)

Symfony bundle for Ciconia Markdown parser for PHP.

## Installation
Add the bundle in your `composer.json` file:


```js
{
    "require": {
        "gremo/ciconia-bundle": "~1.0"
    }
}
```

Then enable the bundle in the kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Gremo\CiconiaBundle\GremoCiconiaBundle(),
        // ...
    );
}
```

## Configuration
Configuration is optional, **extensions are disabled** by default:

```yml
# GremoCiconiaBundle Configuration
gremo_ciconia:
    renderer: ~ # Or null or "html" or "xhtml"
    extensions: ~ # Enable all with true or null (false to disable)
```

To selectively enable an extension:

```yml
# GremoCiconiaBundle Configuration
gremo_ciconia:
    # ...
    extensions:
        fencedCodeBlock: ~ # Or true or null (false to disable) 
        # ...
```

## Usage
Get the `ciconia` service from the service container:

```php
/** @var \Ciconia\Ciconia $ciconia */
$ciconia = $container->get('ciconia');

// Refer to kzykhys/Ciconia for examples
$html = $ciconia->render('Markdown is **awesome**');

// <p>Markdown is <em>awesome</em></p>
```

Or in twig template:

```twig
{{ var|markdown }}
```

## Dependency Injection Tags
Give the service a tag named `ciconia.extension` to automatically registered it as an extension.
