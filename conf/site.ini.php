;<?php die();?>
[cache]
enabled=0
;temps de validite du cache exprime en secondes
lifetime=0
class=_cache

[cacheVar]
class=_cacheVar

[encodage]
;indique l'encodage des fichiers de code, utilise pour la protection des tableaux de contexte ($_GET,$_POST)
charset=UTF-8
;indique si le framework encode en html le code deja en html
double_encode=0

[debug]
class=plugin_debugError
bar.open=0

[language]
;fr / en... //sLangue
default=fr
allow=fr,en

[auth]
;note : >= php5.2 dans le php.ini
session.use_cookies = 1
session.use_only_cookies = 1
session.cookie_httponly=1
session.cookie_secure=0
session.cookie_domain=
session.cookie_path=
session.cookie_lifetime=
enabled=1
class=plugin_auth
module=login::login
;liste des modules non concerne par l'auth: separe par des virgules
module.disabled.list=externalview
;timeout d'inactivite (entre 2 pages), temps en secondes
session.timeout.enabled=0
session.timeout.lifetime=1800

[acl]
class=plugin_gestionuser

[module]
folder.organized=1

[navigation]
scriptname=index.php
var=:nav
module.default=welcome
action.default=index
layout.erreur=../layout/erreurprod.php

[urlrewriting]
enabled=0
class=plugin_routing
conf=../conf/routing.php
use4O4=0

[security]
;XSRF ou CSRF,bSecuriteXSRF utilisation de jeton dans le CRUD, plus d'infos: http://fr.wikipedia.org/wiki/Cross-Site_Request_Forgeries
;XSS, bSecuriteXSS protection des variables GET,POST... via getParam( , plus d'infos http://fr.wikipedia.org/wiki/XSS
xsrf.enabled=1
xsrf.timeout.lifetime=360
xsrf.checkReferer.enabled=1
xsrf.session.enabled=0
xss.getParam.enabled=0
xss.model.enabled=1
xss.model.function=customHtmlentities

[log]
class=plugin_log
error=0
warning=0
application=1
information=0
file.enabled=1
apache.enabled=1

[check]
class=plugin_check

[site]
timezone=Europe/Paris

[model]
ini.var=db

[pdo]
;Plus d'informations ici: http://www.php.net//manual/fr/pdo.setattribute.php
;SILENT,WARNING,EXCEPTION
ATTR_ERRMODE=WARNING
;LOWER,NATURAL,UPPER
ATTR_CASE=NATURAL
