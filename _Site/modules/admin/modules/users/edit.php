<?php
$action = '/admin/users/edit/'.$params['param'];
?>
<section class="content-header">
	<h1>Редактирование пользователя</h1>
	<ol class="breadcrumb">
		<li><a href="/admin/"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li><a href="/admin/users">Пользователи</a></li>
		<li class="active">Редактирование пользователя</li>
	</ol>
</section>
<?php include('_form.php');?>
