<?php 

namespace AWSM\LibWP\Examples\ExampleComponent;

use AWSM\LibWP\Component\Component;

Component::setup()
    ->entryPoint( 'App/Main.php')
    ->assets( 'Assets.php' )
    ->hooks( 'Hooks.php' );