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
							<label class="col-lg-3 control-label">Имя улицы*:</label>
							<div class="col-lg-8">
								<input type="text" name="street[id_street]" value="<?=$street->id_street;?>" hidden="hidden">
								<input type="text" name="street[street_name]" class="form-control" placeholder="Улица"
									   value="<?=$street->street_name;?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">Населенный пункт*:</label>
							<div class="col-lg-8">
								<select name="street[id_locality]" class="form-control">
									<option value="">Не выбрано</option>
									<?php foreach ($localities->find() as $locality){ ?>
										<option value="<?= $locality->id_locality ?>" <?= ($locality->id_locality == $street->id_locality )? 'selected' : '' ?>>
											<?= $locality->locality_name ?></option>
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
							<a href="<?= $f3->get("homeurl") ?>/admin/address/liststreets" class="form-control btn btn-primary"> Список улиц</a>
						</p>

						<p>
							<a href="<?= $f3->get("homeurl") ?>/admin/address/addlocality" class="form-control btn btn-primary"> Добавить насел.пункт</a>
						</p>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>