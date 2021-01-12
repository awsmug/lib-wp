<?php

namespace AWSM\LibWP\WP\Core;

trait FileInfoTrait {
    /**
     * Get plugin data (copied and modified form get_pluginData WP function)
     * 
     * @param string $file
     * @param array  $defaultHeaders
     * 
     * @since 1.0.0
     */
    private function getFileData( $file, $defaultHeaders ) {
        // We don't need to write to the file, so just open for reading.
        $fp = fopen( $file, 'r' );
     
        // Pull only the first 8 KB of the file in.
        $fileData = fread( $fp, 8 * 1024 );
     
        // PHP will close file handle, but we are good citizens.
        fclose( $fp );
     
        // Make sure we catch CR-only line endings.
        $fileData = str_replace( "\r", "\n", $fileData );
    
        $allHeaders = $defaultHeaders;
     
        foreach ( $allHeaders as $field => $regex ) {
            if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( $regex, '/' ) . ':(.*)$/mi', $fileData, $match ) && $match[1] ) {
                $allHeaders[ $field ] = trim( preg_replace( '/\s*(?:\*\/|\?>).*/', '', $match[1] ) );
            } else {
                $allHeaders[ $field ] = '';
            }
        }
     
        return $allHeaders;
    }
}