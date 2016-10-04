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
							<label class="col-lg-3 control-label">Имя насел. пункта*:</label>
							<div class="col-lg-8">
								<input type="text" name="locality[id_locality]" value="<?=$locality->id_locality;?>" hidden="hidden">
								<input type="text" name="locality[locality_name]" class="form-control" placeholder="Город"
									   value="<?=$locality->locality_name;?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">Муниципальный р-он*:</label>
							<div class="col-lg-8">
								<select name="locality[id_district]" class="form-control">
									<option value="">Не выбрано</option>
									<?php foreach ($districts->find() as $district){ ?>
										<option value="<?= $district->id_district ?>" <?= ($district->id_district == $locality->id_district )? 'selected' : '' ?>>
											<?= $district->district_name ?></option>
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
							<a href="<?= $f3->get("homeurl") ?>/admin/address/listlocalities" class="form-control btn btn-primary"> Список городов</a>
						</p>
						<p>
							<a href="<?= $f3->get("homeurl") ?>/admin/address/adddistrict" class="form-control btn btn-primary"> Добавить муниц.район</a>
						</p>

					</div>
				</div>
			</div>
		</form>
	</div>
</section>