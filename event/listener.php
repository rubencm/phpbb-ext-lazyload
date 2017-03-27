<?php
/**
*
* LazyLoad extension for the phpBB Forum Software package.
*
* @copyright (c) 2017 Rubén Calvo <rubencm@gmail.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace rubencm\lazyload\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/**
	* Constructor
	*
	* @access public
	*/
	public function __construct()
	{
		// Nothing
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.viewtopic_modify_post_action_conditions'	=> 'modify_img_bbcode',
		);
	}

	/**
	* Modify image BBCode
	*
	* @param \phpbb\event\data $event The event object
	* @return void
	* @access public
	*/
	public function modify_img_bbcode($event)
	{
		global $message;
		
		$message = preg_replace("/<img src=\"(.*?)\" class=\"(.*?)\" alt=\"(.*?)\">/i", "<img data-original=\"$1\" class=\"$2\" alt=\"$3\"><noscript><img src=\"$1\" class=\"$2\" alt=\"$3\"></noscript>", $message);
	}
}
