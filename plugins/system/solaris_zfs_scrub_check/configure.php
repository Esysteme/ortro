<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Configuration file, allows to generate dinamically the web form for the plugin
 *
 * PHP version 5
 *
 * LICENSE: This file is part of Ortro.
 * Ortro is published under the terms of the GNU GPL License v2 
 * Please see LICENSE and COPYRIGHT files for details.
 *
 * @category Plugins
 * @package  Ortro
 * @author   Fabrizio Cardarello <hunternet@users.sourceforge.net>
 * @license  GNU/GPL v2
 * @link     http://www.ortro.net
 */

$plugin_field['solaris_zfs_scrub_check'][0]['version']           = '1.0.3';
$plugin_field['solaris_zfs_scrub_check'][0]['min_ortro_version'] = '1.2.0';
$plugin_field['solaris_zfs_scrub_check'][0]['authors'][0]        = 'Fabrizio Cardarello <hunternet@users.sourceforge.net>';
$plugin_field['solaris_zfs_scrub_check'][0]['description']       = PLUGIN_SOLARIS_ZFS_SCRUB_CHECK_DESCRIPTION;
$plugin_field['solaris_zfs_scrub_check'][0]['title']             = PLUGIN_SOLARIS_ZFS_SCRUB_CHECK_TITLE;

$plugin_field['solaris_zfs_scrub_check'][1]['type']              = 'text';
$plugin_field['solaris_zfs_scrub_check'][1]['name']              = 'solaris_zfs_scrub_check_user';
$plugin_field['solaris_zfs_scrub_check'][1]['value']             = '';
$plugin_field['solaris_zfs_scrub_check'][1]['attributes']        = 'disabled';
$plugin_field['solaris_zfs_scrub_check'][1]['description']       = PLUGIN_USER;
$plugin_field['solaris_zfs_scrub_check'][1]['num_rules']         = '1';
$plugin_field['solaris_zfs_scrub_check'][1]['rule_msg'][0]       = PLUGIN_USER_RULE;
$plugin_field['solaris_zfs_scrub_check'][1]['rule_type'][0]      = 'required';
$plugin_field['solaris_zfs_scrub_check'][1]['rule_attribute'][0] = '';

$plugin_field['solaris_zfs_scrub_check'][2]['type']        = 'text';
$plugin_field['solaris_zfs_scrub_check'][2]['name']        = 'solaris_zfs_scrub_check_port';
$plugin_field['solaris_zfs_scrub_check'][2]['value']       = '';
$plugin_field['solaris_zfs_scrub_check'][2]['attributes']  = 'disabled';
$plugin_field['solaris_zfs_scrub_check'][2]['description'] = PLUGIN_PORT;
?>