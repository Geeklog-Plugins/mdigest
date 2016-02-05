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
    'mdigest' => 'Notifications nouveaux articles',
    'access_denied' => 'Acc�s interdit',
    'access_denied_msg' => 'Vous n\'avez pas acc�s � cette interface administrative.',
    'installation_failed' => 'L\'installation a �chou�.',
    'installation_failed_msg' => 'L\'installation du plugin Manual Digest a �chou�. Merci de consulter le ficheir error.log pour plus d\'informations.',
    'uninstall_failed' => 'La d�sinstallation a �chou�.',
    'uninstall_failed_msg' => 'La d�sinstallation du plugin Manual Digest a �chou�. Merci de consulter le ficheir error.log pour plus d\'informations.',

    'digest_sent' => 'La notification a bien �t� exp�di�e. <a href="' . $_CONF['site_admin_url'] . '/plugins/mdigest/index.php">Retour � l\'interface d\'administration</a>.',
    'digest_intro' => 'Cette fonction vous permet d\'informer les membres de votre site de la publication d\'un nouvel article. Elle est ind�pendante de la fonction automatis�e par cronjob et vous permet d\'exp�dier une notification suppl�mentaire lorsque vous le souhaitez. Cliquez sur le bouton "Envoyer" ci-dessous (disponible uniquement si vous avez de nouveaux articles � signaler) pour exp�dier l\'avis de parution d\'un nouvel article aux membres qui le souhaitent.',
    'digest_last_sent' => 'Derni�re notification exp�di�e :',
    'never' => '(Jamais)',
    'no_stories' => '<b>Pas de nouveaux articles.</b>',
    'num_stories' => '<b>%d</b> articles seront exp�di�s.',
    'send_button' => 'Envoyer!',
    'not_enabled1' => '<strong>Attention:</strong> Daily Digest n\'est pas activ�. Assurez-vous que',
    'not_enabled2' => 'dans l\'interface de configuration.',

    'search_text' => 'Rechercher un nom de membre, une adresse email ou un identifiant d\'utilisateur.',
    'search_button' => 'Rechercher',
    'new_search' => 'Nouvelle recherche',
    'inspect_text' => "Cliquez sur le nom de l'utilisateur pour inspecter ses param�tres de notification.",
    'uid_not_found' => 'Il n\'y a pas de compte pour l\'identifiant %d.',
    'not_found' => 'Aucun r�sultat pour <b>%s</b>.',
    'try_again' => 'Merci d\'essayer � nouveau.',
    'user' => 'Membre',
    'topics' => 'Cat�gories',
    'all_topics' => 'Toutes les cat�gories',
    'no_topics' => 'Aucun',
    'reset_button' => 'Reset',
    'success' => 'La notification pour l\'utilisateur <b>%s</b> a �t� supprim�e.',
    'block_headline' => 'Notification de publication',
    'digest_reset' => 'La notification a �t� r�initialis�e. <a href="' . $_CONF['site_admin_url'] . '/plugins/mdigest/index.php">Retour</a>.',
    'explain_reset' => 'Utilisation avanc�e : Si vous ne souhaitez pas que syst�me exp�die de notification pour les derniers articles publi�s, cliquez sur le bouton "Reset". Ceci aura pour effet d\'annuler d\'�ventuelles notification par cronjob.',

    'forums' => 'Forums',
    'no_forums' => 'Aucun',
    'forum_topics' => 'Sujets des forums'
);

// Messages for the plugin upgrade
$PLG_mdigest_MESSAGE3002 = $LANG32[9]; // "requires a newer version of Geeklog"

?>
