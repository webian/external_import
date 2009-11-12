<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2007-2009 Francois Suter (Cobweb) <typo3@cobweb.ch>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/


/**
 * This class executes Scheduler events for automatic synchronisations of external data
 *
 * @author		Francois Suter (Cobweb) <typo3@cobweb.ch>
 * @package		TYPO3
 * @subpackage	tx_externalimport
 *
 * $Id$
 */
class tx_externalimport_autosync_scheduler_Task extends tx_scheduler_Task {
	/**
	 * @var	string	Name of the table to synchronize ("all" for all tables)
	 */
	public $table;
	/**
	 * @var	mixed	Index of the particular synchronization
	 */
	public $index;

	/**
	 * This method executes the task registered in the Scheduler event
	 *
	 * @return	void
	 */
	public function execute() {

			// Get the crid for the event
		$crid = $this->scheduler->getEventCrid($this->eventUid);

			// Instantiate the import object and call appropriate method depending on command
		$importer = t3lib_div::makeInstance('tx_externalimport_importer');
		if ($this->commands['sync'] == 'all') {
			$importer->synchronizeAllTables();
		}
	}
}
?>