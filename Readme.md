# Awesome Lib - WP - 
**An OOP Layer for WordPress**

This library wraps WordPress functionality and tries to make WordPress easy to use in object orientated PHP. 
We also put a little magic in this for less effort on programming.

## Creating a Plugin

At first the Lib WP have to be added by requiring it with composer.

```composer require awsm/lib-wp```

After that the main plugin file have to be created.

### Plugin Example file

The main work is done in creating a 

```php
<?php

/**
 * Plugin Name: My Plugin
 * Description: A wonderfull plugin.
 * Author: Sven Wagener
 * Author URI: https://sven-wagener.com
 * Version: 1.2.3
 * Text Domain: myplgin
 * Domain Path: /assets/langauges/
 * Network: true
 * Requires at least: 5.4.0
 * Requires PHP: 7.1.0
 */

namespace AWSM\LibWP\Examples\Plugin;

require '../../../vendor/autoload.php';

use AWSM\LibWP\WP\Core\Plugin;
use AWSM\LibWP\WP\Core\WP;
use AWSM\LibWP\WP\WPException;

use AWSM\LibWP\Examples\Plugin\Components\HelloWorld\HelloWorld;

try {
    Plugin::init()->addComponent( HelloWorld::class );
} catch ( WPException $e ) {
    WP::alert( sprintf( 'Failed to run Plugin: %s', $e->getMessage() ) );
}
```

### 

