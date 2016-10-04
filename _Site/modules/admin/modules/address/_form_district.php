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
							<label class="col-lg-3 control-label">Имя района*:</label>
							<div class="col-lg-8">
								<input type="text" name="district[id_district]" value="<?=$district->id_district;?>" hidden="hidden">
								<input type="text" name="district[district_name]" class="form-control" placeholder="Муниципальный район"
									   value="<?=$district->district_name;?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">Регион*:</label>
							<div class="col-lg-8">
								<select name="district[id_region]" class="form-control">
									<option value="">Не выбрано</option>
									<?php foreach ($regions->find() as $region){ ?>
										<option value="<?= $region->id_region ?>" <?= ($district->id_region == $region->id_region )? 'selected' : '' ?>>
											<?= $region->region_name ?></option>
									<?php } ?>
								</select>
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
							<a href="<?= $f3->get("homeurl") ?>/admin/address/listdistricts" class="form-control btn btn-primary"> Список муниц.районов</a>
						</p>
						<p>
							<a href="<?= $f3->get("homeurl") ?>/admin/address/addregion" class="btn btn-primary form-control"> Добавить регион</a>
						</p>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>