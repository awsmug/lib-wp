<?php

use AWSM\SystemLayer\MyClass;
use AWSM\SystemLayer\WP\Action;
use AWSM\SystemLayer\WP\Hooks;

Assets::instance()
    ->add( new FrontendAsset( 'Assets/Dist/css/buil.css' ) )
    ->add( new FrontendAsset( 'Assets/Dist/js/build.js' ) );