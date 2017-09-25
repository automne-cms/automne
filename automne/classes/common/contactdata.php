<?php
// +----------------------------------------------------------------------+
// | Automne (TM)														  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2010 WS Interactive								  |
// +----------------------------------------------------------------------+
// | Automne is subject to version 2.0 or above of the GPL license.		  |
// | The license text is bundled with this package in the file			  |
// | LICENSE-GPL, and is available through the world-wide-web at		  |
// | http://www.gnu.org/copyleft/gpl.html.								  |
// +----------------------------------------------------------------------+
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: contactdata.php,v 1.4 2010/03/08 16:43:27 sebastien Exp $

/**
  * Class CMS_contactData
  *
  * represent a contact data : job title and service, address, tel and fax numbers, email.
  *
  * @package Automne
  * @subpackage common
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_contactData extends CMS_grandFather
{
	/**
	  * DB id
	  * @var integer
	  * @access private
	  */
	protected $_id;
	
	/**
	  * service (where contact works)
	  * @var string
	  * @access private
	  */
	protected $_service;

	/**
	  * job title
	  * @var string
	  * @access private
	  */
	protected $_jobTitle;
	
	/**
	  * address field 1
	  * @var string
	  * @access private
	  */
	protected $_addressField1;

	/**
	  * address field 2
	  * @var string
	  * @access private
	  */
	protected $_addressField2;

	/**
	  * address field 3
	  * @var string
	  * @access private
	  */
	protected $_addressField3;

	/**
	  * zip code
	  * @var string
	  * @access private
	  */
	protected $_zip;

	/**
	  * city name
	  * @var string
	  * @access private
	  */
	protected $_city;

	/**
	  * state name (full or abbreviated)
	  * @var string
	  * @access private
	  */
	protected $_state;

	/**
	  * country name
	  * @var string
	  * @access private
	  */
	protected $_country;

	/**
	  * phone number
	  * @var string
	  * @access private
	  */
	protected $_phone;

	/**
	  * cellphone number
	  * @var string
	  * @access private
	  */
	protected $_cellphone;

	/**
	  * fax number
	  * @var string
	  * @access private
	  */
	protected $_fax;

	/**
	  * email address
	  * @var string
	  * @access private
	  */
	protected $_email;
	
	/**
	  * company
	  * @var string
	  * @access private
	  */
	protected $_company;
	
	/**
	  * gender
	  * @var string
	  * @access private
	  */
	protected $_gender;

	/**
	  * Constructor.
	  * initializes the contactData if the id is given
	  *
	  * @param integer $id DB id
	  * @return void
	  * @access public
	  */
	public function __construct($id=0)
	{
		if ($id) {
			if (SensitiveIO::isPositiveInteger($id)) {
				$sql = "
					select
						*
					from
						contactDatas
					where
						id_cd='$id'
				";
				$q = new CMS_query($sql);
				if ($q->getNumRows()) {
					$data = $q->getArray();
				} else {
					$this->setError("Unknown DB ID : ".$id);
					return;
				}
			} elseif (is_array($id)) {
				$data = $id;
			} else {
				$this->setError("Id is not a positive integer nor array");
				return;
			}
			$this->_id = $data["id_cd"];
			$this->_service = $data["service_cd"];
			$this->_jobTitle = $data["jobTitle_cd"];
			$this->_addressField1 = $data["addressField1_cd"];
			$this->_addressField2 = $data["addressField2_cd"];
			$this->_addressField3 = $data["addressField3_cd"];
			$this->_zip = $data["zip_cd"];
			$this->_city = $data["city_cd"];
			$this->_state = $data["state_cd"];
			$this->_country = $data["country_cd"];
			$this->_phone = $data["phone_cd"];
			$this->_cellphone = $data["cellphone_cd"];
			$this->_fax = $data["fax_cd"];
			$this->_email = $data["email_cd"];
			$this->_company = isset($data["company_cd"]) ? $data["company_cd"] : '';
			$this->_gender = isset($data["gender_cd"]) ? $data["gender_cd"] : '';
		}
	}
	
	/**
	  * Gets the DB ID of the instance.
	  *
	  * @return integer the DB id
	  * @access public
	  */
	public function getID()
	{
		return $this->_id;
	}
	
	/**
	  * Gets the service (as an office subdivision).
	  *
	  * @return string The service
	  * @access public
	  */
	public function getService()
	{
		return $this->_service;
	}
	
	/**
	  * Sets the service (as an office subdivision).
	  *
	  * @param string $newService the service to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	public function setService($newService)
	{
		$this->_service = $newService;
		return true;
	}
	
	/**
	  * Gets the job title of the person.
	  *
	  * @return string the job title
	  * @access public
	  */
	public function getJobTitle()
	{
		return $this->_jobTitle;
	}
	
	/**
	  * Sets the job title.
	  *
	  * @param string $newJobTitle the job title to set
	  * @return boolean true on success, false on failure to set it
	  * @access public
	  */
	public function setJobTitle($newJobTitle)
	{
		$this->_jobTitle = $newJobTitle;
		return true;
	}
	
	/**
	  * Gets the first address field.
	  *
	  * @return string the address field 1
	  * @access public
	  */
	public function getAddressField1()
	{
		return $this->_addressField1;
	}
	
	/**
	  * Sets the first address field.
	  *
	  * @param string $newValue the new address field 1
	  * @return boolean true on success, false on failure to set it
	  * @access public
	  */
	public function setAddressField1($newValue)
	{
		$this->_addressField1 = $newValue;
		return true;
	}
	
	/**
	  * Gets the second address field.
	  *
	  * @return string the address field 2
	  * @access public
	  */
	public function getAddressField2()
	{
		return $this->_addressField2;
	}
	
	/**
	  * Sets the second address field.
	  *
	  * @param string $newValue the new address field 2
	  * @return boolean true on success, false on failure to set it
	  * @access public
	  */
	public function setAddressField2($newValue)
	{
		$this->_addressField2 = $newValue;
		return true;
	}
	
	/**
	  * Gets the third address field.
	  *
	  * @return string the address field 3
	  * @access public
	  */
	public function getAddressField3()
	{
		return $this->_addressField3;
	}
	
	/**
	  * Sets the third address field.
	  *
	  * @param string $newValue the new address field 3
	  * @return boolean true on success, false on failure to set it
	  * @access public
	  */
	public function setAddressField3($newValue)
	{
		$this->_addressField3 = $newValue;
		return true;
	}
	
	/**
	  * Gets the zip code.
	  *
	  * @return string the zip code
	  * @access public
	  */
	public function getZip()
	{
		return $this->_zip;
	}
	
	/**
	  * Sets the zip code.
	  *
	  * @param string $newZip the new zip code
	  * @return boolean true on success, false on failure to set it
	  * @access public
	  */
	public function setZip($newZip)
	{
		$this->_zip = $newZip;
		return true;
	}
	
	/**
	  * Gets the city name.
	  *
	  * @return string the city
	  * @access public
	  */
	public function getCity()
	{
		return $this->_city;
	}
	
	/**
	  * Sets the city name.
	  *
	  * @param string $newCity the new city name
	  * @return boolean true on success, false on failure to set it
	  * @access public
	  */
	public function setCity($newCity)
	{
		$this->_city = $newCity;
		return true;
	}
	
	/**
	  * Gets the state name (may be abbreviated).
	  *
	  * @return string the state name
	  * @access public
	  */
	public function getState()
	{
		return $this->_state;
	}
	
	/**
	  * Sets the state name (may be abbreviated).
	  *
	  * @param string $newState the new state name
	  * @return boolean true on success, false on failure to set it
	  * @access public
	  */
	public function setState($newState)
	{
		$this->_state = $newState;
		return true;
	}
	
	/**
	  * Gets the country name.
	  *
	  * @return string the country name
	  * @access public
	  */
	public function getCountry()
	{
		return $this->_country;
	}
	
	/**
	  * Sets the country name.
	  *
	  * @param string $newCountry the new country
	  * @return boolean true on success, false on failure to set it
	  * @access public
	  */
	public function setCountry($newCountry)
	{
		$this->_country = $newCountry;
		return true;
	}
	
	/**
	  * Gets the phone number.
	  *
	  * @return string the phone number
	  * @access public
	  */
	public function getPhone()
	{
		return $this->_phone;
	}
	
	/**
	  * Sets the phone number.
	  *
	  * @param string $newPhone the new phone number
	  * @return boolean true on success, false on failure to set it
	  * @access public
	  */
	public function setPhone($newPhone)
	{
		$this->_phone = $newPhone;
		return true;
	}
	
	/**
	  * Gets the cellphone number.
	  *
	  * @return string the cellphone number
	  * @access public
	  */
	public function getCellphone()
	{
		return $this->_cellphone;
	}
	
	/**
	  * Sets the cellphone number.
	  *
	  * @param string $newCellphone the new cellphone number
	  * @return boolean true on success, false on failure to set it
	  * @access public
	  */
	public function setCellphone($newCellphone)
	{
		$this->_cellphone = $newCellphone;
		return true;
	}
	
	/**
	  * Gets the fax number.
	  *
	  * @return string the fax number
	  * @access public
	  */
	public function getFax()
	{
		return $this->_fax;
	}
	
	/**
	  * Sets the fax number.
	  *
	  * @param string $newFax the new fax number
	  * @return boolean true on success, false on failure to set it
	  * @access public
	  */
	public function setFax($newFax)
	{
		$this->_fax = $newFax;
		return true;
	}
	
	/**
	  * Gets the email address.
	  *
	  * @return string the email address
	  * @access public
	  */
	public function getEmail()
	{
		return $this->_email;
	}
	
	/**
	  * Sets the email address.
	  *
	  * @param string $newEmail the new email address
	  * @return boolean true on success, false on failure to set it
	  * @access public
	  */
	public function setEmail($newEmail)
	{
		if(SensitiveIO::isValidEmail($newEmail)){
		    $this->_email = $newEmail;
		    return true;
		}
		return false;
	}
	
	/**
	  * Gets the company.
	  *
	  * @return string the company
	  * @access public
	  */
	public function getCompany()
	{
		return $this->_company;
	}
	
	/**
	  * Sets the company
	  *
	  * @param string $company the new company
	  * @return boolean true on success, false on failure to set it
	  * @access public
	  */
	public function setCompany($company)
	{
		$this->_company = $company;
		return true;
	}
	
	/**
	  * Gets the gender.
	  *
	  * @return string the gender
	  * @access public
	  */
	public function getGender()
	{
		return $this->_gender;
	}
	
	/**
	  * Sets the gender
	  *
	  * @param string $gender the new gender
	  * @return boolean true on success, false on failure to set it
	  * @access public
	  */
	public function setGender($gender)
	{
		$this->_gender = $gender;
		return true;
	}
	
	/**
	  * Short hand to get values by property name
	  *
	  * @param string $property The name of the property
	  * @return mixed See functions for more details
	  * @access public
	  */
	public function getValue($property){
		switch($property){
		    case 'id':
		        return $this->getID();
		    break;
		    default:
				$method = 'get'.ucfirst($property);
				if (method_exists($this, $method)) {
					return $this->{$method}();
				} else {
					$this->setError('Unknown property to get : "'.$property.'"');
				}
			break;
		}
		return false;
	}
	
	/**
	  * Short hand to set values by property name
	  *
	  * @param string $property The name of the property
	  * @param string $value The value to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	public function setValue($property, $value){
		switch($property){
		    default:
				$method = 'set'.ucfirst($property);
				if (method_exists($this, $method)) {
					return $this->{$method}($value);
				} else {
					$this->setError('Unknown property to set : "'.$property.'"');
				}
			break;
		}
		return false;
	}

	/**
	  * Totally destroys the contactData from database.
	  *
	  * @return void
	  * @access public
	  */
	public function destroy()
	{
		if ($this->_id) {
			$sql = "
				delete
				from
					contactDatas
				where
					id_cd='".$this->_id."'
			";
			$q = new CMS_query($sql);
		}
		unset($this);
	}
	
	/**
	  * Writes the contactData into persistence (MySQL for now).
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	public function writeToPersistence()
	{
		$sql_fields = "
			service_cd='".SensitiveIO::sanitizeSQLString($this->_service)."',
			jobTitle_cd='".SensitiveIO::sanitizeSQLString($this->_jobTitle)."',
			addressField1_cd='".SensitiveIO::sanitizeSQLString($this->_addressField1)."',
			addressField2_cd='".SensitiveIO::sanitizeSQLString($this->_addressField2)."',
			addressField3_cd='".SensitiveIO::sanitizeSQLString($this->_addressField3)."',
			zip_cd='".SensitiveIO::sanitizeSQLString($this->_zip)."',
			city_cd='".SensitiveIO::sanitizeSQLString($this->_city)."',
			state_cd='".SensitiveIO::sanitizeSQLString($this->_state)."',
			country_cd='".SensitiveIO::sanitizeSQLString($this->_country)."',
			phone_cd='".SensitiveIO::sanitizeSQLString($this->_phone)."',
			cellphone_cd='".SensitiveIO::sanitizeSQLString($this->_cellphone)."',
			fax_cd='".SensitiveIO::sanitizeSQLString($this->_fax)."',
			email_cd='".SensitiveIO::sanitizeSQLString($this->_email)."',
			company_cd='".SensitiveIO::sanitizeSQLString($this->_company)."',
			gender_cd='".SensitiveIO::sanitizeSQLString($this->_gender)."'
		";
		if ($this->_id) {
			$sql = "
				update
					contactDatas
				set
					".$sql_fields."
				where
					id_cd='".$this->_id."'
			";
		} else {
			$sql = "
				insert into
					contactDatas
				set
					".$sql_fields;
		}
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			return false;
		} elseif (!$this->_id) {
			$this->_id = $q->getLastInsertedID();
		}
		return true;
	}
}

?>