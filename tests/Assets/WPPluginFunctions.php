<?php

function get_plugin_data( $plugin_file, $markup = true, $translate = true ) {
 
    $default_headers = array(
        'Name'        => 'Plugin Name',
        'PluginURI'   => 'Plugin URI',
        'Version'     => 'Version',
        'Description' => 'Description',
        'Author'      => 'Author',
        'AuthorURI'   => 'Author URI',
        'TextDomain'  => 'Text Domain',
        'DomainPath'  => 'Domain Path',
        'Network'     => 'Network',
        'RequiresWP'  => 'Requires at least',
        'RequiresPHP' => 'Requires PHP',
        // Site Wide Only is deprecated in favor of Network.
        '_sitewide'   => 'Site Wide Only',
    );
 
    $plugin_data = get_file_data( $plugin_file, $default_headers, 'plugin' );
 
    $plugin_data['Network'] = ( 'true' === strtolower( $plugin_data['Network'] ) );
    unset( $plugin_data['_sitewide'] );
 
    $plugin_data['Title']      = $plugin_data['Name'];
    $plugin_data['AuthorName'] = $plugin_data['Author'];
 
    return $plugin_data;
}

function get_file_data( $file, $default_headers, $context = '' ) {
    // We don't need to write to the file, so just open for reading.
    $fp = fopen( $file, 'r' );
 
    // Pull only the first 8 KB of the file in.
    $file_data = fread( $fp, 8 * 1024 );
 
    // PHP will close file handle, but we are good citizens.
    fclose( $fp );
 
    // Make sure we catch CR-only line endings.
    $file_data = str_replace( "\r", "\n", $file_data );

    $all_headers = $default_headers;
 
    foreach ( $all_headers as $field => $regex ) {
        if ( preg_match( '/^[ \t\/*#@]*' . preg_quote( $regex, '/' ) . ':(.*)$/mi', $file_data, $match ) && $match[1] ) {
            $all_headers[ $field ] = _cleanup_header_comment( $match[1] );
        } else {
            $all_headers[ $field ] = '';
        }
    }
 
    return $all_headers;
}

function _cleanup_header_comment( $str ) {
    return trim( preg_replace( '/\s*(?:\*\/|\?>).*/', '', $str ) );
}