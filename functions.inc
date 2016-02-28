<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Manuel Digest Plugin 1.4                                                  |
// +---------------------------------------------------------------------------+
// | functions.inc                                                             |
// |                                                                           |
// | This file does two things: 1) it implements the necessary Geeklog Plugin  |
// | API methods and 2) implements all the common code needed by this plugin.  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2016 by the following authors:                              |
// |                                                                           |
// | Authors: Dirk Haun - dirk AT haun-online DOT de                           |
// |          Ben - ben AT geeklog DOT fr                                      |
// +---------------------------------------------------------------------------+
// | Created with the Geeklog Plugin Toolkit.                                  |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

/**
* @package ManuelDigest
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.inc') !== false) {
    die ('This file can not be used on its own.');
}

/**
 * Language file include
 */
$plugin_path = $_CONF['path'] . 'plugins/mdigest/';
$langfile = $plugin_path . 'language/' . $_CONF['language'] . '.php';

if (file_exists($langfile)) {
    require_once $langfile;
} else {
    require_once $plugin_path . 'language/english.php';
}

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementation                                         |
// +---------------------------------------------------------------------------+



/**
* Return plugin entry for "Command and Control" (moderation.php)
*
* @return  array  Array containing (plugin name, admin url, url of plugin icon)
*
*/
function plugin_cclabel_mdigest()
{
    global $_CONF, $LANG_MDIGEST_1;

    $retval = array();
    if (SEC_hasRights('mdigest.admin')) {
        $retval = array($LANG_MDIGEST_1['plugin_name'],
            $_CONF['site_admin_url'] . '/plugins/mdigest/index.php',
            plugin_geticon_mdigest());
    }

    return $retval;
}

/**
* Return plugin entry for the Admins Only block
*
* @return array Array containing (plugin name, plugin admin url, # of plugin items or '')
*/
function plugin_getadminoption_mdigest() 
{
    global $_CONF, $LANG_MDIGEST, $_TABLES,$_SCRIPTS;

    if (SEC_hasRights('user.mail')) {
        if ($_CONF['emailstories'] == 1) {
            $lastrun = DB_getItem ($_TABLES['vars'], 'value', "name = 'lastemailedstories'");
            $storysql = "SELECT sid FROM {$_TABLES['stories']} WHERE draft_flag = 0 AND date <= NOW() AND date >= '{$lastrun}'";
            $result = DB_query ($storysql);
            $count = DB_numRows ($result);
        } else {
            $count = 0;
        }

        if ($count == 0) {
            return array ($LANG_MDIGEST['mdigest'],
                      $_CONF['site_admin_url'] . '/plugins/mdigest/index.php',
                      $count);
        } else {            
            return array ('<span style="color:red">' . $LANG_MDIGEST['mdigest'] . '</span>',
                      $_CONF['site_admin_url'] . '/plugins/mdigest/index.php',
                      $count);
        }
    }	
}

/**
* Returns the URL of the plugin's icon
*
* @return   string      URL of the icon
*
*/
function plugin_geticon_mdigest()
{
    global $_CONF;

    // popular alternative location:
    // return $_CONF['site_url'] . '/mdigest/images/mdigest.png';

    return $_CONF['site_admin_url'] . '/plugins/mdigest/images/mdigest.png';
}

/**
 * Returns the current plugin code version
 *
 * @return string    plugin version
 */
function plugin_chkVersion_mdigest()
{
    global $_CONF;

    require_once $_CONF['path'] . 'plugins/mdigest/autoinstall.php';

    $inst_parms = plugin_autoinstall_mdigest('mdigest');

    return $inst_parms['info']['pi_version'];
}

/**
* Update the plugin
*
* @return   int     Number of message to display or true for success
*
*/
function plugin_upgrade_mdigest()
{
    global $_CONF, $_TABLES;

    $installed_version = DB_getItem($_TABLES['plugins'], 'pi_version',
                                    "pi_name = 'mdigest'");
    $code_version = plugin_chkVersion_mdigest();
    if ($installed_version == $code_version) {
        // nothing to do
        return true;
    }

    require_once $_CONF['path'] . 'plugins/mdigest/autoinstall.php';

    if (! plugin_compatible_with_this_version_mdigest('mdigest')) {
        return 3002;
    }

    // other update code goes here

    // update plugin version number
    $inst_parms = plugin_autoinstall_mdigest('mdigest');
    $pi_gl_version = $inst_parms['info']['pi_gl_version'];

    DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '$code_version', pi_gl_version = '$pi_gl_version' WHERE pi_name = 'mdigest'");

    return true;
}

/**
* Automatic uninstall function for plugins
*
* This code is automatically uninstalling the plugin.
* It passes an array to the core code function that removes
* tables, groups, features and php blocks from the tables.
* Additionally, this code can perform special actions that cannot be
* foreseen by the core code (interactions with other plugins for example)
*
* @return   array   Plugin information
*
*/
function plugin_autouninstall_mdigest()
{
    $out = array (
        /* give the name of the tables, without $_TABLES[] */
        'tables' => array(/* e.g. 'mdigest' */),
        /* give the full name of the group, as in the db */
        'groups' => array('Manuel Digest Admin'),
        /* give the full name of the feature, as in the db */
        'features' => array('mdigest.admin'),
        /* give the full name of the block, including 'phpblock_', etc */
        'php_blocks' => array(),
        /* give all vars with their name */
        'vars' => array('mdigest')
    );

    return $out;
}

?>
