<?php

namespace AWSM\LibWP\Examples\Component;

use AWSM\LibWP\WP\Assets\Assets;
use AWSM\LibWP\WP\Assets\CSS;
use AWSM\LibWP\WP\Assets\JS;
use AWSM\LibWP\WP\Core\Location;
use Locale;

Assets::instance()
    ->add( new JS( 'Assets/Dist/JS/admin.js' ),    Location::admin() )
    ->add( new JS( 'Assets/Dist/JS/index.js' ),    Location::frontend() )
    ->add( new CSS( 'Assets/Dist/CSS/style.css' ), Location::frontend() );