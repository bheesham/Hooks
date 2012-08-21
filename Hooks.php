<?php
/**
 *
 * 	A class for hooks.
 *
 * 	@author Bheesham Persaud <bheesham.persaud@live.ca>
 * 	@copyright Copyright (C) 2012 Bheesham Persaud.
 * 	@license Beerware <http://wikipedia.org/wiki/Beerware>
 *
 */

class Hooks {
	private $names = array();

	function __construct() {

	}

	/**
	 *
	 * 	Attach something to that hook.
	 * 	
	 * 	@param string
	 * 	@param array|string 			Can be a function or the name of a file
	 * 														to include.
	 * 	@param mixed[] 						The arguments you want to pass into the
	 *	 													callback if it's a function.
	 */
	function attach($name, $callback, $args = '') {
		if (!isset($this->names[$name])) {
			$this->names[$name] = array();
		}

		if (is_string($callback) && file_exists($callback)) {
			$this->names[$name][] = array('include', $callback);
		}

		if (is_array($callback)) {
			if (is_callable($callback)) {
				$this->names[$name][] = array('callback', $callback, $args);
			} else if (is_string($callback[0]) && function_exists($callback[0])) {
				$this->names[$name][] = array('function', $callback[0], $args);	
			}
		}
	}

	/**
	 *
	 * Run's all of the hooks associated with this name.
	 * 	
	 * 	@param string
	 *
	 */
	function run($name) {
		// Nothing was attached to this hook.
		if (!isset($this->names[$name])) {
			return;
		}

		foreach($this->names[$name] as $hook) {
			switch ($hook[0]) {
				case 'include':
					include_once $hook[1];
					break;
				case 'function':
				case 'callback':
					call_user_func($hook[1], $hook[2]);
					break;
			}
		}
	}

}