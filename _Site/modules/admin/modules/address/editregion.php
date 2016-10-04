<?php
$action = '/admin/address/editregion/'.$params['param'];
?>
<section class="content-header">
	<h1>Редактирование региона</h1>
	<ol class="breadcrumb">
		<li><a href="/admin/"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li><a href="/admin/users">Адреса</a></li>
		<li class="active">Редактирование регионов</li>
	</ol>
</section>
<?php include('_form_region.php');?>
