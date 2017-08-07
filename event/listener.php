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
			'core.text_formatter_s9e_configure_after' => 'modify_img_template',
		);
	}

	/**
	* Modify image BBCode's template
	*
	* @param \phpbb\event\data $event The event object
	* @return void
	* @access public
	*/
	public function modify_img_template($event)
	{
		$tag   = $event['configurator']->tags['img'];
		$dom   = $tag->template->asDOM();
		$xpath = new \DOMXPath($dom);
		foreach ($xpath->query('//img[@src]') as $img)
		{
			// Create a <noscript> element that contains a copy of the original <img>
			$noscript = $dom->createElement('noscript');
			$noscript->appendChild($img->cloneNode(true));

			// Replace the src attribute with a data-original attribute
			$img->setAttribute('data-original', $img->getAttribute('src'));
			$img->removeAttribute('src');

			// Replace <img> with <noscript> then reinsert <img> before <noscript>
			$img->parentNode->replaceChild($noscript, $img);
			$noscript->parentNode->insertBefore($img, $noscript);
		}
		$dom->saveChanges();
	}
}
