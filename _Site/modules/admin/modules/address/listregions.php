<section class="content-header">
	<h1>Регионы</h1>
	<ol class="breadcrumb">
		<li><a href="/admin/"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li class="active">Регионы</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-8">
			<div class="box">
				<div class="box-body table-responsive no-padding">
					<table id="regions_tbl" class="table table-hover">
						<thead>

						<tr>
							<th>ID</th>
							<th>Регион</th>
							<th width="30px"></th>
						</tr>
						</thead>
						<tbody>
						<?php foreach($regions->find(array(),array('order'=>'region_name')) as $region): ?>
							<tr>
								<td><a href="/admin/address/editregion/<?=$region->id_region?>"><?=$region->id_region?></a></td>
								<td><?=$region->region_name;?></td>
								<td>
							<?php if ($user_group!=4): ?>
									<a href="/admin/address/deleteregion/<?=$region->id_region?>" onclick="return confirm('Вы уверены, что хотите удалить регион?')"><i class="fa fa-trash"></i></a>
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
						<a href="<?= $f3->get("homeurl") ?>/admin/address/addregion" class="form-control btn btn-primary"> Добавить регион</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</section>
<script src="<?= $f3->get("homeurl") ?>/inc/jscss/admin/plugins/datatable/datatable.min.js"></script>
<script>
	$(document).ready(function(){
		$('#regions_tbl').DataTable();
	});
</script>