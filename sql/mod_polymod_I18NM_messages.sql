##
## Contains declarations for module installation : 
## All messages (mandatory) : inject 2/2
##
## @version $Id: mod_polymod_I18NM_messages.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $

DELETE FROM I18NM_messages WHERE module='polymod';

INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (2, 'polymod', NOW(), 'Création / modification d\'un objet \'%s\'', 'Object \'%s\' creation / modification');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (3, 'polymod', NOW(), 'Création / modification de l\'objet \'%s\' :', 'Creation / modification of \'%s\' object:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (4, 'polymod', NOW(), 'Suppression d\'un objet \'%s\'', '\'%s\' object deletion');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (5, 'polymod', NOW(), 'Suppression de l\'objet \'%s\' :', 'Deletion of \'%s\' object:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (6, 'polymod', NOW(), 'Lien existant', 'Current link');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (7, 'polymod', NOW(), 'Accueil', 'Entry');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (18, 'polymod', NOW(), 'Mots-clés', 'Kewyords');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (19, 'polymod', NOW(), 'Publié entre le', 'Published between');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (20, 'polymod', NOW(), 'et le', 'and');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (21, 'polymod', NOW(), '%s objet(s) \'%s\' correspondant à votre recherche', '%s \'%s\' object(s) relative to your search');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (30, 'polymod', NOW(), 'Objet', 'Object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (31, 'polymod', NOW(), 'Changement du contenu d\'un objet \'%s\'', 'Object \'%s\' content change');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (32, 'polymod', NOW(), 'Changement apporté sur l\'objet \'%s\' : %s', 'Content change for object \'%s\' : \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (37, 'polymod', NOW(), 'Libellé', 'Label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (39, 'polymod', NOW(), 'Description', 'Description');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (52, 'polymod', NOW(), 'Confirmez-vous la suppression de l\'objet \'%s\' : %s', 'Do you confirm deletion of object \'%s\' : %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (53, 'polymod', NOW(), 'Proposition de suppression d\'un objet %s', '%s object deletion proposal');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (55, 'polymod', NOW(), 'Suppression de l\'objet \'%s\' : %s', 'Deletion of \'%s\' object : %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (57, 'polymod', NOW(), 'Publication sur le site', 'Publication on website');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (66, 'polymod', NOW(), 'Trouver un objet \'%s\'', 'Find a \'%s\' object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (77, 'polymod', NOW(), 'Lister', 'List');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (82, 'polymod', NOW(), 'Gestion des objets \'%s\'', '\'%s\' objects management');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (108, 'polymod', NOW(), 'Gérer les objets \'%s\'', 'Manage objects \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (109, 'polymod', NOW(), 'Effectuer une recherche', 'Research');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (110, 'polymod', NOW(), '<div class="rowComment">
<h1>Lance une recherche sur un type d\'objet donn&eacute; :</h1>
<div class="retrait"><span class="code"> 	&lt;atm-search what=&quot;<span class="keyword">objet</span>&quot; name=&quot;<span class="keyword">searchName</span>&quot;&gt;...&lt;/atm-search&gt; 	</span><br />
<br />
<ul>
	<li><span class="keyword">objet</span> : Type d\'objet &agrave; rechercher (de la forme <span class="vertclair">{<span class="keyword">objet</span>}</span>)</li>
	<li><span class="keyword">searchName</span> : Nom de la recherche : identifiant unique pour la recherche dans la rang&eacute;e.</li>
	<li>Un attribut <span class="keyword">public</span> (facultatif) peut-&ecirc;tre ajout&eacute; pour sp&eacute;cifier une recherche sur la zone publique ou &eacute;dit&eacute;e. Il prend pour valeur <span class="vertclair">true</span> pour une recherche publique (d&eacute;faut) ou <span class="vertclair">false</span> pour une recherche dans la zone &eacute;dit&eacute;e.</li>
</ul>
</div>
<h2>Ce tag peut contenir les sous-tags suivants :</h2>
<div class="retrait">
<h3>Affichage des r&eacute;sultats :</h3>
<div class="retrait"><span class="code"> 	&lt;atm-result&nbsp; search=&quot;<span class="keyword">searchName</span>&quot;&gt; ... &lt;/atm-result&gt; 	</span><br />
<br />
Le contenu de ce tag sera lu pour chaque r&eacute;sultat trouv&eacute; pour la recherche en cours.
<ul>
	<li><span class="keyword">searchName</span> : Nom de la recherche sur lequel appliquer le param&egrave;tre.</li>
	<li>Un attribut <span class="keyword">return </span>(facultatif) peut-&ecirc;tre ajout&eacute; pour sp&eacute;cifier le type de r&eacute;sultat retourn&eacute;. Par d&eacute;faut une recherche revoie des objets, mais dans l\'optique d\'am&eacute;liorer les performances, il est possible de sp&eacute;cifier les deux valeurs suivantes de retour :
	<ul>
		<li><span class="vertclair">POLYMOD_SEARCH_RETURN_IDS</span> : retournera uniquement l\'identifiant du r&eacute;sultat.</li>
		<li><span class="vertclair">POLYMOD_SEARCH_RETURN_OBJECTSLIGHT</span> : retournera le r&eacute;sultat mais sans charger les sous-objets qu\'il peut contenir dans ses diff&eacute;rents champs. Attention, ce param&egrave;tre n\'est possible que sur une recherche publique.</li>
	</ul>
	</li>
</ul>
<br />
Les valeurs suivantes seront remplac&eacute;es dans le tag :
<ul>
	<li><span class="vertclair">{firstresult}</span> : Vrai si le r&eacute;sultat en cours est le premier de la page en cours.</li>
	<li><span class="vertclair">{lastresult}</span> : Vrai si le r&eacute;sultat en cours est le dernier de la page en cours.</li>
	<li><span class="vertclair">{resultcount}</span> : Num&eacute;ro du r&eacute;sultat dans la page.</li>
	<li><span class="vertclair">{maxresults}</span> : Nombre de r&eacute;sultats pour la recherche.</li>
	<li><span class="vertclair">{maxpages}</span> : Nombre de pages maximum pour la recherche en cours.</li>
	<li><span class="vertclair">{currentpage}</span> : Num&eacute;ro de la page actuelle pour la recherche en cours.</li>
	<li><span class="vertclair">{resultid}</span> : Identifiant du r&eacute;sultat. Utile dans le cas du\'une recherche retournant uniquement les identifiants des r&eacute;sultats (param&egrave;tre return avec la valeur POLYMOD_SEARCH_RETURN_IDS).</li>
</ul>
</div>
<h3>Aucun r&eacute;sultats :</h3>
<div class="retrait"><span class="code"> 	&lt;atm-noresult&nbsp; search=&quot;<span class="keyword">searchName</span>&quot;&gt; ... &lt;/atm-noresult&gt; 	</span><br />
<br />
Le contenu de ce tag sera affich&eacute; si aucun r&eacute;sultat n\'est trouv&eacute; pour la recherche en cours.
<ul>
	<li><span class="keyword">searchName</span> : Nom de la recherche sur lequel appliquer le param&egrave;tre.</li>
</ul>
</div>
<h3>Param&egrave;tre de recherche :</h3>
<div class="retrait"><span class="code"> 	&lt;atm-search-param search=&quot;<span class="keyword">searchName</span>&quot; type=&quot;<span class="keyword">paramType</span>&quot; value=&quot;<span class="keyword">paramValue</span>&quot; mandatory=&quot;<span class="keyword">mandatoryValue</span>&quot; /&gt; 	</span><br />
<br />
Permet de limiter les r&eacute;sultats de la recherche &agrave; des param&egrave;tres donn&eacute;s.
<ul>
	<li><span class="keyword">searchName</span> : Nom de la recherche sur lequel appliquer le param&egrave;tre.</li>
	<li><span class="keyword">paramType</span> : Type de param&egrave;tre, peut-&ecirc;tre de la forme <span class="vertclair">{<span class="keyword">objet:champ</span>:fieldID}</span> pour filtrer la recherche sur la valeur d\'un champs donn&eacute; ou bien un nom de type fixe parmi : <span class="vertclair">%s</span> pour utiliser un filtrage pr&eacute;d&eacute;finis.</li>
	<li><span class="keyword">paramValue</span> : Valeur du param&egrave;tre de la recherche. Si la valeur est \'<span class="vertclair">block</span>\' vous pourrez sp&eacute;cifier cette valeur lors de la cr&eacute;ation de la rang&eacute;e dans la page.</li>
	<li><span class="keyword">mandatoryValue</span> : Bool&eacute;en (<span class="vertclair">true</span> ou <span class="vertclair">false</span>), permet de sp&eacute;cifier si ce param&egrave;tre de recherche est optionnel ou obligatoire.</li>
</ul>
<br />
Un param&egrave;tre suppl&eacute;mentaire <span class="keyword">operator</span> permet d\'ajouter un comportement sp&eacute;cifique au type de champs sur le filtre. La valeur accept&eacute;e par ce param&egrave;tre est expliqu&eacute;e dans l\'aide du champ concern&eacute; si il accepte un tel param&egrave;tre.</div>
<h3>Afficher une page donn&eacute;e de r&eacute;sultats (le nombre de r&eacute;sultats d\'une page est sp&eacute;cifi&eacute; par le tag atm-search-limit) :</h3>
<div class="retrait"><span class="code"> 	&lt;atm-search-page search=&quot;<span class="keyword">searchName</span>&quot;  value=&quot;<span class="keyword">pageValue</span>&quot; /&gt; 	</span><br />
<br />
<ul>
	<li><span class="keyword">searchName</span> : Nom de la recherche sur lequel appliquer le param&egrave;tre.</li>
	<li><span class="keyword">pageValue</span> : Valeur num&eacute;rique de la page &agrave; afficher.</li>
</ul>
</div>
<h3>Limiter le nombre de r&eacute;sultats d\'une page :</h3>
<div class="retrait"><span class="code"> 	&lt;atm-search-limit search=&quot;<span class="keyword">searchName</span>&quot; value=&quot;<span class="keyword">limitValue</span>&quot; /&gt; 	</span><br />
<br />
<ul>
	<li><span class="keyword">searchName</span> : Nom de la recherche sur lequel appliquer la limite.</li>
	<li><span class="keyword">limitValue</span> : Valeur num&eacute;rique de la limite &agrave; appliquer. Si la valeur est \'<span class="vertclair">block</span>\' vous pourrez sp&eacute;cifier cette valeur lors de la cr&eacute;ation de la rang&eacute;e dans la page.</li>
</ul>
</div>
<h3>Ordonner les r&eacute;sultats :</h3>
<div class="retrait"><span class="code">&lt;atm-search-order search=&quot;<span class="keyword">searchName</span>&quot; type=&quot;<span class="keyword">orderType</span>&quot; direction=&quot;<span class="keyword">directionValue</span>&quot; /&gt;</span><br />
<br />
<ul>
	<li><span class="keyword">searchName</span> : Nom de la recherche sur lequel appliquer la limite.</li>
	<li><span class="keyword">orderType</span> : Type de valeur sur lequel appliquer l\'ordre, peut-&ecirc;tre de la forme <span class="vertclair">{<span class="keyword">objet:champ</span>:fieldID}</span> ou un nom de type fixe parmi : <span class="vertclair">%s</span>.</li>
	<li><span class="keyword">directionValue</span> : Sens &agrave; appliquer : <span class="vertclair">asc</span> pour croissant, <span class="vertclair">desc</span> pour d&eacute;croissant. Si la valeur est \'<span class="vertclair">block</span>\' vous pourrez sp&eacute;cifier cette valeur lors de la cr&eacute;ation de la rang&eacute;e dans la page.</li>
</ul>
</div>
</div>
<h2>Fonctions :</h2>
<div class="retrait">
<h3>Afficher la liste des pages de la recherche en cours :</h3>
<div class="retrait">
<div class="code">&lt;atm-function function=&quot;pages&quot; maxpages=&quot;<span class="keyword">maxpagesValues</span>&quot; currentpage=&quot;<span class="keyword">currentpageValue</span>&quot; displayedpage=&quot;<span class="keyword">displayedpagesValue</span>&quot;&gt;<br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;pages&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/pages&gt;</span><br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;currentpage&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/currentpage&gt;</span><br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;start&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/start&gt;</span><br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;previous&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/previous&gt;</span><br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;next&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/next&gt;</span><br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;end&gt;</span> ... <span class="vertclair">{n}</span> ... <span class="keyword">&lt;/end&gt;</span><br />
&lt;/atm-function&gt;</div>
<br />
<br />
Cette fonction permet d\'afficher la liste de toutes les pages possibles pour la recherche.<br />
<ul>
	<li><span class="keyword">maxpagesValue</span> : Nombre de page maximum sur lesquelles boucler (habituellement : <span class="vertclair">{maxpages}</span> ).</li>
	<li><span class="keyword">currentpageValue</span> : Num&eacute;ro de la page courante de la recherche (habituellement : <span class="vertclair">{currentpage}</span> ).</li>
	<li><span class="keyword">displayedpagesValue</span> : Nombre de pages &agrave; afficher.</li>
	<li>Le tag &lt;<span class="keyword">pages</span>&gt; sera lu pour chaque pages &agrave; lister except&eacute; la page courante et la valeur <span class="vertclair">{n}</span> sera remplac&eacute;e par le num&eacute;ro de la page.</li>
	<li>Le tag optionnel &lt;<span class="keyword">currentpage</span>&gt; sera lu pour la page en cours. Si il n\'existe pas, le tag &lt;<span class="keyword">pages</span>&gt; sera utilis&eacute; &agrave; la place.</li>
	<li>Le tag optionnel &lt;<span class="keyword">start</span>&gt; sera lu pour la premi&egrave;re page.</li>
	<li>Le tag optionnel &lt;<span class="keyword">previous</span>&gt; sera lu pour la page pr&eacute;c&eacute;dente.</li>
	<li>Le tag optionnel &lt;<span class="keyword">next</span>&gt; sera lu pour la page suivante.</li>
	<li>Le tag optionnel &lt;<span class="keyword">end</span>&gt; sera lu pour la derni&egrave;re page.</li>
</ul>
</div>
</div>
</div>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (111, 'polymod', NOW(), 'Syntaxe des tags', 'Tags syntax');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (112, 'polymod', NOW(), 'Variables et fonctions des objets', 'Objects variables and functions');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (113, 'polymod', NOW(), 'Tags de travail', 'Working tags');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (114, 'polymod', NOW(), '<div class="rowComment">
	<h1>Tags de travail :</h1>
	<div class="retrait">
		<h3>Afficher le contenu du tag si la condition est remplie :</h3>
			<div class="retrait">
			<span class="code">
				&lt;atm-if what=&quot;<span class="keyword">condition</span>&quot;&gt; ... &lt;/atm-if&gt;
			</span>
			<ul>
				<li><span class="keyword">condition</span> : Condition &agrave; remplir pour afficher le contenu du tag. L\'usage courant est de valider la pr&eacute;sence d\'une valeur non nulle. Cette condition peut aussi prendre toutes les formes valides d\'une condition PHP (voir : <a target="_blank" href="http://www.php.net/if" class="admin">Les structures de contr&ocirc;le en PHP</a>). La condition sera remplie si la valeur existe ou bien n\'est pas nulle ou bien n\'est pas &eacute;gale &agrave; faux (false).</li>
			</ul>
			</div>
		<h3>Boucler sur un ensemble d\'objets :</h3>
			<div class="retrait">
			<span class="code">&lt;atm-loop on=&quot;<span class="keyword">objets</span>&quot;&gt; ... &lt;/atm-loop&gt;</span>
			<ul>
				<li><span class="keyword">objets</span> : Collection d\'objets. Employ&eacute; pour traiter tous les objets d\'un ensemble d\'objets multiple (dit multi-objet).</li>
			</ul>
			Les valeurs suivantes seront remplac&eacute;es dans le tag :
			<ul>
				<li><span class="vertclair">{firstloop}</span> : Vrai si l\'objet en cours est le premier de la liste d\'objets.</li>
				<li><span class="vertclair">{lastloop}</span> : Vrai si l\'objet en cours est le dernier de la liste d\'objets.</li>
				<li><span class="vertclair">{loopcount}</span> : Num&eacute;ro de l\'objet en cours dans la liste d\'objets.</li>
				<li><span class="vertclair">{lastloop}</span> : Vrai si l\'objet en cours est le dernier de la liste d\'objets.</li>
				<li><span class="vertclair">{maxloops}</span> : Nombre d\'objets sur lesquels boucler.</li>
			</ul>
			</div>
		<h3>Ajouter un attribut au tag XHTML p&egrave;re (contenant ce tag) :</h3>
			<div class="retrait">
			<span class="code">
				&lt;atm-parameter attribute=&quot;<span class="keyword">attributeName</span>&quot; value=&quot;<span class="keyword">attributeValue</span>&quot; /&gt;
			</span>
			<ul>
				<li><span class="keyword">attributeName</span> : Nom de l\'attribut &agrave; ajouter.</li>
				<li><span class="keyword">attributeValue</span> : Valeur de l\'attribut &agrave; ajouter.</li>
			</ul>
			</div>
		<h3>Assigner une valeur &agrave; une variable :</h3>
			<div class="retrait">
			<span class="code">&lt;atm-setvar vartype=&quot;<span class="keyword">type</span>&quot; varname=&quot;<span class="keyword">name</span>&quot; value=&quot;<span class="keyword">varValue</span>&quot; /&gt;
			</span>
			<ul>
				<li><span class="keyword">type </span>: Type de la variable &agrave; assigner : <span class="vertclair">request</span>, <span class="vertclair">session</span> ou <span class="vertclair">var</span>.</li>
				<li><span class="keyword">name </span>: Nom de la variable &agrave; assigner. Attention, r&eacute;assigner une variable existante supprimera l\'ancienne valeur.</li>
				<li><span class="keyword">varValue</span> : valeur &agrave; assigner &agrave; la variable.</li>
			</ul>
			</div>
	</div>
</div>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (115, 'polymod', NOW(), 'Bloc de données', 'Datas block');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (116, 'polymod', NOW(), '<div class="rowComment">
	<h1>Bloc de donn&eacute;es du module :</h1>
	<div class="retrait">
	<span class="code">
		&lt;block module=&quot;%s&quot; id=&quot;<span class="keyword">blockID</span>&quot; language=&quot;<span class="keyword">languageCode</span>&quot;&gt; ... &lt;/block&gt;
	</span>
	<br/><br/>
	Ce tag permet l\'affichage de donn&eacute;es sp&eacute;cifiques &agrave; ce module. Il doit entourer tout ensemble de tags relatif &agrave; un traitement de donn&eacute;es du module.<br />
	<ul>
		<li><span class="keyword">blockID </span>: Identifiant unique du bloc de contenu dans la rang&eacute;e. Deux blocs de contenus d\'une m&ecirc;me rang&eacute;e ne doivent pas avoir d\'identifiants identiques.</li>
		<li><span class="keyword">languageCode </span>: (facultatif) Code du langage relatif &agrave; ce bloc de contenu parmi les codes suivants : <span class="vertclair">%s</span>. <br/>Si non présent, la langue de la page sera utilisée. Si non présente, la langue par défaut d\'Automne sera utilisée.</li>
	</ul>
	</div>
</div>', 'TODO %s %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (117, 'polymod', NOW(), 'Libellé de l\'objet, correspond à sa valeur', 'Object label, same as object value');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (118, 'polymod', NOW(), 'Libellé du champ : \'%s\'', 'Field label : \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (119, 'polymod', NOW(), 'Identifiant du champ : \'%s\'', 'Field id : \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (120, 'polymod', NOW(), 'Valeur du champ', 'Field value');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (121, 'polymod', NOW(), 'Nom de l\'objet', 'Object name');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (122, 'polymod', NOW(), 'Variables de l\'objet', 'Object vars');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (123, 'polymod', NOW(), 'Fonctions de l\'objet', 'Object functions');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (124, 'polymod', NOW(), 'Sélection des paramètres de recherche de la rangée \'%s\' du module \'%s\'', 'Parameters selection for row \'%s\' of module \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (125, 'polymod', NOW(), 'Pour la recherche ayant l\'identifiant \'%s\' dans cette rangée', 'For search with \'%s\' ID in this row');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (126, 'polymod', NOW(), '[Erreur : la recherche ayant l\'identifiant \'%s\' dans la rangée \'%s\' n\'est pas valide : Elle porte sur un objet inexistant.]', '[Error : search with \'%s\' ID in \'%s\' row is not valid : It relates to a non-existent object.]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (127, 'polymod', NOW(), '[Erreur : la recherche ayant l\'identifiant \'%s\' dans la rangée \'%s\' n\'est pas valide : Un de ses paramètre porte sur un champ inexistant.]', '[Error : search with \'%s\' ID in \'%s\' row is not valid : One of its parameter relates to a non-existent field.]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (128, 'polymod', NOW(), 'Nombre de résultats par pages', 'Number of results per pages');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (129, 'polymod', NOW(), 'Croissant', 'Ascending');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (130, 'polymod', NOW(), 'Décroissant', 'Descending');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (131, 'polymod', NOW(), 'Ordre d\'affichage', 'Display order');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (132, 'polymod', NOW(), 'Par création d\'objets', 'By object creation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (133, 'polymod', NOW(), '[Erreur : la recherche ayant l\'identifiant \'%s\' dans la rangée \'%s\' n\'est pas valide : Le type de l\'un de ses paramètres est inconnu : \'%s\']', '[Error : search with \'%s\' ID in \'%s\' row is not valid : The type of the one of its parameters is unknown : \'%s\']');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (134, 'polymod', NOW(), 'Publié à partir du', 'Published from');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (135, 'polymod', NOW(), 'Publié jusqu\'au', 'Published to');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (136, 'polymod', NOW(), '[Erreur : la recherche ayant l\'identifiant \'%s\' dans la rangée \'%s\' n\'est pas valide : Le type de l\'un de ses paramètres de tri est inconnu : \'%s\']', '[Error : search with \'%s\' ID in \'%s\' row is not valid : The type of the one of its sort parameters is unknown : \'%s\']');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (137, 'polymod', NOW(), 'Par date de début de publication', 'By publication date start');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (138, 'polymod', NOW(), 'Par date de fin de publication', 'By publication date end');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (139, 'polymod', NOW(), '<div class="rowComment">
	<h1>Variables g&eacute;n&eacute;rales :</h1>
	<div class="retrait">
	<h3>Variables relatives aux pages :</h3>
		<div class="retrait">
			Les variables relatives aux pages sont de la forme <span class="vertclair">{page:<span class="keyword">id</span>:<span class="keyword">type</span>}</span>:
			<ul>
				<li><span class="keyword">id </span>: Identifiant de la page &agrave; laquelle faire r&eacute;f&eacute;rence, peut-&ecirc;tre un identifiant num&eacute;rique d\'une page ou bien \'<span class="vertclair">self</span>\' pour faire r&eacute;f&eacute;rence &agrave; la page courante.</li>
				<li><span class="keyword">type</span> : type de donn&eacute;e souhait&eacute; pour la page parmi les suivant : <span class="vertclair">url </span>(adresse de la page), <span class="vertclair">printurl </span>(adresse de la page d\'impression), <span class="vertclair">id </span>(identifiant de la page), <span class="vertclair">title </span>(nom de la page).</li>
			</ul>
		</div>
	<h3>Variables relatives aux donn&eacute;es envoy&eacute;es (via une adresse ou un formulaire) :</h3>
		<div class="retrait">
		Ces variables correspondent &agrave; une variable provenant de la soumission d\'un formulaire ou bien d\'un param&egrave;tre du lien ayant amen&eacute; &agrave; la page en cours. <br />
		Elles sont de la forme <span class="vertclair">{request:<span class="keyword">type</span>:<span class="keyword">name</span>}</span> :
		<ul>
			<li><span class="keyword">type</span> : Correspond au type de variable attendu, parmi les suivant : <br />
			<ul>
				<li><span class="vertclair">int </span>: nombre entier,&nbsp;</li>
				<li><span class="vertclair">string </span>: cha&icirc;ne de caract&egrave;re,&nbsp;</li>
				<li><span class="vertclair">bool </span>: bool&eacute;en,&nbsp;</li>
				<li><span class="vertclair">array</span>: tableau de valeurs,&nbsp;</li>
				<li><span class="vertclair">email </span>: email valide,</li>
				<li><span class="vertclair">date </span>: date valide sans heure (retourne une date au format MySQL : YYYY-MM-DD),</li>
				<li><span class="vertclair">datetime </span>: date valide avec heure (retourne une date au format MySQL : YYYY-MM-DD HH:MM:SS).</li>
				<li><span class="vertclair">localisedDate</span> : date valide sans heure (retourne une date au format de votre langue actuelle : %s).</li>
			</ul>
			</li>
			<li><span class="keyword">name</span> : Correspond au nom de la variable souhait&eacute; (nom du param&egrave;tre dans l\'url ou bien nom du champ du formulaire).</li>
		</ul>
		</div>
	<h3>Variables de session :</h3>
		<div class="retrait">
		Ces variables sont disponible tout au long de la navigation du visiteur sur le site. <br />
		Elles sont de la forme <span class="vertclair">{session:<span class="keyword">type</span>:<span class="keyword">name</span>}</span> :
		<ul>
			<li><span class="keyword">type</span> : Correspond au type de variable attendu, parmi les suivant :
			<ul>
				<li><span class="vertclair">int </span>: nombre entier,&nbsp;</li>
				<li><span class="vertclair">string </span>: cha&icirc;ne de caract&egrave;re,&nbsp;</li>
				<li><span class="vertclair">bool </span>: bool&eacute;en,&nbsp;</li>
				<li><span class="vertclair">array</span>: tableau de valeurs,&nbsp;</li>
				<li><span class="vertclair">email </span>: email valide,</li>
				<li><span class="vertclair">date </span>: date valide sans heure (retourne une date au format MySQL : YYYY-MM-DD),</li>
				<li><span class="vertclair">datetime </span>: date valide avec heure (retourne une date au format MySQL : YYYY-MM-DD HH:MM:SS).</li>
				<li><span class="vertclair">localisedDate</span> : date valide sans heure (retourne une date au format de votre langue actuelle : %s).</li>
			</ul>
			</li>
			<li><span class="keyword">name</span> : Correspond au nom de la variable souhait&eacute; (nom de la variable de session).</li>
		</ul>
		</div>
	<h3>Variables&nbsp;:</h3>
		<div class="retrait">
		Ces variables correspondent &agrave; des variables PHP classiques. <br />
		Elles sont de la forme <span class="vertclair">{var:<span class="keyword">type</span>:<span class="keyword">name</span>}</span> :
		<ul>
			<li><span class="keyword">type</span> : Correspond au type de variable attendu, parmi les suivant :
			<ul>
				<li><span class="vertclair">int </span>: nombre entier,&nbsp;</li>
				<li><span class="vertclair">string </span>: cha&icirc;ne de caract&egrave;re,&nbsp;</li>
				<li><span class="vertclair">bool </span>: bool&eacute;en,&nbsp;</li>
				<li><span class="vertclair">array</span>: tableau de valeurs,&nbsp;</li>
				<li><span class="vertclair">email </span>: email valide</li>
				<li><span class="vertclair">date </span>: date valide sans heure (retourne une date au format MySQL : YYYY-MM-DD),</li>
				<li><span class="vertclair">datetime </span>: date valide avec heure (retourne une date au format MySQL : YYYY-MM-DD HH:MM:SS).</li>
				<li><span class="vertclair">localisedDate</span> : date valide sans heure (retourne une date au format de votre langue actuelle : %s).</li>
			</ul>
			</li>
			<li><span class="keyword">name</span> : Correspond au nom de la variable souhait&eacute; (nom de la variable PHP).</li>
		</ul>
		</div>
	</div>
</div>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (140, 'polymod', NOW(), 'Variables générales', 'General variables');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (141, 'polymod', NOW(), 'Identifiant unique de l\'objet', 'Unique ID for object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (142, 'polymod', NOW(), 'Libellé de l\'objet', 'Object label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (143, 'polymod', NOW(), 'Nom de l\'objet : \'%s\'', 'Object name : \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (144, 'polymod', NOW(), 'Description de l\'objet : \'%s\'', 'Object description : \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (145, 'polymod', NOW(), 'Identifiant de type de l\'objet : \'%s\'', 'Object type ID : \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (146, 'polymod', NOW(), 'Identifiant du champ auquel l\'objet appartient (si il existe)', 'Identifier of the field to which the object belongs (if exists)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (147, 'polymod', NOW(), 'Identifiant de ressource de l\'objet', 'Object resource ID');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (148, 'polymod', NOW(), 'Ensemble des objets de type \'%s\' associés à ce  champ. Cette valeur est usuellement utilisée par un tag atm-loop', 'Objects of type \'%s\' associated to this field. This value is usually used by a tag atm-loop');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (149, 'polymod', NOW(), 'Nombre d\'objets de type \'%s\' associés à ce champ', 'Count of objects of the type \'%s\' associated to this field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (150, 'polymod', NOW(), 'Date format&eacute;e. Remplacez \'format\' par la valeur correspondant au format accept&eacute; en PHP pour la <a href="http://www.php.net/date" class="admin" target="_blank">\'fonction date\'</a>. Pour une date employ&eacute;e dans un Fil RSS, utilisez la valeur \'<strong>rss</strong>\' pour sp&eacute;cifier le format.', 'Formatted date. Replace \'format\' by the format value accepted in PHP for the <a href="http://www.php.net/date" class="admin" target="_blank">\'date function\'</a>. For a date used in an RSS feed, use \'<strong>rss</strong>\' to specify the format.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (151, 'polymod', NOW(), 'Adresse du lien (URL)', 'Link address (URL)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (152, 'polymod', NOW(), 'Libellé du lien', 'Link label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (153, 'polymod', NOW(), 'Cible du lien (_blank, _top, etc.)', 'Link target (_blank, _top, etc.)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (154, 'polymod', NOW(), 'Type de lien (interne, externe, fichier, etc.)', 'Link type (internal, external, file, etc.)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (155, 'polymod', NOW(), 'Code HTML complet du lien. Le titre du lien peut-être modifié grace à un paramètre (facultatif)', 'Complete HTML code of the link. Link title can be changed with a parameter (optional)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (156, 'polymod', NOW(), 'Identifiant de la catégorie racine de ce champ', 'Root category ID for this field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (157, 'polymod', NOW(), 'Nombre de catégories associées à ce champ', 'Number of categories associated to this field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (158, 'polymod', NOW(), 'Catégories associées à ce champ. Cette valeur est usuellement utilisée par un tag atm-loop', 'Categories associated to this field. This value is usually used by a tag atm-loop');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (159, 'polymod', NOW(), 'Identifiant d\'une catégorie du champ (utilisable dans un tag atm-loop)', 'One category ID of the field (usable in an atm-loop tag)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (160, 'polymod', NOW(), 'Libellé d\'une catégorie du champ (utilisable dans un tag atm-loop)', 'One category label of the field (usable in an atm-loop tag)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (161, 'polymod', NOW(), 'Identifiant de la catégorie du champ', 'Id of the field category');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (162, 'polymod', NOW(), '<strong>Liste de tous les objets d\'un type donn&eacute; :</strong><br /><br /><span class="code">&lt;select ...&gt;&lt;atm-function function=&quot;selectOptions&quot; object=&quot;%s&quot; selected=&quot;<span class="keyword">selectedID</span>&quot;&gt;&lt;/atm-function&gt;&lt;/select&gt;</span><br />Cette fonction permet d\'afficher une liste class&eacute;e par ordre alphab&eacute;tique de tags &lt;option&gt; contenant tous les objets du m&ecirc;me type que l\'objet pass&eacute; en param&egrave;tre. Elle est usuellement employ&eacute;e &agrave; l\'int&eacute;rieur d\'un tag &lt;select&gt;.<br /><ul><li><span class="keyword">selectedID : </span>Identifiant de l\'objet &agrave; selectionner dans la liste</li></ul><br />', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (163, 'polymod', NOW(), '<strong>Arborescence de cat&eacute;gories : </strong><br />
<br />
<span class="code">&lt;atm-function function=&quot;categoriesTree&quot; object=&quot;%s&quot; root=&quot;<span class="keyword">rootID</span>&quot; maxlevel=&quot;<span class="keyword">maxLevel</span>&quot; selected=&quot;<span class="keyword">selectedID</span>&quot;&gt;<br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;item&gt;</span>&lt;li class=&quot;<span class="vertclair">{lvl}</span>&quot;&gt; ... <span class="vertclair">{id}</span> ... <span class="vertclair">{label}</span> ... <span class="vertclair">{sublevel}</span> ... &lt;/li&gt;<span class="keyword">&lt;/item&gt;</span><br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;itemselected&gt;</span>&lt;li class=&quot;<span class="vertclair">{lvl}</span>&quot;&gt; ... <span class="vertclair">{id}</span> ... <span class="vertclair">{label}</span> ... <span class="vertclair">{sublevel}</span> ... &lt;/li&gt;<span class="keyword">&lt;/itemselected&gt;</span><br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;template&gt;</span>&lt;ul&gt;<span class="vertclair">{sublevel}</span>&lt;/ul&gt;<span class="keyword">&lt;/template&gt;</span><br />
&lt;/atm-function&gt;<strong><br />
</strong></span>
<p>Cette Fonction permet d\'afficher une arborescence de cat&eacute;gories.</p>
<ul> <strong>	</strong>
	<li><span class="keyword">rootID </span>: L\'identifiant de la cat&eacute;gorie devant servir de racine &agrave; l\'arborescence.</li>
	<li><span class="keyword">maxLevel </span>: Nombre de niveaux maximum &agrave; afficher pour l\'arborescence (facultatif).</li>
	<li><span class="keyword">selectedID </span>: Cat&eacute;gorie actuellement s&eacute;lectionn&eacute;e (facultatif).</li>
	<li><span class="keyword">usedcategories </span>: Bool&eacute;en <span class="vertclair">true, false</span>, affiche uniquement les cat&eacute;gories utilis&eacute;es (facultatif, d&eacute;faut : true).</li>
	<li>Le tag &lt;<span class="keyword">item</span>&gt; sera lu pour chaque cat&eacute;gorie &agrave; lister. La valeur <span style="font-weight: bold;"><span class="vertclair">{id}</span> </span>sera remplac&eacute;e par l\'identifiant de la cat&eacute;gorie en cours, la valeur <span class="vertclair">{label}</span> par son libell&eacute;. La valeur <span class="vertclair">{lvl}</span> sera remplac&eacute;e par le num&eacute;ro du niveau en cours dans l\'arborescence et la valeur <span class="vertclair">{sublevel}</span> par le niveau suivant dans l\'arborescence.</li>
	<li>Le tag &lt;<span class="keyword">template</span>&gt; sera lu au d&eacute;but de chaque niveau d\'arborescence. La valeur <span class="vertclair">{sublevel}</span> sera remplac&eacute;e par le contenu du niveau d\'arborescence en cours.</li>
	<li>Le tag &lt;<span class="keyword">itemselected</span>&gt; sera lu pour la cat&eacute;gorie actuellement selectionn&eacute;e (facultatif).</li>
</ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (164, 'polymod', NOW(), '<strong>Hi&eacute;rarchie - Historique de cat&eacute;gories :</strong><br />
<br />
<span class="code"> &lt;atm-function function=&quot;categoryLineage&quot; object=&quot;%s&quot; category=&quot;<span class="keyword">categoryID</span>&quot; root=&quot;<span class="keyword">rootCatID</span>&quot;&gt;<br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;ancestor&gt;</span> ... <span class="vertclair">{id}</span> ... <span class="vertclair">{label}</span> ... <span class="keyword">&lt;/ancestor&gt;</span><br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;self&gt;</span> ... <span class="vertclair">{id}</span> ... <span class="vertclair">{label}</span> ... <span class="keyword">&lt;/self&gt;</span><br />
&lt;/atm-function&gt;</span><strong><br />
</strong>Cette fonction permet d\'afficher la hi&eacute;rarchie parente (historique) d\'une cat&eacute;gorie donn&eacute;e.
<ul>
    <li><strong><span class="keyword">categoryID </span>: </strong>L\'identifiant de la cat&eacute;gorie dont on souhaite afficher la hi&eacute;rarchie.</li>
    <li><strong><span class="keyword">rootCatID </span>: </strong>L\'identifiant de la cat&eacute;gorie à partir de laquelle on souhaite afficher la hi&eacute;rarchie (facultatif si "catégorie de plus haut niveau" sélectionnée, obligatoire dans le cas contraire).</li>
    <li>Le tag <strong>&lt;<span class="keyword">ancestor</span>&gt;</strong> sera lu pour chaque anc&egrave;tre de la cat&eacute;gorie trouv&eacute;. La valeur <span class="vertclair">{id}</span> sera remplac&eacute; par l\'identifiant de la cat&eacute;gorie anc&egrave;tre, la valeur <span class="vertclair">{label}</span> par son libell&eacute;.</li>
    <li>Le tag optionel <strong>&lt;<span class="keyword">self</span>&gt;</strong> sera lu pour la cat&eacute;gorie dont on affiche la hierarchie (si le tag n\'existe pas, le tag &lt;<span class="keyword">ancestor</span>&gt; sera employ&eacute;). La valeur <span class="vertclair">{id}</span> sera remplac&eacute; par l\'identifiant de la cat&eacute;gorie&nbsp; dont on affiche la hierarchie, la valeur <span class="vertclair">{label}</span> par son libell&eacute;.</li>
</ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (165, 'polymod', NOW(), '<strong>Liste de toutes les cat&eacute;gories d\'un champ donn&eacute; :</strong><br />
<br />
<span class="code">&lt;select ...&gt;&lt;atm-function function=&quot;selectOptions&quot; object=&quot;%s&quot; selected=&quot;<span class="keyword">selectedID</span>&quot;&gt;&lt;/atm-function&gt;&lt;/select&gt;</span><br />
Cette fonction permet d\'afficher une liste class&eacute;e par ordre alphab&eacute;tique de tags &lt;option&gt; contenant toutes les cat&eacute;gories et sous cat&eacute;gories d\'un champ donn&eacute;. Elle est usuellement employ&eacute;e &agrave; l\'int&eacute;rieur d\'un tag &lt;select&gt;.
<ul>
	<li><span class="keyword">selectedID </span><strong>: </strong>Identifiant de la cat&eacute;gorie &agrave; selectionner dans la liste (facultatif)</li>
	<li><span class="keyword">usedcategories </span>: Bool&eacute;en <span class="vertclair">true, false</span>, affiche uniquement les cat&eacute;gories utilis&eacute;es (facultatif, d&eacute;faut : true).</li>
	<li><span class="keyword">editableonly </span>: Bool&eacute;en <span class="vertclair">true, false</span>, arffiche uniquement les cat&eacute;gories &eacute;ditables (facultatif, d&eacute;faut : false).</li>
	<li><span class="keyword">root </span>: L\'identifiant de la cat&eacute;gorie &agrave;&agrave; employer comme racine.</li>
</ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (166, 'polymod', NOW(), 'Catégories', 'Categories');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (167, 'polymod', NOW(), 'Permet de catégoriser les objets et de gérer leurs droits d\'accès', 'Allows you to categorize objects and to manage their access rights');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (168, 'polymod', NOW(), 'Catégories multiples', 'Multiples categories');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (169, 'polymod', NOW(), 'Catégorie de plus haut niveau', 'Top level category');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (170, 'polymod', NOW(), 'Date', 'Date');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (171, 'polymod', NOW(), 'Champ contenant une date au format de la langue courante', 'Field containing a date with the current language format');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (172, 'polymod', NOW(), 'Si le champ est vide, enregistrer la date du jour', 'If the field is empty, record the current date');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (173, 'polymod', NOW(), 'Avec gestion des Heures - minutes - secondes', 'With management of Hours - minutes - seconds');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (174, 'polymod', NOW(), 'hh:mm:ss', 'hh:mm:ss');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (175, 'polymod', NOW(), 'Lien', 'Link field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (176, 'polymod', NOW(), 'Champ contenant un lien vers un site externe, une page ou un fichier.', 'Field containing a link to an external site, a page or a file.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (177, 'polymod', NOW(), 'Nombre entier', 'Integer number');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (178, 'polymod', NOW(), 'Nombre entier de 11 chiffres maximum', 'Integer number containing 11 digits maximum');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (179, 'polymod', NOW(), 'Peut-être nul', 'Can be null');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (180, 'polymod', NOW(), 'Peut-être négatif', 'Can be negative');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (181, 'polymod', NOW(), 'Champ texte', 'Text field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (182, 'polymod', NOW(), 'Champ de texte long, avec ou sans HTML', 'Long text field, with or without HTML');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (183, 'polymod', NOW(), 'HTML autorisé', 'HTML allowed');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (184, 'polymod', NOW(), 'Type de barre d\'outil pour l\'éditeur de texte (wysiwyg)', 'Toolbar type for the text editor (wysiwyg)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (185, 'polymod', NOW(), 'Chaîne de caractères', 'Characters string');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (186, 'polymod', NOW(), 'Chaîne contenant 255 caractères maximum sans HTML. Peut-être un email.', 'String containing 255 characters maximum without HTML. Can be an email');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (187, 'polymod', NOW(), 'Nombre maximum de charactères :<br /><small>(255 maximum)</small>', 'Max count of caracters :<br /><small>(255 max)</small>');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (188, 'polymod', NOW(), 'Objet inconnu', 'Unknown object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (189, 'polymod', NOW(), 'Cet objet n\'est pas défini', 'This object is not defined');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (190, 'polymod', NOW(), 'Multiples objets \'%s\'', 'Multiple objects \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (191, 'polymod', NOW(), 'Objet composé de multiples objets \'%s\'', 'Object composed with Multiple objects \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (192, 'polymod', NOW(), 'Ces objets peuvent être édités ?', 'These objects can be edited?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (193, 'polymod', NOW(), 'Création d\'un objet \'%s\' à associer', 'Create \'%s\' object to associate');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (194, 'polymod', NOW(), 'Edition d\'un objet \'%s\'', 'Edit \'%s\' object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (195, 'polymod', NOW(), 'Objets \'%s\' associés', 'Associated \'%s\' objects');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (196, 'polymod', NOW(), 'Associer un objet \'%s\' existant', 'Associate an existing object \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (197, 'polymod', NOW(), 'Forcer le chargement des sous objets ?', 'Force subobjects loading?');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (198, 'polymod', NOW(), 'Attention, ce paramètre doit rester désactivé sauf si des données sont manquantes lors de certains chargements. Activer ce paramètre peut entraîner une perte de performance très importante.', 'Attention, this parameter must remain inactived except if data are missing during some loadings. Activate this parameter can involve a very significant loss of performance.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (199, 'polymod', NOW(), 'Uniquement les objets répondant à ces paramètres', 'Only objects with these parameters');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (200, 'polymod', NOW(), 'Image', 'Image');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (201, 'polymod', NOW(), 'Champ contenant une image avec ou sans image zoom', 'Field with an image, with or without zoom image');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (202, 'polymod', NOW(), 'Largeur maximum de la vignette en pixels', 'Maximum width of the thumbnail in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (203, 'polymod', NOW(), 'Date de début de publication formatée. Remplacez \'format\' par la valeur correspondant au format accepté en PHP pour la <a href="http://www.php.net/date" class="admin" target="_blank">\'fonction date\'</a>', 'Formatted date. Replace \'format\' by the format value accepted in PHP for the <a href="http://www.php.net/date" class="admin" target="_blank">\'date function\'</a>');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (204, 'polymod', NOW(), 'Date de fin de publication formatée (si elle existe). Remplacez \'format\' par la valeur correspondant au format accepté en PHP pour la <a href="http://www.php.net/date" class="admin" target="_blank">\'fonction date\'</a>', 'Formatted date. Replace \'format\' by the format value accepted in PHP for the <a href="http://www.php.net/date" class="admin" target="_blank">\'date function\'</a>');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (205, 'polymod', NOW(), 'Utiliser l\'image originale comme image zoom', 'Use original image as zoom');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (206, 'polymod', NOW(), 'Vignette', 'Thumbnail');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (207, 'polymod', NOW(), 'Image zoom', 'Zoom image');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (208, 'polymod', NOW(), '(Sera redimensionnée à %s pixels de large)', '(Will be resized to %s pixels width)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (209, 'polymod', NOW(), 'Utiliser une image zoom distincte', 'Use distinct zoom image');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (210, 'polymod', NOW(), '(Si vous n\'utilisez pas d\'image zoom distincte)', '(If you do no uses a distinct image zoom)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (211, 'polymod', NOW(), 'Conserver l\'image originale comme image zoom', 'Keep original image as an image zoom');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (212, 'polymod', NOW(), '(Si la vignette dépasse cette largeur elle sera redimensionnée)', '(If the thumbnail exceeds this width it will be resized)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (213, 'polymod', NOW(), 'Cochez la case pour effacer l\'image', 'Check the box to delete image');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (214, 'polymod', NOW(), 'Image actuelle', 'Current image');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (215, 'polymod', NOW(), 'Code HTML de l\'image. Le titre du lien peut-être modifié grace à un paramètre (facultatif)', 'Image HTML code. Link title can be changed with a parameter (optional)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (216, 'polymod', NOW(), 'Libellé de l\'image', 'Image label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (217, 'polymod', NOW(), 'Nom du fichier de l\'image', 'Image file name');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (218, 'polymod', NOW(), 'Nom du fichier de l\'image zoom', 'Image file name zoom');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (219, 'polymod', NOW(), 'Chemin du repertoire de l\'image et de l\'image zoom', 'Path to the image and image zoom');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (220, 'polymod', NOW(), 'Largeur de l\'image en pixels', 'Image width in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (221, 'polymod', NOW(), 'Hauteur de l\'image en pixels', 'Image height in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (222, 'polymod', NOW(), 'Largeur de l\'image zoom en pixels', 'Image zoom width in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (223, 'polymod', NOW(), 'Hauteur de l\'image zoom en pixels', 'Image zoom height in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (224, 'polymod', NOW(), 'Poids de l\'image en Mo', 'Image file size in MB');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (225, 'polymod', NOW(), 'Poids de l\'image zoom en Mo', 'Image zoom file size in MB');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (226, 'polymod', NOW(), 'La valeur du champ doit-être un email valide', 'Field value must be a valid email');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (227, 'polymod', NOW(), 'Fichier', 'File');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (228, 'polymod', NOW(), 'Champ contenant un fichier avec ou sans vignette', 'Field with a file, with or without thumbnail');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (229, 'polymod', NOW(), 'Largeur maximum de la vignette en pixels', 'Maximum width of the thumbnail in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (230, 'polymod', NOW(), 'Utiliser une vignette pour le fichier', 'Use thumbnail for file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (231, 'polymod', NOW(), '<!--Icônes de type pour les fichiers-->', '<!--Type icons for files-->');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (232, 'polymod', NOW(), 'Fichier source', 'Source file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (233, 'polymod', NOW(), 'ou Fichier FTP', 'or FTP file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (234, 'polymod', NOW(), 'Chemin du repertoire FTP à utiliser', 'Path for FTP directory to use');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (235, 'polymod', NOW(), '(Laissez vide pour empêcher l\'utilisation d\'un répertoire FTP comme source pour vos documents)', '(Leave empty to prevent the use of a FTP directory as a source for your documents');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (236, 'polymod', NOW(), '(max : %s)', '(max : %s)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (237, 'polymod', NOW(), '(Répertoire FTP : %s)', '(FTP directory : %s)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (238, 'polymod', NOW(), 'Chemin vers l\'icône du fichier (si elle existe)', 'Path to the file icon (if exists)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (239, 'polymod', NOW(), 'Type de fichier (extension)', 'File type (extension)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (240, 'polymod', NOW(), 'Cochez la case pour effacer le fichier', 'Check the box to delete file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (241, 'polymod', NOW(), 'Fichier actuel', 'Current file');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (242, 'polymod', NOW(), 'Code HTML du fichier', 'File HTML code');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (243, 'polymod', NOW(), 'Libellé du fichier', 'File label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (244, 'polymod', NOW(), 'Nom du fichier', 'File name');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (245, 'polymod', NOW(), 'Nom du fichier de la vignette', 'Thumbnail file name');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (246, 'polymod', NOW(), 'Chemin du repertoire du fichier et de la vignette', 'Path to the file and thumbnail');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (247, 'polymod', NOW(), 'Largeur de la vignette en pixels', 'Thumbnail width in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (248, 'polymod', NOW(), 'Hauteur de a vignette en pixels', 'Thumbnail height in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (249, 'polymod', NOW(), 'Autoriser l\'utilisation de fichiers du repertoire FTP', 'Allow usage of FTP files');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (250, 'polymod', NOW(), '(Permet, pour les gros fichiers, d\'utiliser un répertoire d\'automne pour déposer des fichiers via FTP)', '(Allow, for big files, to use an Automne directory to store files with FTP)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (251, 'polymod', NOW(), 'Poids du fichier en Mo', 'File Size in MB');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (252, 'polymod', NOW(), 'Renvoi vrai si l\'objet contient un lien valide.', 'Return true if object contain a valid link');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (253, 'polymod', NOW(), 'Largeur maximum de l\'image en pixels', 'Image maximum width in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (254, 'polymod', NOW(), 'Adresse de prévisualisation', 'Preview  address');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (255, 'polymod', NOW(), 'Valeur HTML du texte (retours chariots convertis pour le texte seul)', 'HTML value of the text (Line breaks converted for plain-text)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (256, 'polymod', NOW(), 'Fichier associé à la catégorie du champ', 'File associated to the field category');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (257, 'polymod', NOW(), 'Fichier d\'une catégorie du champ (utilisable dans un tag atm-loop)', 'One category File of the field (usable in an atm-loop tag)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (258, 'polymod', NOW(), 'Sans %s', 'Without %s');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (259, 'polymod', NOW(), 'Nombre d\'utilisateurs/groupes associées à ce champ', 'Number of users/groups associated to this field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (260, 'polymod', NOW(), 'Utilisateurs/Groupes associés à ce champ. Cette valeur est usuellement utilisée par un tag atm-loop', 'Users/Groups associated to this field. This value is usually used by a tag atm-loop');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (261, 'polymod', NOW(), 'Identifiant d\'un utilisateur/groupe du champ (utilisable dans un tag atm-loop)', 'One user/group ID of the field (usable in an atm-loop tag)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (262, 'polymod', NOW(), 'Nom et prénom d\'un utilisateur ou nom d\'un groupe du champ (utilisable dans un tag atm-loop)', 'Lastname and firstname of one user or name of one group of the field (usable in an atm-loop tag)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (263, 'polymod', NOW(), 'Identifiant de l\'utilisateur ou du groupe', 'Id of the user or group');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (264, 'polymod', NOW(), 'Utilisateur/Groupe', 'User/Group');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (265, 'polymod', NOW(), 'Permet d\'associer un ou plusieurs utilisateurs ou groupe(s) d\'utilisateurs', 'Allows you to associate one or more users or group(s) of users');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (266, 'polymod', NOW(), 'Multiples utilisateurs ou groupes', 'Multiples users or groups');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (267, 'polymod', NOW(), 'Utiliser des groupes', 'Use groups');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (268, 'polymod', NOW(), 'La valeur est l\'utilisateur actuel', 'Value is the current user');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (269, 'polymod', NOW(), 'Ce paramètre exclu les autres', 'This parameter exclude the others');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (270, 'polymod', NOW(), 'Si ce paramètre est sélectionné, vous pourrez utiliser des groupes d\'utilisateurs. Sinon, ce sera des utilisateurs', 'If this parameter is selected, you will use groups of users. Otherwise, it will be users.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (271, 'polymod', NOW(), '<strong>Liste de tous les utilisateurs/groupes du champ :<br />
</strong><br />
<span class="code"> &lt;select&gt;<strong>&lt;</strong>atm-function function=&quot;selectOptions&quot; object=&quot;%s&quot; selected=&quot;<span class="keyword">selectedID</span><strong>&quot;&gt;&lt;/</strong>atm-function<strong>&gt;</strong>&lt;/select&gt;</span><br />
Cette fonction permet d\'afficher une liste class&eacute;e par ordre alphab&eacute;tique de tags &lt;option&gt; contenant tous les utilisateurs/groupes du champ donn&eacute; en param&egrave;tre. Elle est usuellement employ&eacute;e &agrave; l\'int&eacute;rieur d\'un tag &lt;select&gt;.<br />
<ul>
	<li><span class="keyword">selectedID </span><strong>: </strong>Identifiant de l\'utilisateur/groupe &agrave; selectionner dans la liste</li>
</ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (272, 'polymod', NOW(), 'Nom et prénom de l\'utilisateur ou nom du groupe', 'Lastname and firstname of the user or name of the group');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (273, 'polymod', NOW(), 'Email d\'un utilisateur du champ (utilisable dans un tag atm-loop)', 'Email of one user of the field (usable in an atm-loop tag)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (274, 'polymod', NOW(), 'Email de l\'utilisateur', 'Email of the user');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (275, 'polymod', NOW(), 'Modules WYSIWYG associés', 'Associated WYSIWYG Plugins');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (276, 'polymod', NOW(), 'Propriétés de l\'objet', 'Object properties');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (277, 'polymod', NOW(), 'Création / modification d\'un module WYSIWYG pour l\'objet \'%s\'', 'Create / Edit a WYSIWYG plugin for object \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (278, 'polymod', NOW(), 'Syntaxe de la définition du module WYSIWYG pour l\'objet \'%s\'', 'Syntax definition for the WYSIWYG plugin for object \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (279, 'polymod', NOW(), 'Confirmez-vous la suppression du module WYSIWYG \'%s\' ? Attention cette suppression est définitive, elle n\'est pas soumise à validation et elle impactera tous les objets ainsi que tous les fichiers correspondant à ce module !', 'Do you confirm the deletion of the WYSIWYG plugin \'%s\'? Attention this deletion is final, it is not subjected to validation and it will impact all the objects like all the files corresponding to this plugin!');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (280, 'polymod', NOW(), '[Erreur : Aucun module WYSIWYG disponible ...]', '[Error : No WYSIWYG plugin available ...]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (281, 'polymod', NOW(), 'Type', 'Type');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (282, 'polymod', NOW(), 'Editeur de texte', 'Text editor');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (283, 'polymod', NOW(), 'Elément actuellement sélectionné', 'Item currently selected');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (284, 'polymod', NOW(), 'Sélectionner', 'Select');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (285, 'polymod', NOW(), 'Déselectionner', 'Deselect');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (286, 'polymod', NOW(), '[Erreur : Ce module nécessite d\'avoir sélectionné un texte. Merci de sélectionner le texte souhaité ...]', '[Error : this plugin must have a selected text. Please select a text first ...]');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (287, 'polymod', NOW(), 'Modules WYSIWYG', 'WYSIWYG plugins');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (288, 'polymod', NOW(), '<div class="rowComment">
<h1>Bloc de donn&eacute;es d\'un module WYSIWYG :</h1>
<span class="code"> &lt;atm-plugin language=&quot;<span class="keyword">languageCode</span>&quot;&gt;<br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-plugin-valid&gt;</span><br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; ...<br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;/atm-plugin-valid&gt;</span><br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-plugin-invalid&gt;</span><br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; ...<br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;/atm-plugin-invalid&gt;</span><br />
&lt;/atm-plugin&gt;</span><br />
<br />
Ce tag permet l\'affichage de donn&eacute;es sp&eacute;cifiques &agrave; un objet dans l\'&eacute;diteur de texte visuel (WYSIWYG).<br />
Le <span class="keyword">tag atm-plugin-valid</span> sera lu si l\'objet s&eacute;lectionn&eacute; est valide (non supprim&eacute;, valid&eacute; et en cours de publication).<br />
Le tag <span class="keyword">atm-plugin-invalid </span>(facultatif) sera lu si l\'objet s&eacute;lectionn&eacute; est invalide (supprim&eacute;, non valid&eacute; ou dont les dates de publications sont d&eacute;pass&eacute;es ou si l\'utilisateur n\'a pas les droits de consultation de cet objet).<br />
<ul>
	<li><span class="keyword">languageCode </span>: Code du langage relatif au contenu parmi les codes suivants : <span class="vertclair">%s</span>.</li>
	<li><span class="keyword">{plugin:selection}</span> : Sera replac&eacute; par la valeur textuelle s&eacute;lectionn&eacute;e dans l\'&eacute;diteur (facultatif).</li>
</ul>
</div>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (289, 'polymod', NOW(), '<strong>Charge une cat&eacute;gorie donn&eacute;e :<br />
</strong><br />
<span class="code"> &lt;atm-function function=&quot;category&quot; object=&quot;%s&quot; category=&quot;<span class="keyword">categoryID</span>&quot;&gt;<br />
&nbsp;&nbsp;&nbsp; ... <span class="vertclair">{id}</span> ... <span class="vertclair">{label}</span> ... <br />
&lt;/atm-function&gt;</span><strong><br />
</strong>Cette fonction permet d\'afficher le contenu d\'une cat&eacute;gorie donn&eacute;e.<br />
<ul>
	<li><span class="keyword">categoryID </span><strong>: </strong>L\'identifiant de la cat&eacute;gorie dont on souhaite afficher la hi&eacute;rarchie.</li>
	<li>La valeur <span class="vertclair">{id}</span> sera remplac&eacute; par l\'identifiant de la cat&eacute;gorie anc&egrave;tre, la valeur <span class="vertclair">{label}</span> par son libell&eacute;.</li>
</ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (290, 'polymod', NOW(), 'Fils RSS associés', 'Associated RSS Feeds');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (291, 'polymod', NOW(), 'Confirmez-vous la suppression du fil RSS \'%s\' ? Attention cette suppression est définitive, elle n\'est pas soumise à validation et elle impactera tous les objets ainsi que tous les fichiers correspondant à ce module !', 'Do you confirm the deletion of the RSS Feed \'%s\'? Attention this deletion is final, it is not subjected to validation and it will impact all the objects like all the files corresponding to this plugin!');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (292, 'polymod', NOW(), 'Création / modification d\'un fil RSS pour l\'objet \'%s\'', 'Create / Edit an RSS feed for object \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (293, 'polymod', NOW(), 'Syntaxe de la définition du fil RSS pour l\'objet \'%s\'', 'Syntax definition for the RSS feed for object \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (294, 'polymod', NOW(), 'Fils RSS', 'RSS Feeds');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (295, 'polymod', NOW(), '<strong>Bloc de donn&eacute;es d\'un module WYSIWYG :<br /><br />&lt;atm-plugin language=&quot;</strong>languageCode<strong>&quot;&gt;<br />&nbsp;&nbsp;&nbsp; &lt;atm-plugin-valid&gt;<br />&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; ...<br />&nbsp;&nbsp;&nbsp; &lt;/atm-plugin-valid&gt;<br />&nbsp;&nbsp;&nbsp; &lt;atm-plugin-invalid&gt;<br />&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; ...<br />&nbsp;&nbsp;&nbsp; &lt;/atm-plugin-invalid&gt;<br />&lt;/atm-plugin&gt;</strong><br /><br />Ce tag permet l\'affichage de donn&eacute;es sp&eacute;cifiques &agrave; un objet dans l\'&eacute;diteur de texte visuel (WYSIWYG).<br />Le tag <strong>atm-plugin-valid</strong> sera lu si l\'objet s&eacute;lectionn&eacute; est valide (non supprim&eacute;, valid&eacute; et en cours de publication).<br />Le tag <strong>atm-plugin-invalid</strong> (facultatif) sera lu si l\'objet s&eacute;lectionn&eacute; est invalide (supprim&eacute;, non valid&eacute; ou dont les dates de publications sont d&eacute;pass&eacute;es ou si l\'utilisateur n\'a pas les droits de consultation de cet objet).<br /><ul><li><strong>languageCode</strong> : Code du langage relatif au contenu parmi les codes suivants : <strong>%s</strong>.</li><li><strong>{plugin:selection}</strong> : Sera replac&eacute; par la valeur s&eacute;lectionn&eacute;e dans le Wysiwyg (facultatif).</li></ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (296, 'polymod', NOW(), 'Adresse vers le site du fil', 'Address to the feed website');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (297, 'polymod', NOW(), 'Ce lien sera employé dans le fil RSS et permettra d\'aller au site source du fil. Si ce champ n\'est pas rempli, l\'adresse \'%s\' sera utilisée.', 'This link will be used in the RSS feed and will allow to go to source website of the feed. If this field is not filled, the address \'%s\' will be used.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (298, 'polymod', NOW(), 'Auteur', 'Author');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (299, 'polymod', NOW(), 'Email de l\'auteur', 'Author email');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (300, 'polymod', NOW(), 'Copyright', 'Copyright');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (301, 'polymod', NOW(), 'Catégories', 'Categories');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (302, 'polymod', NOW(), 'Liste de termes séparés par des virgules permettant de catégoriser le fil RSS', 'Terms list separated by commas allowing to categorize the RSS feed.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (303, 'polymod', NOW(), 'Interval de mise à jour', 'Update interval');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (304, 'polymod', NOW(), 'Permet aux lecteurs de fils RSS d\'avoir une valeur indicative concernant la fréquence de mise à jour du fil. Par défaut : une fois par jour, minimum : 2 fois par heures.', 'Give to the feed reader an indicative value of the update frequency of the feed. By default : once a day, minimum : twice an hours');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (305, 'polymod', NOW(), 'Fréquence dans cet interval', 'Frequency in this interval');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (306, 'polymod', NOW(), 'Horaire', 'Hourly');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (307, 'polymod', NOW(), 'Quotidienne', 'Daily');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (308, 'polymod', NOW(), 'Hebdomadaire', 'Weekly');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (309, 'polymod', NOW(), 'Mensuelle', 'Monthly');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (310, 'polymod', NOW(), 'Annuelle', 'Yearly');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (311, 'polymod', NOW(), '<strong>Permet de faire un lien vers l\'un des fil RSS de l\'objet&nbsp; :<br />
</strong><br />
<span class="code">&lt;atm-function function=&quot;rss&quot; object=&quot;%s&quot; selected=&quot;<span class="keyword">rssId</span>&quot; attributeName=&quot;<span class="keyword">attributeValue</span>&quot;&gt;<br />
&nbsp;&nbsp;&nbsp; &lt;a href=&quot;<span class="vertclair">{url}</span>&quot; title=&quot;<span class="vertclair">{description}</span>&quot;&gt;<span class="vertclair">{label}</span>&lt;/a&gt;<br />
&lt;/atm-function&gt;</span><br />
Cette fonction permet d\'obtenir les informations concernant l\'un des fil RSS de l\'objet. Elle est usuellement utilis&eacute;e pour r&eacute;aliser un lien d\'abonnement vers ce fil RSS.<br />
<ul>
	<li><span class="keyword">rssId </span><strong>: </strong>Identifiant du fil RSS &agrave; selectionner parmis les suivants : %s</li>
	<li>L\'attribut <span class="keyword">attributeName </span>et sa valeur <span class="keyword">attributeValue </span>sont facultatifs. Ils permettent d\'ajouter un attribut et sa valeur &agrave; l\'adresse du fil RSS g&eacute;n&eacute;r&eacute; par la fonction. Vous pouvez mettre autant d\'attributs suppl&eacute;mentaires de cette fa&ccedil;on.</li>
	<li><span class="vertclair">{url}</span> sera remplac&eacute; par l\'adresse du fil RSS.</li>
	<li><span class="vertclair">{label}</span> sera remplac&eacute; par le libell&eacute; du fil RSS.</li>
	<li><span class="vertclair">{description}</span> sera remplac&eacute; par la description du fil RSS.</li>
</ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (312, 'polymod', NOW(), '<strong>Permet de charger un objet par son identifiant&nbsp; :<br />
<br />
</strong><span class="code">&lt;atm-function function=&quot;loadObject&quot; object=&quot;%s&quot; value=&quot;<span class="keyword">objectId</span>&quot;&gt;&lt;/atm-function&gt;</span><br />
Cette fonction permet de charger depuis la base de donn&eacute;e l\'objet correspondant &agrave; l\'identifiant fourni en param&egrave;tre. L\'objet ainsi charg&eacute; devient accessible m&ecirc;me en dehors d\'une recherche.<br />
<ul>
	<li><span class="keyword">objectId </span><strong>: </strong>Identifiant unique de l\'objet &agrave; charger.</li>
</ul>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (313, 'polymod', NOW(), '<div class="rowComment">
<h1>Bloc de donn&eacute;es d\'un fil RSS :</h1>
<span class="code">&lt;atm-rss language=&quot;<span class="keyword">languageCode</span>&quot;&gt;<br />
&nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-title&gt;</span> ... <span class="keyword">&lt;/atm-rss-title&gt;</span><br />
&nbsp;&nbsp;&nbsp; &lt;atm-search ...&gt;<br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; ...<br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &lt;atm-result ...&gt;<br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<span class="keyword"> &lt;atm-rss-item&gt;</span><br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-url&gt;</span>{page:id:url}?item={object:id}<span class="keyword">&lt;/atm-rss-item-url&gt; </span><br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-title&gt;</span> ... <span class="keyword">&lt;/atm-rss-item-title&gt;</span><br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-content&gt;</span> ... <span class="keyword">&lt;/atm-rss-item-content&gt;</span><br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-author&gt;</span> ... <span class="keyword">&lt;/atm-rss-item-author&gt;</span><br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-date&gt;</span> ... <span class="keyword">&lt;/atm-rss-item-date&gt;</span><br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;atm-rss-item-category&gt;</span> ... <span class="keyword">&lt;/atm-rss-item-category&gt;</span><br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <span class="keyword">&lt;/atm-rss-item&gt;</span><br />
&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &lt;/atm-result&gt;<br />
&nbsp;&nbsp;&nbsp; &lt;/atm-search&gt;<br />
&lt;/atm-rss&gt;</span><br />
<br />
Ce tag permet de cr&eacute;er un fil RSS &agrave; partir d\'objets r&eacute;pondant &agrave; une recherche.<br />
<ul>
	<li><strong><span class="keyword">languageCode </span></strong>: Code du langage relatif au contenu parmi les codes suivants : <strong><span class="vertclair">%s</span></strong>.</li>
</ul>
Le tag <span class="keyword">atm-rss</span> peut contenir un tag <span class="keyword">atm-rss-title</span> (facultatif) permettant de red&eacute;finir le titre du fil RSS. <br />
Le tag <span class="keyword">atm-rss</span><strong> </strong>doit contenir un sous tag <span class="keyword">atm-rss-item</span> lui m&ecirc;me devant &ecirc;tre dans un r&eacute;sultat d\'une recherche. Pour chaque &eacute;l&eacute;ment r&eacute;sultat de la recherche, ce tag permettra la cr&eacute;ation d\'un &eacute;l&eacute;ment correspondant dans le fil RSS.<br />
<br />
Le tag <span class="keyword">atm-rss-item</span> doit<strong> </strong>contenir les sous tags suivants :<br />
<ul>
	<li><span class="keyword">atm-rss-item-url</span><strong> :</strong> Tag obligatoire, il permet de sp&eacute;cifier l\'adresse internet source de l\'&eacute;l&eacute;ment du fil RSS (Les aggr&eacute;gateurs RSS s\'en servent pour cr&eacute;er un lien vers cet &eacute;l&eacute;ment sur votre site). Ce doit donc &ecirc;tre une adresse valide vers l\'&eacute;l&eacute;ment source. Un seul tag de ce type est permit dans chaque tag atm-rss-item.</li>
	<li><span class="keyword">atm-rss-item-title</span><strong> : </strong>Tag obligatoire, il permet de sp&eacute;cifier le nom de l\'&eacute;l&eacute;ment du fil RSS. Le code HTML n\'y est pas autoris&eacute;. Un seul tag de ce type est permit dans chaque tag atm-rss-item.</li>
	<li><span class="keyword">atm-rss-item-content</span><strong> : </strong>Tag obligatoire, il permet de sp&eacute;cifier le contenu de l\'&eacute;l&eacute;ment du fil RSS. Le code HTML y est autoris&eacute;. Un seul tag de ce type est permit dans chaque tag atm-rss-item.</li>
</ul>
Le tag <span class="keyword">atm-rss-item</span> peut<strong> </strong>contenir les sous tags suivants :<br />
<ul>
	<li><span class="keyword">atm-rss-item-author</span><strong> : </strong>Ce tag permet de sp&eacute;cifer l\'auteur de l\'&eacute;l&eacute;ment du fil RSS. Le code HTML n\'y est pas autoris&eacute;. Un seul tag de ce type est permit dans chaque tag atm-rss-item.</li>
	<li><span class="keyword">atm-rss-item-date</span><strong> :</strong> Ce tag permet de sp&eacute;cifer la date de cr&eacute;ation de l\'&eacute;l&eacute;ment du fil RSS. Le code HTML n\'y est pas autoris&eacute;. Un seul tag de ce type est permit dans chaque tag atm-rss-item. Pensez &agrave; employer le format <span class="vertclair">rss</span> si vous employez la valeur d\'un champ de type Date.</li>
	<li><span class="keyword">atm-rss-item-category</span><strong> :</strong> Ce tag permet de sp&eacute;cifer une le nom d\'une cat&eacute;gorie pour l\'&eacute;l&eacute;ment du fil RSS. Le code HTML n\'y est pas autoris&eacute;. Vous pouvez mettre plusieurs tags de ce type dans chaque tag atm-rss-item.</li>
</ul>
</div>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (314, 'polymod', NOW(), 'Utilisateurs', 'Users');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (315, 'polymod', NOW(), 'Groupes', 'Groups');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (316, 'polymod', NOW(), 'Tous les utilisateurs', 'All users');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (317, 'polymod', NOW(), 'Utilisateurs inclus/exclus', 'Included/excluded users');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (318, 'polymod', NOW(), 'Tous les groupes', 'All groups');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (319, 'polymod', NOW(), 'Groupes inclus/exclus', 'Included/excluded groups');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (320, 'polymod', NOW(), 'Inclusion', 'Inclusion');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (321, 'polymod', NOW(), 'Si ce paramètre est à :<br/>"oui" : seuls les utilisateurs/groupes sélectionnés sont affichés dans la liste déroulante du champs.<br/>"non" : les utilisateurs sélectionnés sont exclus de la liste déroulante du champs.', 'If this parameter is :<br/>"yes" : only selected users/groups are display in the selection box of the field.<br/>"no" : selected users are excluded of the selection box of the field.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (322, 'polymod', NOW(), 'Indexé dans le moteur de recherche', 'Indexed in search engine');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (323, 'polymod', NOW(), 'Langue', 'Language');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (324, 'polymod', NOW(), 'Langue de l\'objet. Créé une relation avec les langues disponibles sur le système. Nécessaire à l\'indexation correcte dans le moteur de recherche.', 'Language of the object. It create a relationship with system\'s languages. Needed for a correct indexation in search engine.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (325, 'polymod', NOW(), 'Indexé dans le moteur de recherche', 'Indexed in search engine');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (326, 'polymod', NOW(), 'Indexation', 'Indexation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (327, 'polymod', NOW(), 'Si cet objet appartient en tant que champs à un objet indexé, inutile de l\'indexer lui même', 'If this object belongs as a field to an indexed object, it is useless to index itself');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (328, 'polymod', NOW(), 'Adresse du lien vers l\'objet', 'Link address to the object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (329, 'polymod', NOW(), 'Cette adresse devra permettre d\'aller vers l\'objet à partir des résultats de recherche.', 'This address will have to make possible to go towards the object from the search results.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (330, 'polymod', NOW(), 'Indexer uniquement le dernier sous-objet', 'Index only the last sub-object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (331, 'polymod', NOW(), 'Cette option est utile pour le versioning d\'objets ou les versions antérieures ne doivent pas être indexées dans le moteur de recherche.', 'This option is usefull in case of object versioning which older versions does not need to be indexed');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (332, 'polymod', NOW(), 'Désactiver l\'association de sous-objets', 'Disactivate selection of sub-objets');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (333, 'polymod', NOW(), 'Cette option permet d\'empêcher l\'emploi de sous-objets crées en dehors de l\'objet principal. Elle n\'est utile que si l\'option "Ces objets peuvent être édités" est active.', 'This option avoid the use of objects which are not created inside the master object. It is usefull only if the option "These objects can be edited" is active.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (334, 'polymod', NOW(), 'Contourner les droits', 'Bypass rights');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (335, 'polymod', NOW(), 'Permet de ne pas tenir compte des droits de ces catégories pour les recherches', 'Do not use categories rights management for searching');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (336, 'polymod', NOW(), 'Notification par email', 'Notify by email');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (337, 'polymod', NOW(), 'Ce champs permet d\'envoyer une notification par email lors de la validation d\'un objet', 'This field allow email notification when object is validated');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (338, 'polymod', NOW(), 'Sujet de l\'email', 'Email subject');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (339, 'polymod', NOW(), 'Corps de l\'email', 'Email body');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (340, 'polymod', NOW(), 'Emission au choix', 'Choice for sending');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (341, 'polymod', NOW(), 'Hauteur de l\'éditeur', 'Editor height');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (342, 'polymod', NOW(), 'Largeur de l\'éditeur', 'Editor width');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (343, 'polymod', NOW(), 'Permet de choisir lors de l\'édition de l\'objet si l\'email doit être envoyé', 'Allow to choose if the email will be sent at object edition');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (344, 'polymod', NOW(), 'Inclure des fichiers', 'Include files');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (345, 'polymod', NOW(), 'Permet d\'inclure les fichiers de l\'objet en pièce jointe dans l\'email', 'Allow the inclusion as attachment of object files in the email');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (346, 'polymod', NOW(), 'Emetteur de l\'email', 'Email sender');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (347, 'polymod', NOW(), 'Permet de spécifier une adresse d\'emetteur pour l\'email. Si aucun, l\'adresse "postmaster" d\'Automne sera employée.', 'Allow usage of a specific email address for email sending. If none, "postmaster" Automne email will be used');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (348, 'polymod', NOW(), 'A la validation', 'On validation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (349, 'polymod', NOW(), 'Evènement système', 'System event');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (350, 'polymod', NOW(), 'Emission', 'Sending');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (351, 'polymod', NOW(), 'L\'email sera envoyé à la validation de l\'objet ou déclenché par un évènement système à spécifier (code PHP spécifique).', 'Email will be sent at validation or by a specified system event (specific PHP code).');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (352, 'polymod', NOW(), 'Syntaxe de la définition du sujet et du corps de l\'email', 'Syntax definition for the subject and body of the email');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (353, 'polymod', NOW(), 'Où choisir une page', 'Or choose a page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (354, 'polymod', NOW(), 'Code HTML', 'HTML code');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (355, 'polymod', NOW(), 'Dernier envoi', 'Last sending');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (356, 'polymod', NOW(), 'Jamais', 'Never');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (357, 'polymod', NOW(), 'Actif', 'Active');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (358, 'polymod', NOW(), 'Inactif', 'inactive');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (359, 'polymod', NOW(), 'Preparation des notifications par email', 'Prepare emails notifications');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (360, 'polymod', NOW(), 'Envoi d\'une notification email', 'Sending email notification');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (361, 'polymod', NOW(), 'Autoriser l\'association des inutilisées', 'Allow association of the unused ones');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (362, 'polymod', NOW(), 'Permet de sélectionner les catégories inutilisées dans les rangées', 'Allow association of the unused categories in rows');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (363, 'polymod', NOW(), 'Libellé des objets (séparés par des virgules, ou spécifiez un séparateur en paramètre)', 'Objects labels (comma separated or specify a separator in parameter)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (364, 'polymod', NOW(), 'Notification de validation en attente', 'Notification of awaiting validation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (365, 'polymod', NOW(), 'Notification de suppression en attente', 'Notification of deletion validation');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (366, 'polymod', NOW(), 'Champ requis (renvoie un booléen true ou false)', 'Required field (return a boolean true or false)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (367, 'polymod', NOW(), 'Catégorie par défaut', 'Default category');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (368, 'polymod', NOW(), 'Date de création de l\'objet', 'Creation date of the object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (369, 'polymod', NOW(), 'Décalage temporel', 'Time offset');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (370, 'polymod', NOW(), 'Si "Date du jour", "Date de création" ou "Date de mise à jour" est sélectionné, décaler la valeur de cette durée (Voir le <a href="http://www.php.net/manual/fr/function.strtotime.php" target="_blank" class="admin">format de la fonction strtotime</a>)', 'If "Current date", "Creation date" or "Update date" is selected, offset the date of this value (See the <a href="http://www.php.net/manual/en/function.strtotime.php" target="_blank" class="admin">function strtotime format</a>)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (371, 'polymod', NOW(), 'Date de mise à jour de l\'objet', 'Update date of the object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (372, 'polymod', NOW(), 'Format à respecter', 'Format to comply');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (373, 'polymod', NOW(), 'Ce champ vous permet de spécifier un format à respecter en utilisant une expression régulière PERL (<a href="http://www.php.net/manual/fr/reference.pcre.pattern.syntax.php" target="_blank" class="admin">voir l\'aide du format</a>)', 'This field allow you to specify a format to match using a PERL regular expression (<a href="http://www.php.net/manual/en/reference.pcre.pattern.syntax.php" target="_blank" class="admin">see format help</a>)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (374, 'polymod', NOW(), 'Extensions autorisées', 'Allowed extensions');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (375, 'polymod', NOW(), 'Séparées par une virgule', 'Comma separated');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (376, 'polymod', NOW(), 'Extensions interdites', 'Disallowed extensions');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (377, 'polymod', NOW(), 'Utilisateur créant l\'objet', 'User creating object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (378, 'polymod', NOW(), 'Opérateurs des filtres de recherche pour ce champ', 'Search filter operator for this field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (379, 'polymod', NOW(), 'Un opérateur permet de modifier le fonctionnement d\'un filtre (tag <span class="keyword">atm-search-param</span>) dans une recherche. Il s\'ajoute au filtre en ajoutant le paramètre <span class="keyword">operator</span> suivit de la valeur souhaitée au tag <span class="keyword">atm-search-param</span> proposant un filtre sur ce champ. Les valeurs suivantes sont possibles :', 'An operator can modify the operation of a filter (tag <span class="keyword">atm-search-param</span>) in a search. It added to the filter by adding the <span class="keyword">operator</span> parameter followed by the desired value to tag <span class="keyword">atm-search-param</span> proposing a filter on that field. Following values are available:');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (380, 'polymod', NOW(), '<br/><span class="keyword">&gt;=</span> : supérieur ou égal<br/><span class="keyword">&lt;=</span> : inférieur ou égal<br/><span class="keyword">&lt;</span> : inférieur<br/><span class="keyword">&gt;</span> : supérieur<br/><span class="keyword">&gt;= or null</span> : supérieur ou égal ou nul<br/><span class="keyword">&lt;= or null</span> : inférieur ou égal ou nul<br/><span class="keyword">&lt; or null</span> : inférieur ou nul<br/><span class="keyword">&gt; or null</span> : supérieur ou nul<br/><span class="keyword">&gt;= and not null</span> : (supérieur ou égal) et non nul<br/><span class="keyword">&lt;= and not null</span> : (inférieur ou égal) et non nul<br/><span class="keyword">&lt; and not null</span> : inférieur et non nul<br/><span class="keyword">&gt; and not null</span> : supérieur et non nul', '<br/><span class="keyword">&gt;=</span> : greater or equal<br/><span class="keyword">&lt;=</span> : lower or equal<br/><span class="keyword">&lt;</span> : lower<br/><span class="keyword">&gt;</span> : greater<br/><span class="keyword">&gt;= or null</span> : greater or equal or null<br/><span class="keyword">&lt;= or null</span> : lower or equal or null<br/><span class="keyword">&lt; or null</span> : lower or null<br/><span class="keyword">&gt; or null</span> : greater or null<br/><span class="keyword">&gt;= and not null</span> : (greater or equal) and not null<br/><span class="keyword">&lt;= and not null</span> : (lower or equal) and not null<br/><span class="keyword">&lt; and not null</span> : lower and not null<br/><span class="keyword">&gt; and not null</span> : greater and not null');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (381, 'polymod', NOW(), 'Ne recherche que les objets associés à la catégorie en paramètre (les sous-catégories ne sont plus prises en compte)', 'Search only objects associated to the category in parameter (sub-categories are not used)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (382, 'polymod', NOW(), 'Tags de formulaires (création - modification)', 'Forms tags (create - edit)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (383, 'polymod', NOW(), '<div class="rowComment">
<h1>Cr&eacute;ation modification d\'objets cot&eacute; client :</h1>
<p><span class="code">&lt;atm-form what=&quot;<span class="keyword">objet</span>&quot; name=&quot;<span class="keyword">formName</span>&quot;&gt; ... &lt;/atm-form&gt;</span><br />
Ce tag permet de cr&eacute;er un formulaire de saisie pour un nouvel objet (si ce tag n\'est pas dans un r&eacute;sultat de recherche) ou de modification pour un objet existsnat (si ce tag se trouve dans un r&eacute;sultat de recherche.</p>
<ul>
	<li><span class="keyword">objet</span> : Type d\'objet &agrave; saisir (de la forme <span class="vertclair">{<span class="keyword">objet</span>}</span>)</li>
	<li><span class="keyword">formName</span> : Nom du formulaire : identifiant unique pour le formulaire dans la rang&eacute;e.</li>
</ul>
Les valeurs suivantes seront remplac&eacute;es dans le tag :
<ul>
	<li><span class="vertclair">{filled}</span> : Vrai si le formulaire a &eacute;t&eacute; correctement rempli et que sa validation n\'a provoqu&eacute; aucune erreur.</li>
	<li><span class="vertclair">{required}</span> : Vrai si le formulaire n\'a pas &eacute;t&eacute; correctement rempli et que des champs requis ont &eacute;t&eacute; laiss&eacute;s vides.</li>
	<li><span class="vertclair">{malformed}</span> : Vrai si le formulaire n\'a pas &eacute;t&eacute; correctement rempli et que les values de certains champs sont incorrectes.</li>
</ul>
<h2>Ce tag peut contenir les sous-tags suivants :</h2>
<div class="retrait">
<h3>Affichage des champs requis :</h3>
<div class="retrait"><span class="code">&lt;atm-form-required form=&quot;<span class="keyword">formName</span>&quot;&gt;<br />
&nbsp;&nbsp;&nbsp; ... <span class="vertclair">{requiredname}</span> ...<br />
&lt;/atm-form-required&gt;</span><br />
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
<div class="retrait"><span class="code">&lt;atm-form-malformed form=&quot;<span class="keyword">formName</span>&quot;&gt;<br />
&nbsp;&nbsp;&nbsp; ... <span class="vertclair">{malformedname}</span> ...<br />
&lt;/atm-form-malformed&gt;</span><br />
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
<h3>Affichage d\'un champ de saisie :</h3>
<div class="retrait"><span class="code">&lt;atm-input field=&quot;<span class="keyword">{objet:champ}</span>&quot; form=&quot;<span class="keyword">formName</span>&quot; /&gt;</span><br />
Ce tag sera remplac&eacute; par la zone de saisie (champ de formulaire) n&eacute;cessaire &agrave; la saisie correcte des informations relatives au type du champ sp&eacute;cifi&eacute;.<br />
<ul>
	<li><span class="keyword">formName</span> : Nom du formulaire sur lequel appliquer le tag.</li>
	<li><span class="keyword">{objet:champ}</span> : Champ de l\'objet g&eacute;r&eacute; par le formulaire sur lequel la saisie doit &ecirc;tre effectu&eacute;e.</li>
</ul>
<p>Ce tag peut ensuite avoir tout une suite d\'attributs html qui seront repost&eacute;s sur le code HTML du champ g&eacute;n&eacute;r&eacute; (<span class="vertclair">width, height, id, class, etc.</span>).</p>
</div>
</div>
</div>', 'TODO');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (384, 'polymod', NOW(), 'Booléen', 'Boolean'); 
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (385, 'polymod', NOW(), 'Permet spécifier un état (oui - non)', 'Choose a state (yes - no)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (386, 'polymod', NOW(), 'Libellé de la catégorie', 'Category label');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (387, 'polymod', NOW(), 'Identifiant des utilisateur/groupe du champ', 'User/group IDs of the field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (388, 'polymod', NOW(), 'Si ce paramètre est à :<br/>"oui" : seuls les utilisateurs/groupes sélectionnés ci-dessous recevront les notifications.<br/>"non" : les utilisateurs/groupes sélectionnés ci-dessous sont exclus de la reception des notifications.', 'If this parameter is :<br/>"yes" : only selected users/groups below will receive notifications.<br/>"no" : selected users/groups below are excluded of the notifications.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (389, 'polymod', NOW(), 'Permet de faire une recherche sur une valeur incomplète. Utilisez le caractère % pour spécifier la partie inconnue. Par exemple, "cha%" retournera "chat", "chameau", etc.', 'Allow the research on incomplete value. Use the caracter % for the unkown part. For example, "ca%" will return "cat", "car", etc.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (390, 'polymod', NOW(), 'Les valeurs suivantes sont possibles','Following values are available'); 
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (391, 'polymod', NOW(), 'Opérateurs des champs de saisie pour ce champ', 'Input field operators for this field');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (392, 'polymod', NOW(), 'Un opérateur permet de modifier l\'affichage d\'un champ (<span class="keyword">atm-input</span>) dans un formulaire (<span class="keyword">atm-form</span>). Il s\'ajoute au tag <span class="keyword">atm-input</span> en ajoutant le paramètre <span class="keyword">operator</span> suivi de la valeur souhaitée. Les valeurs suivantes sont possibles :','An operator can modify the display of a field (tag <span class="keyword">atm-input</span>) in a form (tag <span class="keyword">atm-form</span>). It added to the tag <span class="keyword">atm-input</span> by adding the <span class="keyword">operator</span> parameter followed by the desired value. Following values are available:'); 
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (393, 'polymod', NOW(), 'Affiche uniquement les sous catégories de la racine spécifiée','Display only sub categories of the specified root category'); 
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (394, 'polymod', NOW(), 'Comparaison numérique de deux champs numériques flottant.', 'Numeric comparison between two float fields.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (395, 'polymod', NOW(), 'La valeur du champ peut-être un nombre négatif', 'Field value can be negative');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (396, 'polymod', NOW(), 'Nombre flottant (à virgule)', 'Float number');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (397, 'polymod', NOW(), 'Chaîne contenant un nombre à virgule (255 caractères maximum).', 'String containing a float number (255 characters maximum).');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (398, 'polymod', NOW(), 'Ensemble des IDs des objets de type \'%s\' associés à ce  champ.', 'All IDs of objects of type \'%s\' associated to this field.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (399, 'polymod', NOW(), 'Largeur des boîtes de sélection (pixels)', 'Select boxes width (pixels)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (400, 'polymod', NOW(), 'Hauteur des boîtes de sélection (pixels)', 'Select boxes height (pixels)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (401, 'polymod', NOW(), 'Uniquement dans le cas de catégories multiples. 300x200 par défaut.', 'Only if multi-categories. Default 300x200.');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (402, 'polymod', NOW(), 'Description du champ : \'%s\'', 'Field description: \'%s\'');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (403, 'polymod', NOW(), 'Ordre de création', 'Creation order');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (404, 'polymod', NOW(), 'Début de publication', 'Publication date start');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (405, 'polymod', NOW(), 'Trier par', 'Sort by');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (406, 'polymod', NOW(), 'Page', 'Page');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (407, 'polymod', NOW(), 'Permet de choisir une page Automne', 'Permit to choose an Automne page');

INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (409, 'polymod', NOW(), 'Largeur de la vignette dans les résultats de la recherche', 'Thumbnail width in search results list');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (410, 'polymod', NOW(), '(largeur de l\'image dans la liste des résultats, si elle est visible dans les résultats de la recherche) ', '(only if image is visible in search results)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (411, 'polymod', NOW(), 'Retourne vrai (true) si ce champ possède une valeur', 'Retrun true if this field has a value set');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (412, 'polymod', NOW(), '(Si la vignette dépasse cette hauteur elle sera redimensionnée)', '(If the thumbnail exceeds this width it will be resized)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (413, 'polymod', NOW(), 'Hauteur maximum de l\'image en pixels', 'Image maximum height in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (414, 'polymod', NOW(), 'Hauteur maximum de la vignette en pixels', 'Thumbnail maximum height in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (415, 'polymod', NOW(), '(Sera redimensionnée à %s pixels de hauteur)', '(Will be resized to %s pixels height)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (416, 'polymod', NOW(), '(Sera redimensionnée à %s pixels de largeur et %s  pixels de hauteur)', '(Will be resized to %s pixels width and %s pixels height)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (417, 'polymod', NOW(), 'Unité', 'Unit');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (418, 'polymod', NOW(), '(Sera affichée à côté de la valeur)', '(Will be display front of value)');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (419, 'polymod', NOW(), 'Unité : "%s"', 'Unit : "%s"');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (420, 'polymod', NOW(), 'Affichage des résultats côté admin', 'Backoffice search results display');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (421, 'polymod', NOW(), 'Syntaxe pour l\'objet "%s"', 'Syntax for "%s" object');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (422, 'polymod', NOW(), 'Recherchable', 'Searchable');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (423, 'polymod', NOW(), 'Hauteur maximum de la vignette en pixels', 'Maximum height of the thumbnail in pixels');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (424, 'polymod', NOW(), 'Indexé', 'Indexed');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (425, 'polymod', NOW(), 'Largeur de la fenêtre popup', 'Popup window width');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (426, 'polymod', NOW(), 'Hauteur de la fenêtre popup', 'Popup window height');
INSERT INTO `I18NM_messages` (`id`, `module`, `timestamp`, `fr`, `en`) VALUES (427, 'polymod', NOW(), 'message(s) envoyé(s)', 'message(s) sent');

#V4 labels starts to id 500