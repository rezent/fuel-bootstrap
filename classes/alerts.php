<?php

/**
 * Alerts Class
 *
 * @package		Bootstrap
 * @category	Package
 * @author		Derek Myers
 * @link		https://github.com/dmyers/fuel-bootstrap
 */
 
namespace Bootstrap;

class Alerts
{
	/**
	 * loaded alerts instance
	 */
	protected static $_instance = null;

	/**
	 * Types of alerts
	 */
	public static $types = array(
		'success', 'info', 'warning', 'error', 'danger',
	);
	
	/**
	 * array of alerts
	 */
	public static $alerts = array();

	/**
	 * Returns a new Alerts object.
	 *
	 *     $alerts = Alerts::forge();
	 *
	 * @param	void
	 * @access	public
	 * @return  Alerts
	 */
	public static function forge()
	{
		return new static;
	}

	/**
	 * create or return the alerts instance
	 *
	 * @param	void
	 * @access	public
	 * @return	Alerts object
	 */
	public static function instance()
	{
		if (static::$_instance === null) {
			static::$_instance = static::forge();
		}

		return static::$_instance;
	}

	/**
	 * loads alerts from session
	 *
	 * @param	void
	 * @access	public
	 * @return	void
	 */
	public static function load()
	{
		foreach (self::$types as $type) {
			$type_alerts = \Session::get_flash($type);

			if (!empty($type_alerts)) {
				self::$alerts[$type][] = $type_alerts;
			}
		}
	}

	/**
	 * adds new success alert
	 *
	 * @param	string	message for alert
	 * @param	bool	whether to store in session
	 * @access	public
	 * @return	void
	 */
	public static function success($message, $flash = false)
	{
		self::add('success', $message, $flash);
	}

	/**
	 * adds new info alert
	 *
	 * @param	string	message for alert
	 * @param	bool	whether to store in session
	 * @access	public
	 * @return	void
	 */
	public static function info($message, $flash = false)
	{
		self::add('info', $message, $flash);
	}

	/**
	 * adds new warning alert
	 *
	 * @param	string	message for alert
	 * @param	bool	whether to store in session
	 * @access	public
	 * @return	void
	 */
	public static function warning($message, $flash = false)
	{
		self::add('warning', $message, $flash);
	}

	/**
	 * adds new error alert
	 *
	 * @param	string	message for alert
	 * @param	bool	whether to store in session
	 * @access	public
	 * @return	void
	 */
	public static function error($message, $flash = false)
	{
		self::add('error', $message, $flash);
	}

	/**
	 * adds new danger alert
	 *
	 * @param	string	message for alert
	 * @param	bool	whether to store in session
	 * @access	public
	 * @return	void
	 */
	public static function danger($message, $flash = false)
	{
		self::add('danger', $message, $flash);
	}

	/**
	 * adds new alert
	 *
	 * @param	string	type of alert
	 * @param	string	message for alert
	 * @param	bool	whether to store in session
	 * @access	public
	 * @return	void
	 */
	public static function add($type, $message, $flash = false)
	{
		if (!in_array($type, self::$types)) {
			throw new BootstrapException('Invalid alert type given');
		}

		if ($flash) {
			\Session::set_flash($type, $message);
		} else {
			self::$alerts[$type][] = $message;
		}
	}

	/**
	 * adds new alert and stores session
	 *
	 * @param	string	type of alert
	 * @param	string	message for alert
	 * @access	public
	 * @return	void
	 */
	public static function flash($type, $message)
	{
		self::add($type, $message, true);
	}

	/**
	 * renders the alerts
	 *
	 * @param	void
	 * @access	public
	 * @return	void
	 */
	public static function render()
	{
		self::load();

		if (empty(self::$alerts)) {
			return;
		}

		return \View::forge('alerts', array('alerts' => self::$alerts));
	}
}
