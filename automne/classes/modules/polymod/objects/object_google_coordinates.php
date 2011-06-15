<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Automne (TM)														  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2009 WS Interactive								  |
// +----------------------------------------------------------------------+
// | Automne is subject to version 2.0 or above of the GPL license.		  |
// | The license text is bundled with this package in the file			  |
// | LICENSE-GPL, and is available through the world-wide-web at		  |
// | http://www.gnu.org/copyleft/gpl.html.								  |
// +----------------------------------------------------------------------+
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: object_integer.php,v 1.3 2009/06/05 15:02:18 sebastien Exp $

/**
  * Class CMS_object_coordinates
  *
  * represent a simple integer object
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr> 
  * @author Nathalie Crevenat <nathalie.crevenat@ws-interactive.fr>
  */

class CMS_object_google_coordinates extends CMS_object_common
{
	/**
	  * Polymod Messages
	  */
	const MESSAGE_OBJECT_COORDINATES_LABEL = 561;
	const MESSAGE_OBJECT_COORDINATES_DESCRIPTION = 562;
	const MESSAGE_OBJECT_COORDINATES_LONGITUDE_DESCRIPTION = 563;
	const MESSAGE_OBJECT_COORDINATES_LATITUDE_DESCRIPTION = 564;
	const MESSAGE_OBJECT_COORDINATES_PARAMETER_FIELDS = 568;
	const MESSAGE_OBJECT_COORDINATES_PARAMETER_FIELDS_DESC = 566;
	const MESSAGE_OBJECT_COORDINATES_PARAMETER_USE_FIELDS = 567;
	const MESSAGE_OBJECT_COORDINATES_PARAMETER_USE_FIELDS_DESC = 565;
	const MESSAGE_OBJECT_COORDINATES_FIELD_UPDATE_FROM_ADDRESS = 569;
	const MESSAGE_OBJECT_COORDINATES_FIELD_UNKOWN_ADDRESS = 570;
	const MESSAGE_OBJECT_COORDINATES_FIELD_PUT_ON_MAP = 571;
	const MESSAGE_OBJECT_COORDINATES_FIELD_MAP_WINDOW = 572;
	const MESSAGE_OBJECT_COORDINATES_FIELD_ADDRESS = 567;
	const MESSAGE_OBJECT_COORDINATES_FIELD_ENTER_ADDRESS = 573;
	
	/**
	  * from which module, fields messages should be get ?
	  * @var constant
	  * @access private
	  */
	protected $_messagesModule = MOD_POLYMOD_CODENAME;
	
	/**
	  * object label
	  * @var integer
	  * @access private
	  */
	protected $_objectLabel = self::MESSAGE_OBJECT_COORDINATES_LABEL;
	
	/**
	  * object description
	  * @var integer
	  * @access private
	  */
	protected $_objectDescription = self::MESSAGE_OBJECT_COORDINATES_DESCRIPTION;
	
	/**
	  * all subFields definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|boolean|integer|date)", "required" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	protected $_subfields = array(0 => array(
										'type' 			=> 'string',
										'required' 		=> true,
										'internalName'	=> 'lat',
									),
								  1 => array(
										'type' 			=> 'string',
										'required' 		=> true,
										'internalName'	=> 'long',
									),
							);
	
	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_subfieldValues = array(0 => '', 1 => '');
	
	/**
	  * all parameters definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|boolean|integer|date)", "required" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	protected $_parameters = array(0 => array(
										'type' 			=> 'boolean',
										'required' 		=> true,
										'internalName'	=> 'useFieldsAsAddress',
										'externalName'	=> self::MESSAGE_OBJECT_COORDINATES_PARAMETER_USE_FIELDS,
										'description'	=> self::MESSAGE_OBJECT_COORDINATES_PARAMETER_USE_FIELDS_DESC,
									),
									1 => array(
										'type' 			=> 'fields',
										'required' 		=> true,
										'internalName'	=> 'fieldsForAddress',
										'externalName'	=> self::MESSAGE_OBJECT_COORDINATES_PARAMETER_FIELDS,
										'description'	=> self::MESSAGE_OBJECT_COORDINATES_PARAMETER_FIELDS_DESC,
									),
								);
	
	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_parameterValues = array(0 => false, 1 => '');
	
	/**
	  * Constructor.
	  * initialize object.
	  *
	  * @param array $datas DB object values : array(integer "subFieldID" => mixed)
	  * @param CMS_object_field reference
	  * @param boolean $public values are public or edited ? (default is edited)
	  * @return void
	  * @access public
	  */
	function __construct($datas=array(), &$field, $public=false)
	{
		parent::__construct($datas, $field, $public);
	}
	
	/**
	  * get HTML admin (used to enter object values in admin)
	  *
	  * @param integer $fieldID, the current field id (only for poly object compatibility)
	  * @param CMS_language $language, the current admin language
	  * @param string prefixname : the prefix to use for post names
	  * @return string : the html admin
	  * @access public
	  */
	function getHTMLAdmin($fieldID, $language, $prefixName) {
		$return = parent::getHTMLAdmin($fieldID, $language, $prefixName);
		$params = $this->getParamsValues();
		
		unset($return['items'][0]['hideLabel']);
		unset($return['items'][1]['hideLabel']);
		$return['items'][0]['fieldLabel'] = $language->getMessage(self::MESSAGE_OBJECT_COORDINATES_LONGITUDE_DESCRIPTION,false ,$this->_messagesModule);
		$return['items'][1]['fieldLabel'] = $language->getMessage(self::MESSAGE_OBJECT_COORDINATES_LATITUDE_DESCRIPTION,false ,$this->_messagesModule);
		
		$ids = 'coord-'.md5(mt_rand().microtime());
		$return['items'][0]['id'] = $ids.'-long';
		$return['items'][1]['id'] = $ids.'-lat';
		
		//Move the first two fields
		$return['items'][2] = $return['items'][1];
		$return['items'][1] = $return['items'][0];
		
		//Create toolbar
		$return['items'][0] = array(
			'xtype'		=> 'toolbar',
			'items'		=> array(),
		);
		if ($params['useFieldsAsAddress']) {
			$return['items'][0]['items'][] = array(
				'xtype'		=> 'button',
				'text'		=> $language->getMessage(self::MESSAGE_OBJECT_COORDINATES_FIELD_UPDATE_FROM_ADDRESS,false ,$this->_messagesModule),
				'handler'	=> sensitiveIO::sanitizeJSString('function(button){
					var addrFields = \''.$params['fieldsForAddress'].'\'.split(\';\');
					var form = button.findParentByType(\'atmForm\').form;
					var addr = \'\';
					for(var i = 0; i < addrFields.length; i++) {
						var field = form.findField(\'polymodFieldsValue[\' + addrFields[i] + \'_0]\');
						var listfield = form.findField(\'polymodFieldsValue[list\' + addrFields[i] + \'_0]\');
						if (field) {
							addr += \' \' + Ext.util.Format.stripTags(field.getValue());
						} else if (listfield) {
							addr += \' \' + Ext.util.Format.stripTags(listfield.lastSelectionText);
						}
					}
					var geocoder = new google.maps.Geocoder();
					geocoder.geocode({address:addr}, function(results, status) {
						if (status == \'OK\') {
							Ext.getCmp(\''.$ids.'-long\').setValue(results[0].geometry.location.lng());
							Ext.getCmp(\''.$ids.'-lat\').setValue(results[0].geometry.location.lat());
						} else {
							Automne.message.popup({
								msg: 				String.format(\''.$language->getJsMessage(self::MESSAGE_OBJECT_COORDINATES_FIELD_UNKOWN_ADDRESS,false ,$this->_messagesModule).'\', addr),
								buttons: 			Ext.MessageBox.OK,
								closable: 			false,
								icon: 				Ext.MessageBox.ERROR
							});
						}
					});
				}', false, false),
				'scope'		=> 'this'
			);
		}
		$return['items'][0]['items'][] = '->';
		$return['items'][0]['items'][] = array(
			'xtype'		=> 'button',
			'text'		=> $language->getMessage(self::MESSAGE_OBJECT_COORDINATES_FIELD_PUT_ON_MAP,false ,$this->_messagesModule),
			'handler'	=> sensitiveIO::sanitizeJSString('function(button){
				var lat = Ext.getCmp(\''.$ids.'-lat\').getValue();
				var long = Ext.getCmp(\''.$ids.'-long\').getValue();
				if (lat && long) {
					var mapwin = new Automne.Window({
		                layout: \'fit\',
		                title: \''.$language->getJSMessage(self::MESSAGE_OBJECT_COORDINATES_FIELD_MAP_WINDOW,false ,$this->_messagesModule).'\',
		                modal:true,
						width:600,
		                height:600,
		                items: {
		                    xtype: \'gmappanel\',
		                    zoomLevel: 13,
		                    gmapType: \'map\',
		                    id: \'map-'.$ids.'\',
		                    mapConfOpts: [\'enableScrollWheelZoom\',\'enableDoubleClickZoom\',\'enableDragging\'],
		                    mapControls: [\'GSmallMapControl\',\'GMapTypeControl\',\'NonExistantControl\'],
							setCenter: {
		                        lat: lat,
								lng: long,
								marker: {draggable: true}
		                    }
		                },
						listeners:{\'beforeclose\':function(window){
							var map = Ext.getCmp(\'map-'.$ids.'\');
							if (map.gmarks && map.gmarks[0]) {
								Ext.getCmp(\''.$ids.'-long\').setValue(map.gmarks[0].getPosition().lng());
								Ext.getCmp(\''.$ids.'-lat\').setValue(map.gmarks[0].getPosition().lat());
							}
						}}
		            });
					mapwin.show(button);
				} else {
					var gmapWindow = function(button, value) {
					   	if (button == \'ok\') {
							var mapwin = new Automne.Window({
				                layout: \'fit\',
				                title: \''.$language->getJSMessage(self::MESSAGE_OBJECT_COORDINATES_FIELD_MAP_WINDOW,false ,$this->_messagesModule).'\',
				                modal:true,
								width:600,
				                height:600,
				                items: {
				                    xtype: \'gmappanel\',
				                    zoomLevel: 13,
				                    gmapType: \'map\',
				                    id: \'map-'.$ids.'\',
				                    mapConfOpts: [\'enableScrollWheelZoom\',\'enableDoubleClickZoom\',\'enableDragging\'],
				                    mapControls: [\'GSmallMapControl\',\'GMapTypeControl\',\'NonExistantControl\'],
									setCenter: {
				                        geoCodeAddr: value,
										marker: {draggable: true}
				                    }
				                },
								listeners:{\'beforeclose\':function(window){
									var map = Ext.getCmp(\'map-'.$ids.'\');
									if (map.gmarks && map.gmarks[0]) {
										Ext.getCmp(\''.$ids.'-long\').setValue(map.gmarks[0].getPosition().lng());
										Ext.getCmp(\''.$ids.'-lat\').setValue(map.gmarks[0].getPosition().lat());
									}
								}}
				          	});
							mapwin.show();
						}
					};
					Ext.MessageBox.prompt(\''.$language->getJSMessage(self::MESSAGE_OBJECT_COORDINATES_FIELD_ADDRESS,false ,$this->_messagesModule).'\', \''.$language->getJSMessage(self::MESSAGE_OBJECT_COORDINATES_FIELD_ENTER_ADDRESS,false ,$this->_messagesModule).'\', gmapWindow);
				}
			}', false, false),
			'listeners'	=> array('render' => sensitiveIO::sanitizeJSString('function(){
				if (typeof google == \'undefined\' || typeof google.maps == \'undefined\' || typeof google.maps.Map == \'undefined\') {
					var script = document.createElement("script");
				    script.type = "text/javascript";
				    script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=isNaN";
				    document.body.appendChild(script);
				}
			}', false, false)),
			'scope'		=> 'this'
		);
		return $return;
	}

    /**
      * get object values structure available with getValue method
      *
      * @return multidimentionnal array : the object values structure
      * @access public
      */
    function getStructure() {
		$structure = parent::getStructure();
		unset($structure['value']);
		$structure['longitude'] = '';
		$structure['latitude'] = '';
		return $structure;
    }

    /**
      * get an object value
      *
      * @param string $name : the name of the value to get
      * @param string $parameters (optional) : parameters for the value to get
      * @return multidimentionnal array : the object values structure
      * @access public
      */
    function getValue($name, $parameters = '') {
		switch($name) {
		    case "longitude" :
		        return $this->_subfieldValues[0]->getValue();
		    case "latitude" :
		        return $this->_subfieldValues[1]->getValue();
		    default:
				return parent::getValue($name, $parameters);
			break;
		}
    }

/**
  * Return the needed form field tag for current object field
  *
  * @param array $values : parameters values array(parameterName => parameterValue) in :
  *     id : the form field id to set
  * @param multidimentionnal array $tags : xml2Array content of atm-function tag
  * @return string : the form field HTML tag
  * @access public
  */
    function getInput($fieldID, $language, $inputParams) {
		//hidden field : use parent method
		if (isset($inputParams['hidden']) && ($inputParams['hidden'] == 'true' || $inputParams['hidden'] == 1)) {
			return parent::getInput($fieldID, $language, $inputParams);
		}
		$params = $this->getParamsValues();
		$html = 'todo';
		return $html;
    }

    /**
      * get labels for object structure and functions
      *
      * @return array : the labels of object structure and functions
      * @access public
      */
    function getLabelsStructure(&$language) {
		$labels = parent::getLabelsStructure($language);
		$params = $this->getParamsValues();
		unset($labels['structure']['value']);
		$labels['structure']['longitude'] = $language->getMessage(self::MESSAGE_OBJECT_COORDINATES_LONGITUDE_DESCRIPTION,false ,$this->_messagesModule);
		$labels['structure']['latitude'] = $language->getMessage(self::MESSAGE_OBJECT_COORDINATES_LATITUDE_DESCRIPTION,false ,$this->_messagesModule);
		return $labels;
    }
	
	/**
	 * return the lat and long of a point by is adress
	 * @param object $language cms_language object
	 * @param string $address
	 * @param string ccTld country top level domain to wich restrain the geocoding
	 * @return array of coordonate
	 * @access protected
	 */
	public static function getCoordinates (&$language,  $address = '' , $ccTld = false ){
		$lat = $long = '';
		//for the moment the adress is mandatory but we'll set it optionnal in the future
		if(!$address){
			CMS_grandFather::raiseError('Address is required for geocoding');
			return false;
		}
		
		$sGoogleApiUrl = sprintf('http://maps.google.com/maps/api/geocode/json?address=%s&sensor=false&language=%s',
						 urlencode(io::sanitizeAsciiString($address, ' ')),
						 $language->getCode()
					);
		if( $sCcTld ){						 
			$sGoogleApiUrl .= '&region='.$sCcTld;
		}
		//creating a call context to limit call duration
		$oContext = stream_context_create(array(
			'http' => array(
			  'method'  => 'GET',
			  'timeout' => 4 //we wait 4second for the service to answer
			)
		));
		
		$sTmpData = file_get_contents($sGoogleApiUrl,false,$oContext);
		
		if( $sTmpData === false) {
			//error trying reading the file
			CMS_grandFather::raiseError('Unable to read distant file at address '.$sGoogleApiUrl);
		}else{
			//if we can decode the answer
			if ( ($oAnswer = json_decode($sTmpData)) ){
				
				if( $oAnswer->status != 'OK' ){
					CMS_grandFather::raiseError('Error while requesting google maps api '.$sGoogleApiUrl);
				}
				
				//we use the first result
				$oPoint = array_shift($oAnswer->results);
				unset($oAnswer);
				
				$lat =  isset( $oPoint->geometry->location->lat ) ? $oPoint->geometry->location->lat : '';
				$long = isset( $oPoint->geometry->location->lng ) ? $oPoint->geometry->location->lng : '';
			}
		}
		return  ( array( 'lat' => $lat , 'long' => $long ) );
	}
	
	/**
	  * Treat fields parameters to import
	  *
	  * @param array $params The import parameters.
	  *		array(
	  *				create	=> false|true : create missing objects (default : true)
	  *				update	=> false|true : update existing objects (default : true)
	  *				files	=> false|true : use files from PATH_TMP_FS (default : true)
	  *			)
	  * @param CMS_language $cms_language The CMS_langage to use
	  * @param array $idsRelation : Reference : The relations between import datas ids and real imported ids
	  * @param string $infos : Reference : The import infos returned
	  * @return array : the treated parameters
	  * @access public
	  */
	function importParams($params, $cms_language, &$idsRelation, &$infos) {
		if (isset($params['fieldsForAddress']) && $params['fieldsForAddress']) {
			$fieldsIds = explode(';', $params['fieldsForAddress']);
			$convertedFieldsIds = array();
			foreach ($fieldsIds as $fieldId) {
				$convertedFieldsIds[] = isset($idsRelation['fields'][$fieldId]) ? $idsRelation['fields'][$fieldId] : $fieldId;
			}
			$params['fieldsForAddress'] = implode(';', $convertedFieldsIds);
		}
		return $params;
	}
}

?>
