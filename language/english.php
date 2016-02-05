<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Manuel Digest Plugin 1.4                                                  |
// +---------------------------------------------------------------------------+
// | english.php                                                               |
// |                                                                           |
// | English language file                                                     |
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
* Import Geeklog plugin messages for reuse
*
* @global array $LANG32
*/
global $LANG32;

// +---------------------------------------------------------------------------+
// | Array Format:                                                             |
// | $LANGXX[YY]:  $LANG - variable name                                       |
// |               XX    - specific array name                                 |
// |               YY    - phrase id or number                                 |
// +---------------------------------------------------------------------------+

$LANG_MDIGEST = array (
    'mdigest' => 'Manual Digest',
    'access_denied' => 'Access Denied',
    'access_denied_msg' => 'You are illegally trying access one of the Manual Digest administration pages.  Please note that all attempts to illegally access this page are logged',
    'installation_failed' => 'Installation Failed',
    'installation_failed_msg' => 'The installation of the Manual Digest plugin failed.  Please see your Geeklog error.log file for diagnostic information.',
    'uninstall_failed' => 'Uninstall Failed',
    'uninstall_failed_msg' => 'The uninstall of the Manual Digest plugin failed.  Please see your Geeklog error.log file for diagnostic information.',

    'digest_sent' => 'Digest has been sent. <a href="' . $_CONF['site_admin_url'] . '/plugins/mdigest/index.php">Back</a>.',
    'digest_intro' => 'This will let you send a digested version of recent stories on your site. If you can not use a cronjob (to run the <tt>emailgeeklogstories</tt> script automatically) or if you want to send out an extra digest, simply hit the "Send" button below (only available if you have stories to send).',
    'digest_last_sent' => 'Last Digest sent:',
    'never' => '(never)',
    'no_stories' => '<b>No new stories found.</b>',
    'num_stories' => '<b>%d</b> stories will be sent.',
    'send_button' => 'Send!',
    'not_enabled1' => '<strong>Warning:</strong> Daily Digest is not enabled. Makesure you have',
    'not_enabled2' => 'in your config.',

    'search_text' => 'Search for a user name, email address or user id.',
    'search_button' => 'Search',
    'new_search' => 'New Search',
    'inspect_text' => "Click on the user name to inspect the user's daily digest settings.",
    'uid_not_found' => 'There is no user account with user id %d.',
    'not_found' => 'There were no matches for <b>%s</b>.',
    'try_again' => 'Please try again.',
    'user' => 'User',
    'topics' => 'Topics',
    'all_topics' => 'all topics',
    'no_topics' => 'none',
    'reset_button' => 'Reset',
    'success' => 'Daily Digest settings for user <b>%s</b> have been reset.',
    'block_headline' => 'Daily Digest Maintenance',
    'digest_reset' => 'Digest has been reset. <a href="' . $_CONF['site_admin_url'] . '/plugins/mdigest/index.php">Back</a>.',
    'explain_reset' => 'If you don\'t want the outstanding stories to be sent, use the "Reset" button.',

    'forums' => 'Forums',
    'no_forums' => 'none',
    'forum_topics' => 'Forum topics'
);

// Messages for the plugin upgrade
$PLG_mdigest_MESSAGE3002 = $LANG32[9]; // "requires a newer version of Geeklog"

?>
