<?php

include_once('tbs_class.php');
include_once('param.php');

$connect=mysql_connect($mysql_host,$mysql_user,$mysql_passwd);
mysql_select_db($mysql_base,$connect);

$TBS=new clsTinyButStrong;

if(isset($_GET['liste'])){

	
	$TBS->LoadTemplate('liste.html');
	
	$sql="select art_articles.id_articles, nom_articles, desc_articles, desc_type_article, numero, date_numero, url_couverture, ";
	$sql=$sql." nom_magazine from art_articles, art_magazine, art_numero, art_type_article  "; 
	switch($_GET['liste'])
	{
		case 'marques':
			$sql=$sql.", art_marques_articles where art_marques_articles.id_articles=art_articles.id_articles and art_marques_articles.id_marques=".$_GET['id']." and ";
			break;
			

		case 'machines':
			$sql=$sql.", art_machines_articles where art_machines_articles.id_articles=art_articles.id_articles and art_machines_articles.id_machines=".$_GET['id']." and ";
			break;

		case 'magazines':
			$sql=$sql." where art_magazine.id_magazine=".$_GET['id']." and ";
			break;

		case 'numero':
			$sql=$sql." where art_numero.id_numero=".$_GET['id']." and ";
			break;

		default:
			$sql=$sql." where ";
			break;
	}

	$sql=$sql." art_articles.id_numero=art_numero.id_numero and art_numero.id_magazine=art_magazine.id_magazine";
 	$sql=$sql." and art_articles.id_type_article=art_type_article.id_type_article order by nom_magazine, date_numero";
	$TBS->MergeBlock('lstArticles',$connect,$sql);

	//print $sql;	
	
}
elseif(isset($_GET['articles'])){
	$TBS->LoadTemplate('article.html');
	
	$sql="select nom_articles, desc_articles, numero, date_numero, url_couverture, ";
	$sql=$sql." nom_magazine from art_articles, art_magazine, art_numero, art_type_article  "; 
	$sql=$sql." where art_articles.id_numero=art_numero.id_numero and art_numero.id_magazine=art_magazine.id_magazine";
 	$sql=$sql." and art_articles.id_articles=".$_GET['articles'];

	$TBS->MergeBlock('descArticles',$connect,$sql);

	$TBS->MergeBlock('lstPages',$connect,'select * from art_pages where id_articles='.$_GET['articles'].' order by nom_pages');
	
}
else
{

	$TBS->LoadTemplate('pageprinc.html');
	$TBS->MergeBlock('lstMarques',$connect,'select art_marques.id_marques, nom_marques, id_machines, nom_machines from art_marques, art_machines where art_machines.id_marques=art_marques.id_marques order by nom_marques, nom_machines');

	$TBS->MergeBlock('lstMagazines',$connect,'select art_magazine.id_magazine, nom_magazine,id_numero, numero, date_numero from art_numero, art_magazine where art_magazine.id_magazine=art_numero.id_magazine order by nom_magazine, numero');

}
$TBS->Show();

mysql_close($connect);

?>
