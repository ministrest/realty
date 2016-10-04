<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?=$this->description?>">
	<meta name="keywords" content="<?=$this->keywords?>">
	<link rel="shortcut icon" sizes="16x16 24x24 32x32 48x48 64x64" src="/favicon.ico">
	<title><?= isset($this->pageTitle)?$this->pageTitle:''?><?=$this->title?></title>
	<meta property="og:title" content="Агентство недвижимости Goodman"/>
	<meta property="og:type" content="article"/>
	<meta property="og:url" content="http://gman.su"/>
	<meta property="og:image" content="/inc/i/img-og-logo.jpg"/>
	<meta property="og:description" content="Хорошие сделки для хороших людей. Широкий спектр услуг на вторичном рынке при продаже, покупке и аренде недвижимости."/>
	<?php foreach($this->css as $path) { ?>
		<link href="<?= $path ?>" rel="stylesheet" />
	<?php } ?>
	<?php foreach($this->js as $path) { ?>
		<script src="<?= $path; ?>"></script>
	<?php } ?>
	<!-- ToTop -->
	<script src="/inc/jscss/totop.js"></script>
</head>