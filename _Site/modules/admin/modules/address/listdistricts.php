<section class="content-header">
	<h1>Муниципальные районы</h1>
	<ol class="breadcrumb">
		<li><a href="/admin/"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li class="active">Муниципальные районы</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-8">
			<div class="box">
				<div class="box-body table-responsive no-padding">
					<table id="districts_tbl" class="table table-hover">
						<thead>
						<tr>
							<th>ID</th>
							<th>Регион</th>
							<th>Муниципальный район</th>
							<th width="30px"></th>
						</tr>
						</thead>
						<tbody>
						<?php foreach($districts->find(array(),array('order'=>'district_name')) as $district): ?>
							<tr>
								<td><a href="/admin/address/editdistrict/<?=$district->id_district?>"><?=$district->id_district?></a></td>
								<td><?=$regions->getAttribute($district->id_region, 'region_name');?></td>
								<td><?=$district->district_name;?></td>
								<td>
									<?php if ($user_group!=4): ?>
									<a href="/admin/address/deletedistrict/<?=$district->id_district?>" onclick="return confirm('Вы уверены, что хотите удалить район?')"><i class="fa fa-trash"></i></a>
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
		$('#districts_tbl').DataTable();
	});
</script>