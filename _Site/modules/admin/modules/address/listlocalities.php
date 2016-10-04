<section class="content-header">
	<h1>Города</h1>
	<ol class="breadcrumb">
		<li><a href="/admin/"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li class="active">Города</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-8">
			<div class="box">
				<div class="box-body table-responsive no-padding">
					<table id="localities_tbl" class="table table-hover">
						<thead>
						<tr>
							<th>ID</th>
							<th>Муниципальный район</th>
							<th>Населённый пункт</th>
							<th width="30px"></th>
						</tr>
						</thead>
						<tbody>
						<?php foreach($localities->find() as $locality): ?>
							<tr>
								<td><a href="/admin/address/editlocality/<?=$locality->id_locality?>"><?=$locality->id_locality?></a></td>
								<td><?=$districts->getAttribute($locality->id_district, 'district_name');?></td>
								<td><?=$locality->locality_name;?></td>
								<td>
							<?php if ($user_group!=4): ?>
									<a href="/admin/address/deletelocality/<?=$locality->id_locality?>" onclick="return confirm('Вы уверены, что хотите удалить город?')"><i class="fa fa-trash"></i></a>
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
						<a href="<?= $f3->get("homeurl") ?>/admin/address/addlocality" class="form-control btn btn-primary"> Добавить город</a>
					</p>
					<p>
						<a href="<?= $f3->get("homeurl") ?>/admin/address/adddistrict" class="form-control btn btn-primary"> Добавить муниц.район</a>
					</p>

				</div>
			</div>
		</div>
	</div>
</section>
<script src="<?= $f3->get("homeurl") ?>/inc/jscss/admin/plugins/datatable/datatable.min.js"></script>
<script>
	$(document).ready(function(){
		$('#localities_tbl').DataTable();
	});
</script>