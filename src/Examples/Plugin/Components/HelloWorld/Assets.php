<?php

namespace AWSM\LibWP\Examples\Plugin\Components\HelloWorld;

use AWSM\LibWP\WP\Assets\Assets;
use AWSM\LibWP\WP\Assets\CSS;
use AWSM\LibWP\WP\Assets\JS;
use AWSM\LibWP\WP\Core\LocationCallbacks;

Assets::instance()
    ->add( new JS( 'Assets/Dist/JS/admin.js' ),    LocationCallbacks::admin() )
    ->add( new JS( 'Assets/Dist/JS/index.js' ),    LocationCallbacks::frontend() )
    ->add( new CSS( 'Assets/Dist/CSS/style.css' ), LocationCallbacks::frontend() );