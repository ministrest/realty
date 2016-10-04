<section class="content-header">
	<h1>Просмотр объекта</h1>
	<ol class="breadcrumb">
		<li><a href="/admin/"><i class="fa fa-dashboard"></i> Главная</a></li>
		<li><a href="/admin/users">Объект</a></li>
		<li class="active">Просмотр объекта</li>
	</ol>
</section>
<section class="content">
	<div class="row">
		<form role="form" class="form-horizontal" method="post" ENCTYPE="multipart/form-data" action="<?= $action ?>">
			<div class="col-lg-8">
				<div class="box box-primary">
					<!-- form start -->
					<div class="box-body">
						<?php
						$errors = $f3->get('errors');
						if (count($errors) > 0) {
							?>
							<div class="callout callout-warning">
								<p>Пожалуйста проверьте введенные данные</p>
								<?php foreach($errors as $key => $error){
									echo $error;
								}?>
							</div>
						<?php } ?>
						<div class="form-group<?= (in_array('address', $f3->get('errors'))) ? ' has-error' : ''; ?>">
							<label class="col-lg-3 control-label">Адрес*:</label>

							<div class="col-lg-8">
								<select  disabled="disabled" name="building[id_address]" class="form-control">
									<option value="">Не выбрано</option>
									<?php foreach ($addresses->find() as $address) { ?>
										<option
											value="<?= $address->id_address ?>" <?= ($address->id_address == $building->id_address) ? 'selected' : '' ?>>
											<?= $address->getAddress(); ?>
										</option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">Стадия строительства дома*:</label>
							<div class="col-lg-8">
								<select  disabled="disabled" name="building[id_building_state]" class="form-control">
									<option value="">Не выбрано</option>
									<?php foreach ($building_states->find() as $building_state) { ?>
										<option
											value="<?= $building_state->id_building_state ?>" <?= ($building_state->id_building_state == $building->id_building_state) ? 'selected' : '' ?>>
											<?= $building_state->building_state_name; ?>
										</option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">Тип дома:</label>
							<div class="col-lg-8">
								<select  disabled="disabled" name="building[id_building_type]" class="form-control">
									<option value="">Не выбрано</option>
									<?php foreach ($building_types->find() as $building_type) { ?>
										<option
											value="<?= $building_type->id_building_type ?>" <?= ($building_type->id_building_type == $building->id_building_type) ? 'selected' : '' ?>>
											<?= $building_type->building_type_name; ?>
										</option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-3 control-label">Серия дома:</label>
							<div class="col-lg-8">
								<input  disabled="disabled" type="text" name="building[building_series]" class="form-control"
									   placeholder="Серия дома"
									   value="<?= $building->building_series; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label"> Год постройки:</label>

							<div class="col-lg-8">
								<input  disabled="disabled" type="text" name="building[built_year]" class="form-control"
									   placeholder="Год постройки"
									   value="<?= $building->built_year; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">Очередь строительства:</label>

							<div class="col-lg-8">
								<input  disabled="disabled" type="text" name="building[building_phase]" class="form-control"
									   placeholder="Очередь строительства"
									   value="<?= $building->building_phase; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">Корпус дома:</label>

							<div class="col-lg-8">
								<input  disabled="disabled" type="text" name="building[building_section]" class="form-control"
									   placeholder="Корпус дома"
									   value="<?= $building->building_section; ?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-3 control-label">Общее количество этажей в доме:</label>

							<div class="col-lg-2">
								<input  disabled="disabled" type="text" name="building[floors_total]"
									   class="form-control numeric-field field-short"
									   value="<?= $building->floors_total; ?>">
							</div>

							<label class="col-lg-3 control-label">Высота потолков:</label>
							<div class="col-lg-2">
								<input  disabled="disabled" type="text" name="building[ceiling_height]"
									   class="form-control numeric-field field-short"
									   value="<?= $building->ceiling_height; ?>"> м
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-3 control-label">Квартал сдачи дома:</label>
							<div class="col-lg-2">
								<input  disabled="disabled" type="text" name="building[ready_quarter]"
									   class="form-control numeric-field field-short"
									   value="<?= $building->ready_quarter; ?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-4 control-label">Лифт:</label>

							<div class="col-lg-2">
								<div class="checkbox">
									<input  disabled="disabled" type="checkbox"
										   name="building[lift]" <?php if ($building->lift == '1') echo 'checked="checked"'; ?>>
								</div>
							</div>
							<label class="col-lg-4 control-label">Мусоропровод:</label>

							<div class="col-lg-2">
								<div class="checkbox">
									<input  disabled="disabled" type="checkbox"
										   name="building[rubbish_chute]" <?php if ($building->rubbish_chute == '1') echo 'checked="checked"'; ?>>
								</div>
							</div>
							<label class="col-lg-4 control-label">Элитность:</label>

							<div class="col-lg-2">
								<div class="checkbox">
									<input  disabled="disabled" type="checkbox"
										   name="building[is_elite]" <?php if ($building->is_elite == '1') echo 'checked="checked"'; ?>>
								</div>
							</div>
							<label class="col-lg-4 control-label">Парковки:</label>

							<div class="col-lg-2">
								<div class="checkbox">
									<input  disabled="disabled" type="checkbox"
										   name="building[parking]" <?php if ($building->parking == '1') echo 'checked="checked"'; ?>>
								</div>
							</div>
							<label class="col-lg-4 control-label">Охрана/сигнализация:</label>

							<div class="col-lg-2">
								<div class="checkbox">
									<input  disabled="disabled" type="checkbox"
										   name="building[alarm]" <?php if ($building->alarm == '1') echo 'checked="checked"'; ?>>
								</div>
							</div>

						</div>

					</div>
					<div class="box-footer">
						<div class="pull-right">
							<input  disabled="disabled" type="submit" value="Сохранить" class="btn btn-primary">
						</div>
					</div>
				</div>

			</div>
			<div class="col-lg-3">
				<div class="box">
					<div class="box-body">
						<p>
							<a href="<?= $f3->get("homeurl") ?>/admin/buildings/list" class="form-control btn btn-primary"> Список зданий</a>
						</p>
						<p>
							<a href="<?= $f3->get("homeurl") ?>/admin/objects/list<?= ($building->id_address>0)?"?address=".$building->id_address : '' ?>"
							   class="form-control btn btn-primary"> Все объекты в здании</a>
						</p>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>

