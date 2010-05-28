/**
  * Automne Javascript file
  *
  * String.prototype.ellipse
  * Provide an ellypse method on all JS String objects
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: string.js,v 1.2 2009/03/02 11:26:54 sebastien Exp $
  */
String.prototype.ellipse = function(maxLength){
	if(this.length > maxLength){
		return this.substr(0, maxLength-3) + '...';
	}
	return this;
};