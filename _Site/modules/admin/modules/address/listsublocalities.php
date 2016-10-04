<section class="content-header">
	<h1>Района</h1>
	<ol class="breadcrumb">
		<li><a href="/admin/"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li class="active">Района</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-8">
			<div class="box">
				<div class="box-body table-responsive no-padding">
					<table id="sublocalities_tbl" class="table table-hover">
						<thead>

						<tr>
							<th>ID</th>
							<th>Город</th>
							<th>Район</th>
							<th width="30px"></th>
						</tr>
						</thead>
						<tbody>
						<?php foreach($sublocalities->find(array(),array('order'=>'sublocality_name')) as $sublocality): ?>
							<tr>
								<td><a href="/admin/address/editsublocality/<?=$sublocality->id_sublocality?>"><?=$sublocality->id_sublocality?></a></td>
								<td><?=$localities->getAttribute($sublocality->id_locality, 'locality_name');?></td>
								<td><?=$sublocality->sublocality_name;?></td>
								<td>
							<?php if ($user_group!=4): ?>
									<a href="/admin/address/deletesublocality/<?=$sublocality->id_sublocality?>" onclick="return confirm('Вы уверены, что хотите удалить Район?')"><i class="fa fa-trash"></i></a>
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
						<a href="<?= $f3->get("homeurl") ?>/admin/address/addsublocality" class="form-control btn btn-primary"> Добавить район</a>
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
		$('#sublocalities_tbl').DataTable();
	});
</script>