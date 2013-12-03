<?php
/**
  * Class CMS_polymod_oembed_definition_catalog
  * Represent an Oembed definition for an object
  *
  */

class CMS_polymod_oembed_definition_catalog extends CMS_grandFather
{
	public static function getById($id = 0) {
		if (! io::isPositiveInteger($id)) {
			return null;
		}
		$sql = 'SELECT * from mod_object_oembed_definition where id_mood = '.io::sanitizeSQLString($id);
		$query = new CMS_query($sql);
		$data = array_pop($query->getAll());
		if($data === null) {
			return null;
		}

		$definition = new CMS_polymod_oembed_definition();

		$definition->setId($data['id_mood']);
		$definition->setUuid($data['uuid_mood']);
		$definition->setObjectdefinition($data['objectdefinition_mood']);
		$definition->setCodename($data['codename_mood']);
		$definition->setXML($data['xml_mood']);
		$definition->setJson($data['json_mood']);

		return $definition;
	}

	public static function getByCodename($codename) {
		$sql = 'SELECT * from mod_object_oembed_definition where codename_mood = "'.io::sanitizeSQLString($codename).'"';
		$query = new CMS_query($sql);

		$data = array_pop($query->getAll());
		if($data === null) {
			return null;
		}

		$definition = new CMS_polymod_oembed_definition();

		$definition->setId($data['id_mood']);
		$definition->setUuid($data['uuid_mood']);
		$definition->setObjectdefinition($data['objectdefinition_mood']);
		$definition->setCodename($data['codename_mood']);
		$definition->setXML($data['xml_mood']);
		$definition->setJson($data['json_mood']);

		return $definition;
	}

	public static function getDefinitionsForObject($objectid) {
		$sql = 'SELECT * from mod_object_oembed_definition where objectdefinition_mood = "'.io::sanitizeSQLString($objectid).'"';
		$query = new CMS_query($sql);

		$defs = array();

		while ($data = $query->getArray()) {
			$definition = new CMS_polymod_oembed_definition();
			$definition->setId($data['id_mood']);
			$definition->setUuid($data['uuid_mood']);
			$definition->setObjectdefinition($data['objectdefinition_mood']);
			$definition->setCodename($data['codename_mood']);
			$definition->setXML($data['xml_mood']);
			$definition->setJson($data['json_mood']);
			$defs[] = $definition;
		}
		return $defs;
	}

	public static function countByCodename($codename, $id = null) {
		$sql = 'SELECT count(*) as count from mod_object_oembed_definition where codename_mood = "'.io::sanitizeSQLString($codename).'"';
		if($id) {
			$sql .= ' AND id_mood <> '.$id;
		}
		$query = new CMS_query($sql);
		$data = array_pop($query->getAll());
		return (int) $data['count'];
	}
}