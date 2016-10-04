<section class="content-header">
	<h1>Здания</h1>
	<ol class="breadcrumb">
		<li><a href="/admin/"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li class="active">Здания</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-body table-responsive no-padding">
					<table id="buildings_tbl" class="table table-hover">
						<thead>
						<tr>
							<th>ID</th>
							<th>Адрес</th>
							<th>Стадия</th>
							<th>Тип дома</th>
							<th>Год</th>
							<th width="30px"></th>
						</tr>
						</thead>
						<tbody>
						<?php foreach($building->find() as $building_): ?>
							<tr>
								<td><a href="/admin/buildings/edit/<?=$building_->id_building?>"><?=$building_->id_building?></a></td>
								<td><?php
									$address = $addresses->findByPk($building_->id_address);
									if(isset($address)) {
										echo $address[0]->getAddress();
									} else {
										echo "Адрес не задан";
									}
									?></td>
								<td><?=$building_states->getAttribute($building_->id_building_state,"building_state_name");?></td>
								<td><?=$building_types->getAttribute($building_->id_building_type,"building_type_name");?></td>
								<td><?=$building_->built_year;?></td>
								<td>
									<?php if ($user_group!=4): ?>
									<a href="/admin/buildings/delete/<?=$building_->id_building?>" onclick="return confirm('Вы уверены, что хотите удалить объект?')"><i class="fa fa-trash"></i></a></td>
								<?php endif; ?>
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
		$('#buildings_tbl').DataTable();
	});
</script>
