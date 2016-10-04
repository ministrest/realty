<section class="content">
	<div class="row">
		<form role="form" class="form-horizontal" method="post" ENCTYPE="multipart/form-data" action="<?=$action?>">
			<div class="col-lg-8">
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Основные данные</h3>
					</div>
					<!-- form start -->
					<div class="box-body">
						<?php
						$errors = $f3->get('errors');
						if(count($errors)>0){?>
							<div class="callout callout-warning">
								<p>Пожалуйста проверьте введенные данные</p>
								<?php foreach ($errors as $error) { ?>
									<p class="text-danger"><i class="fa fa-times-circle-o"></i>Поле <?= $error; ?></p>
								<?php } ?>
							</div>
						<?php } ?>
						<div class="form-group<?= (in_array('object',$f3->get('errors')))? ' has-error' : '';?>">
							<label class="col-lg-3 control-label">Объект*:</label>
							<div class="col-lg-8">
								<select name="advert[id_object]" class="form-control">
									<option value="">Не выбрано</option>
									<?php
									if(isset($_GET['object']) and $_GET['object']>0){
										if(!isset($advert)) $advert = new \goodman\models\Advert_info();
										$advert->id_object = $_GET['object'];
									}
									 foreach ($objects->find() as $object){ ?>
										<option value="<?= $object->id_object ?>" <?= ($object->id_object == $advert->id_object )? 'selected' : '' ?>>
											<?= $object->getFullAddress() ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						<div class="form-group<?= (in_array('id_property_type',$f3->get('errors')))? ' has-error' : '';?>">
							<label class="col-lg-3 control-label">Тип недвижимости:</label>
							<div class="col-lg-8">
								<select name="advert[id_property_type]" class="form-control">
									<option value="">Не выбрано</option>
									<?php foreach ($property_types->find() as $property_type) { ?>
										<option
											value="<?= $property_type->id_property_type ?>" <?= ($property_type->id_property_type == $advert->id_property_type) ? 'selected' : '' ?>>
											<?= $property_type->property_type ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group<?= (in_array('value',$f3->get('errors')))? ' has-error' : '';?>">
							<label class="col-lg-3 control-label">Цена:</label>
							<div class="col-lg-8">
								<input type="text" name="advert[value]" class="form-control numeric-field field-medium" placeholder="Цена"
									   value="<?= number_format($advert->value, 0, '', ' ' );?>" onchange="
                                            var str = $(this).val();
                                            str = str.replace(/\s+/g, '');
                                            str = str.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
                                            $(this).prop( 'value', str );
                                    ">
								<select name="advert[id_currency]" class="form-control currency-field">
									<?php foreach ($currencies->find() as $currency){ ?>
										<option value="<?= $currency->id_currency?>" <?= ($currency->id_currency == $advert->id_currency )? 'selected' : '' ?>>
											<?=$currency->currency_name;?>
										</option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group<?= (in_array('creation_date',$f3->get('errors')))? ' has-error' : '';?>">
							<label class="col-lg-3 control-label">Дата создания:</label>
							<div class="col-lg-8">
								<input type="text" name="advert[creation_date]" class="form-control" disabled="disabled"
									   value="<?php if(isset($advert->creation_date) and !empty($advert->creation_date)) {
										   echo $advert->creation_date;
									   } else {
											   $date = new \DateTime();
											   $date = $date->format('d-m-Y H:i:s');
											   echo $date;
										   }
									   ?>">
							</div>
						</div>
						<div class="form-group<?= (in_array('last_update_date',$f3->get('errors')))? ' has-error' : '';?>">
							<label class="col-lg-3 control-label">Дата последнего обновления:</label>
							<div class="col-lg-8">
								<input type="text" name="advert[last_update_date]" class="form-control" disabled="disabled"
									   value="<?php if(isset($advert->last_update_date) and !empty($advert->last_update_date)) {
										   echo $advert->last_update_date;}
									   else{
										   $date = new \DateTime();
										   $date = $date->format('d-m-Y H:i:s');
										   echo $date;
									   }
									   ?>">
							</div>
						</div>

						<div class="form-group<?= (in_array('expire_date',$f3->get('errors')))? ' has-error' : '';?>">
							<label class="col-lg-3 control-label">Действует до:</label>
							<div class="col-lg-8">
								<div class="input-group date" data-provide="datepicker" data-date-format="dd-mm-yyyy">
									<input name="advert[expire_date]" type="text" class="form-control" value="<?=(isset($advert->expire_date) and !empty($advert->expire_date))? date('d-m-Y', strtotime($advert->expire_date)) : ''?>">
									<div class="input-group-addon">
										<span class="fa fa-clock-o"></span>
									</div>
								</div>
							</div>
						</div>

					</div>
					<div class="box-header with-border">
						<h3 class="box-title">Дополнительные условия</h3>
					</div>
					<div class="box-body">

						<input type="text" name="advert[id_advert]" class="hidden" value="<?=$advert->id_advert;?>">
						<div class="form-group<?= (in_array('deal_status',$f3->get('errors')))? ' has-error' : '';?>">
							<label class="col-lg-3 control-label">Статус сделки*:</label>
							<div class="col-lg-8">
								<select name="advert[id_deal_status]" class="form-control">
									<option value="">Не выбрано</option>
									<?php foreach ($deal_statuses->find() as $status){ ?>
										<option value="<?= $status->id_deal_status ?>" <?= ($status->id_deal_status == $advert->id_deal_status )? 'selected' : '' ?>>
											<?= $status->deal_status_name ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 control-label">Не для агентов:</label>
							<div class="col-lg-2">
								<div class="checkbox">
									<input type="checkbox" name="advert[not_for_agents]" <?php if ($advert->not_for_agents == '1' ) echo 'checked="checked"'; ?>>
								</div>
							</div>

							<label class="col-lg-4 control-label">Ипотека:</label>
							<div class="col-lg-2">
								<div class="checkbox">
									<input type="checkbox" name="advert[mortgage]" <?php if ($advert->mortgage == '1' ) echo 'checked="checked"'; ?>>
								</div>
							</div>

							<label class="col-lg-4 control-label">Торг:</label>
							<div class="col-lg-2">
								<div class="checkbox">
									<input type="checkbox" name="advert[haggle]" <?php if ($advert->haggle == '1' ) echo 'checked="checked"'; ?>>
								</div>
							</div>

							<label class="col-lg-4 control-label">Залог:</label>
							<div class="col-lg-2">
								<div class="checkbox">
									<input type="checkbox" name="advert[rent_pledge]" <?php if ($advert->rent_pledge == '1' ) echo 'checked="checked"'; ?>>
								</div>
							</div>
						</div>
						<?php if ($object->isMy() or $user_group==2): ?>
							<div class="form-group">
								<label class="col-lg-3 control-label">Пользователь:</label>
								<div class="col-lg-8">
									<select name="advert[user_id]" class="form-control">
										<?php foreach ($users->find() as $user){ ?>
											<option value="<?= $user->id_user ?>" <?= ($advert->user_id == $user->id_user)? 'selected' : '' ?>>
												<?= $user->login ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						<?php endif; ?>
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
							<a href="<?= $f3->get("homeurl") ?>/admin/adverts/addregion" class="form-control btn btn-primary"> Новое объявление</a>
						</p>
						<p>
							<a href="<?= $f3->get("homeurl") ?>/admin/address/adddistrict" class="form-control btn btn-primary"> Список объявлений</a>
						</p>
						<p>
							<?php if (isset($advert->id_object)) { ?>
								<a href="<?= $f3->get("homeurl") ?>/admin/objects/edit/<?= $advert->id_object ?>"
								   class="form-control btn btn-primary"> Посмотреть объект</a>
							<?php } ?>
						</p>
						<p>
							<?php if (!empty($building)) { ?>
								<a href="<?= $f3->get("homeurl") ?>/admin/buildings/edit/<?= $building->id_building ?>"
								   class="form-control btn btn-primary"> Посмотреть здание</a>
							<?php } else { ?>
								<a href="<?= $f3->get("homeurl") ?>/admin/buildings/add/<?= $address->id_address ?>"
								   class="form-control btn btn-primary"> Добавить инф-ю о здании</a>
							<?php } ?>
						</p>
					</div>
				</div>
			</div>
		</form>

	</div>
</section>