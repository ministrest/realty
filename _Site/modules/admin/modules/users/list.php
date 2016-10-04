<section class="content-header">
	<h1>Пользователи</h1>
	<ol class="breadcrumb">
		<li><a href="/admin/"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li class="active">Пользователи</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-body table-responsive no-padding">
					<table id="users_tbl" class="table table-hover">
						<thead>
							<tr>
								<th>Логин</th>
								<th>Email</th>
								<th>Группа</th>
								<th>Дата создания</th>
								<th width="30px"></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($users->find(array(),array('order'=>'login')) as $user): ?>
							<tr>
								<td><a href="/admin/users/edit/<?=$user->id_user?>"><?=$user->login?></a></td>
								<td><a href="/admin/users/edit/<?=$user->id_user?>"><?=$user->email?></a></td>
								<td><?=$user->getGroup($user->id_group)?></td>
								<td><?=date('d/m/Y', strtotime($user->created))?></td>
								<td>
									<?php if ($user_group!=4): ?>
									<a href="/admin/users/delete/<?=$user->id_user?>" onclick="return confirm('Вы уверены, что хотите удалить пользователя?')"><i class="fa fa-trash"></i></a>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
<script src="<?= $f3->get("homeurl") ?>/inc/jscss/admin/plugins/datatable/datatable.min.js"></script>
<script>
	$(document).ready(function(){
		$('#users_tbl').DataTable();
	});
</script>