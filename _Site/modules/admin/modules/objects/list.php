<section class="content-header">
	<h1>Объекты</h1>
	<ol class="breadcrumb">
		<li><a href="/admin/"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li class="active">Объекты</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-body table-responsive no-padding">
					<table id="objects_tbl" class="table table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Адрес</th>
								<th>Ремонт</th>
								<th>Состояние</th>
								<th>Агент</th>
								<th>Площадь</th>
								<th width="30px"></th>
							</tr>
						</thead>
						<tbody>
						<?php 
						if(isset($_GET['address']) and $_GET['address']>0){
							$objects = $objects->find(array('id_address=?',$_GET['address']));
						} else {
							$objects = $objects->find();
						}
                             foreach($objects as $object): ?>
							<tr>
								<td><a href="/admin/objects/edit/<?=$object->id_object?>"><?=$object->id_object?> </a>
									<?php if (count($object->getImages())>0): ?>
										<i class="ion ion-image"></i>
									<?php endif; ?>
								</td>
								<td><?=$object->getFullAddress();?></td>
								<td><?=$renovations->getAttribute($object->id_renovation,"renovation_name");?></td>
								<td><?=$qualities->getAttribute($object->id_quality,"quality_name");?></td>
								<td><?=$category_agents->getAttribute($object->id_category_agent,"category_name");?></td>
								<td><?=$object->full_space;?></td>
								<td>
									<?php if ($object->isMy() or $user_group==2): ?>
									<a href="/admin/objects/delete/<?=$object->id_object?>" onclick="return confirm('Вы уверены, что хотите удалить объект?')"><i class="fa fa-trash"></i></a>
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
		$('#objects_tbl').DataTable();
	});
</script>