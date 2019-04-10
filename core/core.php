<?php

// Subpackage namespace
namespace LittleBizzy\MaintenanceMode\Core;

// Aliased namespaces
use \LittleBizzy\MaintenanceMode\Helpers;

/**
 * Core class
 *
 * @package Maintenance Mode
 * @subpackage Core
 */
final class Core extends Helpers\Singleton {



	/**
	 * Needed admin capability
	 */
	const CAPABILITY = 'delete_plugins';



	/**
	 * Pseudo constructor
	 */
	protected function onConstruct() {


		/* Plugin setup */

		// Factory object
		$this->plugin->factory = new Factory($this->plugin);

		// Add registrar handler
		$this->plugin->factory->registrar->setHandler($this);

		// Set admin capability
		$this->plugin->capability = self::CAPABILITY;


		/* Context check */

		// Check admin context
		if ($this->plugin->context()->admin()) {
			$this->plugin->factory->admin();
			$this->plugin->factory->toolbar();

		// Front area display
		} elseif ($this->plugin->context()->front()) {
			$this->plugin->factory->display();
		}
	}



	/**
	 * Delete plugin options
	 */
	public static function onUninstall() {
		delete_option('mml_enabled');
		delete_option('mml_mode');
	}



}