<?php
/**
*
* @package phpBB Extension - Milestones
* @copyright (c) 2016 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\milestones\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var string */
	protected $milestones_table;

	/**
	* Constructor
	*
	* @param \phpbb\template\template				$template
	* @param \phpbb\user							$user
	* @param \phpbb\db\driver\driver_interface 		$db
	* @param \phpbb\request\request					$request
	* @param string									$milestones_table
	*/
	public function __construct(
		\phpbb\template\template $template,
		\phpbb\user $user,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\request\request $request,
		$milestones_table)
	{
		$this->template 		= $template;
		$this->user 			= $user;
		$this->db 				= $db;
		$this->request 			= $request;
		$this->milestones_table = $milestones_table;
	}

	public static function getSubscribedEvents()
	{
		return array(
			'core.user_setup'	=> 'load_language_on_setup',
			'core.page_header' => 'page_header',
		);
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext 	= $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name'	=> 'dmzx/milestones',
			'lang_set'	=> 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function page_header($event)
	{
		$sql = 'SELECT *
			FROM ' . $this->milestones_table;
		$result	 = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);

		if ($row['milestones_enable'])
		{
			$this->template->assign_vars(array(
				'MILESTONES_ENABLE'	=> $row['milestones_enable'],
			));

			while ($row = $this->db->sql_fetchrow($result))
			{
				if (!empty($row['milestones']))
				{
					$this->template->assign_block_vars('milestones', array(
						'MILESTONES'		=> $row['milestones'],
						'MILESTONES_TEXT'	=> $row['milestones_text'],
					));
				};
			}
		}
		$this->db->sql_freeresult($result);
	}
}
