# Awesome Lib - WP (pre alpha)
**An OOP Layer for WordPress**

This library wraps WordPress functionality and tries to make WordPress easy to use in object orientated PHP. 
We also put a little magic in this for less effort on programming.

## Creating a Plugin

At first the Lib WP have to be added by requiring it with composer.

```composer require awsm/lib-wp:dev-develop```

After that the main plugin file have to be created.

### Plugin Example file

The main work is done in creating a plugin file with the necessary comments. Please take care that 
the comments section is important for the library. It reads all data and works with it. 

#### Text Domain
Setting this data is needed for loading the textdomain. 

#### Domain Path
If langauage files are stored within the plugin, you have to add the path to these files here.
Be sure that the the language files have the syntax \[Textdomain\]_\[language\].mo. For example
```mytextdomain_de_DE.mo```.

#### Requires at least
The minimum WordPress version which is needed for the plugin.

#### Requires PHP
The minumum PHP version which is needed for the Plugin.

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

require dirname( __FILE__ ) . '/vendor/autoload.php';


use AWSM\LibWP\WP\Core\Plugin;
use AWSM\ExamplePlugin\HelloWorld\HelloWorld;
use AWSM\ExamplePlugin\HelloWorld2\HelloWorld2;


Plugin::init()
    ->addComponent( HelloWorld::class )
    ->addComponent( HelloWorld2::class );
```

