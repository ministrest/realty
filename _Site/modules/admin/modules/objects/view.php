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
			<div class="col-lg-7">
				<div class="box box-primary">
					<!-- form start -->
					<div class="box-body">

						<div class="form-group<?= (in_array('address', $f3->get('errors'))) ? ' has-error' : ''; ?>">
							<label class="col-lg-3 control-label">Адрес*:</label>
							<div class="col-lg-8">
								<input disabled="disabled"  type="text" name="object[id_object]" id="object[id_object]" hidden="hidden"
									   value="<?= $object->id_object; ?>">
								<select  disabled="disabled" name="object[id_address]" class="form-control">
									<option value="">Не выбрано</option>
									<?php
									if(isset($_GET['address']) and $_GET['address']>0){
										if(!isset($object)) $object = new \goodman\models\Object_info();
										$object->id_address = $_GET['address'];
									}
									foreach ($addresses->find() as $address) { ?>
										<option
											value="<?= $address->id_address ?>" <?= ($address->id_address == $object->id_address) ? 'selected' : '' ?>>
											<?= $address->getAddress(); ?>
										</option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group<?= (in_array('renovation', $f3->get('errors'))) ? ' has-error' : ''; ?>">
							<label class="col-lg-3 control-label">Состояние ремонта*:</label>
							<div class="col-lg-8">
								<select  disabled="disabled" name="object[id_renovation]" class="form-control">
									<option value="">Не выбрано</option>
									<?php foreach ($renovations->find() as $renovation) { ?>
										<option
											value="<?= $renovation->id_renovation ?>" <?= ($renovation->id_renovation == $object->id_renovation) ? 'selected' : '' ?>>
											<?= $renovation->renovation_name ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group<?= (in_array('quality', $f3->get('errors'))) ? ' has-error' : ''; ?>">
							<label class="col-lg-3 control-label">Состояние объекта*:</label>
							<div class="col-lg-8">
								<select  disabled="disabled" name="object[id_quality]" class="form-control">
									<option value="">Не выбрано</option>
									<?php foreach ($qualities->find() as $quality) { ?>
										<option
											value="<?= $quality->id_quality ?>" <?= ($quality->id_quality == $object->id_quality) ? 'selected' : '' ?>>
											<?= $quality->quality_name ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div
							class="form-group<?= (in_array('category_agent', $f3->get('errors'))) ? ' has-error' : ''; ?>">
							<label class="col-lg-3 control-label">Категория агента*:</label>
							<div class="col-lg-8">
								<select  disabled="disabled" name="object[id_category_agent]" class="form-control">
									<option value="">Не выбрано</option>
									<?php foreach ($category_agents->find() as $category_agent) { ?>
										<option
											value="<?= $category_agent->id_category_agent ?>" <?= ($category_agent->id_category_agent == $object->id_category_agent) ? 'selected' : '' ?>>
											<?= $category_agent->category_name ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div
							class="form-group<?= (in_array('description', $f3->get('errors'))) ? ' has-error' : ''; ?>">
							<label class="col-lg-3 control-label">Описание:</label>
							<div class="col-lg-8">
                                <textarea  disabled="disabled" name="object[description]" class="form-control" placeholder="Описание"
										   style="max-width: 500px;"><?= $object->description; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">Площадь квартиры\дома*:</label>
							<div class="col-lg-1">
								<input disabled="disabled"  type="text" name="object[full_space]"
									   class="form-control numeric-field field-short"
									   value="<?= $object->full_space; ?>"> кв.м
							</div>

							<label class="col-lg-3 control-label">Жилая площадь:</label>
							<div class="col-lg-1">
								<input disabled="disabled"  type="text" name="object[living_space]"
									   class="form-control numeric-field field-short"
									   value="<?= $object->living_space; ?>"> кв.м
							</div>

							<label class="col-lg-2 control-label">Площадь кухни:</label>
							<div class="col-lg-1">
								<input disabled="disabled"  type="text" name="object[kitchen_space]"
									   class="form-control numeric-field field-short"
									   value="<?= $object->kitchen_space; ?>"> кв.м
							</div>
						</div>
						<div class="form-group<?= (in_array('lot_types', $f3->get('errors'))) ? ' has-error' : ''; ?>">
							<label class="col-lg-3 control-label">Тип участка:</label>
							<div class="col-lg-4">
								<select  disabled="disabled" name="object[id_lot_type]" class="form-control">
									<option value="">Не выбрано</option>
									<?php foreach ($lot_types->find() as $lot_type) { ?>
										<option
											value="<?= $lot_type->id_lot_type ?>" <?= ($lot_type->id_lot_type == $object->id_lot_type) ? 'selected' : '' ?>>
											<?= $lot_type->lot_type_name ?></option>
									<?php } ?>
								</select>
							</div>

							<label class="col-lg-3 control-label">Площадь участка:</label>
							<div class="col-lg-1">
								<input disabled="disabled"  type="text" name="object[lot_area]"
									   class="form-control numeric-field field-short" value="<?= $object->lot_area; ?>">
								кв.м
							</div>
						</div>

						<div class="box-header with-border">
							Общая информация
						</div>

						<div class="form-group">
							<label class="col-lg-4 control-label">Телефон:</label>
							<div class="col-lg-2">
								<div class="checkbox">
									<input disabled="disabled"  type="checkbox"
										   name="object[phone]" <?php if ($object->phone == '1') echo 'checked="checked"'; ?>>
								</div>
							</div>
							<label class="col-lg-4 control-label">Интернет:</label>
							<div class="col-lg-2">
								<div class="checkbox">
									<input disabled="disabled"  type="checkbox"
										   name="object[internet]" <?php if ($object->internet == '1') echo 'checked="checked"'; ?>>
								</div>
							</div>
							<label class="col-lg-4 control-label">Мебель:</label>
							<div class="col-lg-2">
								<div class="checkbox">
									<input disabled="disabled"  type="checkbox"
										   name="object[room_furniture]" <?php if ($object->room_furniture == '1') echo 'checked="checked"'; ?>>
								</div>
							</div>
							<label class="col-lg-4 control-label">Туалет:</label>
							<div class="col-lg-2">
								<div class="checkbox">
									<input disabled="disabled"  type="checkbox"
										   name="object[toilet]" <?php if ($object->toilet == '1') echo 'checked="checked"'; ?>>
								</div>
							</div>
							<label class="col-lg-4 control-label">Душ:</label>
							<div class="col-lg-2">
								<div class="checkbox">
									<input disabled="disabled"  type="checkbox"
										   name="object[shower]" <?php if ($object->shower == '1') echo 'checked="checked"'; ?>>
								</div>
							</div>
							<label class="col-lg-4 control-label">Кухня:</label>
							<div class="col-lg-2">
								<div class="checkbox">
									<input disabled="disabled"  type="checkbox"
										   name="object[kitchen]" <?php if ($object->kitchen == '1') echo 'checked="checked"'; ?>>
								</div>
							</div>
							<label class="col-lg-4 control-label">Лифт:</label>
							<div class="col-lg-2">
								<div class="checkbox">
									<input disabled="disabled"  type="checkbox"
										   name="object[elevator]" <?php if ($object->elevator == '1') echo 'checked="checked"'; ?>>
								</div>
							</div>
							<label class="col-lg-4 control-label">Новостройка:</label>
							<div class="col-lg-2">
								<div class="checkbox">
									<input disabled="disabled"  type="checkbox"
										   name="object[new_flat]" <?php if ($object->new_flat == '1') echo 'checked="checked"'; ?>>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-4 control-label">Кол-во комнат:</label>
							<div class="col-lg-2">
								<input disabled="disabled"  type="text" name="object[rooms]" class="form-control numeric-field field-short"
									   value="<?= $object->rooms; ?>">
							</div>

							<label class="col-lg-3 control-label"> Кол-во комнат в сделке:</label>
							<div class="col-lg-2">
								<input disabled="disabled"  type="text" name="object[rooms_offered]"
									   class="form-control numeric-field field-short"
									   value="<?= $object->rooms_offered; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">Покрытие пола:</label>
							<div class="col-lg-8">
								<select  disabled="disabled" name="object[id_floor_covering]" class="form-control">
									<?php foreach ($floors->find() as $floor) { ?>
										<option
											value="<?= $floor->id_floor ?>" <?= ($floor->id_floor == $object->id_floor_covering) ? 'selected' : '' ?>>
											<?= $floor->floor_covering_name; ?>
										</option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">Тип санузла:</label>
							<div class="col-lg-8">
								<input disabled="disabled"  type="text" name="object[bathroom_unit]" class="form-control"
									   placeholder="Тип санузла"
									   value="<?= $object->bathroom_unit; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">Вид из окон:</label>
							<div class="col-lg-8">
								<input disabled="disabled"  type="text" name="object[window_view]" class="form-control"
									   placeholder="Вид из окон"
									   value="<?= $object->window_view; ?>">
							</div>
						</div>

						<div class="box-header with-border">
							Для квартир
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label">Апартаменты:</label>
							<div class="col-lg-1">
								<div class="checkbox">
									<input disabled="disabled"  type="checkbox"
										   name="object[apartments]" <?php if ($object->apartments == '1') echo 'checked="checked"'; ?>>
								</div>
							</div>

							<label class="col-lg-5 control-label">Открытая планировка:</label>
							<div class="col-lg-1">
								<div class="checkbox">
									<input disabled="disabled"  type="checkbox"
										   name="object[open_plan]" <?php if ($object->open_plan == '1') echo 'checked="checked"'; ?>>
								</div>
							</div>

						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label">№ квартиры:</label>
							<div class="col-lg-2">
								<input disabled="disabled"  type="text" name="object[flat_number]"
									   class="form-control numeric-field field-short"
									   value="<?= $object->flat_number; ?>">
							</div>

							<label class="col-lg-3 control-label">Этаж:</label>
							<div class="col-lg-2">
								<input disabled="disabled"  type="text" name="object[floor]" class="form-control numeric-field field-short"
									   value="<?= $object->floor; ?>">
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-3 control-label">Тип комнат:</label>
							<div class="col-lg-8">
								<input disabled="disabled"  type="text" name="object[rooms_type]" class="form-control"
									   placeholder="Тип комнат"
									   value="<?= $object->rooms_type; ?>">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-3 control-label">Балкон:</label>
							<div class="col-lg-8">
								<input disabled="disabled"  type="text" name="object[balcony]" class="form-control" placeholder="Балкон"
									   value="<?= $object->balcony; ?>">
							</div>
						</div>
						<div class="box-header with-border">
							Для домов и участков
						</div>
						<div class="form-group">

							<label class="col-lg-4 control-label">Бассейн:</label>
							<div class="col-lg-2">
								<div class="checkbox">
									<input disabled="disabled"  type="checkbox"
										   name="object[pool]" <?php if ($object->pool == '1') echo 'checked="checked"'; ?>>
								</div>
							</div>

							<label class="col-lg-4 control-label">Сауна:</label>
							<div class="col-lg-2">
								<div class="checkbox">
									<input disabled="disabled"  type="checkbox"
										   name="object[sauna]" <?php if ($object->sauna == '1') echo 'checked="checked"'; ?>>
								</div>
							</div>

							<label class="col-lg-4 control-label">Отопление:</label>
							<div class="col-lg-2">
								<div class="checkbox">
									<input disabled="disabled"  type="checkbox"
										   name="object[heating_supply]" <?php if ($object->heating_supply == '1') echo 'checked="checked"'; ?>>
								</div>
							</div>

							<label class="col-lg-4 control-label">Водоснабжение:</label>
							<div class="col-lg-2">
								<div class="checkbox">
									<input disabled="disabled"  type="checkbox"
										   name="object[water_supply]" <?php if ($object->water_supply == '1') echo 'checked="checked"'; ?>>
								</div>
							</div>

							<label class="col-lg-4 control-label">Канализация:</label>
							<div class="col-lg-2">
								<div class="checkbox">
									<input disabled="disabled"  type="checkbox"
										   name="object[sewerage_supply]" <?php if ($object->sewerage_supply == '1') echo 'checked="checked"'; ?>>
								</div>
							</div>

							<label class="col-lg-4 control-label">Электроснабжение:</label>
							<div class="col-lg-2">
								<div class="checkbox">
									<input disabled="disabled"  type="checkbox"
										   name="object[electricity_supply]" <?php if ($object->electricity_supply == '1') echo 'checked="checked"'; ?>>
								</div>
							</div>

							<label class="col-lg-4 control-label">Газоснабжение:</label>
							<div class="col-lg-2">
								<div class="checkbox">
									<input disabled="disabled"  type="checkbox"
										   name="object[gas_supply]" <?php if ($object->gas_supply == '1') echo 'checked="checked"'; ?>>
								</div>
							</div>
						</div>

					</div>
				</div>


			</div>
		</form>

		<?php if ($object->id_object > 0) { ?>
			<form>
				<div class="col-lg-5">
					<div class="box">
						<div class="box-body">
							<p>
								<a href="<?= $f3->get("homeurl") ?>/admin/objects/list"
								   class="form-control btn btn-primary"> Список объектов</a>
							</p>
							<p>
								<a href="<?= $f3->get("homeurl") ?>/admin/adverts/list"
								   class="form-control btn btn-primary"> Список объявлений</a>
							</p>
							<p>
								<?php
								$advert = $adverts->find(array('id_object=?', $object->id_object));
								if (isset($advert[0]->id_object)) { ?>
									<a href="<?= $f3->get("homeurl") ?>/admin/adverts/edit/<?= $advert[0]->id_advert ?>"
									   class="form-control btn btn-primary"> Посмотреть объявление</a>
								<?php } else { ?>
									<a href="<?= $f3->get("homeurl") ?>/admin/adverts/add<?= ($object->id_object>0)?"?object=".$object->id_object : '' ?>"
									   class="form-control btn btn-primary"> Добавить объявление</a>
								<?php } ?>
							</p>
							<p>
								<?php
								$building = $buildings->find(array('id_address=?', $object->id_address));
								if (!empty($building[0])) { ?>
									<a href="<?= $f3->get("homeurl") ?>/admin/buildings/edit/<?= $building[0]->id_building ?>"
									   class="form-control btn btn-primary"> Посмотреть здание</a>
								<?php } else { ?>
									<a href="<?= $f3->get("homeurl") ?>/admin/buildings/add/<?= $object->id_address ?>"
									   class="form-control btn btn-primary"> Добавить инф-ю о здании</a>
								<?php } ?>
							</p>
						</div>
					</div>
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Изображения</h3>
						</div>
						<div class="box-body imageplace">
							<div class="form-group">
								<?php if (isset($obj_images)): ?>
									<?php foreach ($obj_images as $image): ?>
										<div class="image_item">
											<img src="<?= $image->catalog. $image->filename ?>">
											<a href="#" class="img_del deleteimg"
											   id="<?= $image->id_image; ?>"><i class="fa fa-trash"></i></a>
										</div>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>

						</div>
					</div>
				</div>
			</form>
		<?php } else { ?>
			<div class="col-lg-5">
				<div class="box">
					<div class="box-body">
						<p>
							<a href="<?= $f3->get("homeurl") ?>/admin/objects/list" class="form-control btn btn-primary">
								Список объектов</a>
						</p>
						<p>
							<a href="<?= $f3->get("homeurl") ?>/admin/adverts/list" class="form-control btn btn-primary">
								Список объявлений</a>
						</p>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</section>

