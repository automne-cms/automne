#----------------------------------------------------------------
#
# Messages content for module polymod
# French Messages
#
#----------------------------------------------------------------
# $Id: polymod.sql,v 1.1 2010/01/18 17:29:42 sebastien Exp $

DELETE FROM messages WHERE module_mes = 'polymod' and language_mes = 'fr';

INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(2, 'polymod', 'fr', 'Création / modification d''un élément ''%s''');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(3, 'polymod', 'fr', 'Création / modification de l''élément ''%s'' :');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(4, 'polymod', 'fr', 'Suppression d''un élément ''%s''');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(5, 'polymod', 'fr', 'Suppression de l''élément ''%s'' :');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(6, 'polymod', 'fr', 'Lien existant');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(7, 'polymod', 'fr', 'Accueil');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(18, 'polymod', 'fr', 'Mots-clés');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(19, 'polymod', 'fr', 'Publié entre le');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(20, 'polymod', 'fr', 'et le');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(21, 'polymod', 'fr', '%s élément(s) ''%s'' correspondant à votre recherche');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(30, 'polymod', 'fr', 'Objet');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(31, 'polymod', 'fr', 'Changement du contenu d''un élement %s');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(32, 'polymod', 'fr', 'Changement apporté sur l''élément %s : <strong>%s</strong>\n\nAuteur(s) de la modification :\n%s');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(37, 'polymod', 'fr', 'Libellé');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(39, 'polymod', 'fr', 'Description');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(52, 'polymod', 'fr', 'Confirmez-vous la suppression de l''élément ''%s'' : %s');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(53, 'polymod', 'fr', 'Proposition de suppression d''un élément %s');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(55, 'polymod', 'fr', 'Suppression de l''élément %s : <strong>%s</strong>\n\nAuteur(s) de la suppression :\n%s');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(57, 'polymod', 'fr', 'Publication sur le site');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(66, 'polymod', 'fr', 'Trouver un élément ''%s''');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(77, 'polymod', 'fr', 'Lister');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(82, 'polymod', 'fr', 'Gestion des éléments ''%s''');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(108, 'polymod', 'fr', 'Gérer les éléments ''%s''');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(109, 'polymod', 'fr', 'Effectuer une recherche');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(110, 'polymod', 'fr', '<div class="rowComment"> <h1>Lance une recherche sur un type d''objet donn&eacute; :</h1> <div class="retrait"><span class="code"> &lt;atm-search what=&quot;<span class="keyword">objet</span>&quot; name=&quot;<span class="keyword">searchName</span>&quot;&gt;...&lt;/atm-search&gt; </span><br /> <br /> <ul> <li><span class="keyword">objet</span> : Type d''objet &agrave; rechercher (de la forme <span class="vertclair">{<span class="keyword">objet</span>}</span>)</li> <li><span class="keyword">searchName</span> : Nom de la recherche : identifiant unique pour la recherche dans la rang&eacute;e.</li> <li>Un attribut <span class="keyword">public</span> (facultatif) peut &ecirc;tre ajout&eacute; pour sp&eacute;cifier une recherche sur la zone publique ou &eacute;dit&eacute;e. Il prend pour valeur <span class="vertclair">true</span> pour une recherche publique (d&eacute;faut) ou <span class="vertclair">false</span> pour une recherche dans la zone &eacute;dit&eacute;e.</li> </ul> </div> <h2>Ce tag peut contenir les sous-tags suivants :</h2> <div class="retrait"> <h3>Affichage des r&eacute;sultats :</h3> <div class="retrait"><span class="code"> &lt;atm-result&nbsp; search=&quot;<span class="keyword">searchName</span>&quot;&gt; ... &lt;/atm-result&gt; </span><br /> <br /> Le contenu de ce tag sera lu pour chaque r&eacute;sultat trouv&eacute; pour la recherche en cours. <ul> <li><span class="keyword">searchName</span> : Nom de la recherche sur lequel appliquer le param&egrave;tre.</li> <li>Un attribut <span class="keyword">return </span>(facultatif) peut &ecirc;tre ajout&eacute; pour sp&eacute;cifier le type de r&eacute;sultat retourn&eacute;. Par d&eacute;faut une recherche renvoie des objets, mais dans l''optique d''am&eacute;liorer les performances, il est possible de sp&eacute;cifier les deux valeurs suivantes de retour : <ul> <li><span class="vertclair">POLYMOD_SEARCH_RETURN_IDS</span> : retournera uniquement l''identifiant du r&eacute;sultat.</li> <li><span class="vertclair">POLYMOD_SEARCH_RETURN_OBJECTSLIGHT</span> : retournera le r&eacute;sultat mais sans charger les sous-objets qu''il peut contenir dans ses diff&eacute;rents champs. Attention, ce param&egrave;tre n''est possible que sur une recherche publique.</li> </ul> </li> </ul> <br /> Les valeurs suivantes seront remplac&eacute;es dans le tag : <ul> <li><span class="vertclair">{firstresult}</span> : Vrai si le r&eacute;sultat en cours est le premier de la page en cours.</li> <li><span class="vertclair">{lastresult}</span> : Vrai si le r&eacute;sultat en cours est le dernier de la page en cours.</li> <li><span class="vertclair">{resultcount}</span> : Num&eacute;ro du r&eacute;sultat dans la page.</li> <li><span class="vertclair">{maxresults}</span> : Nombre de r&eacute;sultats pour la recherche.</li> <li><span class="vertclair">{maxpages}</span> : Nombre de pages maximum pour la recherche en cours.</li> <li><span class="vertclair">{currentpage}</span> : Num&eacute;ro de la page actuelle pour la recherche en cours.</li> <li><span class="vertclair">{resultid}</span> : Identifiant du r&eacute;sultat. Utile dans le cas d''une recherche retournant uniquement les identifiants des r&eacute;sultats (param&egrave;tre return avec la valeur POLYMOD_SEARCH_RETURN_IDS).</li> </ul> </div> <h3>Aucun r&eacute;sultats :</h3> <div class="retrait"><span class="code"> &lt;atm-noresult&nbsp; search=&quot;<span class="keyword">searchName</span>&quot;&gt; ... &lt;/atm-noresult&gt; </span><br /> <br /> Le contenu de ce tag sera affich&eacute; si aucun r&eacute;sultat n''est trouv&eacute; pour la recherche en cours. <ul> <li><span class="keyword">searchName</span> : Nom de la recherche sur laquelle appliquer le param&egrave;tre.</li> </ul> </div> <h3>Param&egrave;tre de recherche :</h3> <div class="retrait"><span class="code"> &lt;atm-search-param search=&quot;<span class="keyword">searchName</span>&quot; type=&quot;<span class="keyword">paramType</span>&quot; value=&quot;<span class="keyword">paramValue</span>&quot; mandatory=&quot;<span class="keyword">mandatoryValue</span>&quot; /&gt; </span><br /> <br /> Permet de limiter les r&eacute;sultats de la recherche &agrave; des param&egrave;tres donn&eacute;s. <ul> <li><span class="keyword">searchName</span> : Nom de la recherche sur laquelle appliquer le param&egrave;tre.</li> <li><span class="keyword">paramType</span> : Type de param&egrave;tre, peut &ecirc;tre de la forme <span class="vertclair">{<span class="keyword">objet:champ</span>:fieldID}</span> pour filtrer la recherche sur la valeur d''un champ donn&eacute; ou bien un nom de type fixe parmi : <span class="vertclair">%s</span> pour utiliser un filtrage pr&eacute;d&eacute;fini.</li> <li><span class="keyword">paramValue</span> : Valeur du param&egrave;tre de la recherche. Si la valeur est ''<span class="vertclair">block</span>'' vous pourrez sp&eacute;cifier cette valeur lors de la cr&eacute;ation de la rang&eacute;e dans la page.</li> <li><span class="keyword">mandatoryValue</span> : Bool&eacute;en (<span class="vertclair">true</span> ou <span class="vertclair">false</span>), permet de sp&eacute;cifier si ce param&egrave;tre de recherche est optionnel ou obligatoire.</li> </ul> <br /> Un param&egrave;tre suppl&eacute;mentaire <span class="keyword">operator</span> permet d''ajouter un comportement sp&eacute;cifique au type de champ sur le filtre. La valeur accept&eacute;e par ce param&egrave;tre est expliqu&eacute;e dans l''aide du champ concern&eacute; s''il accepte un tel param&egrave;tre.</div> <h3>Afficher une page donn&eacute;e de r&eacute;sultats (le nombre de r&eacute;sultats d''une page est sp&eacute;cifi&eacute; par le tag atm-search-limit) :</h3> <div class="retrait"><span class="code"> &lt;atm-search-page search=&quot;<span class="keyword">searchName</span>&quot; value=&quot;<span class="keyword">pageValue</span>&quot; /&gt; </span><br /> <br /> <ul> <li><span class="keyword">searchName</span> : Nom de la recherche sur laquelle appliquer le param&egrave;tre.</li> <li><span class="keyword">pageValue</span> : Valeur num&eacute;rique de la page &agrave; afficher.</li> </ul> </div> <h3>Limiter le nombre de r&eacute;sultats d''une page :</h3> <div class="retrait"><span class="code"> &lt;atm-search-limit search=&quot;<span class="keyword">searchName</span>&quot; value=&quot;<span class="keyword">limitValue</span>&quot; /&gt; </span><br /> <br /> <ul> <li><span class="keyword">searchName</span> : Nom de la recherche sur laquelle appliquer la limite.</li> <li><span class="keyword">limitValue</span> : Valeur num&eacute;rique de la limite &agrave; appliquer. Si la valeur est ''<span class="vertclair">block</span>'' vous pourrez sp&eacute;cifier cette valeur lors de la cr&eacute;ation de la rang&eacute;e dans la page.</li> </ul> </div> <h3>Ordonner les r&eacute;sultats :</h3> <div class="retrait"><span class="code">&lt;atm-search-order search=&quot;<span class="keyword">searchName</span>&quot; type=&quot;<span class="keyword">orderType</span>&quot; direction=&quot;<span class="keyword">directionValue</span>&quot; /&gt;</span><br /> <br /> <ul> <li><span class="keyword">searchName</span> : Nom de la recherche sur laquelle appliquer la limite.</li> <li><span class="keyword">orderType</span> : Type de valeur sur laquelle appliquer l''ordre, peut &ecirc;tre de la forme <span class="vertclair">{<span class="keyword">objet:champ</span>:fieldID}</span> ou un nom de type fixe parmi : <span class="vertclair">%s</span>.</li> <li><span class="keyword">directionValue</span> : Sens &agrave; appliquer : <span class="vertclair">asc</span> pour croissant, <span class="vertclair">desc</span> pour d&eacute;croissant. Si la valeur est ''<span class="vertclair">block</span>'' vous pourrez sp&eacute;cifier cette valeur lors de la cr&eacute;ation de la rang&eacute;e dans la page.</li> </ul> </div> </div> <h2>Fonctions :</h2> <div class="retrait"> <h3>Afficher la liste des pages de la recherche en cours :</h3> <div class="retrait"> <div class="code">&lt;atm-function function=&quot;pages&quot; maxpages=&quot;<span class="keyword">maxpagesValues</span>&quot; currentpage=&quot;<span class="keyword">currentpageValue</span>&quot; displayedpage=&quot;<span class="keyword">displayedpagesValue</span>&quot;&gt;<br /> &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;pages&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/pages&gt;</span><br /> &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;currentpage&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/currentpage&gt;</span><br /> &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;start&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/start&gt;</span><br /> &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;previous&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/previous&gt;</span><br /> &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;next&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/next&gt;</span><br /> &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;end&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/end&gt;</span><br /> &lt;/atm-function&gt;</div> <br /> <br /> Cette fonction permet d''afficher la liste de toutes les pages possibles pour la recherche.<br /> <ul> <li><span class="keyword">maxpagesValue</span> : Nombre de pages maximum sur lesquelles boucler (habituellement : <span class="vertclair">{maxpages}</span> ).</li> <li><span class="keyword">currentpageValue</span> : Num&eacute;ro de la page courante de la recherche (habituellement : <span class="vertclair">{currentpage}</span> ).</li> <li><span class="keyword">displayedpagesValue</span> : Nombre de pages &agrave; afficher.</li> <li>Le tag &lt;<span class="keyword">pages</span>&gt; sera lu pour chaque pages &agrave; lister except&eacute; la page courante et la valeur <span class="vertclair">{n}</span> sera remplac&eacute;e par le num&eacute;ro de la page.</li> <li>Le tag optionnel &lt;<span class="keyword">currentpage</span>&gt; sera lu pour la page en cours. S''il n''existe pas, le tag &lt;<span class="keyword">pages</span>&gt; sera utilis&eacute; &agrave; la place.</li> <li>Le tag optionnel &lt;<span class="keyword">start</span>&gt; sera lu pour la premi&egrave;re page.</li> <li>Le tag optionnel &lt;<span class="keyword">previous</span>&gt; sera lu pour la page pr&eacute;c&eacute;dente.</li> <li>Le tag optionnel &lt;<span class="keyword">next</span>&gt; sera lu pour la page suivante.</li> <li>Le tag optionnel &lt;<span class="keyword">end</span>&gt; sera lu pour la derni&egrave;re page.</li> </ul> </div> </div> </div>');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(111, 'polymod', 'fr', 'Syntaxe des tags');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(112, 'polymod', 'fr', 'Variables et fonctions des objets');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(113, 'polymod', 'fr', 'Tags de travail');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(114, 'polymod', 'fr', '
<div class="rowComment">
	<h1>Tags de travail :</h1>
	<div class="retrait">
		<h3>Afficher le contenu du tag si la condition est remplie :</h3>
		<div class="retrait">
			<span class="code"> &lt;atm-if what=&quot;<span class="keyword">condition</span>&quot;&gt; ... &lt;/atm-if&gt; </span>
			<ul>
				<li><span class="keyword">condition</span> : Condition &agrave; remplir pour afficher le contenu du tag. L''usage courant est de valider la pr&eacute;sence d''une valeur non nulle. Cette condition peut aussi prendre toutes les formes valides d''une condition PHP (voir : <a target="_blank" href="http://www.php.net/if" class="admin">Les structures de contr&ocirc;le en PHP</a>). La condition sera remplie si la valeur existe ou bien n''est pas nulle ou bien n''est pas &eacute;gale &agrave; faux (false).</li>
			</ul>
		</div>
		<h3>Boucler sur un ensemble d''objets :</h3>
		<div class="retrait">
			<span class="code">&lt;atm-loop on=&quot;<span class="keyword">objets</span>&quot;&gt; ... &lt;/atm-loop&gt;</span>
			<ul>
				<li><span class="keyword">objets</span> : Collection d''objets. Employ&eacute; pour traiter tous les objets d''un ensemble d''objets multiple (dit multi-objet).</li>
				<li>Un attribut <span class="keyword">reverse</span> (facultatif) peut être ajouté pour inverser l''ordre des résultats (valeur : booléen <span class="vertclair">true</span>, <span class="vertclair">false</span>)</li>
			</ul>
			<br />
			Les valeurs suivantes seront remplac&eacute;es dans le tag :
			<ul>
				<li><span class="vertclair">{firstloop}</span> : Vrai si l''objet en cours est le premier de la liste d''objets.</li>
				<li><span class="vertclair">{lastloop}</span> : Vrai si l''objet en cours est le dernier de la liste d''objets.</li>
				<li><span class="vertclair">{loopcount}</span> : Num&eacute;ro de l''objet en cours dans la liste d''objets.</li>
				<li><span class="vertclair">{lastloop}</span> : Vrai si l''objet en cours est le dernier de la liste d''objets.</li>
				<li><span class="vertclair">{maxloops}</span> : Nombre d''objets sur lesquels boucler.</li>
			</ul>
		</div>
		<h3>Ajouter un attribut au tag XHTML p&egrave;re (contenant ce tag) :</h3>
		<div class="retrait">
			<span class="code"> &lt;atm-parameter attribute=&quot;<span class="keyword">attributeName</span>&quot; value=&quot;<span class="keyword">attributeValue</span>&quot; /&gt; </span>
			<ul>
				<li><span class="keyword">attributeName</span> : Nom de l''attribut &agrave; ajouter.</li>
				<li><span class="keyword">attributeValue</span> : Valeur de l''attribut &agrave; ajouter.</li>
			</ul>
		</div>
		<h3>Assigner une valeur &agrave; une variable :</h3>
		<div class="retrait">
			<span class="code">&lt;atm-setvar vartype=&quot;<span class="keyword">type</span>&quot; varname=&quot;<span class="keyword">name</span>&quot; value=&quot;<span class="keyword">varValue</span>&quot; /&gt; </span>
			<ul>
				<li><span class="keyword">type </span>: Type de la variable &agrave; assigner : <span class="vertclair">request</span>, <span class="vertclair">session</span> ou <span class="vertclair">var</span>.</li>
				<li><span class="keyword">name </span>: Nom de la variable &agrave; assigner. Attention, r&eacute;assigner une variable existante supprimera l''ancienne valeur.</li>
				<li><span class="keyword">varValue</span> : valeur &agrave; assigner &agrave; la variable.</li>
			</ul>
		</div>
		<h3>Recharger une zone en AJAX :</h3>
		<div class="retrait">
			<span class="code">&lt;atm-xml what=&quot;<span class="keyword">condition</span>&quot;&gt; ... &lt;/atm-xml&gt; </span><br />
			Permet de recharger une zone sp&eacute;cifique de la page via une requête de type AJAX.<br />Si la requête HTTP appelant la page en cours contient les param&egrave;tres v&eacute;rifiant l''attribut <span class="keyword">condition</span>, alors seul le contenu du tag atm-xml sera renvoyé en réponse à la requête HTTP. Le reste du contenu de la page en cours sera ignoré.<br /><br />Pour plus d''informations, consultez la <a href="http://doc.automne.ws" target="_blank">documentation d''Automne en ligne</a> ou étudiez les modules Polymod fournis avec la démonstration d''Automne, ils font appel à cette fonctionnalité.
			<ul>
				<li><span class="keyword">condition</span> : Condition &agrave; remplir pour obtenir le contenu du tag atm-xml.</li>
			</ul><br />
			<strong>Exemple à l''aide de JQuery :</strong><br /><br />
			Votre rangée comporte le code suivant :<br />
			<span class="code">&lt;atm-xml what=&quot;<span class="keyword">{request:string:out} == ''xml''</span>&quot;&gt;<br />
			&nbsp;&nbsp;&nbsp; ... recherche d''actualit&eacute;s ...<br />
			&lt;/atm-xml&gt;</span><br />
			Si on effectue la requête ajax suivante vers la page comportant cette rangée :<br />
			<span class="code">
			$.ajax({<br />
			&nbsp;&nbsp;&nbsp;type:&nbsp;"POST",<br />
			&nbsp;&nbsp;&nbsp;url:&nbsp;pageURL,<br />
			&nbsp;&nbsp;&nbsp;data:&nbsp;''<span class="keyword">out=xml</span>&cat='' + $(''#cat'').val(),<br />
			&nbsp;&nbsp;&nbsp;success:&nbsp;displaySearch<br />
			});
			</span><br />
			Alors la recherche d''actualit&eacute;s sera relanc&eacute;e avec le param&egrave;tre de la cat&eacute;gorie selectionn&eacute; et seul le contenu de cette zone sera retourné :<br />
			<span class="code">
			&lt;?xml version=&quot;1.0&quot; encoding=&quot;utf-8&quot;?&gt;<br />
			&lt;response xmlns:xsi=&quot;http://www.w3.org/2001/XMLSchema-instance&quot; xmlns:xsd=&quot;http://www.w3.org/2001/XMLSchema&quot;&gt;<br />
			&nbsp;&nbsp;&nbsp;&nbsp;&lt;error&gt;0&lt;/error&gt;<br />
			&nbsp;&nbsp;&nbsp;&nbsp;&lt;data&gt;&lt;![CDATA[<span class="keyword"> ... le contenu du tag atm-xml correspondant à la nouvelle recherche d''actualités ... </span>]]&gt;&lt;/data&gt;<br />
			&lt;/response&gt;
			</span>
		</div>
	</div>
</div>
');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(115, 'polymod', 'fr', 'Bloc de données');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(116, 'polymod', 'fr', '<div class="rowComment">\n	<h1>Bloc de donn&eacute;es du module :</h1>\n	<div class="retrait">\n	<span class="code">\n		&lt;block module=&quot;%s&quot; id=&quot;<span class="keyword">blockID</span>&quot; language=&quot;<span class="keyword">languageCode</span>&quot;&gt; ... &lt;/block&gt;\n	</span>\n	<br/><br/>\n	Ce tag permet l''affichage de donn&eacute;es sp&eacute;cifiques &agrave; ce module. Il doit entourer tout ensemble de tags relatif &agrave; un traitement de donn&eacute;es du module.<br />\n	<ul>\n		<li><span class="keyword">blockID </span>: Identifiant unique du bloc de contenu dans la rang&eacute;e. Deux blocs de contenus d''une m&ecirc;me rang&eacute;e ne doivent pas avoir d''identifiants identiques.</li>\n		<li><span class="keyword">languageCode </span>: (facultatif) Code du langage relatif &agrave; ce bloc de contenu parmi les codes suivants : <span class="vertclair">%s</span>. <br/>Si non présent, la langue de la page sera utilisée. Si non présente, la langue par défaut d''Automne sera utilisée.</li>\n	</ul>\n	</div>\n</div>');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(117, 'polymod', 'fr', 'Libellé de l''objet, correspond à sa valeur');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(118, 'polymod', 'fr', 'Libellé du champ : ''%s''');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(119, 'polymod', 'fr', 'Identifiant du champ : ''%s''');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(120, 'polymod', 'fr', 'Valeur du champ');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(121, 'polymod', 'fr', 'Nom de l''objet');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(122, 'polymod', 'fr', 'Variables de l''objet');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(123, 'polymod', 'fr', 'Fonctions de l''objet');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(124, 'polymod', 'fr', 'Sélection des paramètres de recherche de la rangée ''%s'' du module ''%s''');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(125, 'polymod', 'fr', 'Pour la recherche ayant l''identifiant ''%s'' dans cette rangée');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(126, 'polymod', 'fr', '[Erreur : la recherche ayant l''identifiant ''%s'' dans la rangée ''%s'' n''est pas valide : Elle porte sur un objet inexistant.]');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(127, 'polymod', 'fr', '[Erreur : la recherche ayant l''identifiant ''%s'' dans la rangée ''%s'' n''est pas valide : Un des paramètres porte sur un champ inexistant.]');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(128, 'polymod', 'fr', 'Nombre de résultats par page');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(129, 'polymod', 'fr', 'Croissant');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(130, 'polymod', 'fr', 'Décroissant');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(131, 'polymod', 'fr', 'Ordre d''affichage');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(132, 'polymod', 'fr', 'Par création d''objet');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(133, 'polymod', 'fr', '[Erreur : la recherche ayant l''identifiant ''%s'' dans la rangée ''%s'' n''est pas valide : Le type de l''un de ces paramètres est inconnu : ''%s'']');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(134, 'polymod', 'fr', 'Publié à partir du');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(135, 'polymod', 'fr', 'Publié jusqu''au');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(136, 'polymod', 'fr', '[Erreur : la recherche ayant l''identifiant ''%s'' dans la rangée ''%s'' n''est pas valide : Le type de l''un de ces paramètres de tri est inconnu : ''%s'']');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(137, 'polymod', 'fr', 'Par date de début de publication');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(138, 'polymod', 'fr', 'Par date de fin de publication');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(139, 'polymod', 'fr', '
<div class="rowComment">
	<h1>Variables g&eacute;n&eacute;rales :</h1>
	<div class="retrait">
		<h3>Variables relatives aux pages :</h3>
		<div class="retrait"> Les variables relatives aux pages sont de la forme <span class="vertclair">{page:<span class="keyword">id</span>:<span class="keyword">type</span>}</span>:
		<ul>
			<li><span class="keyword">id </span>: Identifiant de la page &agrave; laquelle faire r&eacute;f&eacute;rence, peut &ecirc;tre un identifiant num&eacute;rique d''une page ou bien ''<span class="vertclair">self</span>'' pour faire r&eacute;f&eacute;rence &agrave; la page courante.</li>
			<li><span class="keyword">type</span> : type de donn&eacute;e souhait&eacute; pour la page parmi les suivants : <span class="vertclair">url </span>(adresse de la page), <span class="vertclair">printurl </span>(adresse de la page d''impression), <span class="vertclair">id </span>(identifiant de la page), <span class="vertclair">title </span>(nom de la page).</li>
		</ul>
		</div>
		<h3>Variables relatives aux donn&eacute;es envoy&eacute;es (via une adresse ou un formulaire) :</h3>
		<div class="retrait"> Ces variables correspondent &agrave; une variable provenant de la soumission d''un formulaire ou bien d''un param&egrave;tre du lien ayant amen&eacute; &agrave; la page en cours. <br /> Elles sont de la forme <span class="vertclair">{request:<span class="keyword">type</span>:<span class="keyword">name</span>}</span> :
		<ul>
			<li><span class="keyword">type</span> : Correspond au type de variable attendu, parmi les suivants : <br />
			<ul>
				<li><span class="vertclair">int </span>: nombre entier,&nbsp;</li>
				<li><span class="vertclair">string </span>: cha&icirc;ne de caract&egrave;re,&nbsp;</li>
				<li><span class="vertclair">safestring </span>: cha&icirc;ne de caract&egrave;re sans code HTML,&nbsp;</li>
				<li><span class="vertclair">bool </span>: bool&eacute;en,&nbsp;</li>
				<li><span class="vertclair">array</span>: tableau de valeurs,&nbsp;</li>
				<li><span class="vertclair">email </span>: email valide,</li>
				<li><span class="vertclair">date </span>: date valide sans heure (retourne une date au format MySQL : YYYY-MM-DD),</li>
				<li><span class="vertclair">datetime </span>: date valide avec heure (retourne une date au format MySQL : YYYY-MM-DD HH:MM:SS),</li>
				<li><span class="vertclair">localisedDate</span> : date valide sans heure (retourne une date au format de votre langue actuelle : %s).</li>
			</ul>
			</li>
			<li><span class="keyword">name</span> : Correspond au nom de la variable souhait&eacute; (nom du param&egrave;tre dans l''url ou bien nom du champ du formulaire).</li>
		</ul>
		</div>
		<h3>Variables de session :</h3>
		<div class="retrait"> Ces variables sont disponibles tout au long de la navigation du visiteur sur le site. <br /> Elles sont de la forme <span class="vertclair">{session:<span class="keyword">type</span>:<span class="keyword">name</span>}</span> :
		<ul>
			<li><span class="keyword">type</span> : Correspond au type de variable attendu, parmi les suivants :
			<ul>
				<li><span class="vertclair">int </span>: nombre entier,&nbsp;</li>
				<li><span class="vertclair">string </span>: cha&icirc;ne de caract&egrave;re,&nbsp;</li>
				<li><span class="vertclair">bool </span>: bool&eacute;en,&nbsp;</li>
				<li><span class="vertclair">array</span>: tableau de valeurs,&nbsp;</li>
				<li><span class="vertclair">email </span>: email valide,</li>
				<li><span class="vertclair">date </span>: date valide sans heure (retourne une date au format MySQL : YYYY-MM-DD),</li>
				<li><span class="vertclair">datetime </span>: date valide avec heure (retourne une date au format MySQL : YYYY-MM-DD HH:MM:SS),</li>
				<li><span class="vertclair">localisedDate</span> : date valide sans heure (retourne une date au format de votre langue actuelle : %s).</li>
			</ul>
			</li>
			<li><span class="keyword">name</span> : Correspond au nom de la variable souhait&eacute; (nom de la variable de session).</li>
		</ul>
		</div>
		<h3>Variables&nbsp;:</h3>
		<div class="retrait"> Ces variables correspondent &agrave; des variables PHP classiques. <br /> Elles sont de la forme <span class="vertclair">{var:<span class="keyword">type</span>:<span class="keyword">name</span>}</span> :
		<ul>
			<li><span class="keyword">type</span> : Correspond au type de variable attendu, parmi les suivants :
			<ul>
				<li><span class="vertclair">int </span>: nombre entier,&nbsp;</li>
				<li><span class="vertclair">string </span>: cha&icirc;ne de caract&egrave;re,&nbsp;</li>
				<li><span class="vertclair">bool </span>: bool&eacute;en,&nbsp;</li>
				<li><span class="vertclair">array</span>: tableau de valeurs,&nbsp;</li>
				<li><span class="vertclair">email </span>: email valide</li>
				<li><span class="vertclair">date </span>: date valide sans heure (retourne une date au format MySQL : YYYY-MM-DD),</li>
				<li><span class="vertclair">datetime </span>: date valide avec heure (retourne une date au format MySQL : YYYY-MM-DD HH:MM:SS),</li>
				<li><span class="vertclair">localisedDate</span> : date valide sans heure (retourne une date au format de votre langue actuelle : %s).</li>
			</ul>
			</li>
			<li><span class="keyword">name</span> : Correspond au nom de la variable souhait&eacute; (nom de la variable PHP).</li>
		</ul>
		</div>
		<h3>Variables relatives aux utilisateurs :</h3>
		<div class="retrait"> Les variables relatives aux utilisateurs sont de la forme <span class="vertclair">{user:<span class="keyword">id</span>:<span class="keyword">type</span>}</span>:
		<ul>
			<li><span class="keyword">id </span>: Identifiant de l''utilisateur auquel faire r&eacute;f&eacute;rence, peut &ecirc;tre un identifiant num&eacute;rique d''un utilisateur ou bien ''<span class="vertclair">self</span>'' pour faire r&eacute;f&eacute;rence &agrave; l''utilisateur courant (uniquement si la vérification des droits côté client est activé dans les paramètres Automne).</li>
			<li><span class="keyword">type</span> : Correspond au type de variable attendu, parmi les suivants : <br />
			<ul>
				<li><span class="vertclair">login </span>: identifiant de l''utilisateur,</li>
				<li><span class="vertclair">fistName </span>: prénom,</li>
				<li><span class="vertclair">lastName </span>: nom,</li>
				<li><span class="vertclair">fullName </span>: prénom et nom,</li>
				<li><span class="vertclair">email</span>: email,</li>
				<li><span class="vertclair">language </span>: retourne un objet CMS_language correspondant à la langue du compte utilisateur,</li>
				<li><span class="vertclair">active </span>: bool&eacute;en, <span class="vertclair">true</span> pour actif, <span class="vertclair">false</span> pour inactif,</li>
				<li><span class="vertclair">deleted </span>: bool&eacute;en, <span class="vertclair">true</span> pour supprimé, <span class="vertclair">false</span> pour existant.</li>
				</ul>
			</li>
		</ul>
		</div>
	</div>
</div>
');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(140, 'polymod', 'fr', 'Variables générales');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(141, 'polymod', 'fr', 'Identifiant unique de l''objet');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(142, 'polymod', 'fr', 'Libellé de l''objet');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(143, 'polymod', 'fr', 'Nom de l''objet : ''%s''');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(144, 'polymod', 'fr', 'Description de l''objet : ''%s''');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(145, 'polymod', 'fr', 'Identifiant de type de l''objet : ''%s''');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(146, 'polymod', 'fr', 'Identifiant du champ auquel l''objet appartient (si il existe)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(147, 'polymod', 'fr', 'Identifiant de ressource de l''objet');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(148, 'polymod', 'fr', 'Ensemble des objets de type ''%s'' associés à ce  champ. Cette valeur est usuellement utilisée par un tag atm-loop');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(149, 'polymod', 'fr', 'Nombre d''objets de type ''%s'' associés à ce champ');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(150, 'polymod', 'fr', 'Date format&eacute;e. Remplacez ''format'' par la valeur correspondant au format accept&eacute; en PHP pour la <a href="http://www.php.net/date" class="admin" target="_blank">''fonction date''</a>. Pour une date employ&eacute;e dans un Fil RSS, utilisez la valeur ''<strong>rss</strong>'' pour sp&eacute;cifier le format.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(151, 'polymod', 'fr', 'Adresse du lien (URL)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(152, 'polymod', 'fr', 'Libellé du lien');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(153, 'polymod', 'fr', 'Cible du lien (_blank, _top, etc.)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(154, 'polymod', 'fr', 'Type de lien (interne, externe, fichier, etc.)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(155, 'polymod', 'fr', 'Code HTML complet du lien. Le titre du lien peut-être modifié grâce à un paramètre (facultatif)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(156, 'polymod', 'fr', 'Identifiant de la catégorie racine de ce champ');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(157, 'polymod', 'fr', 'Nombre de catégories associées à ce champ');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(158, 'polymod', 'fr', 'Catégories associées à ce champ. Cette valeur est usuellement utilisée par un tag atm-loop');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(159, 'polymod', 'fr', 'Identifiant d''une catégorie du champ (utilisable dans un tag atm-loop)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(160, 'polymod', 'fr', 'Libellé d''une catégorie du champ (utilisable dans un tag atm-loop)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(161, 'polymod', 'fr', 'Identifiant de la catégorie du champ');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(162, 'polymod', 'fr', '<strong>Liste de tous les objets d''un type donn&eacute; :</strong><br /><br /><span class="code">&lt;select ...&gt;&lt;atm-function function=&quot;selectOptions&quot; object=&quot;%s&quot; selected=&quot;<span class="keyword">selectedID</span>&quot;&gt;&lt;/atm-function&gt;&lt;/select&gt;</span><br />Cette fonction permet d''afficher une liste class&eacute;e par ordre alphab&eacute;tique de tags &lt;option&gt; contenant tous les objets du m&ecirc;me type que l''objet pass&eacute; en param&egrave;tre. Elle est usuellement employ&eacute;e &agrave; l''int&eacute;rieur d''un tag &lt;select&gt;.<br /><ul><li><span class="keyword">selectedID : </span>Identifiant de l''objet &agrave; selectionner dans la liste</li></ul><br />');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(163, 'polymod', 'fr', '<strong>Arborescence de cat&eacute;gories : </strong><br /> <br /> <span class="code">&lt;atm-function function=&quot;categoriesTree&quot; object=&quot;%s&quot; root=&quot;<span class="keyword">rootID</span>&quot; maxlevel=&quot;<span class="keyword">maxLevel</span>&quot; selected=&quot;<span class="keyword">selectedID</span>&quot;&gt;<br /> &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;item&gt;</span>&lt;li class=&quot;<span class="vertclair">{lvl}</span>&quot;&gt; ... <span class="vertclair">{id}</span> ... <span class="vertclair">{label}</span> ... <span class="vertclair">{sublevel}</span> ... &lt;/li&gt;<span class="keyword">&lt;/item&gt;</span><br /> &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;itemselected&gt;</span>&lt;li class=&quot;<span class="vertclair">{lvl}</span>&quot;&gt; ... <span class="vertclair">{id}</span> ... <span class="vertclair">{label}</span> ... <span class="vertclair">{sublevel}</span> ... &lt;/li&gt;<span class="keyword">&lt;/itemselected&gt;</span><br /> &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;template&gt;</span>&lt;ul&gt;<span class="vertclair">{sublevel}</span>&lt;/ul&gt;<span class="keyword">&lt;/template&gt;</span><br /> &lt;/atm-function&gt;<strong><br /> </strong></span> <p>Cette Fonction permet d''afficher une arborescence de cat&eacute;gories.</p> <ul> <strong> </strong> <li><span class="keyword">rootID </span>: L''identifiant de la cat&eacute;gorie devant servir de racine &agrave; l''arborescence.</li> <li><span class="keyword">maxLevel </span>: Nombre de niveaux maximum &agrave; afficher pour l''arborescence (facultatif).</li> <li><span class="keyword">selectedID </span>: Cat&eacute;gorie actuellement s&eacute;lectionn&eacute;e (facultatif).</li> <li><span class="keyword">usedcategories </span>: Bool&eacute;en <span class="vertclair">true, false</span>, affiche uniquement les cat&eacute;gories utilis&eacute;es (facultatif, d&eacute;faut : true).</li> <li>Le tag &lt;<span class="keyword">item</span>&gt; sera lu pour chaque cat&eacute;gorie &agrave; lister. La valeur <span style="font-weight: bold;"><span class="vertclair">{id}</span> </span>sera remplac&eacute;e par l''identifiant de la cat&eacute;gorie en cours, la valeur <span class="vertclair">{label}</span> par son libell&eacute;, la valeur <span class="vertclair">{description}</span> par sa description, la valeur <span class="vertclair">{icon}</span> par le tag HTML permettant d''afficher l''icône. La valeur <span class="vertclair">{lvl}</span> sera remplac&eacute;e par le num&eacute;ro du niveau en cours dans l''arborescence et la valeur <span class="vertclair">{sublevel}</span> par le niveau suivant dans l''arborescence.</li> <li>Le tag &lt;<span class="keyword">template</span>&gt; sera lu au d&eacute;but de chaque niveau d''arborescence. La valeur <span class="vertclair">{sublevel}</span> sera remplac&eacute;e par le contenu du niveau d''arborescence en cours.</li> <li>Le tag &lt;<span class="keyword">itemselected</span>&gt; sera lu pour la cat&eacute;gorie actuellement sélectionn&eacute;e (facultatif).</li> </ul>');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(164, 'polymod', 'fr', '<strong>Hi&eacute;rarchie - Historique de cat&eacute;gories :</strong><br /> <br /> <span class="code"> &lt;atm-function function=&quot;categoryLineage&quot; object=&quot;%s&quot; category=&quot;<span class="keyword">categoryID</span>&quot; root=&quot;<span class="keyword">rootCatID</span>&quot;&gt;<br /> &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;ancestor&gt;</span> ... <span class="vertclair">{id}</span> ... <span class="vertclair">{label}</span> ... <span class="keyword">&lt;/ancestor&gt;</span><br /> &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;self&gt;</span> ... <span class="vertclair">{id}</span> ... <span class="vertclair">{label}</span> ... <span class="keyword">&lt;/self&gt;</span><br /> &lt;/atm-function&gt;</span><strong><br /> </strong>Cette fonction permet d''afficher la hi&eacute;rarchie parente (historique) d''une cat&eacute;gorie donn&eacute;e. <ul> <li><strong><span class="keyword">categoryID </span>: </strong>L''identifiant de la cat&eacute;gorie dont on souhaite afficher la hi&eacute;rarchie.</li> <li><strong><span class="keyword">rootCatID </span>: </strong>L''identifiant de la cat&eacute;gorie à partir de laquelle on souhaite afficher la hi&eacute;rarchie (facultatif si "catégorie de plus haut niveau" sélectionnée, obligatoire dans le cas contraire).</li> <li>Le tag <strong>&lt;<span class="keyword">ancestor</span>&gt;</strong> sera lu pour chaque ancêtre de la cat&eacute;gorie trouv&eacute;. La valeur <span class="vertclair">{id}</span> sera remplac&eacute; par l''identifiant de la cat&eacute;gorie ancêtre, la valeur <span class="vertclair">{label}</span> par son libell&eacute;.</li> <li>Le tag optionel <strong>&lt;<span class="keyword">self</span>&gt;</strong> sera lu pour la cat&eacute;gorie ancêtre dont on affiche la hiérarchie (si le tag n''existe pas, le tag &lt;<span class="keyword">ancestor</span>&gt; sera employ&eacute;). La valeur <span class="vertclair">{id}</span> sera remplac&eacute; par l''identifiant de la cat&eacute;gorie&nbsp; dont on affiche la hiérarchie, la valeur <span class="vertclair">{label}</span> par son libell&eacute;.</li> </ul>');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(165, 'polymod', 'fr', '<strong>Liste de toutes les cat&eacute;gories d''un champ donn&eacute; :</strong><br /> <br /> <span class="code">&lt;select ...&gt;&lt;atm-function function=&quot;selectOptions&quot; object=&quot;%s&quot; selected=&quot;<span class="keyword">selectedID</span>&quot;&gt;&lt;/atm-function&gt;&lt;/select&gt;</span><br /> Cette fonction permet d''afficher une liste class&eacute;e par ordre alphab&eacute;tique de tags &lt;option&gt; contenant toutes les cat&eacute;gories et sous cat&eacute;gories d''un champ donn&eacute;. Elle est usuellement employ&eacute;e &agrave; l''int&eacute;rieur d''un tag &lt;select&gt;. <ul> <li><span class="keyword">selectedID </span><strong>: </strong>Identifiant de la cat&eacute;gorie &agrave; sélectionner dans la liste (facultatif)</li> <li><span class="keyword">usedcategories </span>: Bool&eacute;en <span class="vertclair">true, false</span>, affiche uniquement les cat&eacute;gories utilis&eacute;es (facultatif, d&eacute;faut : true).</li> <li><span class="keyword">editableonly </span>: Bool&eacute;en <span class="vertclair">true, false</span>, arffiche uniquement les cat&eacute;gories &eacute;ditables (facultatif, d&eacute;faut : false).</li> <li><span class="keyword">root </span>: L''identifiant de la cat&eacute;gorie &agrave; employer comme racine.</li> </ul>');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(166, 'polymod', 'fr', 'Catégories');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(167, 'polymod', 'fr', 'Permet de catégoriser les objets et de gérer leurs droits d''accès');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(168, 'polymod', 'fr', 'Catégories multiples');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(169, 'polymod', 'fr', 'Catégorie de plus haut niveau');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(170, 'polymod', 'fr', 'Date');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(171, 'polymod', 'fr', 'Champ contenant une date au format de la langue courante');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(172, 'polymod', 'fr', 'Si le champ est vide, enregistrer la date du jour');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(173, 'polymod', 'fr', 'Avec gestion des heures, minutes, secondes');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(174, 'polymod', 'fr', 'hh:mm:ss');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(175, 'polymod', 'fr', 'Lien');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(176, 'polymod', 'fr', 'Champ contenant un lien vers un site externe, une page ou un fichier.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(177, 'polymod', 'fr', 'Nombre entier');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(178, 'polymod', 'fr', 'Nombre entier de 11 chiffres maximum');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(179, 'polymod', 'fr', 'Peut être nul');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(180, 'polymod', 'fr', 'Peut être négatif');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(181, 'polymod', 'fr', 'Champ texte');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(182, 'polymod', 'fr', 'Champ de texte long, avec ou sans HTML');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(183, 'polymod', 'fr', 'HTML autorisé');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(184, 'polymod', 'fr', 'Type de barre d''outil pour l''éditeur de texte (wysiwyg)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(185, 'polymod', 'fr', 'Chaîne de caractères');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(186, 'polymod', 'fr', 'Chaîne contenant 255 caractères maximum sans HTML. Peut être un email.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(187, 'polymod', 'fr', 'Nombre maximum de charactères :<br /><small>(255 maximum)</small>');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(188, 'polymod', 'fr', 'Objet inconnu');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(189, 'polymod', 'fr', 'Cet objet n''est pas défini');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(190, 'polymod', 'fr', 'Multiples objets ''%s''');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(191, 'polymod', 'fr', 'Objet composé de multiples objets ''%s''');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(192, 'polymod', 'fr', 'Ces objets peuvent être édités ?');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(193, 'polymod', 'fr', 'Création d''un élément ''%s'' à associer');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(194, 'polymod', 'fr', 'Edition d''un objet ''%s''');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(195, 'polymod', 'fr', 'Eléments ''%s'' actuellement associés');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(196, 'polymod', 'fr', 'Associer un objet ''%s'' existant');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(197, 'polymod', 'fr', 'Forcer le chargement des sous objets ?');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(198, 'polymod', 'fr', 'Attention, ce paramètre doit rester désactivé sauf si des données sont manquantes lors de certains chargements. Activer ce paramètre peut entraîner une perte de performance très importante.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(199, 'polymod', 'fr', 'Uniquement les objets répondant à ces paramètres');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(200, 'polymod', 'fr', 'Image');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(201, 'polymod', 'fr', 'Champ contenant une image avec ou sans image zoom');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(202, 'polymod', 'fr', 'Largeur maximum de la vignette en pixels');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(203, 'polymod', 'fr', 'Date de début de publication formatée. Remplacez ''format'' par la valeur correspondant au format accepté en PHP pour la <a href="http://www.php.net/date" class="admin" target="_blank">''fonction date''</a>. Pour une date employ&eacute;e dans un Fil RSS, utilisez la valeur ''<strong>rss</strong>'' pour sp&eacute;cifier le format.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(204, 'polymod', 'fr', 'Date de fin de publication formatée (si elle existe). Remplacez ''format'' par la valeur correspondant au format accepté en PHP pour la <a href="http://www.php.net/date" class="admin" target="_blank">''fonction date''</a>. Pour une date employ&eacute;e dans un Fil RSS, utilisez la valeur ''<strong>rss</strong>'' pour sp&eacute;cifier le format.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(205, 'polymod', 'fr', 'Utiliser la vignette originale pour l''image zoom');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(206, 'polymod', 'fr', 'Vignette');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(207, 'polymod', 'fr', 'Image zoom');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(208, 'polymod', 'fr', '(La vignette sera redimensionnée à %s pixels de large)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(209, 'polymod', 'fr', 'Utiliser une image zoom distincte');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(210, 'polymod', 'fr', '(Si vous n''utilisez pas d''image zoom distincte)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(211, 'polymod', 'fr', 'Conserver l''image originale de la vignette comme image zoom');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(212, 'polymod', 'fr', '(Si la vignette dépasse cette largeur elle sera redimensionnée)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(213, 'polymod', 'fr', 'Cochez la case pour effacer l''image');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(214, 'polymod', 'fr', 'Image actuelle');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(215, 'polymod', 'fr', 'Code HTML de l''image. Le titre du lien peut être modifié grace à un paramètre (facultatif)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(216, 'polymod', 'fr', 'Libellé de l''image');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(217, 'polymod', 'fr', 'Nom du fichier de l''image');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(218, 'polymod', 'fr', 'Nom du fichier de l''image zoom');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(219, 'polymod', 'fr', 'Chemin du répertoire de l''image et de l''image zoom');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(220, 'polymod', 'fr', 'Largeur de l''image en pixels');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(221, 'polymod', 'fr', 'Hauteur de l''image en pixels');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(222, 'polymod', 'fr', 'Largeur de l''image zoom en pixels');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(223, 'polymod', 'fr', 'Hauteur de l''image zoom en pixels');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(224, 'polymod', 'fr', 'Poids de l''image en Mo');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(225, 'polymod', 'fr', 'Poids de l''image zoom en Mo');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(226, 'polymod', 'fr', 'La valeur du champ doit être un email valide');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(227, 'polymod', 'fr', 'Fichier');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(228, 'polymod', 'fr', 'Champ contenant un fichier avec ou sans vignette');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(229, 'polymod', 'fr', 'Largeur maximum de la vignette en pixels');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(230, 'polymod', 'fr', 'Utiliser une vignette pour le fichier');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(231, 'polymod', 'fr', '<!--Icônes de type pour les fichiers-->');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(232, 'polymod', 'fr', 'Fichier source');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(233, 'polymod', 'fr', 'ou Fichier FTP');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(234, 'polymod', 'fr', 'Chemin du repertoire FTP à utiliser');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(235, 'polymod', 'fr', '(Laissez vide pour empêcher l''utilisation d''un répertoire FTP comme source pour vos documents)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(236, 'polymod', 'fr', '(max : %s)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(237, 'polymod', 'fr', '(Répertoire FTP : %s)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(238, 'polymod', 'fr', 'Chemin vers l''icône du fichier (si elle existe)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(239, 'polymod', 'fr', 'Type de fichier (extension)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(240, 'polymod', 'fr', 'Cochez la case pour effacer le fichier');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(241, 'polymod', 'fr', 'Fichier actuel');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(242, 'polymod', 'fr', 'Code HTML du fichier');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(243, 'polymod', 'fr', 'Libellé du fichier');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(244, 'polymod', 'fr', 'Nom du fichier');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(245, 'polymod', 'fr', 'Nom du fichier de la vignette');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(246, 'polymod', 'fr', 'Chemin du répertoire du fichier et de la vignette');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(247, 'polymod', 'fr', 'Largeur de la vignette en pixels');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(248, 'polymod', 'fr', 'Hauteur de la vignette en pixels');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(249, 'polymod', 'fr', 'Autoriser l''utilisation de fichiers du répertoire FTP');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(250, 'polymod', 'fr', '(Permet d''utiliser un répertoire d''Automne pour déposer des gros fichiers via FTP)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(251, 'polymod', 'fr', 'Poids du fichier en Mo');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(252, 'polymod', 'fr', 'Renvoi vrai si l''objet contient un lien valide.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(253, 'polymod', 'fr', 'Largeur maximum de l''image en pixels');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(254, 'polymod', 'fr', 'Adresse de prévisualisation');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(255, 'polymod', 'fr', 'Valeur HTML du texte (retours chariots convertis pour le texte seul)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(256, 'polymod', 'fr', 'Fichier associé à la catégorie du champ');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(257, 'polymod', 'fr', 'Fichier d''une catégorie du champ (utilisable dans un tag atm-loop)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(258, 'polymod', 'fr', 'Sans %s');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(259, 'polymod', 'fr', 'Nombre d''utilisateurs/groupes associés à ce champ');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(260, 'polymod', 'fr', 'Utilisateurs/Groupes associés à ce champ. Cette valeur est usuellement utilisée par un tag atm-loop');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(261, 'polymod', 'fr', 'Identifiant d''un utilisateur/groupe du champ (utilisable dans un tag atm-loop)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(262, 'polymod', 'fr', 'Nom et prénom d''un utilisateur ou nom d''un groupe du champ (utilisable dans un tag atm-loop)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(263, 'polymod', 'fr', 'Identifiant de l''utilisateur ou du groupe');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(264, 'polymod', 'fr', 'Utilisateur/Groupe');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(265, 'polymod', 'fr', 'Permet d''associer un ou plusieurs utilisateurs ou groupe(s) d''utilisateurs');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(266, 'polymod', 'fr', 'Multiples utilisateurs ou groupes');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(267, 'polymod', 'fr', 'Utiliser des groupes');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(268, 'polymod', 'fr', 'La valeur est l''utilisateur actuel');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(269, 'polymod', 'fr', 'Ce paramètre exclut les autres');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(270, 'polymod', 'fr', 'Si ce paramètre est sélectionné, vous pourrez utiliser des groupes d''utilisateurs. Sinon, ce sera des utilisateurs');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(271, 'polymod', 'fr', '<strong>Liste de tous les utilisateurs/groupes du champ :<br />\n</strong><br />\n<span class="code"> &lt;select&gt;<strong>&lt;</strong>atm-function function=&quot;selectOptions&quot; object=&quot;%s&quot; selected=&quot;<span class="keyword">selectedID</span><strong>&quot;&gt;&lt;/</strong>atm-function<strong>&gt;</strong>&lt;/select&gt;</span><br />\nCette fonction permet d''afficher une liste class&eacute;e par ordre alphab&eacute;tique de tags &lt;option&gt; contenant tous les utilisateurs/groupes du champ donn&eacute; en param&egrave;tre. Elle est usuellement employ&eacute;e &agrave; l''int&eacute;rieur d''un tag &lt;select&gt;.<br />\n<ul>\n	<li><span class="keyword">selectedID </span><strong>: </strong>Identifiant de l''utilisateur/groupe &agrave; selectionner dans la liste</li>\n</ul>');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(272, 'polymod', 'fr', 'Nom et prénom de l''utilisateur ou nom du groupe');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(273, 'polymod', 'fr', 'Email d''un utilisateur du champ (utilisable dans un tag atm-loop)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(274, 'polymod', 'fr', 'Email de l''utilisateur');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(275, 'polymod', 'fr', 'Modules WYSIWYG associés');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(276, 'polymod', 'fr', 'Propriétés de l''objet');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(277, 'polymod', 'fr', 'Création / modification d''un module WYSIWYG pour l''objet ''%s''');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(278, 'polymod', 'fr', 'Syntaxe de la définition du module WYSIWYG pour l''objet ''%s''');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(279, 'polymod', 'fr', 'Confirmez-vous la suppression du module WYSIWYG ''%s'' ? Attention cette suppression est définitive, elle n''est pas soumise à validation et elle impactera tous les objets ainsi que tous les fichiers correspondant à ce module !');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(280, 'polymod', 'fr', '[Erreur : Aucun module WYSIWYG disponible ...]');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(281, 'polymod', 'fr', 'Type');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(282, 'polymod', 'fr', 'Editeur de texte');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(283, 'polymod', 'fr', 'Elément actuellement sélectionné');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(284, 'polymod', 'fr', 'Sélectionner');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(285, 'polymod', 'fr', 'Déselectionner');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(286, 'polymod', 'fr', '[Erreur : Ce module nécessite d''avoir sélectionné un texte. Merci de sélectionner le texte souhaité ...]');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(287, 'polymod', 'fr', 'Modules WYSIWYG');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(288, 'polymod', 'fr', '
<div class="rowComment"> 
<h1>Bloc de données d''un module WYSIWYG :</h1>
<p><span class="code"> &lt;atm-plugin language="<span class="keyword">languageCode</span>"&gt;<br />
&#160;&#160;&#160; <span class="keyword">&lt;atm-plugin-valid&gt;</span><br />
&#160;&#160;&#160; &#160;&#160;&#160; ...<br />
&#160;&#160;&#160; <span class="keyword">&lt;/atm-plugin-valid&gt;</span><br />
&#160;&#160;&#160; <span class="keyword">&lt;atm-plugin-invalid&gt;</span><br />
&#160;&#160;&#160; &#160;&#160;&#160; ...<br />
&#160;&#160;&#160; <span class="keyword">&lt;/atm-plugin-invalid&gt;</span><br />
&#160;&#160;&#160; <span class="keyword">&lt;atm-plugin-view&gt;</span><br />
&#160;&#160;&#160;&#160;&#160;&#160;&#160; ...<br />
&#160;&#160;&#160; <span class="keyword">&lt;/atm-plugin-view&gt;</span><br />
&lt;/atm-plugin&gt;</span><br />
<br />
Ce tag permet l''affichage de données spécifiques à un objet dans l''éditeur de texte visuel (WYSIWYG).<br />
Le <span class="keyword">tag atm-plugin-valid</span> sera lu si l''objet sélectionné est valide (non supprimé, validé et en cours de publication).</p>
<p><br />
Le tag <span class="keyword">atm-plugin-invalid </span>(facultatif) sera lu si l''objet sélectionné est invalide (supprimé, non validé ou dont les dates de publication sont dépassées ou si l''utilisateur n''a pas les droits de consultation de cet objet).</p>
<p><br />
Le tag <span class="keyword">atm-plugin-view</span> (facultatif) remplacera le tag atm-plugin-valid dans l''éditeur de texte visuel (WYSIWYG). Il est principalement utilisé pour afficher une version simplifié des données et ainsi faciliter la modification du contenu de l''éditeur.</p>
<ul>
    <li><span class="keyword">languageCode </span>: Code du langage relatif au contenu parmi les codes suivants : <span class="vertclair">%s</span>.</li>
    <li><span class="keyword">{plugin:selection}</span> : Sera replacé par la valeur textuelle sélectionnée dans l''éditeur (facultatif).</li>
</ul>
</div>
');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(289, 'polymod', 'fr', '<strong>Charge une cat&eacute;gorie donn&eacute;e :<br />\n</strong><br />\n<span class="code"> &lt;atm-function function=&quot;category&quot; object=&quot;%s&quot; category=&quot;<span class="keyword">categoryID</span>&quot;&gt;<br />\n&nbsp;&nbsp;&nbsp; ... <span class="vertclair">{id}</span> ... <span class="vertclair">{label}</span> ... <br />\n&lt;/atm-function&gt;</span><strong><br />\n</strong>Cette fonction permet d''afficher le contenu d''une cat&eacute;gorie donn&eacute;e.<br />\n<ul>\n	<li><span class="keyword">categoryID </span><strong>: </strong>L''identifiant de la cat&eacute;gorie dont on souhaite afficher la hi&eacute;rarchie.</li>\n	<li>La valeur <span class="vertclair">{id}</span> sera remplac&eacute; par l''identifiant de la cat&eacute;gorie anc&egrave;tre, la valeur <span class="vertclair">{label}</span> par son libell&eacute;.</li>\n</ul>');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(290, 'polymod', 'fr', 'Fils RSS associés');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(291, 'polymod', 'fr', 'Confirmez-vous la suppression du fil RSS ''%s'' ? Attention cette suppression est définitive, elle n''est pas soumise à validation et elle impactera tous les objets ainsi que tous les fichiers correspondant à ce module !');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(292, 'polymod', 'fr', 'Création / modification d''un fil RSS pour l''objet ''%s''');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(293, 'polymod', 'fr', 'Syntaxe de la définition du fil RSS pour l''objet ''%s''');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(294, 'polymod', 'fr', 'Fils RSS');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(295, 'polymod', 'fr', '<strong>Bloc de donn&eacute;es d''un module WYSIWYG :<br /><br />&lt;atm-plugin language=&quot;</strong>languageCode<strong>&quot;&gt;<br />&nbsp;&nbsp;&nbsp; &lt;atm-plugin-valid&gt;<br />&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; ...<br />&nbsp;&nbsp;&nbsp; &lt;/atm-plugin-valid&gt;<br />&nbsp;&nbsp;&nbsp; &lt;atm-plugin-invalid&gt;<br />&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; ...<br />&nbsp;&nbsp;&nbsp; &lt;/atm-plugin-invalid&gt;<br />&lt;/atm-plugin&gt;</strong><br /><br />Ce tag permet l''affichage de donn&eacute;es sp&eacute;cifiques &agrave; un objet dans l''&eacute;diteur de texte visuel (WYSIWYG).<br />Le tag <strong>atm-plugin-valid</strong> sera lu si l''objet s&eacute;lectionn&eacute; est valide (non supprim&eacute;, valid&eacute; et en cours de publication).<br />Le tag <strong>atm-plugin-invalid</strong> (facultatif) sera lu si l''objet s&eacute;lectionn&eacute; est invalide (supprim&eacute;, non valid&eacute; ou dont les dates de publication sont d&eacute;pass&eacute;es ou si l''utilisateur n''a pas les droits de consultation de cet objet).<br /><ul><li><strong>languageCode</strong> : Code du langage relatif au contenu parmi les codes suivants : <strong>%s</strong>.</li><li><strong>{plugin:selection}</strong> : Sera replac&eacute; par la valeur s&eacute;lectionn&eacute;e dans le Wysiwyg (facultatif).</li></ul>');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(296, 'polymod', 'fr', 'Adresse vers le site du fil');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(297, 'polymod', 'fr', 'Ce lien sera employé dans le fil RSS et permettra d''aller au site source du fil. Si ce champ n''est pas rempli, l''adresse ''%s'' sera utilisée.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(298, 'polymod', 'fr', 'Auteur');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(299, 'polymod', 'fr', 'Email de l''auteur');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(300, 'polymod', 'fr', 'Copyright');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(301, 'polymod', 'fr', 'Catégories');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(302, 'polymod', 'fr', 'Liste de termes séparés par des virgules permettant de catégoriser le fil RSS');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(303, 'polymod', 'fr', 'Interval de mise à jour');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(304, 'polymod', 'fr', 'Permet aux lecteurs de fils RSS d''avoir une valeur indicative concernant la fréquence de mise à jour du fil. Par défaut : 1 fois par jour, minimum : 2 fois par heure.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(305, 'polymod', 'fr', 'Fréquence dans cet interval');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(306, 'polymod', 'fr', 'Horaire');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(307, 'polymod', 'fr', 'Quotidienne');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(308, 'polymod', 'fr', 'Hebdomadaire');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(309, 'polymod', 'fr', 'Mensuelle');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(310, 'polymod', 'fr', 'Annuelle');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(311, 'polymod', 'fr', '<strong>Permet de faire un lien vers l''un des fil RSS de l''objet&nbsp; :<br /> </strong><br /> <span class="code">&lt;atm-function function=&quot;rss&quot; object=&quot;%s&quot; selected=&quot;<span class="keyword">rssId</span>&quot; attributeName=&quot;<span class="keyword">attributeValue</span>&quot;&gt;<br /> &nbsp;&nbsp;&nbsp; &lt;a href=&quot;<span class="vertclair">{url}</span>&quot; title=&quot;<span class="vertclair">{description}</span>&quot;&gt;<span class="vertclair">{label}</span>&lt;/a&gt;<br /> &lt;/atm-function&gt;</span><br /> Cette fonction permet d''obtenir les informations concernant l''un des fil RSS de l''objet. Elle est usuellement utilis&eacute;e pour r&eacute;aliser un lien d''abonnement vers ce fil RSS.<br /> <ul> <li><span class="keyword">rssId </span><strong>: </strong>Identifiant du fil RSS &agrave; selectionner parmi les suivants : %s</li> <li>L''attribut <span class="keyword">attributeName </span>et sa valeur <span class="keyword">attributeValue </span>sont facultatifs. Ils permettent d''ajouter un attribut et sa valeur &agrave; l''adresse du fil RSS g&eacute;n&eacute;r&eacute; par la fonction. Vous pouvez mettre autant d''attributs suppl&eacute;mentaires de cette fa&ccedil;on.</li> <li><span class="vertclair">{url}</span> sera remplac&eacute; par l''adresse du fil RSS.</li> <li><span class="vertclair">{label}</span> sera remplac&eacute; par le libell&eacute; du fil RSS.</li> <li><span class="vertclair">{description}</span> sera remplac&eacute; par la description du fil RSS.</li> </ul>');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(312, 'polymod', 'fr', '<strong>Permet de charger un objet par son identifiant&nbsp; :<br />\n<br />\n</strong><span class="code">&lt;atm-function function=&quot;loadObject&quot; object=&quot;%s&quot; value=&quot;<span class="keyword">objectId</span>&quot;&gt;&lt;/atm-function&gt;</span><br />\nCette fonction permet de charger depuis la base de donn&eacute;e l''objet correspondant &agrave; l''identifiant fourni en param&egrave;tre. L''objet ainsi charg&eacute; devient accessible m&ecirc;me en dehors d''une recherche.<br />\n<ul>\n	<li><span class="keyword">objectId </span><strong>: </strong>Identifiant unique de l''objet &agrave; charger.</li>\n</ul>');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(313, 'polymod', 'fr', '<div class="rowComment">\n<h1>Bloc de donn&eacute;es d''un fil RSS :</h1>\n<span class="code">&lt;atm-rss language=&quot;<span class="keyword">languageCode</span>&quot;&gt;<br />\n&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-title&gt;</span> ... <span class="keyword">&lt;/atm-rss-title&gt;</span><br />\n&nbsp;&nbsp;&nbsp; &lt;atm-search ...&gt;<br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; ...<br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &lt;atm-result ...&gt;<br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<span class="keyword"> &lt;atm-rss-item&gt;</span><br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-url&gt;</span>{page:id:url}?item={object:id}<span class="keyword">&lt;/atm-rss-item-url&gt; </span><br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-title&gt;</span> ... <span class="keyword">&lt;/atm-rss-item-title&gt;</span><br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-content&gt;</span> ... <span class="keyword">&lt;/atm-rss-item-content&gt;</span><br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-author&gt;</span> ... <span class="keyword">&lt;/atm-rss-item-author&gt;</span><br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-date&gt;</span> ... <span class="keyword">&lt;/atm-rss-item-date&gt;</span><br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-category&gt;</span> ... <span class="keyword">&lt;/atm-rss-item-category&gt;</span><br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;/atm-rss-item&gt;</span><br />\n&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &lt;/atm-result&gt;<br />\n&nbsp;&nbsp;&nbsp; &lt;/atm-search&gt;<br />\n&lt;/atm-rss&gt;</span><br />\n<br />\nCe tag permet de cr&eacute;er un fil RSS &agrave; partir d''objets r&eacute;pondant &agrave; une recherche.<br />\n<ul>\n	<li><strong><span class="keyword">languageCode </span></strong>: Code du langage relatif au contenu parmi les codes suivants : <strong><span class="vertclair">%s</span></strong>.</li>\n</ul>\nLe tag <span class="keyword">atm-rss</span> peut contenir un tag <span class="keyword">atm-rss-title</span> (facultatif) permettant de red&eacute;finir le titre du fil RSS. <br />\nLe tag <span class="keyword">atm-rss</span><strong> </strong>doit contenir un sous tag <span class="keyword">atm-rss-item</span> lui m&ecirc;me devant &ecirc;tre dans un r&eacute;sultat d''une recherche. Pour chaque &eacute;l&eacute;ment r&eacute;sultat de la recherche, ce tag permettra la cr&eacute;ation d''un &eacute;l&eacute;ment correspondant dans le fil RSS.<br />\n<br />\nLe tag <span class="keyword">atm-rss-item</span> doit<strong> </strong>contenir les sous tags suivants :<br />\n<ul>\n	<li><span class="keyword">atm-rss-item-url</span><strong> :</strong> Tag obligatoire, il permet de sp&eacute;cifier l''adresse internet source de l''&eacute;l&eacute;ment du fil RSS (Les aggr&eacute;gateurs RSS s''en servent pour cr&eacute;er un lien vers cet &eacute;l&eacute;ment sur votre site). Ce doit donc &ecirc;tre une adresse valide vers l''&eacute;l&eacute;ment source. Un seul tag de ce type est permit dans chaque tag atm-rss-item.</li>\n	<li><span class="keyword">atm-rss-item-title</span><strong> : </strong>Tag obligatoire, il permet de sp&eacute;cifier le nom de l''&eacute;l&eacute;ment du fil RSS. Le code HTML n''y est pas autoris&eacute;. Un seul tag de ce type est permit dans chaque tag atm-rss-item.</li>\n	<li><span class="keyword">atm-rss-item-content</span><strong> : </strong>Tag obligatoire, il permet de sp&eacute;cifier le contenu de l''&eacute;l&eacute;ment du fil RSS. Le code HTML y est autoris&eacute;. Un seul tag de ce type est permit dans chaque tag atm-rss-item.</li>\n</ul>\nLe tag <span class="keyword">atm-rss-item</span> peut<strong> </strong>contenir les sous tags suivants :<br />\n<ul>\n	<li><span class="keyword">atm-rss-item-author</span><strong> : </strong>Ce tag permet de sp&eacute;cifer l''auteur de l''&eacute;l&eacute;ment du fil RSS. Le code HTML n''y est pas autoris&eacute;. Un seul tag de ce type est permit dans chaque tag atm-rss-item.</li>\n	<li><span class="keyword">atm-rss-item-date</span><strong> :</strong> Ce tag permet de sp&eacute;cifer la date de cr&eacute;ation de l''&eacute;l&eacute;ment du fil RSS. Le code HTML n''y est pas autoris&eacute;. Un seul tag de ce type est permit dans chaque tag atm-rss-item. Pensez &agrave; employer le format <span class="vertclair">rss</span> si vous employez la valeur d''un champ de type Date.</li>\n	<li><span class="keyword">atm-rss-item-category</span><strong> :</strong> Ce tag permet de sp&eacute;cifer une le nom d''une cat&eacute;gorie pour l''&eacute;l&eacute;ment du fil RSS. Le code HTML n''y est pas autoris&eacute;. Vous pouvez mettre plusieurs tags de ce type dans chaque tag atm-rss-item.</li>\n</ul>\n</div>');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(314, 'polymod', 'fr', 'Utilisateurs');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(315, 'polymod', 'fr', 'Groupes');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(316, 'polymod', 'fr', 'Tous les utilisateurs');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(317, 'polymod', 'fr', 'Utilisateurs inclus/exclus');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(318, 'polymod', 'fr', 'Tous les groupes');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(319, 'polymod', 'fr', 'Groupes inclus/exclus');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(320, 'polymod', 'fr', 'Inclusion');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(321, 'polymod', 'fr', 'Si ce paramètre est à :<br/>"oui" : seuls les utilisateurs/groupes sélectionnés sont affichés dans la liste déroulante du champ.<br/>"non" : les utilisateurs sélectionnés sont exclus de la liste déroulante du champ.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(322, 'polymod', 'fr', 'Indexé dans le moteur de recherche');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(323, 'polymod', 'fr', 'Langue');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(324, 'polymod', 'fr', 'Langue de l''objet. Créé une relation avec les langues disponibles sur le système. Nécessaire à l''indexation correcte dans le moteur de recherche.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(325, 'polymod', 'fr', 'Indexé dans le moteur de recherche');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(326, 'polymod', 'fr', 'Indexation');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(327, 'polymod', 'fr', 'Si cet objet appartient en tant que champ à un objet indexé, inutile de l''indexer lui même');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(328, 'polymod', 'fr', 'Adresse du lien vers l''objet');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(329, 'polymod', 'fr', 'Cette adresse devra permettre d''aller vers l''objet à partir des résultats de recherche.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(330, 'polymod', 'fr', 'Indexer uniquement le dernier sous-objet');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(331, 'polymod', 'fr', 'Cette option est utile pour le versioning d''objets quand les versions antérieures ne doivent pas être indexées dans le moteur de recherche.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(332, 'polymod', 'fr', 'Désactiver l''association de sous-objets');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(333, 'polymod', 'fr', 'Cette option permet d''empêcher l''emploi de sous-objets créés en dehors de l''objet principal. Elle n''est utile que si l''option "Ces objets peuvent être édités" est active.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(334, 'polymod', 'fr', 'Contourner les droits');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(335, 'polymod', 'fr', 'Permet de ne pas tenir compte des droits de ces catégories pour les recherches');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(336, 'polymod', 'fr', 'Notification par email');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(337, 'polymod', 'fr', 'Ce champ permet d''envoyer une notification par email lors de la validation d''un objet');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(338, 'polymod', 'fr', 'Sujet de l''email');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(339, 'polymod', 'fr', 'Corps de l''email');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(340, 'polymod', 'fr', 'Emission au choix');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(341, 'polymod', 'fr', 'Hauteur de l''éditeur');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(342, 'polymod', 'fr', 'Largeur de l''éditeur');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(343, 'polymod', 'fr', 'Permet de choisir lors de l''édition de l''objet si l''email doit être envoyé');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(344, 'polymod', 'fr', 'Inclure des fichiers');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(345, 'polymod', 'fr', 'Permet d''inclure les fichiers de l''objet en pièce jointe dans l''email');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(346, 'polymod', 'fr', 'Emetteur de l''email');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(347, 'polymod', 'fr', 'Permet de spécifier une adresse d''emetteur pour l''email. Si aucun, l''adresse "postmaster" d''Automne sera employée.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(348, 'polymod', 'fr', 'A la validation');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(349, 'polymod', 'fr', 'Evénement système');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(350, 'polymod', 'fr', 'Emission');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(351, 'polymod', 'fr', 'L''email sera envoyé à la validation de l''objet ou déclenché par un événement système à spécifier (code PHP spécifique).');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(352, 'polymod', 'fr', 'Syntaxe de la définition du sujet et du corps de l''email');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(353, 'polymod', 'fr', 'Où choisir une page');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(354, 'polymod', 'fr', 'Code HTML');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(355, 'polymod', 'fr', 'Dernier envoi');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(356, 'polymod', 'fr', 'Jamais');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(357, 'polymod', 'fr', 'Actif');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(358, 'polymod', 'fr', 'Inactif');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(359, 'polymod', 'fr', 'Préparation des notifications par email');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(360, 'polymod', 'fr', 'Envoi d''une notification email');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(361, 'polymod', 'fr', 'Autoriser l''association des inutilisées');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(362, 'polymod', 'fr', 'Permet de sélectionner les catégories inutilisées dans les rangées');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(363, 'polymod', 'fr', 'Libellé des objets (séparés par des virgules, ou spécifiez un séparateur en paramètre)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(364, 'polymod', 'fr', 'Notification de validation en attente');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(365, 'polymod', 'fr', 'Notification de suppression en attente');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(366, 'polymod', 'fr', 'Champ requis (renvoie un booléen true ou false)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(367, 'polymod', 'fr', 'Catégorie par défaut');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(368, 'polymod', 'fr', 'Date de création de l''objet');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(369, 'polymod', 'fr', 'Décalage temporel');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(370, 'polymod', 'fr', 'Si "Date du jour", "Date de création" ou "Date de mise à jour" est sélectionné, décaler la valeur de cette durée (Voir le <a href="http://www.php.net/manual/fr/function.strtotime.php" target="_blank" class="admin">format de la fonction strtotime</a>)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(371, 'polymod', 'fr', 'Date de mise à jour de l''objet');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(372, 'polymod', 'fr', 'Format à respecter');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(373, 'polymod', 'fr', 'Ce champ vous permet de spécifier un format à respecter en utilisant une expression régulière PERL (<a href="http://www.php.net/manual/fr/reference.pcre.pattern.syntax.php" target="_blank" class="admin">voir l''aide du format</a>)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(374, 'polymod', 'fr', 'Extensions autorisées');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(375, 'polymod', 'fr', 'Séparées par une virgule');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(376, 'polymod', 'fr', 'Extensions interdites');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(377, 'polymod', 'fr', 'Utilisateur créant l''objet');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(378, 'polymod', 'fr', 'Opérateurs des filtres de recherche pour ce champ');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(379, 'polymod', 'fr', 'Un opérateur permet de modifier le fonctionnement d''un filtre (tag <span class="keyword">atm-search-param</span>) dans une recherche. Il s''ajoute au filtre en ajoutant le paramètre <span class="keyword">operator</span> suivit de la valeur souhaitée au tag <span class="keyword">atm-search-param</span> proposant un filtre sur ce champ. Les valeurs suivantes sont possibles :');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(380, 'polymod', 'fr', '<br/><span class="keyword">&gt;=</span> : supérieur ou égal<br/><span class="keyword">&lt;=</span> : inférieur ou égal<br/><span class="keyword">&lt;</span> : inférieur<br/><span class="keyword">&gt;</span> : supérieur<br/><span class="keyword">&gt;= or null</span> : supérieur ou égal ou nul<br/><span class="keyword">&lt;= or null</span> : inférieur ou égal ou nul<br/><span class="keyword">&lt; or null</span> : inférieur ou nul<br/><span class="keyword">&gt; or null</span> : supérieur ou nul<br/><span class="keyword">&gt;= and not null</span> : (supérieur ou égal) et non nul<br/><span class="keyword">&lt;= and not null</span> : (inférieur ou égal) et non nul<br/><span class="keyword">&lt; and not null</span> : inférieur et non nul<br/><span class="keyword">&gt; and not null</span> : supérieur et non nul');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(381, 'polymod', 'fr', 'Ne recherche que les objets associés à la catégorie en paramètre (les sous-catégories ne sont plus prises en compte)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(382, 'polymod', 'fr', 'Tags de formulaires (création - modification)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(383, 'polymod', 'fr', '
<div class="rowComment">
	<h1>Cr&eacute;ation modification d''objets cot&eacute; client :</h1>
	<p><span class="code">&lt;atm-form what=&quot;<span class="keyword">objet</span>&quot; name=&quot;<span class="keyword">formName</span>&quot;&gt; ... &lt;/atm-form&gt;</span><br />
	Ce tag permet de cr&eacute;er un formulaire de saisie pour un nouvel objet (si ce tag n''est pas dans un r&eacute;sultat de recherche)
	ou de modification pour un objet existsnat (si ce tag se trouve dans un r&eacute;sultat de recherche.</p>
	<ul>
		<li><span class="keyword">objet</span> : Type d''objet &agrave; saisir (de la forme <span class="vertclair">{<span class="keyword">objet</span>}</span>)</li>
		<li><span class="keyword">formName</span> : Nom du formulaire : identifiant unique pour le formulaire dans la rang&eacute;e.</li>
	</ul>
	Les valeurs suivantes seront remplac&eacute;es dans le tag :
	<ul>	
		<li><span class="vertclair">{filled}</span> : Vrai si le formulaire a &eacute;t&eacute; correctement rempli et que sa validation n''a provoqu&eacute; aucune erreur.</li>	
		<li><span class="vertclair">{required}</span> : Vrai si le formulaire n''a pas &eacute;t&eacute; correctement rempli et que des champs requis ont &eacute;t&eacute; laiss&eacute;s vides.</li>	
		<li><span class="vertclair">{malformed}</span> : Vrai si le formulaire n''a pas &eacute;t&eacute; correctement rempli et que les values de certains champs sont incorrectes.</li>
		<li><span class="vertclair">{error}</span> : Vrai si le formulaire a g&eacute;n&eacute;r&eacute; une erreur.</li>
	</ul>
	<h2>Ce tag peut contenir les sous-tags suivants :</h2>
	<div class="retrait">
		<h3>Affichage des champs requis :</h3>
			<div class="retrait">
				<span class="code">&lt;atm-form-required form=&quot;<span class="keyword">formName</span>&quot;&gt;<br />&nbsp;&nbsp;&nbsp; ... <span class="vertclair">{requiredname}</span> ...<br />&lt;/atm-form-required&gt;</span><br />
				Le contenu du tag sera lu pour chaque champ requis lors de la saisie du formulaire.<br />
				<ul>
					<li><span class="keyword">formName</span> : Nom du formulaire sur lequel appliquer le tag.</li>
				</ul>
				<p>Les valeurs suivantes seront remplac&eacute;es dans le tag :</p>
				<ul>
					<li><span class="vertclair">{firstrequired}</span> : Vrai si le champ requis en cours est le premier du formulaire en cours.</li>
					<li><span class="vertclair">{last</span><span class="vertclair">required</span><span class="vertclair">}</span> : Vrai si le champ requis en cours est le dernier du formulaire en cours.</li>
					<li><span class="vertclair">{</span><span class="vertclair">required</span><span class="vertclair">count}</span> : Num&eacute;ro du champ requis dans le formulaire en cours.</li>
					<li><span class="vertclair">{max</span><span class="vertclair">required</span><span class="vertclair">}</span> : Nombre de champs requis dans le formulaire en cours.</li>
					<li><span class="vertclair">{</span><span class="vertclair">required</span><span class="vertclair">name}</span> : Nom du champ requis dans le formulaire en cours.</li>
					<li><span class="vertclair">{</span><span class="vertclair">required</span><span class="vertclair">field}</span> : Objet champ requis dans le formulaire en cours.</li>
				</ul>
			</div>
		<h3>Affichage des champs malform&eacute;s :</h3>
		<div class="retrait">
			<span class="code">&lt;atm-form-malformed form=&quot;<span class="keyword">formName</span>&quot;&gt;<br />&nbsp;&nbsp;&nbsp; ... <span class="vertclair">{malformedname}</span> ...<br />&lt;/atm-form-malformed&gt;</span><br />
			Le contenu du tag sera lu pour chaque champ malform&eacute; lors de la saisie du formulaire.<br />
			<ul>
				<li><span class="keyword">formName</span> : Nom du formulaire sur lequel appliquer le tag.</li>
			</ul>
			<p>Les valeurs suivantes seront remplac&eacute;es dans le tag :</p>
			<ul>
				<li><span class="vertclair">{firstmalformed}</span> : Vrai si le champ malform&eacute; en cours est le premier du formulaire en cours.</li>
				<li><span class="vertclair">{lastmalformed}</span> : Vrai si le champ malform&eacute; en cours est le dernier du formulaire en cours.</li>
				<li><span class="vertclair">{malformedcount}</span> : Num&eacute;ro du champ malform&eacute; dans le formulaire en cours.</li>
				<li><span class="vertclair">{maxmalformed}</span> : Nombre de champs malform&eacute;s dans le formulaire en cours.</li>
				<li><span class="vertclair">{malformedname}</span> : Nom du champ malform&eacute; dans le formulaire en cours.</li>
				<li><span class="vertclair">{malformedfield}</span> : Objet champ malform&eacute; dans le formulaire en cours.</li>
			</ul>
		</div>
		<h3>Affichage d''un champ de saisie :</h3>
		<div class="retrait">
			<span class="code">&lt;atm-input field=&quot;<span class="keyword">{objet:champ}</span>&quot; form=&quot;<span class="keyword">formName</span>&quot; /&gt;</span><br />
			Ce tag sera remplac&eacute; par la zone de saisie (champ de formulaire) n&eacute;cessaire &agrave; la saisie correcte des informations relatives au type du champ sp&eacute;cifi&eacute;.<br />
			<ul>
				<li><span class="keyword">formName</span> : Nom du formulaire sur lequel appliquer le tag.</li>
				<li><span class="keyword">{objet:champ}</span> : Champ de l''objet g&eacute;r&eacute; par le formulaire sur lequel la saisie doit &ecirc;tre effectu&eacute;e.</li>
			</ul>
			<p>Ce tag peut ensuite avoir tout une suite d''attributs html qui seront repost&eacute;s sur le code HTML du champ g&eacute;n&eacute;r&eacute; (<span class="vertclair">width, height, id, class, etc.</span>).</p>
		</div>
		<h3>Affichage d''un champ de saisie avec v&eacute;rification complexe :</h3>
		<div class="retrait">
			<span class="code">&lt;atm-input field=&quot;<span class="keyword">{objet:champ}</span>&quot; form=&quot;<span class="keyword">formName</span>&quot;&gt;<br />&nbsp;&nbsp;&nbsp; ... &lt;atm-input-callback return=&quot;<span class="keyword">returnValue</span>&quot; /&gt; ...<br /> &lt;/atm-input&gt;</span><br />
			Cette balise permet d''effectuer des validations de champs dans un atm-form 
			<ul>
				<li><span class="keyword">returnValue</span> : La pr&eacute;sence du tag atm-input-callback avec pour attribut return=&quot;<span class="vertclair">valid</span>&quot; validera le contenu du champ, en cas d''abscence du tag ou de valeur diff&eacute;rente de <span class="vertclair">valid</span> le champ retournera une erreur de type <span class="vertclair">malformed</span> </li>
			</ul>
			<br />
			<p>Cet exemple permet de rechercher si un utilisateur existe d&eacute;jà pour un email donn&eacute; et auquel cas, d''emp&ecirc;cher sa r&eacute;inscription : </p><br />
			<span class="code">
				&lt;atm-input id=&quot;participant-email&quot; field=&quot;<span class="keyword">{Participant:Email}</span>&quot; form=&quot;<span class="keyword">quizInscription</span>&quot;&gt;<br />
				&nbsp;&nbsp;&nbsp;&lt;atm-search what=&quot;<span class="keyword">{Participant}</span>&quot; name=&quot;<span class="keyword">emailCheck</span>&quot;&gt;<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;atm-search-param search=&quot;<span class="keyword">emailCheck</span>&quot; type=&quot;<span class="keyword">{Participant:Email:fieldID}</span>&quot; value=&quot;<span class="keyword">{request:string:participantEmail}</span>&quot; mandatory=&quot;<span class="keyword">true</span>&quot; /&gt;<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;atm-result search=&quot;<span class="keyword">emailCheck</span>&quot;&gt;<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;atm-input-callback return=&quot;<span class="vertclair">invalid</span>&quot; /&gt;<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;/atm-result&gt;<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;atm-noresult search=&quot;<span class="keyword">emailCheck</span>&quot;&gt;<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;atm-input-callback return=&quot;<span class="vertclair">valid</span>&quot; /&gt;<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;/atm-noresult&gt;<br />
				&nbsp;&nbsp;&nbsp;&lt;/atm-search&gt;<br />
				&lt;/atm-input&gt;
			</span><br />
		</div>
	</div>
</div>
');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(384, 'polymod', 'fr', 'Booléen');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(385, 'polymod', 'fr', 'Permet de spécifier un état (oui - non)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(386, 'polymod', 'fr', 'Libellé de la catégorie');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(387, 'polymod', 'fr', 'Identifiant des utilisateur/groupe du champ');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(388, 'polymod', 'fr', 'Si ce paramètre est à :<br/>"oui" : seuls les utilisateurs/groupes sélectionnés ci-dessous recevront les notifications.<br/>"non" : les utilisateurs/groupes sélectionnés ci-dessous sont exclus de la réception des notifications.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(389, 'polymod', 'fr', 'Permet de faire une recherche sur une valeur incomplète. Utilisez le caractère % pour spécifier la partie inconnue. Par exemple, "cha%" retournera "chat", "chameau", etc.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(390, 'polymod', 'fr', 'Les valeurs suivantes sont possibles');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(391, 'polymod', 'fr', 'Opérateurs des champs de saisie pour ce champ');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(392, 'polymod', 'fr', 'Un opérateur permet de modifier l''affichage d''un champ (<span class="keyword">atm-input</span>) dans un formulaire (<span class="keyword">atm-form</span>). Il s''ajoute au tag <span class="keyword">atm-input</span> en ajoutant le paramètre <span class="keyword">operator</span> suivi de la valeur souhaitée. Les valeurs suivantes sont possibles :');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(393, 'polymod', 'fr', 'Affiche uniquement les sous catégories de la racine spécifiée');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(394, 'polymod', 'fr', 'Comparaison numérique de deux champs numériques flottants.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(395, 'polymod', 'fr', 'La valeur du champ peut être un nombre négatif');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(396, 'polymod', 'fr', 'Nombre flottant (à virgule)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(397, 'polymod', 'fr', 'Chaîne contenant un nombre à virgule (255 caractères maximum).');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(398, 'polymod', 'fr', 'Ensemble des IDs des objets de type ''%s'' associé à ce champ.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(399, 'polymod', 'fr', 'Largeur des boîtes de sélection (pixels)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(400, 'polymod', 'fr', 'Hauteur des boîtes de sélection (pixels)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(401, 'polymod', 'fr', 'Uniquement dans le cas de catégories multiples. 300x200 par défaut.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(402, 'polymod', 'fr', 'Description du champ : ''%s''');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(403, 'polymod', 'fr', 'Ordre de création');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(404, 'polymod', 'fr', 'Début de publication');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(405, 'polymod', 'fr', 'Trier par');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(406, 'polymod', 'fr', 'Page');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(407, 'polymod', 'fr', 'Permet de choisir une page Automne');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(409, 'polymod', 'fr', 'Largeur de la vignette dans les résultats de la recherche');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(410, 'polymod', 'fr', '(largeur de l''image dans la liste des résultats, si elle est visible dans les résultats de la recherche) ');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(411, 'polymod', 'fr', 'Retourne vrai (true) si ce champ possède une valeur');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(412, 'polymod', 'fr', '(Si la vignette dépasse cette hauteur elle sera redimensionnée)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(413, 'polymod', 'fr', 'Hauteur maximum de l''image en pixels');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(414, 'polymod', 'fr', 'Hauteur maximum de la vignette en pixels');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(415, 'polymod', 'fr', '(La vignettte sera redimensionnée à %s pixels de hauteur)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(416, 'polymod', 'fr', '(La vignettte sera redimensionnée à %s pixels de largeur et %s  pixels de hauteur)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(417, 'polymod', 'fr', 'Unité');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(418, 'polymod', 'fr', '(Sera affichée à côté de la valeur)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(419, 'polymod', 'fr', 'Unité : "%s"');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(420, 'polymod', 'fr', 'Affichage des résultats côté admin');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(421, 'polymod', 'fr', 'Syntaxe pour l''objet "%s"');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(422, 'polymod', 'fr', 'Recherchable');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(423, 'polymod', 'fr', 'Hauteur maximum de la vignette en pixels');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(424, 'polymod', 'fr', 'Indexé');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(425, 'polymod', 'fr', 'Largeur de la fenêtre popup');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(426, 'polymod', 'fr', 'Hauteur de la fenêtre popup');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(427, 'polymod', 'fr', 'message(s) envoyé(s)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(428, 'polymod', 'fr', 'Ne recherche que les objets associés à la(aux) catégorie(s) éditable(s) fournie(s) en paramètre');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(429, 'polymod', 'fr', 'Ne recherche que les objets qui ne sont pas associés à la catégorie en paramètre');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(430, 'polymod', 'fr', 'Ne recherche que les objets qui ne sont pas associés à la catégorie en paramètre, de façon stricte (les sous-catégories ne sont plus prises en compte)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(500, 'polymod', 'fr', 'Les catégories sont employées pour le(s) champ(s) : ');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(501, 'polymod', 'fr', 'Résultats : {0} %s sur {1}');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(502, 'polymod', 'fr', 'Résultats : Aucun résultat pour votre recherche ...');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(503, 'polymod', 'fr', 'Résultats');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(504, 'polymod', 'fr', '{0} %s sur {1}');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(505, 'polymod', 'fr', 'Supprime le ou les éléments %s sélectionnés. ');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(506, 'polymod', 'fr', 'Cette action est soumise à une validation ultérieure.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(507, 'polymod', 'fr', 'Cette action n''est pas soumise à une validation et est effective directement.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(508, 'polymod', 'fr', 'Annule la demande de suppression du ou des éléments %s sélectionnés.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(509, 'polymod', 'fr', 'Dévérouille le ou les éléments %s sélectionnés. Attention, si une personne est actuellement en train de modifier cet élément, elle pourrait perdre ses modifications.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(510, 'polymod', 'fr', 'Aperçu avant validation du ou des éléments %s sélectionnés.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(511, 'polymod', 'fr', 'Modification du ou des éléments %s sélectionnés.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(512, 'polymod', 'fr', 'Création d''un nouvel élément %s.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(513, 'polymod', 'fr', 'Recevez un email pour toute validation en attente dans ce module.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(514, 'polymod', 'fr', 'Validations');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(515, 'polymod', 'fr', 'Heures');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(516, 'polymod', 'fr', 'Modifier l''élément associé sélectionné');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(517, 'polymod', 'fr', 'Enlever l''élément associé sélectionné');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(518, 'polymod', 'fr', 'Choisissez les éléments ''%s'' à associer');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(519, 'polymod', 'fr', 'Choisissez l''aide à afficher : ');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(520, 'polymod', 'fr', 'Ordre aléatoire');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(521, 'polymod', 'fr', 'Sur cette page, vous pouvez spécifier des paramètres pour l''affichage de la rangée de contenu en cours d''édition.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(522, 'polymod', 'fr', 'Le formulaire est incomplet ou possède des valeurs incorrectes ...');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(523, 'polymod', 'fr', 'Cet onglet est désactivé car vous devez avoir sélectionné du texte pour l''utiliser.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(524, 'polymod', 'fr', 'Cet onglet est désactivé car vous ne devez pas avoir de texte sélectionné pour l''utiliser.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(525, 'polymod', 'fr', 'L''élément ''%s'' que vous cherchez à éditer est vérouillé par %s le %s.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(526, 'polymod', 'fr', 'Vous n''avez pas le droit d''éditer l''élément ''%s''.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(527, 'polymod', 'fr', 'Sur cette page, vous pouvez créer ou modifier les données de l''élément %s');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(528, 'polymod', 'fr', 'Erreur durant l''enregistrement de l''élément ...');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(529, 'polymod', 'fr', 'Aucune catégorie disponible ...');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(530, 'polymod', 'fr', 'Aucun élément disponible ...');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(531, 'polymod', 'fr', 'Elément inexistant ...');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(532, 'polymod', 'fr', 'Titre de la page');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(533, 'polymod', 'fr', 'Adresse (url) de la page');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(534, 'polymod', 'fr', 'Identifiant de la page');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(535, 'polymod', 'fr', 'Les champs suivants sont obligatoire :');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(536, 'polymod', 'fr', 'Taille max : %s car.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(537, 'polymod', 'fr', 'Le contenu du champ ''%s'' est mal formatté et il ne peut être enregistré.<br />Evitez tout copier-coller de texte depuis un éditeur de texte externe. Employez les outils ''Coller comme texte'' ou ''Coller de Word'' de la barre d''outils dans ce cas.<br /><br />Vérifiez le code source de votre contenu : il doit être composé de XHTML valide.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(538, 'polymod', 'fr', '<strong>Liste de toutes les valeurs du champ :</strong><br />\n<br />\n<span class="code">&lt;select ...&gt;&lt;atm-function function=&quot;selectOptions&quot; object=&quot;%s&quot; selected=&quot;<span class="keyword">selectedValue</span>&quot;&gt;&lt;/atm-function&gt;&lt;/select&gt;</span><br />\nCette fonction permet d''afficher une liste class&eacute;e par ordre alphab&eacute;tique de tags &lt;option&gt; contenant toutes les valeurs du champ. Elle est usuellement employ&eacute;e &agrave; l''int&eacute;rieur d''un tag &lt;select&gt;.\n<ul>\n   <li><span class="keyword">selectedValue </span><strong>: </strong>Valeur &agrave; s&eacute;lectionner dans la liste (facultatif)</li>\n</ul>');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(539, 'polymod', 'fr', 'Comparaison numérique de deux champs.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(540, 'polymod', 'fr', 'Description de la catégorie');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(541, 'polymod', 'fr', 'Enregistrer et Valider');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(542, 'polymod', 'fr', 'Enregistre vos modifications et les valide automatiquement. Vos modifications seront directement publiées sur le site sans étape intermédiaire de validation.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(543, 'polymod', 'fr', 'Enregistre vos modifications sans les valider. Vos modifications devront être validées avant d''être visibles sur le site.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(544, 'polymod', 'fr', 'Enregistre vos modifications. Vos modifications seront directement visibles sur le site.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(545, 'polymod', 'fr', 'Chemin vers la vignette si elle existe.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(546, 'polymod', 'fr', 'Chemin vers la vignette si elle existe (utilisable dans un tag atm-loop).');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(547, 'polymod', 'fr', 'Code HTML complet de la vignette si elle existe.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(548, 'polymod', 'fr', 'Code HTML complet de la vignette si elle existe (utilisable dans un tag atm-loop).');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(549, 'polymod', 'fr', 'Largeur maximum de l''image zoom en pixels');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(550, 'polymod', 'fr', '(Si l''image zoom dépasse cette largeur elle sera redimensionnée)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(551, 'polymod', 'fr', 'Hauteur maximum de l''image zoom en pixels');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(552, 'polymod', 'fr', '(Si l''image zoom dépasse cette hauteur elle sera redimensionnée)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(553, 'polymod', 'fr', 'Publiés (En ligne)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(554, 'polymod', 'fr', 'Non publiés (Hors ligne)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(555, 'polymod', 'fr', 'Validés (Statut vert)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(556, 'polymod', 'fr', 'En attente de validation (Statut orange)');