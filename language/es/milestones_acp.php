<?php
/**
*
* @package phpBB Extension - Milestones
* @copyright (c) 2016 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'MILESTONES_ENABLE'					=> 'Habilitar Hitos',
	'MILESTONES_ENABLE_EXPLAIN'			=> 'Habilitar Hitos en el índice',
	'MILESTONES_PLACEHOLDER'			=> 'phpbb/phpbb',
	'MILESTONES_PLACEHOLDER_NAME'		=> 'phpbb',
	'MILESTONES_REPOSITORY'				=> 'Repositorio',
	'MILESTONES_REPOSITORY_EXPLAIN'		=> 'Añadir un repositorio de su elección.',
	'MILESTONES_REPOSITORY_TEXT'		=> 'Nombre del Hito',
	'MILESTONES_MORE_LINKS'				=> 'Añadir repositorio',
	'MILESTONES_SAVED'					=> 'Ajustes de Hitos guardados',
	'MILESTONES_VERSION'				=> 'Versión',
));
