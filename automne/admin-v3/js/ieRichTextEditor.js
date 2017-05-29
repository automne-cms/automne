	/**
	* Fonctions pour Internet Explorer, manipulation de la sélection dans un textarea
	*/
	
	/*
		insertion du tag demandé (tag fermant) de type <b></b>
		On vérifie la sélection de l'utilisateur dans le textarea auparavant
		pour encolre cette sélection du tag demandé
	*/
	function insertClosingTag(el, tag)
	{
		strTxtSelected = "";
		//récupérer la sélection de l'utilisateur
		if(typeof(el.currRange) != 'undefined' && el.currRange.text != ""){
			strTxtSelected = el.currRange.text ;
		}
		//écrire le tag et l'insérer à l'emplacement du curseur
		if(tag!="" && tag!='undefined'){
			tag = "<" + tag + ">" + strTxtSelected + "</" + tag + ">";
		}
		insertAtCaret(el, tag) ;
	}
	
	/* insertion d'un tag fermé en lui-même (XHTML) sans option pour le moment */
	function insertSelfClosedTag(el, tag)
	{
		//écrire le tag et l'insérer à l'emplacement du curseur
		if(tag!="" && tag!='undefined'){
			tag = "<" + tag + " />";
		}
		insertAtCaret(el, tag) ;
	}
	
	/* fonctions spéciales wizards pour automne */
	function insertAutomneWizard(el, wizard){
		strTxtSelected = "";
		//récupérer la sélection de l'utilisateur
		if(typeof(el.currRange) != 'undefined' && el.currRange.text != ""){
			strTxtSelected = el.currRange.text ;
		}
		//écrire le tag et l'insérer à l'emplacement du curseur
		tag = "" ;
		//ul
		if(htmlAutomneWizards[wizard]!="" && htmlAutomneWizards[wizard]!= 'undefined'){
			tag = htmlAutomneWizards[wizard].replace("{{data}}", strTxtSelected) ;
		}
		insertAtCaret(el, tag) ;
	}
	
	/* fonctions spéciales wizards */
	function insertWizard(el, wizard){
		strTxtSelected = "";
		//récupérer la sélection de l'utilisateur
		if(typeof(el.currRange) != 'undefined' && el.currRange.text != ""){
			strTxtSelected = el.currRange.text ;
		}
		//écrire le tag et l'insérer à l'emplacement du curseur
		tag = htmlWizards[wizard] ;
		switch(wizard){
			case "table" :
				var nbColonnes = prompt('Nombre de colonnes : ',1) ;
				var nbLignes = prompt('Nombre de lignes : ',1) ;
				var strLignes = "" ;
				if(nbLignes>0){
					for(var row=0;row<nbLignes;row++){
						strLignes += "	<tr>\n" ;
						if(nbColonnes>0){
							for(var col=0;col<nbColonnes;col++){
								var strData = (col == 0 && row == 0) ? "{{data}}" : "" ;
								strLignes += '		<td>' + strData + '</td>\n' ;
							}
						}
						strLignes += "	</tr>\n" ;
					}
					tag = tag.replace("{{data}}", strLignes);
				}else{
					tag = "" ;
				}
				break ;
			case "ul" : case "ol" :
				var nbPuces = prompt('Nombre de puces attendues : ',1) ;
				var strPuces = "" ;
				if(nbPuces>0){
					for(var i=0;i<nbPuces;i++){
						var strData = (i>0) ? "" : "{{data}}" ;
						strPuces += '	<li>' + strData + '</li>\n' ;
					}
					tag = tag.replace("{{data}}", strPuces);
				}else{
					tag = "" ;
				}
				break ;
		}
		//remplacer le champs {{data}} par les données de la sélection
		if(tag!="" && tag!= 'undefined'){
			tag = tag.replace("{{data}}", strTxtSelected) ;
		}
		insertAtCaret(el, tag) ;
	}
	
	/* fonctions spéciales wizards */
	function insertSpecialChar(el, strChar){
		//écrire le tag et l'insérer à l'emplacement du curseur
		tag = "" ;
		//ul
		if(strChar!="" && strChar!= 'undefined'){
			insertAtCaret(el, "&" + strChar + ";") ;
		}
	}
	/* insère un <br /> à chaque retour chariot sur la zone sélectionnée */
	function insertLineBreaks(el){
		var strTxtSelected = "";
		var tag = "" ;
		//récupérer la sélection de l'utilisateur
		if(typeof(el.currRange) != 'undefined' && el.currRange.text != ""){
			strTxtSelected = el.currRange.text ;
		}
		//\u000A > Line Feed; \u000D > Carriage Return
 		if(strTxtSelected!=""){
			arr = new Array(0);
			arr = strTxtSelected.split("\u000D");
			if(arr.length>0){
				for(i=0;i<arr.length;i++){
					tag += arr[i] + "<br />\r" ;
				}
			}else{
				tag = strTxtSelected ;
			}
		}
		insertAtCaret(el, tag) ;
	}
	
	/*
		réception de la sélection depuis le curseur si elle n'est pas vide
	*/
	function getUserSelection()
	{
		var txt = "" ;
		/* The selection objects type property returns None, Text or Control. The 
		type "Control" applies to images and objects. They are handled differently 
		and in this example I will ignote the operation unless the type is 
		"Text" by returning. */
		if(document.selection){
			if(document.selection.type == "Text" && document.selection != 'undefined' && document.selection != "") {
				txt = document.selection.createRange().text;
			}
		}else if(window.getSelection()){
			txt = window.getSelection();
		}
		return txt ;
	}
	
	/* fonctions de positionnement du curseur et des insertions d'éléments */
	function setCaretToStart (el) {
	  if (el.createTextRange) {
	    var v = el.value;
	    var r = el.createTextRange();
	    r.moveEnd('character', -v.length);
	    r.select();
	  }
	}
	function setCaretToEnd (el) {
	  if (el.createTextRange) {
	    var v = el.value;
	    var r = el.createTextRange();
	    r.moveStart('character', v.length);
	    r.select();
	  }
	}
	function setCaretToLine (el, lNo) {
	  if (el.createTextRange) {
	    var v = el.value;
	    var p = -1;
	    var r = el.createTextRange();
	    r.collapse();
	    var l = 1;
	    while (l++ < lNo)
	      p = el.value.indexOf('\r\n', p + 1);
	    r.moveStart('character', lNo == 1 ? 0 : p - (lNo * 1) + 3);
	    r.select();
	  }
	}
	function insertAtEnd (el, txt) {
	  el.value += txt;
	  setCaretToEnd (el);
	}
	function insertAtStart (el, txt) {
	  el.value = txt + el.value;
	  setCaretToStart (el);
	}
	function insertOnClick (el, txt) {
	  var r = document.selection.createRange();
	  r.text = txt;
	}
	function insertTag (el, sel) {
	  var v = sel.options[sel.selectedIndex].value;
	  insertOnClick(el, v);
	}
	function insertAtCaret (el, txt) {
	  if(typeof(el.currRange)!='undefined' && el.currRange){
	    el.currRange.text = el.currRange.text.charAt(el.currRange.text.length - 1) != ' ' ? txt : txt + ' ';
	    el.currRange.select();
	  }else{
	    insertAtEnd(el, txt);
	  }
	}
	function storeCaret(editEl) {
		if(editEl.createTextRange){
			editEl.currRange = document.selection.createRange().duplicate();
		}else{
			editEl.currRange = editEl.value;
		}
	}
	
	/* cette fonction affiche et masque les objets ciblés par leur ID
	cette fonction est utilisée par le cadre frmTaches
	attendu : ID de l objet à masquer/afficher et nom de l'image de fleche à manipuler en swap */
	function showHide(idObjet){
		if(document.getElementById(idObjet)){
			if(document.getElementById(idObjet).style.display == "none"){
				document.getElementById(idObjet).style.display = "";
			}else if(document.getElementById(idObjet).style.display == "" || document.getElementById(idObjet).style.display == " "){
				document.getElementById(idObjet).style.display = "none";
			}
		}
	}
