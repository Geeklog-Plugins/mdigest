<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Manuel Digest Plugin 1.4                                                  |
// +---------------------------------------------------------------------------+
// | autoinstall.php                                                           |
// |                                                                           |
// | This file provides helper functions for the automatic plugin install.     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2016 by the following authors:                              |
// |                                                                           |
// | Authors: Dirk Haun - dirk AT haun-online DOT de                           |
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

/**
* Plugin autoinstall function
*
* @param    string  $pi_name    Plugin name
* @return   array               Plugin information
*
*/
function plugin_autoinstall_mdigest($pi_name)
{
    $pi_name         = 'mdigest';
    $pi_display_name = 'Manuel Digest';
    $pi_admin        = $pi_display_name . ' Admin';

    $info = array(
        'pi_name'         => $pi_name,
        'pi_display_name' => $pi_display_name,
        'pi_version'      => '1.4.0',
        'pi_gl_version'   => '2.0.0',
        'pi_homepage'     => 'http://geeklog.info'
    );

    $groups = array(
        $pi_admin => 'Users in this group can administer the '
                     . $pi_display_name . ' plugin'
    );

    $features = array(
        $pi_name . '.admin'    => 'Full access to ' . $pi_display_name
                                  . ' plugin'
    );

    $mappings = array(
        $pi_name . '.admin'     => array($pi_admin)
    );

    $tables = array(
    );

    $inst_parms = array(
        'info'      => $info,
        'groups'    => $groups,
        'features'  => $features,
        'mappings'  => $mappings,
        'tables'    => $tables
    );

    return $inst_parms;
}
	
/**
* Check if the plugin is compatible with this Geeklog version
*
* @param    string  $pi_name    Plugin name
* @return   boolean             true: plugin compatible; false: not compatible
*
*/
function plugin_compatible_with_this_version_mdigest($pi_name)
{
    // add checks here

    return true;
}

?>
