/**
  * Automne Javascript file
  *
  * Automne.categories
  * Provide Automne categories rights management methods
  * @class Automne.categories
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: categories.js,v 1.1 2009/06/22 14:10:34 sebastien Exp $
  */
//Modules elements rights functions
Automne.categories = {
	onRow: function (obj) {
		if (obj != 'undefined') {
			obj.style.backgroundColor = '#FDF5A2';
		}
	},
	outRow: function (obj) {
		if (obj != 'undefined') {
			obj.style.backgroundColor = '';
		}
	},
	unselectOthers: function (catID, catValue, count, hash) {
		var clearances = [0,1,2,3];
		var clearancesColors = ['#FF7E71', '#E2FAAA', '#CFE779', '#85A122'];
		var parentClearance;
		
		//for a given UL, get all Li then mark inputs to display or hide. This function use reference vars
		var getInputs = function (el) {
			var childs = el.childNodes;
			var inputs = new Array();
			//get all checkboxes for Lis of this UL
			for (var i = 0, childslen = childs.length; i < childslen; i++) {
				if (childs[i].tagName == 'LI') {
					var checked = false;
					var catId = childs[i].id.split(/-/)[2];
					var liInputs = Ext.get('checkboxes-'+ hash +'-' + catId).dom.getElementsByTagName('INPUT');
					for (var j = 0, inputlen = liInputs.length; j < inputlen; j++) {
						inputs[inputs.length] = liInputs[j];
						if (liInputs[j].checked) {
							checked = true;
						}
					}
					if (!checked && Ext.get('ul-'+ hash +'-' + catId)) {
						getInputs(Ext.get('ul-'+ hash +'-' + catId).dom);
					}
				}
			}
			for (var i = 0, inputlen = inputs.length; i < inputlen; i++) {
				if (inputs[i].value == catValue) {
					if (checkbox.checked == true) {
						inputsToHide[inputsToHide.length] = inputs[i];
					} else {
						inputsToShow[inputsToShow.length] = inputs[i];
					}
				} else if (inputs[i].style.display == 'none') {
					inputsToShow[inputsToShow.length] = inputs[i];
				} else if (checkbox.checked == false && inputs[i].value == parentClearance) {
					inputsToHide[inputsToHide.length] = inputs[i];
				}
			}
		}
		
		//get parent clearance (from the disabled checkbox of this category)
		for (var i = 0, clearlen = clearances.length; i < clearlen; i++) {
			if (clearances[i] != catValue && Ext.get('check-'+ hash +'-' + catID + '_' + clearances[i]) && Ext.get('check-'+ hash +'-' + catID + '_' + clearances[i]).dom.style.display == 'none') {
				parentClearance = clearances[i];
			}
		}
		//set li color and disable other checkbox of the line (if any)
		if (Ext.get('check-'+ hash +'-' + catID + '_' + catValue).dom.checked == true) {
			//unselect others from the same line
			for (var i=0, clearlen = clearances.length; i < clearlen; i++) {
				if (catValue != clearances[i]) {
					if (Ext.get('check-'+ hash +'-' + catID + '_' + clearances[i])) {
						Ext.get('check-'+ hash +'-' + catID + '_' + clearances[i]).dom.checked = false;
					}
				}
			}
			//set color
			Ext.get('li-'+ hash +'-' + catID).dom.style.backgroundColor=clearancesColors[catValue];
		} else {
			//set color
			Ext.get('li-'+ hash +'-' + catID).dom.style.backgroundColor = (count == 1 && Ext.get('ul-'+ hash +'-' + catID)) ? clearancesColors[0] : '';
		}
		//then allow or disallow checkboxes below the checked one
		if (Ext.get('ul-'+ hash +'-' + catID)) {
			var checkbox = Ext.get('check-'+ hash +'-' + catID + '_' + catValue).dom;
			var inputsToHide = new Array();
			var inputsToShow = new Array();
			var resetBackground = new Array();
			var stop = false;
			//for this UL, get all Li directly below then mark inputs to display or hide
			getInputs(Ext.get('ul-'+ hash +'-' + catID).dom);
			for (var i = 0, hidelen = inputsToHide.length; i < hidelen; i++) {
				//if li is already checked, we must reset background
				if (inputsToHide[i].checked) {
					Ext.get('li-'+ hash +'-' + inputsToHide[i].name.substr(3)).dom.style.backgroundColor='';
				}
				inputsToHide[i].checked = false;
				inputsToHide[i].style.display = 'none';
			}
			for (var i = 0, showlen = inputsToShow.length; i < showlen; i++) {
				inputsToShow[i].checked = false;
				inputsToShow[i].style.display = 'block';
			}
		}
		//force clearance 'none' checking
		if (count == 1 && Ext.get('check-'+ hash +'-' + catID + '_' + catValue).dom.checked == false && Ext.get('ul-'+ hash +'-' + catID)) {
			Ext.get('check-'+ hash +'-' + catID + '_' + 0).dom.checked = true;
			Automne.categories.unselectOthers(catID,0, 1, hash);
		} else {
			Automne.categories.saveValues(hash);
		}
	},
	saveValues: function (hash) {
		//get all checked inputs
		var inputs = Ext.get('categoriesList-'+ hash).dom.getElementsByTagName('INPUT');
		var profileId =  Ext.get('profile-'+ hash).dom.value;
		var module =  Ext.get('module-'+ hash).dom.value;
		var type =  Ext.get('type-'+ hash).dom.value;
		var rights = '';
		for (var i = 0, inputlen = inputs.length; i < inputlen; i++) {
			if (inputs[i].type == 'checkbox' && inputs[i].checked) {
				rights += (rights) ? ';':'';
				rights += inputs[i].name.substr(3) + ',' + inputs[i].value;
			}
		}
		if (type == 'user') {
			Automne.server.call('users-controler.php', Ext.emptyFn, {
				userId:			profileId,
				action:			'categories-rights',
				module:			module,
				rights:			rights,
				catIds:			Ext.get('catIds-'+hash).dom.value
			});
		} else {
			Automne.server.call('groups-controler.php', Ext.emptyFn, {
				groupId:		profileId,
				action:			'categories-rights',
				module:			module,
				rights:			rights,
				catIds:			Ext.get('catIds-'+hash).dom.value
			});
		}
	},
	open: function (catId, hash, el) {
		var profileId =  Ext.get('profile-'+ hash).dom.value;
		var module =  Ext.get('module-'+ hash).dom.value;
		var type =  Ext.get('type-'+ hash).dom.value;
		if (type == 'user') {
			Automne.server.call('modules-categories-rights.php', Automne.categories.opener, {
				userId:			profileId,
				hash:			hash,
				module:			module,
				item:			catId
			});
		} else {
			Automne.server.call('modules-categories-rights.php', Automne.categories.opener, {
				groupId:		profileId,
				hash:			hash,
				module:			module,
				item:			catId
			});
		}
		Ext.get(el).remove();
	},
	opener: function(response, options, content) {
		//define shortcut
		var xml = response.responseXML;
		var li = Ext.get('li-'+ options.params.hash +'-'+ options.params.item);
		li.insertHtml('beforeEnd', content);
	}
};