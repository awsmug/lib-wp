<?php

namespace AWSM\LibWP\WP\Core;

use AWSM\LibTools\Patterns\SingletonTrait;
use AWSM\LibWP\WP\Hooks\Action;
use AWSM\LibWP\WP\Hooks\HookableHiddenMethodsTrait;
use AWSM\LibWP\WP\Hooks\Hooks;

/**
 * AdminNotices Class
 * 
 * This class helps adding admin notices.
 * 
 * @method AdminNotices instance() Returns AdminNotices class instance.
 * 
 * @since 1.0.0
 */
class AdminNotices {
    use HookableHiddenMethodsTrait, SingletonTrait;

    /**
     * True if admin notices are already hooked into WP.
     * 
     * @var bool
     * 
     * @since 1.0.0
     */
    private $hooked = false;

    /**
     * Admin notice messages.
     * 
     * @var array
     * 
     * @since 1.0.0
     */
    private $notices = [];

    /**
     * Constructor
     * 
     * @since 1.0.0
     */
    protected function __construct()
    {
        $this->setHookableHiddenMethods( ['showNotices', 'showNotice'] );
    }

    /**
     * Add a message to admin notices.
     * 
     * @param string $message Message to show.
     * @param string $type    Message type error, warning, success or info. Default is info.
     * 
     * @return AdminNotices
     * 
     * @since 1.0.0
     */
    public function add( string $message, $type = 'info' )
    {
        $this->notices[] = [ 'message' => $message, 'type' => $type ];

        if ( ! $this->hooked ) {
            Hooks::instance()->add( new Action( 'admin_notices', [ $this, 'showNotices'] ) )->load( $this );
        }

        $this->hooked = true;

        return $this;
    }

    /**
     * Show notices.
     * 
     * @since 1.0.0
     */
    private function showNotices() {
        foreach( $this->notices AS $notice ) {
            switch( $notice['type'] ) {
                case 'error':
                    $this->showNotice( 'error', $notice['message'] );
                    break;
                case 'warning':
                    $this->showNotice( 'warning', $notice['message'] );
                    break;
                case 'success':
                    $this->showNotice( 'success', $notice['message'] );
                    break;
                case 'info':
                    $this->showNotice( 'info', $notice['message'] );
                    break;
                default:
                    break;
            }
        }
    }

    /**
     * Show notice.
     * 
     * @param string $message Message to show.
     * @param string $type    Message type error, warning, success or info. Default is info.
     * 
     * @since 1.0.0
     */
    private function showNotice( $type, $message ) {
        ?>
        <div class="notice notice-<?php echo $type; ?> is-dismissible">
            <p><?php echo $message; ?></p>
        </div>
        <?php
    }
}