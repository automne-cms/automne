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
//
// $Id: rss.php,v 1.8 2010/03/08 16:45:23 sebastien Exp $

/**
  * PHP page : generate Polymod RSS Feeds
  *
  * @package Automne
  * @subpackage frontend
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

if (!isset($_REQUEST['atm-previz'])) {
	define('SYSTEM_DEBUG', false);
}

//Include all needed classes
require_once($_SERVER["DOCUMENT_ROOT"]."/automne/classes/polymodFrontEnd.php");

//Get RSS object
$error = 0;
$ttl = '1440';
$data = $label = $rssTitle = $description = $link = $categoriesTags = $copyrightTag = $emailTag = '';

$hash = md5(serialize($_REQUEST));
$cache = new CMS_cache($hash, 'polymod', 'auto', true);
if ($cache->exist()) {
	//Get content from cache
	$content = $cache->load();
} else {
	$cache->start();
	
	if (!isset($_REQUEST['id']) || !sensitiveIO::isPositiveInteger($_REQUEST['id'])) {
		$error = 1;
	} else {
		$RSSDefinition = new CMS_poly_rss_definitions($_REQUEST['id']);
		if ($RSSDefinition->hasError()) {
			$error = 2;
		}
		
		//Create RSS Content
		ob_start();
		eval(sensitiveIO::stripPHPTags($RSSDefinition->getValue('compiledDefinition')));
		$data = ob_get_contents();
		ob_end_clean();
		if (!$data) {
			$error = 3;
		}
		
		$label = new CMS_object_i18nm($RSSDefinition->getValue("labelID"));
		$description = new CMS_object_i18nm($RSSDefinition->getValue("descriptionID"));
		$link = ($RSSDefinition->getValue("link")) ? $RSSDefinition->getValue("link") : CMS_websitesCatalog::getMainURL();
		
		$categoriesTags = '';
		if ($RSSDefinition->getValue("categories")) {
			$categories = array_map('trim', explode(',',$RSSDefinition->getValue("categories")));
			foreach ($categories as $category) {
				$categoriesTags .= '<category>'.$category.'</category>'."\n";
			}
		}
		$copyrightTag = '';
		if ($RSSDefinition->getValue("copyright")) {
			$copyrightTag .= '<copyright>'.$RSSDefinition->getValue("copyright").'</copyright>'."\n";
		}
		$emailTag = '';
		if ($RSSDefinition->getValue("email")) {
			$emailTag .= '<managingEditor>'.$RSSDefinition->getValue("email").' ('.APPLICATION_LABEL.')</managingEditor>'."\n";
		}
		$ttl = $RSSDefinition->getValue("ttl");
	}
	//if no RSS title in generated content, get the default one
	if (!$data || $error || substr(trim($data),0,7) != '<title>') {
		$rssTitle = '<title>'.((is_object($label) && is_object($cms_language)) ? $label->getValue($cms_language->getCode()) : 'Error').'</title>';
	}
	
	// Encoding
	$encoding = 'UTF-8';
	
	$content = 
	'<?xml version="1.0" encoding="'.$encoding.'" ?>'."\n".
	'<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss" xmlns:atom="http://www.w3.org/2005/Atom">'."\n".
	'    <channel>'."\n".
	'		<atom:link href="'.$link.'" rel="self" type="application/rss+xml" />'."\n".
	'		'.$rssTitle."\n".
	'		<description>'.((is_object($description) && is_object($cms_language)) ? $description->getValue($cms_language->getCode()) : 'This RSS Feed has an error ...').'</description>'."\n".
	'		<link>'.$link.'</link>'."\n".
	'		<language>'.((isset($cms_language)) ? $cms_language->getCode() : 'en').'</language>'."\n".
	'		'.$categoriesTags.
	'		'.$copyrightTag.
	'		<generator>'.CMS_grandFather::SYSTEM_LABEL.'</generator>'."\n".
	'		'.$emailTag.
	'		<webMaster>'.APPLICATION_MAINTAINER_EMAIL.' ('.APPLICATION_LABEL.')</webMaster>'."\n".
	'		<docs>http://blogs.law.harvard.edu/tech/rss</docs>'."\n".
	'		<ttl>'.$ttl.'</ttl>'."\n";
	
	if (!$error) {
		$content .= $data."\n";
	} else {
		$content .=
		'<item>'."\n".
		'    <title>RSS Feed Error ..</title>'."\n".
		'    <guid isPermaLink="false">Error'.mktime().'</guid>'."\n".
		'    <description><![CDATA[';
		switch ($error) {
			case 1:
				$content .= 'Error : RSS ID not found or not a valid integer ... Please contact the webmaster here : '.APPLICATION_MAINTAINER_EMAIL;
			break;
			case 2:
				$content .= 'Error : Invalid RSS ID found ... Please contact the webmaster here : '.APPLICATION_MAINTAINER_EMAIL;
			break;
			case 3:
				$content .= 'Error : RSS Content generation error or no valid content for this RSS feed ... Please contact the webmaster here : '.APPLICATION_MAINTAINER_EMAIL;;
			break;
		}
		$content .=']]></description>'."\n".
		'    <link>'.CMS_websitesCatalog::getMainURL().'</link>'."\n".
		'</item>';
	}
	$content .= 
	'	</channel>'."\n".
	'</rss>';
	
	if('utf-8' != strtolower(APPLICATION_DEFAULT_ENCODING)){
		$content = io::utf8Encode($content);
	}
	//output content to record it into cache
	echo $content;
	$content = $cache->endSave();
}
unset($cache);

//send RSS content
if (!isset($_REQUEST['atm-previz'])) {
	header('Content-type: text/xml; charset=UTF-8');
	echo $content;
} else {
	echo '<pre>'.htmlspecialchars($content).'</pre>';
}
?>