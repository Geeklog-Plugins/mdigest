<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Manuel Digest Plugin 1.4                                                  |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Plugin administration page                                                |
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

require_once '../../../lib-common.php';
require_once '../../auth.inc.php';

if (!SEC_hasRights ('user.mail') && !SEC_hasRights ('user.edit')) {
    // Someone is trying to illegally access this page
    COM_accessLog ("Someone has tried to illegally access the Manual Digest index page. User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: $REMOTE_ADDR", 1);

    $display = COM_startBlock ($LANG_MDIGEST['access_denied']);
    $display .= $LANG_MDIGEST['access_denied_msg'];
    $display .= COM_endBlock ();
    $display = COM_createHTMLDocument($display);
    COM_output($display);
    exit;
}

if (DB_getItem ($_TABLES['plugins'], 'pi_enabled', "pi_name='mdigest'") != 1) {
    echo COM_refresh ($_CONF['site_admin_url']);
    exit;
}

/**
* undo function for htmlspecialchars()
*
* This function translates HTML entities created by htmlspecialchars() back
* into their ASCII equivalents. Also handles the entities for $, {, and }.
*
* @param    string   $string   The string to convert.
* @return   string   The converted string.
*
*/
function MDIGEST_undoSpecialChars( $string )
{
    $string = str_replace( '&#36;',     '$', $string );
    $string = str_replace( '&#123;',    '{', $string );
    $string = str_replace( '&#125;',    '}', $string );
    $string = str_replace( '&gt;',      '>', $string );
    $string = str_replace( '&lt;',      '<', $string );
    $string = str_replace( '&quot;',    '"', $string );
    $string = str_replace( '&nbsp;',    ' ', $string );
    $string = str_replace( '&amp;',     '&', $string );
    $string = str_replace( '&Agrave;',  'A', $string );
    $string = str_replace( '&agrave;',  'à', $string );
    $string = str_replace( '&Acirc;',   'A', $string );
    $string = str_replace( '&acirc;',   'â', $string );
    $string = str_replace( '&Ccedil;',  'C', $string );
    $string = str_replace( '&ccedil;',  'ç', $string );
    $string = str_replace( '&Egrave;',  'E', $string );
    $string = str_replace( '&egrave;',  'è', $string );
    $string = str_replace( '&Eacute;',  'E', $string );
    $string = str_replace( '&eacute;',  'é', $string );
    $string = str_replace( '&Ecirc;',   'E', $string );
    $string = str_replace( '&ecirc;',   'ê', $string );
    $string = str_replace( '&Euml;',    'E', $string );
    $string = str_replace( '&euml;',    'ë', $string );
    $string = str_replace( '&Icirc;',   'I', $string );
    $string = str_replace( '&icirc;',   'î', $string );
    $string = str_replace( '&Iuml;',    'I', $string );
    $string = str_replace( '&iuml;',    'ï', $string );
    $string = str_replace( '&Ocirc;',   'O', $string );
    $string = str_replace( '&ocirc;',   'ô', $string );
    $string = str_replace( '&OElig;',  'OE', $string );
    $string = str_replace( '&oelig;',  'oe', $string );
    $string = str_replace( '&Ugrave;',  'U', $string );
    $string = str_replace( '&ugrave;',  'ù', $string );
    $string = str_replace( '&Ucirc;',   'U', $string );
    $string = str_replace( '&ucirc;',   'û', $string );
    $string = str_replace( '&Uuml;',    'U', $string );
    $string = str_replace( '&uuml;',    'ü', $string );
    $string = str_replace( '&#376;',    'Y', $string );
    $string = str_replace( '&yuml;',    'ÿ', $string );
    $string = str_replace( '&rsquo;',  '\'', $string );
 
    return( $string );
}

 
/**
* This will email new stories in the topics that the user is interested in
*
* In account information the user can specify which topics for which they
* will receive any new article for in a daily digest.
*
* @return   void
*/
 
function MDIGEST_emailUserTopics_html()
{
    global $_CONF, $_TABLES, $LANG08, $LANG24;
 
    $subject = strip_tags( $_CONF['site_name'] . $LANG08[30] . strftime( '%d-%m-%Y', time() ));
 
    $authors = array();
 
    // Get users who want stories emailed to them
    $usersql = "SELECT username,email,etids,{$_TABLES['users']}.uid AS uuid "
        . "FROM {$_TABLES['users']}, {$_TABLES['userindex']} "
        . "WHERE {$_TABLES['users']}.uid > 1 AND {$_TABLES['userindex']}.uid = {$_TABLES['users']}.uid AND (etids <> '-' OR etids IS NULL) ORDER BY {$_TABLES['users']}.uid";
 
    $users = DB_query( $usersql );
    $nrows = DB_numRows( $users );
 
    $lastrun = DB_getItem( $_TABLES['vars'], 'value', "name = 'lastemailedstories'" );
 
    // For each user, pull the stories they want and email it to them
    for( $x = 1; $x <= $nrows; $x++ )
    {
        $U = DB_fetchArray( $users );
 
        $storysql = array();
        $storysql['mysql'] = "SELECT sid,uid,date AS day,title,introtext,bodytext";
 
        $storysql['mssql'] = "SELECT sid,uid,date AS day,title,CAST(introtext AS text) AS introtext,CAST(bodytext AS text) AS introtext";
 
        $commonsql = " FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta
            WHERE draft_flag = 0 AND date <= NOW() AND date >= '{$lastrun}'
            AND ta.type = 'article' AND ta.id = sid ";
 
        $topicsql = "SELECT tid FROM {$_TABLES['topics']}"
                  . COM_getPermSQL( 'WHERE', $U['uuid'] );
        $tresult = DB_query( $topicsql );
        $trows = DB_numRows( $tresult );
 
        if( $trows == 0 )
        {
            // this user doesn't seem to have access to any topics ...
            continue;
        }
 
        $TIDS = array();
        for( $i = 1; $i <= $trows; $i++ )
        {
            $T = DB_fetchArray( $tresult );
            $TIDS[] = $T['tid'];
        }
 
        if( !empty( $U['etids'] ))
        {
            $ETIDS = explode( ' ', $U['etids'] );
            $TIDS = array_intersect( $TIDS, $ETIDS );
        }
 
        if( sizeof( $TIDS ) > 0)
        {// We have list of Daily Digest topic ids that user has access too and that the user wants a report on
             $commonsql .= " AND (ta.tid IN ('" . implode( "','", $TIDS ) . "'))";
        }
 
        $commonsql .= COM_getPermSQL( 'AND', $U['uuid'] );
        $commonsql .= ' ORDER BY featured DESC, date DESC';
 
        $storysql['mysql'] .= $commonsql;
        $storysql['mssql'] .= $commonsql;
 
        $stories = DB_query( $storysql );
        $nsrows = DB_numRows( $stories );
 
        if( $nsrows == 0 )
        {
            // If no new stories where pulled for this user, continue with next
            continue;
        }
 
        $mailtext = $LANG08[29] . strftime( $_CONF['shortdate'], time() ) . "<br />";
 
        for( $y = 0; $y < $nsrows; $y++ )
        {
            // Loop through stories building the requested email message
            $S = DB_fetchArray( $stories );
 
            $mailtext .= "<br />------------------------------<br /><br />";
            $mailtext .= "$LANG08[31]: "
                . MDIGEST_undoSpecialChars( stripslashes( $S['title'] )) . "<br />";
            if( $_CONF['contributedbyline'] == 1 )
            {
                if( empty( $authors[$S['uid']] ))
                {
                    $storyauthor = COM_getDisplayName ($S['uid']);
                    $authors[$S['uid']] = $storyauthor;
                }
                else
                {
                    $storyauthor = $authors[$S['uid']];
                }
                $mailtext .= "$LANG24[7]: " . $storyauthor . "<br />";
            }
 
            $mailtext .= "$LANG08[32]: " . strftime( $_CONF['date'], strtotime( $S['day' ])) . "<br /><br />";
 
            if( $_CONF['emailstorieslength'] > 0 )
            {
                if($S['postmode']==='wikitext'){
                    $storytext = MDIGEST_undoSpecialChars( strip_tags( COM_renderWikiText ( stripslashes( $S['introtext'] ))));
                } else {
                    $storytext = $S['introtext'];
                }
 
                if( $_CONF['emailstorieslength'] > 1 )
                {
                    $storytext = $S['introtext'] . "<br /><br />" . $S['bodytext'] ;
                }
 
                $mailtext .= $storytext . "<br /><br />";
            }
 
            $mailtext .= $LANG08[33] . ' ' . COM_buildUrl( $_CONF['site_url']
                      . '/article.php?story=' . $S['sid'] ) . "<br />";
        }
 
        $mailtext .= "<br />------------------------------<br />";
        $mailtext .= "<br />$LANG08[34]<br />";
        $mailtext .= "<br />------------------------------<br />";
 
        $mailto = $U['username'] . ' <' . $U['email'] . '>';
 
        if ($_CONF['site_mail'] !== $_CONF['noreply_mail']) {
            $mailfrom = $_CONF['noreply_mail'];
            $mailtext .= LB . LB . $LANG04[159];
        } else {
            $mailfrom = $_CONF['site_mail'];
        }
        COM_mail( $mailto, $subject, $mailtext , $mailfrom, $html = true);
    }
 
    DB_query( "UPDATE {$_TABLES['vars']} SET value = NOW() WHERE name = 'lastemailedstories'" );
}

function MDIGEST_send_digest ()
{
    global $_CONF, $_TABLES, $LANG_MDIGEST, $PHP_SELF;

    $display = '';

    if ($_CONF['emailstories'] == 1) {
        if (isset ($_POST['sendit']) && !empty ($_POST['sendit'])) {
            MDIGEST_emailUserTopics_html ();
            $display .= '<p>' . $LANG_MDIGEST['digest_sent'] . '</p>' . LB;
        } else if (isset ($_POST['resetit']) && !empty ($_POST['resetit'])) {
            DB_query ("UPDATE {$_TABLES['vars']} SET value = NOW() WHERE name = 'lastemailedstories'");
            $display .= '<p>' . $LANG_MDIGEST['digest_reset'] . '</p>' . LB;
        } else {
            $display .= '<p>' . $LANG_MDIGEST['digest_intro'] . '</p>' . LB;
            $display .= '<p>' . $LANG_MDIGEST['explain_reset'] . '</p>' . LB;
            $lastrun = DB_getItem ($_TABLES['vars'], 'value', "name = 'lastemailedstories'");
            if (empty ($lastrun)) {
                $display .= '<p>' . $LANG_MDIGEST['digest_last_sent'] . ' ' . $LANG_MDIGEST['never'] . '</p>' . LB;
            } else {
                $display .= '<p>' . $LANG_MDIGEST['digest_last_sent'] . ' <b>' . $lastrun . '</b></p>' . LB;
            }

            $sql = "SELECT sid FROM {$_TABLES['stories']} WHERE draft_flag = 0 AND date <= NOW() AND date >= '{$lastrun}'";
            $result = DB_query ($sql);
            $count = DB_numRows ($result);
            if ($count == 0) {
                $display .= '<p>' . $LANG_MDIGEST['no_stories'] . '</p>' . LB;
            } else {
                $msg = sprintf ($LANG_MDIGEST['num_stories'], $count);
                $display .= '<p>' . $msg . '</p>' . LB;

                $display .= '<form action="' . $PHP_SELF . '" method="POST">' . LB;
                $display .= '<input type="submit" value="' . $LANG_MDIGEST['send_button'] . '" name="sendit">' . LB;
                $display .= ' &nbsp; <input type="submit" value="' . $LANG_MDIGEST['reset_button'] . '" name="resetit">' . LB;
                $display .= '</form>' . LB;
            }
        }
    } else {
        $display .= '<p>' . $LANG_MDIGEST['not_enabled1'] . '</p>' . LB;
        $display .= '<blockquote><code>$_CONF[\'emailstories\'] = 1;</code></blockquote>' . LB;
        $display .= '<p>' . $LANG_MDIGEST['not_enabled2'] . '</p>' . LB;
    }

    return $display;
}

function MDIGEST_search_form ($query = '')
{
    global $_CONF, $LANG_MDIGEST, $PHP_SELF;

    $display = '';

    $display .= '<form action="' . $_CONF['site_admin_url'] . '/plugins/mdigest/search.php" method="GET">' . LB;
    $display .= '<p>' . $LANG_MDIGEST['search_text'] . '</p>' . LB;
    $display .= '<input type="text" size="40" name="query" value="' . $query . '">' . LB;
    $display .= '<input type="submit" value="' . $LANG_MDIGEST['search_button'] . '">' . LB;
    $display .= '<input type="hidden" name="mode" value="search">' . LB;
    $display .= '</form>' . LB;

    return $display;
}


$display = '';

if (SEC_hasRights ('user.mail')) {
    $display .= COM_startBlock ($LANG_MDIGEST['mdigest']);
    $display .= MDIGEST_send_digest ();
    $display .= COM_endBlock();
}

if (SEC_hasRights ('user.edit')) {
    $display .= COM_startBlock ($LANG_MDIGEST['block_headline']);
    $display .= MDIGEST_search_form ();
    $display .= COM_endBlock();
}

$display = COM_createHTMLDocument($display);
COM_output($display);

?>
