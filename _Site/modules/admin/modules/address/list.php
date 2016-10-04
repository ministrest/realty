<section class="content-header">
	<h1>Адреса</h1>
	<ol class="breadcrumb">
		<li><a href="/admin/"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li class="active">Адреса</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<div class="col-lg-12">
			<div class="box">
				<div class="box-body table-responsive no-padding">
					<table id="addresses_tbl" class="table table-hover">
						<thead>
						<tr>
							<th>ID</th>
							<th>Населенный пункт</th>
							<th>Район</th>
							<th>Адрес</th>
							<th width="30px"></th>
						</tr>
						</thead>
						<tbody>
						<?php foreach($addresses->find() as $address): ?>
							<tr>
								<td><a href="/admin/address/edit/<?=$address->id_address?>"><?=$address->id_address?></a></td>
								<td><?=$sublocalities->getCity($address->id_sublocality);?></td>
								<td><?=$sublocalities->getAttribute($address->id_sublocality,"sublocality_name");?></td>
								<td><?=$streets->getAttribute($address->id_street,"street_name");?>
									<?php echo (isset($address->house_number))? ", д.".$address->house_number : "" ?>
				
								</td>
								<td>
									<?php if ($user_group!=4): ?>
									<a href="/admin/address/delete/<?=$address->id_address?>" onclick="return confirm('Вы уверены, что хотите удалить адрес?')"><i class="fa fa-trash"></i></a></td>
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
		$('#addresses_tbl').DataTable();
	});
</script>