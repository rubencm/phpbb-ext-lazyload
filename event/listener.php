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
			'core.text_formatter_s9e_render_after'	=> 'modify_img_bbcode',
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
		$event['html'] = preg_replace("/<img src=\"(.*?)\" class=\"postimage\" alt=\"(.*?)\">/i", "<img data-original=\"$1\" class=\"postimage\" alt=\"$2\"><noscript><img src=\"$1\" class=\"postimage\" alt=\"$2\"></noscript>", $event['html']);
	}
}
