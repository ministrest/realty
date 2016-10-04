<section class="content-header">
	<h1>Улицы</h1>
	<ol class="breadcrumb">
		<li><a href="/admin/"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li class="active">Улицы</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-8">
			<div class="box">
				<div class="box-body table-responsive no-padding">
					<table id="streets_tbl" class="table table-hover">
						<thead>
						<tr>
							<th>ID</th>
							<th>Город</th>
							<th>Улица</th>
							<th width="30px"></th>
						</tr>
						</thead>
						<tbody>
						<?php foreach($streets->find(array(),array('order'=>'street_name')) as $street): ?>
							<tr>
								<td><a href="/admin/address/editstreet/<?=$street->id_street?>"><?=$street->id_street?></a></td>
								<td><?=$localities->getAttribute($street->id_locality, 'locality_name');?></td>
								<td><?=$street->street_name;?></td>
								<td>
									<?php if ($user_group!=4): ?>
									<a href="/admin/address/deletestreet/<?=$street->id_street?>" onclick="return confirm('Вы уверены, что хотите удалить улицу?')"><i class="fa fa-trash"></i></a>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-3">
			<div class="box">
				<div class="box-body">
					<p>
						<a href="<?= $f3->get("homeurl") ?>/admin/address/addstreet" class="form-control btn btn-primary"> Добавить улицу</a>
					</p>

					<p>
						<a href="<?= $f3->get("homeurl") ?>/admin/address/addlocality" class="form-control btn btn-primary"> Добавить город</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</section>
<script src="<?= $f3->get("homeurl") ?>/inc/jscss/admin/plugins/datatable/datatable.min.js"></script>
<script>
	$(document).ready(function(){
		$('#streets_tbl').DataTable();
	});
</script>