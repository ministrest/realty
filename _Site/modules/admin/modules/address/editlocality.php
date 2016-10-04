<?php
$action = '/admin/address/editlocality/'.$params['param'];
?>
<section class="content-header">
	<h1>Редактирование города</h1>
	<ol class="breadcrumb">
		<li><a href="/admin/"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li><a href="/admin/users">Адреса</a></li>
		<li class="active">Редактирование городов</li>
	</ol>
</section>
<?php include('_form_locality.php');?>
