<section class="content">
	<div class="row">
		<form role="form" class="form-horizontal" method="post" ENCTYPE="multipart/form-data" action="<?=$action?>">
			<div class="col-lg-8">
				<div class="box box-primary">
					<!-- form start -->
					<div class="box-body">
						<?php
						$errors = $f3->get('errors');
						if(count($errors)>0){?>
							<div class="callout callout-warning">
								<p>Пожалуйста проверьте введенные данные</p>
								<?php foreach($errors as $key => $error){
									echo $error;
								}?>
							</div>
						<?php }	?>

						<div class="form-group">
							<label class="col-lg-3 control-label">Имя региона*:</label>
							<div class="col-lg-8">
								<input type="text" name="region[id_region]" value="<?=$region->id_region;?>" hidden="hidden">
								<input type="text" name="region[region_name]" class="form-control" placeholder="Регион"
									   value="<?=$region->region_name;?>">
							</div>
						</div>

					</div>
					<div class="box-footer">
						<div class="pull-right">
							<input type="submit" value="Сохранить" class="btn btn-primary">
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="box">
					<div class="box-body">
						<p>
							<a href="<?= $f3->get("homeurl") ?>/admin/address/listregions" class="form-control btn btn-primary">Список регионов</a>
						</p>

					</div>
				</div>
			</div>
		</form>
	</div>
</section>