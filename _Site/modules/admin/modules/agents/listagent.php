<section class="content-header">
	<h1>Агенты</h1>
	<ol class="breadcrumb">
		<li><a href="/admin/"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li class="active">Агенты</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-body table-responsive no-padding">
					<table id="agents_tbl" class="table table-hover">
						<thead>
							<tr>
								<th>Имя</th>
								<th>Телефон</th>
								<th>Доп. номер</th>
								<th>Логин</th>
								<th>День рождения</th>
								<th width="30px"></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($agents->find(array(),array('order'=>'name')) as $agent): ?>
							<tr>
								<td><a href="/admin/agents/editagent/<?=$agent->id_sales_agent?>"><?=$agent->name?></a></td>
								<td><a href="/admin/agents/editagent/<?=$agent->id_sales_agent?>"><?=$agent->formatPhone($agent->phone)?></a></td>
								<td><?php if (isset($agent->additional_number)){?><a href="/admin/agents/editagent/<?=$agent->id_sales_agent?>"><?=$agent->formatPhone($agent->additional_number)?></a><?php } ?></td>
								<td><?php $user = $agent->getUser();
									echo $user->login;
									?></td>
								<td><?=date('d/m/Y', strtotime($agent->birthday))?></td>
								<td><a href="/admin/agents/deleteagent/<?=$agent->id_sales_agent?>"
									   onclick="return confirm('Вы уверены, что хотите удалить агента?')">
										<i class="fa fa-trash"></i></a></td>
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
		$('#agents_tbl').DataTable();
	});
</script>