<?php

namespace AWSM\LibWP\Examples\Component;

use AWSM\LibWP\WP\Assets\Assets;
use AWSM\LibWP\WP\Assets\CSS;
use AWSM\LibWP\WP\Assets\JS;

Assets::instance()
    ->add( new JS( 'Assets/Dist/JS/admin.js',     array( Location::class, 'isBackend' ) ) )
    ->add( new JS( 'Assets/Dist/JS/index.js',     array( Location::class, 'isFrontend' ) ) )
    ->add( new CSS( 'Assets/Dist/CSS/style.css',  array( Location::class, 'isFrontend' ) ) );