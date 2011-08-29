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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+

/**
  * Class CMS_oembed
  *
  * Represent an oembed resource object
  *
  * @package Automne
  * @subpackage common
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_oembed extends CMS_grandFather
{
	protected $_url;
	protected $_maxwidth;
	protected $_maxheight;
	protected $_provider;
	protected $_datas = array();
	
	/**
	 * Oembed Providers list
	 * @var array
	 * @access public
	 */
	public $providers = array(
		array(
			'api'		=> 'http://www.youtube.com/oembed',
			'scheme'	=> array('http://www.youtube.com/watch?*')
		),
		array(
			'api'		=> 'http://www.flickr.com/services/oembed/',
			'scheme'	=> array('http://*.flickr.com/*')
		),
		array(
			'api'		=> 'http://lab.viddler.com/services/oembed/',
			'scheme'	=> array('http://*.viddler.com/*')
		),
		array(
			'api'		=> 'http://qik.com/api/oembed.json',
			'scheme'	=> array('http://qik.com/video/*', 'http://qik.com/*')
		),
		array(
			'api'		=> 'http://revision3.com/api/oembed/',
			'scheme'	=> array('http://*.revision3.com/*')
		),
		array(
			'api'		=> 'http://www.hulu.com/api/oembed.json',
			'scheme'	=> array('http://www.hulu.com/watch/*')
		),
		array(
			'api'		=> 'http://www.vimeo.com/api/oembed.json',
			'scheme'	=> array('http://www.vimeo.com/*', 'http://www.vimeo.com/groups/*/*')
		),
		array(
			'api'		=> 'http://www.polleverywhere.com/services/oembed/',
			'scheme'	=> array('http://www.polleverywhere.com/polls/*', 'http://www.polleverywhere.com/multiple_choice_polls/*', 'http://www.polleverywhere.com/free_text_polls/*')
		),
		array(
			'api'		=> 'http://www.dailymotion.com/services/oembed',
			'scheme'	=> array('http://www.dailymotion.com/video/*')
		),
		array(
			'api'		=> 'http://www.screenr.com/api/oembed.json',
			'scheme'	=> array('http://*screenr.com/*')
		),
		array(
			'api'		=> 'http://www.scribd.com/services/oembed',
			'scheme'	=> array('http://*scribd.com/*')
		),
	);
	
	/**
	 * Emùbedly specific vars
	 */
	protected $_embedlyKey;
	protected $_embedlyRegexpService = 'http://api.embed.ly/1/services/php';
	protected $_embedlyApi = 'http://api.embed.ly/1/oembed';
	
	
	/**
	  * Constructor.
	  * initialize object.
	  *
	  * @param string $url the url of the distant oembed resource to get
	  * @param integer $maxwidth the max width to apply to distant oembed resource (optional)
	  * @param integer $maxheight the max height to apply to distant oembed resource (optional)
	  * @return void
	  * @access public
	  */
	function __construct($url, $maxwidth='', $maxheight='', $embedlyKey = '') {
		$url = trim($url);
		if (strtolower(substr($url, 0, 4)) != 'http') {
			$url = 'http://'.$url;
		}
		if (!@parse_url($url)) {
			$this->raiseError('Malformed url: '.$url);
			return;
		}
		if ($embedlyKey) {
			$this->_embedlyKey = $embedlyKey;
		} elseif (defined('OEMBED_EMBEDLY_KEY') && OEMBED_EMBEDLY_KEY) {
			$this->_embedlyKey = OEMBED_EMBEDLY_KEY;
		}
		$this->_url = $url;
		$this->_maxwidth = $maxwidth && io::isPositiveInteger($maxwidth) ? $maxwidth : '';
		$this->_maxheight = $maxheight && io::isPositiveInteger($maxheight) ? $maxheight : '';
	}
	
	/**
	  * Get current provider using media URL.
	  *
	  * @return boolean
	  * @access protected
	  */
	protected function _getProvider() {
		if ($this->_provider) {
			return true;
		}
		if (!$this->_url) {
			$this->raiseError('No valid url given');
			return false;
		}
		$regreplace = array(
			'http://'	=> '',
			'https://'	=> '',
			'.'			=> '\.',
			'?'			=> '\?',
			'*'			=> '.*',
			'/'			=> '\/',
		);
		foreach ($this->providers as $provider) {
			$founded = false;
			if (isset($provider['scheme']) && $provider['scheme']) {
				foreach ($provider['scheme'] as $scheme) {
					//convert scheme to regexp
					$regexp = str_replace(array_keys($regreplace), $regreplace, $scheme);
					if (preg_match('/('.$regexp.')/i', $this->_url)) {
						$founded = true;
						break;
					}
				}
			}
			if ($founded) {
				break;
			}
		}
		if ($founded) { //service founded with known oembed api
			$this->_provider = $provider['api'];
			return true;
		} elseif ($this->_embedlySupported()) { //try embed.ly api
			$this->_provider = $this->_embedlyApi;
			return true;
		} elseif ($this->_embedlyKey) { //if embed.ly key is provided, use embed.ly pro service. This can be used with any URL
			$this->_provider = $this->_embedlyApi.'?key='.$this->_embedlyKey;
			return true;
		}
		return false;
	}
	
	/**
	  * Use embed.ly regexp service to check URL
	  *
	  * @return boolean
	  * @access public
	  */
	protected function _embedlySupported() {
		//set cache lifetime
		$lifetime = 86400; //(default : 24 hours)
		//create cache id
		$cacheId = 'embedlyServiceRegexp';
		//create cache object to store service regexp
		$cache = new CMS_cache($cacheId, 'oembed', $lifetime, false);
		$regexp = '';
		if (!$cache->exist() || !($regexp = $cache->load())) {
			try {
				$client = new Zend_Http_Client();
				$client->setUri($this->_embedlyRegexpService);
				//HTTP config
				$httpConfig = array(
				    'maxredirects'	=> 5,
				    'timeout'		=> 10,
					'useragent'		=> 'Mozilla/5.0 (compatible; Automne/'.AUTOMNE_VERSION.'; +http://www.automne-cms.org)',
				);
				if (defined('APPLICATION_PROXY_HOST') && APPLICATION_PROXY_HOST) {
					$httpConfig['adapter'] = 'Zend_Http_Client_Adapter_Proxy';
					$httpConfig['proxy_host'] = APPLICATION_PROXY_HOST;
					if (defined('APPLICATION_PROXY_PORT') && APPLICATION_PROXY_PORT) {
						$httpConfig['proxy_port'] = APPLICATION_PROXY_PORT;
					}
				}
				$client->setConfig($httpConfig);
				
				$client->request();
				$response = $client->getLastResponse();
			} catch (Zend_Http_Client_Exception $e) {
				$this->raiseError('Error for url: '.$this->_embedlyRegexpService.' - '.$e->getMessage());
			}
			if (isset($response) && $response->isSuccessful()) {
				$jsonString = $response->getBody();
				$jsonResponse = json_decode($jsonString, true);
			} else {
				if (isset($response)) {
					$this->raiseError('Error for url: '.$this->_embedlyRegexpService.' - '.$response->getStatus().' - '.$response->getMessage());
				} else {
					$this->raiseError('Error for url: '.$this->_embedlyRegexpService.' - no response object');
				}
			}
			if (!isset($jsonResponse) && $cache) {
				//create cache object with new lifetime (2h) to store error
				$cache = new CMS_cache($cacheId, 'oembed', 7200, false);
				$cache->save('error', array('type' => 'oembed', 'service' => 'regexp'));
				return false;
			}
			$regexp = '#'.implode('|', array_map(array(__CLASS__, '_regImploder'), $jsonResponse)).'#i';
			if ($cache) {
				$cache->save($regexp, array('type' => 'oembed', 'service' => 'regexp'));
			}
		}
		if (!isset($regexp) || !$regexp || $regexp == 'error') {
			return false;
		}
		return preg_match($regexp, $this->_url) ? true : false;
	}
	
	/**
     * @param array $r
     * @return string
     */
    private static function _regImploder($r) {
        return implode('|', array_map(array(__CLASS__, '_regDelimStripper'), $r['regex']));
    }
	
	/**
     * @param string $s
     * @return string
     */
    private static function _regDelimStripper($s) {
        return substr($s, 1, -2);
    } 
	
	/**
	  * Does current oembed object has provider
	  *
	  * @return boolean
	  * @access public
	  */
	function hasProvider() {
		//load provider if needed
		if (!$this->_getProvider()) {
			return false;
		}
		return $this->_provider ? true : false;
	}
	
	/**
	  * Get current provider using media URL.
	  *
	  * @return string the provider API url
	  * @access public
	  */
	function getProvider() {
		//load provider if needed
		if (!$this->_getProvider()) {
			return false;
		}
		return $this->_provider;
	}
	
	/**
	  * Retrieve current media datas from provider
	  *
	  * @return boolean
	  * @access protected
	  */
	protected function _retrieveDatas() {
		if ($this->_datas) {
			return true;
		}
		//load provider
		if (!$this->_getProvider()) {
			return false;
		}
		//set cache lifetime
		$lifetime = 86400; //(default : 24 hours)
		//create cache id from files, compression status and last time files access
		$cacheId = md5(serialize(array(
			'url'		=> $this->_url,
			'maxwidth'	=> io::isPositiveInteger($this->_maxwidth) ? $this->_maxwidth : '',
			'maxheight'	=> io::isPositiveInteger($this->_maxheight) ? $this->_maxheight : '',
		)));
		//create cache object
		$cache = new CMS_cache($cacheId, 'oembed', $lifetime, false);
		$datas = '';
		if (!$cache->exist() || !($datas = $cache->load())) {
			try {
				$client = new Zend_Http_Client();
				$client->setUri($this->getProvider());
				
				//HTTP config
				$httpConfig = array(
				    'maxredirects'	=> 5,
				    'timeout'		=> 10,
					'useragent'		=> 'Mozilla/5.0 (compatible; Automne/'.AUTOMNE_VERSION.'; +http://www.automne-cms.org)',
				);
				if (defined('APPLICATION_PROXY_HOST') && APPLICATION_PROXY_HOST) {
					$httpConfig['adapter'] = 'Zend_Http_Client_Adapter_Proxy';
					$httpConfig['proxy_host'] = APPLICATION_PROXY_HOST;
					if (defined('APPLICATION_PROXY_PORT') && APPLICATION_PROXY_PORT) {
						$httpConfig['proxy_port'] = APPLICATION_PROXY_PORT;
					}
				}
				$client->setConfig($httpConfig);
				
				$client->setParameterGet(array(
				    'url'		=> $this->_url,
					'format'	=> 'json',
				));
				if (io::isPositiveInteger($this->_maxwidth)) {
					$client->setParameterGet('maxwidth', $this->_maxwidth);
				}
				if (io::isPositiveInteger($this->_maxheight)) {
					$client->setParameterGet('maxheight', $this->_maxheight);
				}
				$client->request();
				$response = $client->getLastResponse();
			} catch (Zend_Http_Client_Exception $e) {
				$this->raiseError('Error for url: '.$this->_url.' - '.$e->getMessage());
			}
			if (isset($response) && $response->isSuccessful()) {
				$jsonString = $response->getBody();
				$datas = json_decode($jsonString, true);
			} else {
				if (isset($response)) {
					$this->raiseError('Error for oembed url: '.$this->_url.' (Provider: '.$this->getProvider().') - '.$response->getStatus().' - '.$response->getMessage());
				} else {
					$this->raiseError('Error for oembed url: '.$this->_url.' (Provider: '.$this->getProvider().') - no response object');
				}
				//create error datas
				$datas = array(
					'error'			=> isset($response) ? $response->getStatus() : '500',
					'cache_age'		=> 7200, //2h cache for erors
					'type'			=> 'error'
				);
			}
			if ($cache) {
				if (isset($datas['cache_age']) && io::isPositiveInteger($datas['cache_age']) && $datas['cache_age'] != 86400) {
					//create cache object with new lifetime
					$cache = new CMS_cache($cacheId, 'oembed', $datas['cache_age'], false);
				}
				$cache->save($datas, array('type' => 'oembed', 'provider' => $this->getProvider()));
			}
		}
		if (!$datas) {
			return false;
		}
		$this->_datas = $datas;
		return true;
	}
	
	/**
	  * Get current media datas from provider
	  *
	  * @return array the medias datas returned by provider
	  * @access public
	  */
	function getDatas() {
		//load datas if needed
		if (!$this->_retrieveDatas()) {
			return array();
		}
		return $this->_datas;
	}
	
	/**
	  * Get HTML embed code for current media
	  *
	  * @param array the html attributes to add to returned code
	  * @param boolean does the HTML should be returned into an iframe ? (default false)
	  * @return string the html embed code (framed if needed)
	  * @access public
	  */
	function getHTML($attributes = array(), $inframe = false) {
		//load datas
		if (!($datas = $this->getDatas())) {
			return '';
		}
		if (!isset($datas['type'])) {
			$this->raiseError('Missing datas type: '.$datas['type'].' for url: '.$this->_url);
			return '';
		}
		if ($datas['type'] == 'error') {
			return '';
		}
		$style = '';
		if (!isset($attributes['style'])) {
			if (io::isPositiveInteger($this->_maxwidth) && !io::isPositiveInteger($this->_maxheight)) {
				$style = ' style="max-width:'.$this->_maxwidth.'px;overflow:auto;"';
			}
			if (!io::isPositiveInteger($this->_maxwidth) && io::isPositiveInteger($this->_maxheight)) {
				$style = ' style="max-height:'.$this->_maxheight.'px;overflow:auto;"';
			}
			if (io::isPositiveInteger($this->_maxwidth) && io::isPositiveInteger($this->_maxheight)) {
				$style = ' style="max-width:'.$this->_maxwidth.'px;max-height:'.$this->_maxheight.'px;overflow:auto;"';
			}
		}
		$attr='';
		foreach ($attributes as $attName => $attValue) {
			$attName = io::htmlspecialchars(trim(strtolower($attName)));
			if ($attValue && (!in_array($attName, array('src', 'href')) && !($datas['type'] != 'link' && $attName == 'target'))) {
				$attr .= ' '.$attName.'="'.io::htmlspecialchars($attValue).'"';
			}
		}
		switch ($datas['type']) {
			case 'photo':
				if (!isset($datas['url'])) {
					return '';
				}
				return '<img src="'.io::htmlspecialchars($datas['url']).'"'.(isset($datas['title']) && !isset($attributes['title']) ? ' title="'.io::htmlspecialchars($datas['title']).'"' : '').$style.$attr.' />';
			break;
			case 'rich':
			case 'video':
				if (!isset($datas['html'])) {
					return '';
				}
				return (!$inframe) ? $this->_getIframe($style, $attr) : $this->_addWmode($datas['html']);
			break;
			case 'link':
				if (isset($datas['html'])) {
					return (!$inframe) ? $this->_getIframe($style, $attr) : $this->_addWmode($datas['html']);
				}
				if (!isset($datas['title']) || !isset($datas['url'])) {
					return '';
				}
				return '<a href="'.io::htmlspecialchars($datas['url']).'"'.$style.$attr.(isset($datas['description']) && !isset($attributes['title']) ? ' title="'.io::htmlspecialchars($datas['description']).'"' : '').'>'.$datas['title'].'</a>';
			break;
			default :
				$this->raiseError('Unkown datas type: '.$datas['type'].' for url: '.$this->_url);
				return '';
			break;
		}
	}
	
	/**
	  * Get thumbnial HTML code for current media
	  *
	  * @param array the html attributes to add to returned code
	  * @return string the html thumbnail code
	  * @access public
	  */
	function getThumbnail($attributes = array()) {
		//load datas
		if (!($datas = $this->getDatas())) {
			return '';
		}
		if (!isset($datas['type'])) {
			$this->raiseError('Missing datas type: '.$datas['type'].' for url: '.$this->_url);
			return '';
		}
		if ($datas['type'] == 'error') {
			return '';
		}
		
		$style = '';
		if (!isset($attributes['style'])) {
			if (io::isPositiveInteger($this->_maxwidth) && !io::isPositiveInteger($this->_maxheight)) {
				$style = ' style="max-width:'.$this->_maxwidth.'px;overflow:auto;"';
			}
			if (!io::isPositiveInteger($this->_maxwidth) && io::isPositiveInteger($this->_maxheight)) {
				$style = ' style="max-height:'.$this->_maxheight.'px;overflow:auto;"';
			}
			if (io::isPositiveInteger($this->_maxwidth) && io::isPositiveInteger($this->_maxheight)) {
				$style = ' style="max-width:'.$this->_maxwidth.'px;max-height:'.$this->_maxheight.'px;overflow:auto;"';
			}
		}
		$attr='';
		foreach ($attributes as $attName => $attValue) {
			$attName = io::htmlspecialchars(trim(strtolower($attName)));
			if ($attValue && (!in_array($attName, array('src', 'href')) && !($datas['type'] != 'link' && $attName == 'target'))) {
				$attr .= ' '.$attName.'="'.io::htmlspecialchars($attValue).'"';
			}
		}
		if (!isset($datas['thumbnail_url'])) {
			return '';
		}
		return '<img src="'.io::htmlspecialchars($datas['thumbnail_url']).'"'.(isset($datas['title']) && !isset($attributes['title']) ? ' title="'.io::htmlspecialchars($datas['title']).'"' : '').$style.$attr.' />';
	}
	
	/**
	  * Get title for current media
	  *
	  * @return string the media title
	  * @access public
	  */
	function getTitle() {
		//load datas
		if (!($datas = $this->getDatas())) {
			return '';
		}
		return $this->getData('title');
	}
	
	/**
	  * Get provider name for current media
	  *
	  * @return string the media provider name
	  * @access public
	  */
	function getProviderName() {
		//load datas
		if (!($datas = $this->getDatas())) {
			return '';
		}
		if ($datas['type'] == 'error') {
			return '';
		}
		return isset($datas['provider_name']) ? $datas['provider_name'] : (isset($datas['provider']) ? $datas['provider'] : '');
	}
	
	/**
	  * Get datas for current media
	  *
	  * @return array the media datas
	  * @access public
	  */
	function getData($name) {
		//load datas
		if (!($datas = $this->getDatas())) {
			return '';
		}
		if ($datas['type'] == 'error') {
			return '';
		}
		return isset($datas[$name]) ? $datas[$name] : '';
	}
	
	/**
	  * Add wmode transparent to flash embed code
	  *
	  * @param string $html the html code to transform
	  * @return string the html code transformed
	  * @access protected
	  */
	protected function _addWmode($html) {
		$matches = array();
		if (stripos($html, '<object ') !== false && stripos($html, ' name="wmode"') === false) {
			$html = preg_replace('#<object([^>]*)>#', '<object\1><param name="wmode" value="transparent"></param>', $html);
		}
		if (stripos($html, '<embed ') !== false && stripos($html, ' wmode="transparent"') === false) {
			$html = preg_replace('#<embed([^>]*)>#', '<embed wmode="transparent"\1>', $html);
		}
		return $html;
	}
	
	/**
	  * Get iframe code for current html embed code
	  *
	  * @param string $style the html style code to add
	  * @param string $attr the html attributes code to add
	  * @return string the html code
	  * @access protected
	  */
	protected function _getIframe($style, $attr) {
		//load datas
		if (!($datas = $this->getDatas())) {
			return '';
		}
		//already iframe embeded, no need to redo an iframe arround
		if (strtolower(substr(trim($datas['html']), 0, 8)) == '<iframe ') {
			return '<div'.$style.$attr.'>'.$datas['html'].'</div>';
		}
		//frame param
		$frameParam = base64_encode(serialize(array(
			'url'		=> $this->_url,
			'maxwidth'	=> io::isPositiveInteger($this->_maxwidth) ? $this->_maxwidth : '',
			'maxheight'	=> io::isPositiveInteger($this->_maxheight) ? $this->_maxheight : '',
		)));
		//frame domain
		if (defined('APPLICATION_EMBED_DOMAIN') && APPLICATION_EMBED_DOMAIN) {
			$domain = strtolower(substr(APPLICATION_EMBED_DOMAIN,0,4)) == 'http' ? APPLICATION_EMBED_DOMAIN : 'http://'.APPLICATION_EMBED_DOMAIN;
		} else {
			$domain = CMS_websitesCatalog::getCurrentDomain();
		}
		//iframe width/height
		$width = $height = '';
		if (isset($datas['width']) && io::isPositiveInteger($datas['width'])) {
			$width = io::htmlspecialchars($datas['width']);
		} else {
			//try to guess width for iframe ...
			$matches = array();
			if (preg_match('/^<[^>]* width="([0-9]+)"/i', trim($datas['html']) , $matches) && isset($matches[1])) {
				$width = $matches[1];
			} elseif (io::isPositiveInteger($this->_maxwidth)) {
				$width = $this->_maxwidth;
			}
		}
		if (isset($datas['height']) && io::isPositiveInteger($datas['height'])) {
			$height = io::htmlspecialchars($datas['height']);
		} else {
			//try to guess width for iframe ...
			$matches = array();
			if (preg_match('/^<[^>]* height="([0-9]+)"/i', trim($datas['html']) , $matches) && isset($matches[1])) {
				$height = $matches[1];
			} elseif (io::isPositiveInteger($this->_maxheight)) {
				$height = $this->_maxheight;
			}
		}
		return '<iframe scrolling="no" frameBorder="0"'.
				($width ? ' width="'.$width.'"' : '').
				($height ? ' height="'.$height.'"' : '').
				'src="'.$domain.PATH_MAIN_WR.'/oembed/frame'.(!STRIP_PHP_EXTENSION ? '.php' : '').'?params='.$frameParam.'">'.
				'	<a href="'.$domain.PATH_MAIN_WR.'/oembed/frame'.(!STRIP_PHP_EXTENSION ? '.php' : '').'?params='.$frameParam.'" target="_blank">Click to view media</a>'.
				'</iframe>';
	}
}
?>