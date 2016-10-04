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
						<?php }
						if(isset($address->id_sublocality)){
							$sublocality = $address->getLocalityModel();
						}
						?>

						<div class="form-group<?= (in_array('sublocality', $f3->get('errors'))) ? ' has-error' : ''; ?>">
							<label class="col-lg-3 control-label">Населенный пункт*:</label>
							<div class="col-lg-7">
								<select name="sublocality[id_locality]" id="localities" class="form-control" onchange="$.ajax({
									url: 'getSublocality',
									type: 'POST',
									dataType: 'json',
									data: 'query=getSublocality&id_locality=' + $(this).val(),
									error: function () {alert( 'При выполнении запроса произошла ошибка' );},
									success: function ( data ) {
										var arr1 = jQuery.makeArray(data['loc']);
										$('#sublocalities').empty();
										for ( var i = 0; i < arr1.length; i++ ) {
											$('#sublocalities').append( '<option value=' + arr1[i].id_sublocality + '>' + arr1[i].sublocality_name + '</option>' );
										}
										if ($('#sublocalities').attr('disabled')) {
											$('#sublocalities').prop( 'disabled', false );
										}

										var arr2 = jQuery.makeArray(data['str']);
										$('#streets').empty();
										$('#streets2').val('');
										for ( var i = 0; i < arr2.length; i++ ) {
											$('#streets').append( '<option value=' + arr2[i].street_id + '>' + arr2[i].street_name + '</option>' );
										}
										if ($('#streets').attr('disabled')) {
											$('#streets').prop( 'disabled', false );
											$('#streets2').prop( 'disabled', false );
										}
										}
									});">
									<option value="">Не выбрано</option>
									<?php foreach ($localities->find() as $locality) { ?>
										<option
											value="<?= $locality->id_locality ?>" <?= ($locality->id_locality == $sublocality->id_locality) ? 'selected' : '' ?>>
											<?= $locality->locality_name ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group<?= (in_array('sublocality', $f3->get('errors'))) ? ' has-error' : ''; ?>">
							<label class="col-lg-3 control-label">Район*:</label>
							<div class="col-lg-7">
								<select name="address[id_sublocality]" id="sublocalities" class="form-control" <?= (isset($address->id_sublocality) and $address->id_sublocality>0)? '' : 'disabled' ?>>
									<option value="">Не выбрано</option>
									<?php foreach ($sublocalities->find() as $sublocality){ ?>
										<option value="<?= $sublocality->id_sublocality ?>" <?= ($sublocality->id_sublocality == $address->id_sublocality )? 'selected' : '' ?>>
											<?= $sublocality->sublocality_name ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group<?= (in_array('street', $f3->get('errors'))) ? ' has-error' : ''; ?>">
							<label class="col-lg-3 control-label">Улица*:</label>
							<div class="col-lg-7">
								<select name="address[id_street]" id="streets" class="form-control" <?= (isset($address->id_street) and $address->id_street>0)? '' : 'disabled' ?> onchange="
                                        $('#h_number').prop( 'value', '' );
										$('#nonadmin_sublocality').prop( 'value', '' );
                                        var a = $(this).val();
                                        if(a>0){
                                            $('#h_number').prop( 'disabled', false );
                                        }else{
                                            $('#h_number').prop( 'disabled', true );
                                }">
									<option value="">Не выбрано</option>
									<?php foreach ($streets->find(array(),array('order'=>'street_name')) as $street){ ?>
										<option value="<?= $street->id_street ?>" <?= ($street->id_street == $address->id_street )? 'selected' : '' ?>>
											<?= $street->street_name ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-lg-3 control-label">Номер дома*:</label>
							<div class="col-lg-2">
								д. <input type="text" id="h_number" name="address[house_number]"
										  class="form-control numeric-field"
										  placeholder="Номер дома"
										  value="<?= $address->house_number; ?>" <?= (isset($address->house_number) and !empty($address->house_number))? '' : 'disabled' ?> onchange="$.ajax({
									url: 'getHouse',
									type: 'POST',
									dataType: 'json',
									data: 'query=getHouse&house_number=' + $(this).val() + '&id_sublocality=' + $('#sublocalities').val() + '&id_street=' + $('#streets').val(),
									error: function () {alert( 'При выполнении запроса произошла ошибка' );},
									success: function ( data ) {
									        $('#nonadmin_sublocality').prop( 'value', '' );
									        var a = $('#h_number').val().trim().length;
									        if(a>0){
                                                $('#nonadmin_sublocality').prop( 'value', data['nonadmin_sublocality'] );
                                            }
										}
									});">
							</div>
						</div>
						<div class="form-group<?= (in_array('sublocality', $f3->get('errors'))) ? ' has-error' : ''; ?>">
							<label class="col-lg-3 control-label">Ориентир:</label>
							<div class="col-lg-7">
                                 <textarea name="address[nonadmin_sublocality]" id="nonadmin_sublocality"
										   class="form-control" placeholder="Ориентир" rows="3" maxlength="50"
										   style="max-width: 500px;"><?= $address->nonadmin_sublocality; ?></textarea>
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
						<?php if($users->checkAccess('foradmin',$f3)){ ?>
						<p>
							<a href="<?= $f3->get("homeurl") ?>/admin/address/addregion" class="form-control btn btn-primary"> Добавить регион</a>
						</p>
						<p>
							<a href="<?= $f3->get("homeurl") ?>/admin/address/adddistrict" class="form-control btn btn-primary"> Добавить муниц.район</a>
						</p>
						<p>
							<a href="<?= $f3->get("homeurl") ?>/admin/address/addlocality" class="form-control btn btn-primary"> Добавить насел.пункт</a>
						</p>
						<p>
							<a href="<?= $f3->get("homeurl") ?>/admin/address/addsublocality" class="form-control btn btn-primary"> Добавить район</a>
						</p>
						<p>
							<a href="<?= $f3->get("homeurl") ?>/admin/address/addstreet" class="form-control btn btn-primary"> Добавить улицу</a>
						</p>
						<?php } ?>
						<p>
							<?php if (!empty($building)) { ?>
								<a href="<?= $f3->get("homeurl") ?>/admin/buildings/edit/<?= $building->id_building ?>"
								   class="form-control btn btn-primary"> Посмотреть инф-ю о здании</a>
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
<script src="<?= $f3->get("homeurl") ?>/inc/jscss/admin/autocomplete.js"></script>