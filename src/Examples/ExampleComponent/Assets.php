<?php

use AWSM\LibWP\WP\Assets\Assets;

Assets::instance()
    ->add( new FrontendAsset( 'Assets/Dist/css/buil.css' ) )
    ->add( new FrontendAsset( 'Assets/Dist/js/build.js' ) );