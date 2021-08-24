<?php
/**
*
* @package phpBB Extension - Milestones
* @copyright (c) 2016 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\milestones\controller;

use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\language\language;
use phpbb\log\log_interface;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;

class admin_controller
{
	/** @var config */
	protected $config;

	/** @var template */
	protected $template;

	/** @var log_interface */
	protected $log;

	/** @var user */
	protected $user;

	/** @var driver_interface */
	protected $db;

	/** @var request */
	protected $request;

	/** @var language */
	protected $language;

	/** @var string */
	protected $milestones_table;

	/** @var string Custom form action */
	protected $u_action;

	/**
	 * Constructor
	 *
	 * @param config				$config
	 * @param template				$template
	 * @param log_interface			$log
	 * @param user					$user
	 * @param driver_interface		$db
	 * @param request				$request
	 * @param language				$language
	 * @param string				$milestones_table
	 */
	public function __construct(
		config $config,
		template $template,
		log_interface $log,
		user $user,
		driver_interface $db,
		request $request,
		language $language,
		$milestones_table
	)
	{
		$this->config 			= $config;
		$this->template 		= $template;
		$this->log 				= $log;
		$this->user 			= $user;
		$this->db 				= $db;
		$this->request 			= $request;
		$this->language			= $language;
		$this->milestones_table = $milestones_table;
	}

	/**
	* Display the options a user can configure for this extension
	*
	* @return null
	* @access public
	*/
	public function display_options()
	{
		$this->language->add_lang('milestones_acp', 'dmzx/milestones');

		add_form_key('acp_milestones');

		$sql = 'SELECT *
			FROM '. $this->milestones_table;
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			if (!empty($row['milestones']))
			{
				$this->template->assign_block_vars('milestones', [
					'MILESTONES'		=> $row['milestones'],
					'MILESTONES_TEXT'	=> $row['milestones_text'],
				]);
			}
		}
		$this->db->sql_freeresult($result);

		if (empty($row['milestones']))
		{
			$this->template->assign_block_vars('milestones', [
				'MILESTONES' => '',
			]);
		}

		// Is the form being submitted to us?
		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key('acp_milestones'))
			{
				trigger_error('FORM_INVALID');
			}

			$this->db->sql_query('DELETE FROM ' . $this->milestones_table);

			if (isset($row['milestones_id']) !== null)
			{
				$sql_arr_id = [
					'milestones_id' => '1',
				];
				$sql = 'INSERT INTO ' . $this->milestones_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr_id);
				$this->db->sql_query($sql);
			}

			$milestones 		= $this->request->variable('milestones', ['' => ''],true);
			$milestones_text 	= $this->request->variable('milestones_text', ['' => ''],true);
			$milestones			= array_filter($milestones);

			$i = 0;
			while ($i < count($milestones))
			{
				$sql_ary1 = [
					'milestones' 		=> $milestones[$i],
					'milestones_text' 	=> $milestones_text[$i],
				];
				$this->db->sql_multi_insert($this->milestones_table, $sql_ary1);
				$i++;
			}

			$sql_ary_block = [
				'milestones_enable' => $this->request->variable('milestones_enable', ''),
			];

			$this->db->sql_query('UPDATE ' . $this->milestones_table . '
				SET ' . $this->db->sql_build_array('UPDATE', $sql_ary_block) . "
				WHERE milestones_id = 1"
			);

			// Add option settings change action to the admin log
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_MILESTONES_SAVE');

			trigger_error($this->user->lang('MILESTONES_SAVED') . adm_back_link($this->u_action));
		}

		$sql = 'SELECT milestones_enable
			FROM ' . $this->milestones_table . "
			WHERE milestones_id = 1";
		$result = $this->db->sql_query($sql);
		$milestones_data = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$this->template->assign_vars([
			'U_ACTION'				=> $this->u_action,
			'MILESTONES_ENABLE'		=> $milestones_data['milestones_enable'],
			'MILESTONES_VERSION'	=> $this->config['milestones_version'],
		]);
	}

	/**
	* Set page url
	*
	* @param string $u_action Custom form action
	* @return null
	* @access public
	*/
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
