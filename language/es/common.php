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
	'MILESTONES_TITLE'					=> 'Hitos',
	'MILESTONES_VIA_GITHUB'				=> 'vía Github',
	'MILESTONES_LAST_UPDATED'			=> 'Última actualización',
	'MILESTONES_COMPLETE'				=> 'completo(s)',
	'MILESTONES_OPEN'					=> 'abierto(s)',
	'MILESTONES_CLOSED'					=> 'cerrado(s)',
	'MILESTONES_VIEW' 					=> '»» mostrar »»',
	'MILESTONES_HIDE' 					=> '&nbsp;«« ocultar ««',
	'MILESTONES_NO_REPOSITORY' 			=> 'Ho hay Hitos definidos en este respositorio',
	//ACP
	'ACP_MILESTONES_TITLE'				=> 'Hitos',
	'ACP_MILESTONES_CONFIG'				=> 'Configuración',
	'MILESTONES_ENABLE'					=> 'Habilitar Hitos',
	'MILESTONES_ENABLE_EXPLAIN'			=> 'Habilitar Hitos en el índice.',
	'MILESTONES_PLACEHOLDER'			=> 'phpbb/phpbb',
	'MILESTONES_PLACEHOLDER_NAME'		=> 'phpbb',
	'MILESTONES_REPOSITORY'				=> 'Repositorio',
	'MILESTONES_REPOSITORY_EXPLAIN'		=> 'Agregar el repositorio elegído.',
	'MILESTONES_REPOSITORY_TEXT'			=> 'Nombre del Hito',
	'MILESTONES_MORE_LINKS'				=> 'Agregar repositorio',
	'LOG_MILESTONES_SAVE'				=> '<strong>Configuración de Hitos modificada</strong>' ,
	'MILESTONES_SAVED'					=> 'Configuración guardada',
	'MILESTONES_VERSION'					=> 'Versión',
	'MILESTONES_VERSION_CHECK'			=> 'Comprobación de la versión de los Hitos',
	'MILESTONES_AUTHOR'					=> 'Autor',
	'MILESTONES_ANNOUNCEMENT_TOPIC'		=> 'Anuncio de lanzamiento',
	'MILESTONES_CURRENT_VERSION'		=> 'Versión actual',
	'MILESTONES_VERSION'				=> 'Versión',
	'MILESTONES_DOWNLOAD_LATEST'		=> 'Decargar la última versión',
	'MILESTONES_DOWNLOAD'				=> 'Descargar',
	'MILESTONES_LATEST_VERSION'			=> 'Ultima versión',
	'MILESTONES_NOT_UP_TO_DATE'			=> '%s no esta al día',
	'MILESTONES_RELEASE_ANNOUNCEMENT'	=> 'Tema del anuncio',
	'MILESTONES_UP_TO_DATE'				=> '%s está actualizado',
));
