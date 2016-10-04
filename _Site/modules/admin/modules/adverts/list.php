<section class="content-header">
	<h1>Объявления</h1>
	<ol class="breadcrumb">
		<li><a href="/admin/"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li class="active">Объявления</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-body table-responsive no-padding">

					<table id="adverts_tbl" class="table table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Объект</th>
								<th>Категория</th>
								<th>Тип недвиж-ти</th>
								<th>Создано</th>
								<th width="30px"></th>
							</tr>
						</thead>
						<tbody>
						<?php
						if(isset($_GET['user']) and $_GET['user']>0){
							$adverts = $adverts->find(array('user_id=?',$_GET['user']));
						} else {
							$adverts = $adverts->find();
						}
						foreach($adverts as $advert): ?>
							<tr>
								<td><a href="/admin/adverts/edit/<?=$advert->id_advert?>"><?=$advert->id_advert?></a></td>
								<td><?php
									if(isset($advert->id_object)){
										$object = $objects->find(array('id_object=?', $advert->id_object));
										$object = $object[0];
										$f_address=$object->getFullAddress();
										if ($f_address) {
											echo $object->getFullAddress();
										} else {
											echo "здание удалено";
										}
									}
									else{
										echo "здание не задано";
									}
									?></td>
								<td><?php
									if(isset($advert->id_category)) {
										echo $categories->getAttribute($advert->id_category, "category_object_name");
									}
									?></td>
								<td><?php
									if(isset($advert->id_property_type)) {
										echo $property_types->getAttribute($advert->id_property_type, "property_type");
									}
									?></td>
								<td><?php $date = $advert->creation_date;
									$d1 = strtotime($date);
									$date2 = date("d-m-Y", $d1);
									echo $users->getAttribute($advert->user_id,"login"). ' '.$date2;?></td>
								<td>
							<?php if (($advert->isMy()) or $user_group==2): ?>
									<a href="/admin/adverts/delete/<?=$advert->id_advert?>" onclick="return confirm('Вы уверены, что хотите удалить объявление?')"><i class="fa fa-trash"></i></a>
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
		$('#adverts_tbl').DataTable();
	});
</script>
