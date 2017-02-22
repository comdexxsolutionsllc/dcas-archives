<?php
/* fr-keywords for class.autokeyword.php */

//assuming that your site contents is from a database.
//set the outbase of the database to $data.
header('Content-type: text/html; charset=utf-8');

$data = "Le plus haut niveau de sécurité pour l'authentification et la distribution électronique de logiciels.
Marx Software Security est conforme aux nouveaux standards ITSEC E6 pour les solutions de sécurité.

Wackerstein/Allemagne, Février 2005. Marx Software Security a présenté sa version innovante de la clé Cryptoken а la foire du CeBIT (hall 7, booth B19). Le système d'exploitation de carte а puce intègré MULTOS permet а la clé USB de se doter du plus haut niveau de sécurité ITSEC E6. En plus de CrypToken, Marx présentera deux nouvelles solutions de sécurité pour la distribution éléctronique de logiciels  ESD (Electronic Software Distribution). La plateforme d'applications Smarx OS offre une interface graphique facile а maintenir et qui constitue, pour les développeurs et les distributeurs de logiciels, un outil efficace de contrôle d'authentification, d'autorisation, et d'administration de licences logicielles. La deuxième composante du noueau pack MARX ESD est le Système de Management de Mise а Jour а Distance RUMS (Remote Update Management System). Cela permet une mise а jour rapide et facile de logiciels par Internet.
La nouvelle CrypToken offre, en plus du PKCS#11 et du Microsoft CAPI, le système d'exploitation de carte а puce ouvert et multi-applications MULTOS. Ce dernier est certifié selon le plus haut niveau de sécurité des applications de carte а puce, le ITSEC E6. Il supporte les interfaces qui permettent а l'industrie de la sécurité, aux intégrateurs systèmes ou aux VARs, d'intégrer une clé au sein des environnements de sécurité existants et des applications de sécurité. Cette clé permet de valider plusieurs applications grвce а l'authentification multi-facteurs. La clé USB CrypToken est livrée dans un boitier métallique robuste avec un microprocesseur cryptographique embarqué. Celui-ci génère et mémorise en dur le cryptage et décodage RSA standard. Il peut être utilisé aussi bien dans les PKI (Public Key infrastructures) que dans les réseaux virtuels privés VPN (Virtual Private Networks) pour des signatures numériques, le cryptage d'email et les applications eBusiness.

Distribution de logiciels efficace et fiable via Internet
Marx Software Security présentera au CeBIT une autre nouvelle solution de sécurité: la plateforme d'application Smarx OS. Il offre aux fabricants et distributeurs de logiciels un pack de sécurité intégrée qui contrôle toute les licences des utilisateurs finaux. Il est fourni avec un système de base de données qui permet l'administration et la maintenance de toutes les données clients imortantes, y compris la version des licences ou les informations sur l'état des mises а jour. Avec ce système de distribution fiable, les fabricants et les distributeurs de licences peuvent mesurer le temps d'utilisation, lancer des fonctions optionnelles, ou augmenter le nombre de stations de travail authorisées au sein d'un réseau. L'interface d'utilisateur graphique de la plateforme d'applications SmarxOS est facile а implémenter, permet une distribution efficace, et constitue un outil de contrôle pour tous les besoins en licences de logiciels. Les requêtes clients pour les mises а jour de logiciels peuvent être traitées rapidement et facilement en ligne grвce au nouveau Système de Management de Mise а Jour а Distance RUMS (Remote Update Management System). Le distributeur de licences enverra un code d'activation au client pour rallonger le temps d'utilisation de l'application logicielle, ou pour donner l'accès а des fonctions optionnelles du programme, ou pour ajouter de nouvelles stations de travail.
A propos de Marx Software Security

Marx Software Security GmbH fournit le système Crypto-Box, un pack de distribution électronique de logiciels mondialement reconnu. Marx permet non seulement une protection de logiciels et de management et d'activation des licences, mais aussi des solutions de sécurité pour la publication numérique, la sécurité du Web, et le cryptage en temps réel de fichiers et flux Audio-/Video. CryptoTech, la nouvelle division de Marx, distribue la clé USB CrypToken. Cette dernière permet le cryptage et le stockage fiables de données ainsi qu'une authentification efficace avec des signatures numériques, des PKI (public key infrastructures), des systèmes de contrôle d'accès, et des applications e-business.
Au fil des années, Marx Software Security a développé un grand nombre de solutions de sécurité spécifiques pour diverse industries. Les clients de MARX sont, entre autre, Siemens, Kodak, Fuji Film, la Bourse de Paris, Michelin, Deutsche Telekom, des départements gouvernementaux et des administrations publiques. Pour de plus amples informations sur les différentes divisions de Marx ou leurs produits, vous êtes invités а vous rendre sur www.marx.com ou www.cryptotech.com. ";

echo "<H1>Input - text</H1>";
echo $data;

//this the actual application.
include('class.autokeyword.php');

$params['content'] = $data; //page content
//set the length of keywords you like
$params['min_word_length'] = 5;  //minimum length of single words
$params['min_word_occur'] = 2;  //minimum occur of single words

$params['min_2words_length'] = 3;  //minimum length of words for 2 word phrases
$params['min_2words_phrase_length'] = 10; //minimum length of 2 word phrases
$params['min_2words_phrase_occur'] = 2; //minimum occur of 2 words phrase

$params['min_3words_length'] = 3;  //minimum length of words for 3 word phrases
$params['min_3words_phrase_length'] = 10; //minimum length of 3 word phrases
$params['min_3words_phrase_occur'] = 2; //minimum occur of 3 words phrase

$keyword = new autokeyword($params, "UTF-8");

echo "<H1>Output - keywords</H1>";
//echo $keyword->get_keywords();
echo "<H2>words</H2>";
echo $keyword->parse_words();
echo "<H2>2 words phrase</H2>";
echo $keyword->parse_2words();
echo "<H2>2 words phrase</H2>";
echo $keyword->parse_3words();

echo "<H2>All together</H2>";
echo $keyword->get_keywords();

?>
