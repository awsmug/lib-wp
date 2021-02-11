<?php

namespace AWSM\LibWP\Examples\Plugin\Components\HelloWorld;

use AWSM\LibWP\Examples\Plugin\MyPlugin;
use AWSM\LibWP\WP\Assets\Assets;
use AWSM\LibWP\WP\Assets\CSS;
use AWSM\LibWP\WP\Assets\JS;
use AWSM\LibWP\WP\Core\LocationCallbacks;

MyPlugin::instance()->assets()
    ->add( new JS( 'Assets/Dist/JS/admin.js' ),    LocationCallbacks::admin() )
    ->add( new JS( 'Assets/Dist/JS/index.js' ),    LocationCallbacks::frontend() )
    ->add( new CSS( 'Assets/Dist/CSS/style.css' ), LocationCallbacks::frontend() );