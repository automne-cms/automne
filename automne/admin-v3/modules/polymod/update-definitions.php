<?php
/**
  * Update all stored definitions
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * @version $Id: update-definitions.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $
  */
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

//foreach definition, plugin and rss, recompile stored values if exists
$modules = CMS_modulesCatalog::getAll("id", true);
foreach ($modules as $module) {
	if ($module->isPolymod()) {
		//get objects definition for module
		$objects = CMS_poly_object_catalog::getObjectsForModule($module->getCodename());
		foreach ($objects as $object) {
			if ($object->getValue('indexURL')) {
				$object->compileDefinition();
				$object->writeToPersistence();
			}
		}
		//get plugins for module
		$plugins = CMS_poly_object_catalog::getAllPluginDefIDForModule($module->getCodename());
		foreach ($plugins as $pluginID) {
			$plugin = new CMS_poly_plugin_definitions($pluginID);
			if ($plugin->getValue('definition') && method_exists($plugin, 'compileDefinition')) {
				$plugin->compileDefinition();
				$plugin->writeToPersistence();
			}
		}
	}
}
//get all RSS definition
$rssDefinitions = CMS_poly_object_catalog::getAllRSSDefinitionsForObject();
foreach ($rssDefinitions as $rssDefinition) {
	if ($rssDefinition->getValue('definition')) {
		$rssDefinition->compileDefinition();
		$rssDefinition->writeToPersistence();
	}
}
echo "Objects definitions recompilations is done.<br />";
?>