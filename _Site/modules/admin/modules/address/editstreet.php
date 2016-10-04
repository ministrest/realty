<?php
$action = '/admin/address/editstreet/'.$params['param'];
?>
<section class="content-header">
	<h1>Редактирование улицы</h1>
	<ol class="breadcrumb">
		<li><a href="/admin/"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li><a href="/admin/users">Адреса</a></li>
		<li class="active">Редактирование улиц</li>
	</ol>
</section>
<?php include('_form_street.php');?>
