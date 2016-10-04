<section class="content">
    <div class="row">
        <div class="col-lg-11">
            <div class="box box-primary">

                <div class="box-header with-border">
                    <h3 class="box-title">Адрес объекта</h3>
                </div>
                <!-- form start -->
                <div class="box-body">
                    <form id="address_form" role="form" class="form-horizontal" method="post"
                          ENCTYPE="multipart/form-data"
                          action="<?= $action ?>">
                        <?php
                        $errors = $f3->get('errors');
                        if (count($errors['address']) > 0) {
                            ?>
                            <div class="callout callout-warning">
                                <p>Пожалуйста проверьте введенные данные</p>
                            </div>
                        <?php }
                        if(isset($address->id_sublocality)){
                            $sublocality = $address->getLocalityModel();
                        }
                        ?>

                        <div class="form-group<?= (in_array('sublocality', $f3->get('errors'))) ? ' has-error' : ''; ?>">
                            <label class="col-lg-2 control-label">Населенный пункт*:</label>
                            <div class="col-lg-2">
                                <select name="sublocality[id_locality]" id="localities" class="form-control" onchange="$.ajax({
									url: 'getSublocality',
									type: 'POST',
									dataType: 'json',
									data: 'query=getSublocality&id_locality=' + $(this).val(),
									error: function () {alert( 'При выполнении запроса произошла ошибка' );},
									success: function ( data ) {
										var arr1 = jQuery.makeArray(data['loc']);
										$('#h_number').prop( 'value', '' );
										$('#nonadmin_sublocality').prop( 'value', '' );
										$('#id_address').prop( 'value', '' );
										$('#building_form')[0].reset();
									    $('#object_form')[0].reset();
									    $('#advert_form')[0].reset();
										$('#sublocalities').empty();
										for ( var i = 0; i < arr1.length; i++ ) {
											$('#sublocalities').append( '<option value=' + arr1[i].id_sublocality + '>' + arr1[i].sublocality_name + '</option>' );
										}
										$('#sublocalities').prop( 'disabled', false );
										var arr2 = jQuery.makeArray(data['str']);
										$('#streets').empty();
										$('#streets2').val('');
										for ( var i = 0; i < arr2.length; i++ ) {
											$('#streets').append( '<option value=' + arr2[i].street_id + '>' + arr2[i].street_name + '</option>' );
										}
										$('#streets').prop( 'disabled', false );
										$('#streets2').prop( 'disabled', false );
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
                            <input type="hidden" value="<?= $address->id_address ?>" id="id_address" name="address[id_address]">
                            <label class="col-lg-1 control-label">Район*:</label>
                            <div class="col-lg-2">
                                <select name="address[id_sublocality]" id="sublocalities" class="form-control" <?= (isset($address->id_sublocality) and $address->id_sublocality>0)? '' : 'disabled' ?>
                                        onchange="
                                        $('#h_number').prop( 'value', '' );
										$('#nonadmin_sublocality').prop( 'value', '' );
										$('#id_address').prop( 'value', '' );
										$('#building_form')[0].reset();
									    $('#object_form')[0].reset();
									    $('#advert_form')[0].reset();
									    ">
                                    <option value="">Не выбрано</option>
                                    <?php foreach ($sublocalities->find() as $sublocality){ ?>
                                        <option value="<?= $sublocality->id_sublocality ?>" <?= ($sublocality->id_sublocality == $address->id_sublocality )? 'selected' : '' ?>>
                                            <?= $sublocality->sublocality_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <label class="col-lg-1 control-label">Улица*:</label>
                            <div class="col-lg-3">
                                <select name="address[id_street]" id="streets" class="form-control" <?= (isset($address->id_street) and $address->id_street>0)? '' : 'disabled' ?> onchange="
                                        $('#h_number').prop( 'value', '' );
										$('#nonadmin_sublocality').prop( 'value', '' );
										$('#id_address').prop( 'value', '' );
										$('#building_form')[0].reset();
									    $('#object_form')[0].reset();
									    $('#advert_form')[0].reset();
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
                            <label class="col-lg-2 control-label">Номер дома*:</label>
                            <div class="col-lg-2">
                                д. <input type="text" id="h_number" name="address[house_number]"
                                          class="form-control numeric-field"
                                          placeholder="Номер дома"
                                          value="<?= $address->house_number; ?>" <?= (isset($address->house_number) and !empty($address->house_number))? '' : 'disabled' ?> onchange="$.ajax({
									url: 'getBuilding',
									type: 'POST',
									dataType: 'json',
									data: 'query=getBuilding&house_number=' + $(this).val() + '&id_sublocality=' + $('#sublocalities').val() + '&id_street=' + $('#streets').val(),
									error: function () {alert( 'При выполнении запроса произошла ошибка' );},
									success: function ( data ) {
									        $('#building_form')[0].reset();
									        $('#object_form')[0].reset();
									        $('#advert_form')[0].reset();
									        $('#nonadmin_sublocality').prop( 'value', '' );
									        $('#id_address').prop( 'value', '' );
									        var a = $('#h_number').val().trim().length;
									        if(a>0){
                                                var checkboxes = ['is_elite', 'lift', 'alarm', 'rubbish_chute', 'parking'];
                                                if(!($.isEmptyObject(data['building']))){
                                                    $('#building_form').removeClass( 'hidden' );
                                                    $('#object_form').removeClass( 'hidden' );
                                                    $.each(data['building'], function(index, value){

                                                         if ($.inArray(index, checkboxes) > -1  && value==1){
                                                            var ind = 'building['+index+']';
                                                            $('[name=\''+ind+'\']').prop( 'checked', 'checked' );
                                                         } else {
                                                            var ind = 'building['+index+']';
                                                            $('[name=\''+ind+'\']').prop( 'value', value );
                                                        }
                                                    });
                                                }
                                                $('#nonadmin_sublocality').prop( 'value', data['nonadmin_sublocality'] );
                                                $('#id_address').prop( 'value', data['id_address'] );

                                                /*
                                                var arr3 = data['object'];
                                                var arr4 = data['advert'];
                                                 var ar_chb = ['phone', 'internet', 'toilet', 'room_furniture', 'shower',
                                                'elevator', 'kitchen', 'new_flat', 'apartments', 'open_plan', 'pool',
                                                'sauna', 'heating_supply', 'sewerage_supply', 'water_supply', 'electricity_supply', 'gas_supply'];
                                                var ar_chbox = ['rent_pledge', 'mortgage', 'not_for_agents', 'haggle'];
                                                $.each(arr3, function(index, value){
                                                     if ($.inArray(index, ar_chb) > -1  && value==1){
                                                        var ind = 'object['+index+']';
                                                        $('[name=\''+ind+'\']').prop( 'checked', 'checked' );
                                                     } else {
                                                        var ind = 'object['+index+']';
                                                        $('[name=\''+ind+'\']').prop( 'value', value );
                                                    }
                                                });
                                                $.each(arr4, function(index, value){
                                                     if ($.inArray(index, ar_chbox) > -1  && value==1){
                                                        var ind = 'advert['+index+']';
                                                        $('[name=\''+ind+'\']').prop( 'checked', 'checked' );
                                                     } else {
                                                        var ind = 'advert['+index+']';
                                                        $('[name=\''+ind+'\']').prop( 'value', value );
                                                    }
                                                });
                                                */
                                            }
										}
									});">
                            </div>
                            <label class="col-lg-1 control-label">Ориентир:</label>
                            <div class="col-lg-7">
                                 <textarea name="address[nonadmin_sublocality]" id="nonadmin_sublocality"
                                           class="form-control" placeholder="Ориентир" rows="3" maxlength="50"
                                           style="max-width: 500px;"><?= $address->nonadmin_sublocality; ?></textarea>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="pull-right">
                                <input type="submit" value="<?=(isset($address->id_address) and $address->id_address>0)?'Обновить' : 'Сохранить'?>" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-11">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Информация о здании</h3>
                </div>
                <div class="box-body">
                    <form id="building_form" role="form" class="form-horizontal <?=(isset($building))? '': 'hidden' ?>" method="post"
                          ENCTYPE="multipart/form-data" action="<?= $action ?>">
                        <!-- form start -->
                        <div class="box-body">
                            <?php
                            $errors = $f3->get('errors');
                            if (count($errors['building']) > 0) {
                                ?>
                                <div class="callout callout-warning">
                                    <p>Пожалуйста проверьте введенные данные</p>
                                    <?php foreach ($errors['building'] as $error) { ?>
                                        <p class="text-danger"><i class="fa fa-times-circle-o"></i>Поле <?= $error; ?></p>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <input type="hidden" value="<?= $building->id_building ?>" name="building[id_building]">
                            <input type="hidden" value="<?= $building->id_address ?>" name="building[id_address]">
                            <!--
                            <div
                                class="form-group<?= (in_array('address', $f3->get('errors'))) ? ' has-error' : ''; ?>">
                                <label class="col-lg-3 control-label">Адрес*:</label>

                                <div class="col-lg-8">
                                    <select name="building[id_address]" class="form-control">
                                        <option value="">Не выбрано</option>
                                        <?php foreach ($addresses->find() as $address) { ?>
                                            <option
                                                value="<?= $address->id_address ?>" <?= ($address->id_address == $building->id_address) ? 'selected' : '' ?>>
                                                <?= $address->getAddress(); ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div> -->

                            <div class="form-group">
                                <label class="col-lg-2 control-label">Стадия строительства дома*:</label>
                                <div class="col-lg-2">
                                    <select name="building[id_building_state]" class="form-control">
                                        <option value="">Не выбрано</option>
                                        <?php foreach ($building_states->find() as $building_state) { ?>
                                            <option
                                                value="<?= $building_state->id_building_state ?>" <?= ($building_state->id_building_state == $building->id_building_state) ? 'selected' : '' ?>>
                                                <?= $building_state->building_state_name; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <label class="col-lg-2 control-label">Тип дома:</label>
                                <div class="col-lg-2">
                                    <select name="building[id_building_type]" class="form-control">
                                        <option value="">Не выбрано</option>
                                        <?php foreach ($building_types->find() as $building_type) { ?>
                                            <option
                                                value="<?= $building_type->id_building_type ?>" <?= ($building_type->id_building_type == $building->id_building_type) ? 'selected' : '' ?>>
                                                <?= $building_type->building_type_name; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <label class="col-lg-2 control-label">Серия дома:</label>
                                <div class="col-lg-2">
                                    <input type="text" name="building[building_series]" class="form-control"
                                           placeholder="Серия дома" value="<?= $building->building_series; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label"> Год постройки:</label>

                                <div class="col-lg-2">
                                    <input type="text" name="building[built_year]" class="form-control"
                                           placeholder="Год постройки" value="<?= $building->built_year; ?>">
                                </div>

                                <label class="col-lg-2 control-label">Очередь строительства:</label>

                                <div class="col-lg-2">
                                    <input type="text" name="building[building_phase]" class="form-control"
                                           placeholder="Очередь строительства"
                                           value="<?= $building->building_phase; ?>">
                                </div>

                                <label class="col-lg-2 control-label">Корпус дома:</label>

                                <div class="col-lg-1">
                                    <input type="text" name="building[building_section]" class="form-control"
                                           placeholder="Корпус дома" value="<?= $building->building_section; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Общее количество этажей в доме:</label>

                                <div class="col-lg-1">
                                    <input type="text" name="building[floors_total]"
                                           class="form-control numeric-field field-short"
                                           value="<?= $building->floors_total; ?>">
                                </div>

                                <label class="col-lg-2 control-label">Высота потолков:</label>
                                <div class="col-lg-1">
                                    <input type="text" name="building[ceiling_height]"
                                           class="form-control numeric-field field-short"
                                           value="<?= $building->ceiling_height; ?>"> м
                                </div>

                                <label class="col-lg-2 control-label">Квартал сдачи дома:</label>
                                <div class="col-lg-1">
                                    <input type="text" name="building[ready_quarter]"
                                           class="form-control numeric-field field-short"
                                           value="<?= $building->ready_quarter; ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-lg-4 control-label">Лифт:</label>

                                <div class="col-lg-2">
                                    <div class="checkbox">
                                        <input type="checkbox"
                                               name="building[lift]" <?php if ($building->lift == '1') echo 'checked="checked"'; ?>>
                                    </div>
                                </div>
                                <label class="col-lg-4 control-label">Мусоропровод:</label>

                                <div class="col-lg-2">
                                    <div class="checkbox">
                                        <input type="checkbox"
                                               name="building[rubbish_chute]" <?php if ($building->rubbish_chute == '1') echo 'checked="checked"'; ?>>
                                    </div>
                                </div>
                                <label class="col-lg-4 control-label">Элитность:</label>

                                <div class="col-lg-2">
                                    <div class="checkbox">
                                        <input type="checkbox"
                                               name="building[is_elite]" <?php if ($building->is_elite == '1') echo 'checked="checked"'; ?>>
                                    </div>
                                </div>
                                <label class="col-lg-4 control-label">Парковки:</label>

                                <div class="col-lg-2">
                                    <div class="checkbox">
                                        <input type="checkbox"
                                               name="building[parking]" <?php if ($building->parking == '1') echo 'checked="checked"'; ?>>
                                    </div>
                                </div>
                                <label class="col-lg-4 control-label">Охрана/сигнализация:</label>

                                <div class="col-lg-2">
                                    <div class="checkbox">
                                        <input type="checkbox"
                                               name="building[alarm]" <?php if ($building->alarm == '1') echo 'checked="checked"'; ?>>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="box-footer">
                            <div class="pull-right">
                                <input type="submit" value="<?=(isset($building->id_building) and $building->id_building>0)?'Обновить' : 'Сохранить'?>" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-11">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Описание объекта</h3>
                </div>
                <div class="box-body">
                    <form id="object_form" role="form" class="form-horizontal <?=(isset($object))? '': 'hidden' ?>" method="post"
                          ENCTYPE="multipart/form-data" action="<?= $action ?>">
                        <?php
                        $errors = $f3->get('errors');
                        if (count($errors['object']) > 0) {
                            ?>
                            <div class="callout callout-warning">
                                <p>Пожалуйста проверьте введенные данные</p>
                                <?php foreach ($errors['object'] as $error) { ?>
                                    <p class="text-danger"><i class="fa fa-times-circle-o"></i>Поле <?= $error; ?></p>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <input type="hidden" name="object[id_object]" id="object[id_object]" value="<?= $object->id_object; ?>">
                        <input type="hidden" id="object[id_address]" name="object[id_address]" value="<?= $object->id_address ?>">
                        <!--<div class="form-group<?= (in_array('address', $f3->get('errors'))) ? ' has-error' : ''; ?>">
                                        <label class="col-lg-3 control-label">Адрес*:</label>
                                        <div class="col-lg-8">

                                            <select name="object[id_address]" class="form-control">
                                                <option value="">Не выбрано</option>
                                                <?php
                        if (isset($_GET['address']) and $_GET['address'] > 0) {
                            if (!isset($object)) $object = new \goodman\models\Object_info();
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
                                    </div> -->

                        <div class="form-group<?= (in_array('category', $f3->get('errors'))) ? ' has-error' : ''; ?>">
                            <label class="col-lg-2 control-label">Категория объекта*:</label>
                            <div class="col-lg-4">
                                <?php
                                $cat_lands = array(4,9);
                                $cat_flats = array(1,2);
                                $cat_houses = array(3,5,6,7,8);
                                ?>
                                <select name="object[id_category]" id="object[id_category]" class="form-control" onchange="
                                 /*var v = $(this).val();
                                 var lands = ['4','9'];
                                 var flats = ['1','2'];
                                 var houses = ['3','5','6','7','8'];
                                 if ($.inArray(v, lands) > -1 ){
                                    $('div.notforland').addClass( 'hidden' );
                                    $('div.notforflat').removeClass( 'hidden' );
                                    $('div.forflat').addClass( 'hidden' );
                                    $('div.forhouses').addClass( 'hidden' );
                                 }
                                 if ($.inArray(v, flats) > -1 ){
                                    $('div.notforland').removeClass( 'hidden' );
                                    $('div.notforflat').addClass( 'hidden' );
                                    $('div.forflat').removeClass( 'hidden' );
                                    $('div.forhouses').addClass( 'hidden' );
                                 }
                                 if ($.inArray(v, houses) > -1 ){
                                    $('div.notforland').removeClass( 'hidden' );
                                    $('div.notforflat').removeClass( 'hidden' );
                                    $('div.forflat').addClass( 'hidden' );
                                    $('div.forhouses').removeClass( 'hidden' );
                                 }*/
                                    ">
                                    <option value="">Не выбрано</option>
                                    <?php foreach ($categories->find() as $category) { ?>
                                        <option
                                            value="<?= $category->id_category_object ?>" <?= ($category->id_category_object == $object->id_category) ? 'selected' : '' ?>>
                                            <?= $category->category_object_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>


                        <div class="box-header with-border">
                            Общая информация
                        </div>

                        <div class="form-group<?= (in_array('quality', $f3->get('errors'))) ? ' has-error' : ''; ?> notforland">

                                <label class="col-lg-2 control-label">Состояние ремонта*:</label>
                                <div class="col-lg-2">
                                    <select name="object[id_renovation]" class="form-control">
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
                            <label class="col-lg-2 control-label">Состояние объекта*:</label>
                            <div class="col-lg-2">
                                <select name="object[id_quality]" class="form-control">
                                    <option value="">Не выбрано</option>
                                    <?php foreach ($qualities->find() as $quality) { ?>
                                        <option
                                            value="<?= $quality->id_quality ?>" <?= ($quality->id_quality == $object->id_quality) ? 'selected' : '' ?>>
                                            <?= $quality->quality_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <label class="col-lg-2 control-label">Категория агента*:</label>
                            <div class="col-lg-2">
                                <select name="object[id_category_agent]" class="form-control">
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
                                <textarea name="object[description]" class="form-control" placeholder="Описание"
                                          maxlength="500" rows="10"
                                          style="max-width: 500px;"><?= $object->description; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Площадь квартиры\дома*:</label>
                            <div class="col-lg-1">
                                <input type="text" name="object[full_space]"
                                       class="form-control numeric-field field-short"
                                       value="<?= $object->full_space; ?>"> кв.м
                            </div>
<div class="notforland  ">
                            <label class="col-lg-3 control-label">Жилая площадь:</label>
                            <div class="col-lg-1">
                                <input type="text" name="object[living_space]"
                                       class="form-control numeric-field field-short"
                                       value="<?= $object->living_space; ?>"> кв.м
                            </div>

                            <label class="col-lg-2 control-label">Площадь кухни:</label>
                            <div class="col-lg-1">
                                <input type="text" name="object[kitchen_space]"
                                       class="form-control numeric-field field-short"
                                       value="<?= $object->kitchen_space; ?>"> кв.м
                            </div>
</div>
                        </div>
<div class="notforflat ">
                        <div class="form-group<?= (in_array('lot_types', $f3->get('errors'))) ? ' has-error' : ''; ?>">
                            <label class="col-lg-3 control-label">Тип участка:</label>
                            <div class="col-lg-4">
                                <select name="object[id_lot_type]" class="form-control">
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
                                <input type="text" name="object[lot_area]"
                                       class="form-control numeric-field field-short" value="<?= $object->lot_area; ?>">
                                кв.м
                            </div>
                        </div>
</div>
<div class="notforland">
                        <div class="form-group">
                            <label class="col-lg-4 control-label">Телефон:</label>
                            <div class="col-lg-2">
                                <div class="checkbox">
                                    <input type="checkbox"
                                           name="object[phone]" <?php if ($object->phone == '1') echo 'checked="checked"'; ?>>
                                </div>
                            </div>
                            <label class="col-lg-4 control-label">Интернет:</label>
                            <div class="col-lg-2">
                                <div class="checkbox">
                                    <input type="checkbox"
                                           name="object[internet]" <?php if ($object->internet == '1') echo 'checked="checked"'; ?>>
                                </div>
                            </div>
                            <label class="col-lg-4 control-label">Мебель:</label>
                            <div class="col-lg-2">
                                <div class="checkbox">
                                    <input type="checkbox"
                                           name="object[room_furniture]" <?php if ($object->room_furniture == '1') echo 'checked="checked"'; ?>>
                                </div>
                            </div>
                            <label class="col-lg-4 control-label">Туалет:</label>
                            <div class="col-lg-2">
                                <div class="checkbox">
                                    <input type="checkbox"
                                           name="object[toilet]" <?php if ($object->toilet == '1') echo 'checked="checked"'; ?>>
                                </div>
                            </div>
                            <label class="col-lg-4 control-label">Душ:</label>
                            <div class="col-lg-2">
                                <div class="checkbox">
                                    <input type="checkbox"
                                           name="object[shower]" <?php if ($object->shower == '1') echo 'checked="checked"'; ?>>
                                </div>
                            </div>
                            <label class="col-lg-4 control-label">Кухня:</label>
                            <div class="col-lg-2">
                                <div class="checkbox">
                                    <input type="checkbox"
                                           name="object[kitchen]" <?php if ($object->kitchen == '1') echo 'checked="checked"'; ?>>
                                </div>
                            </div>
                            <label class="col-lg-4 control-label">Лифт:</label>
                            <div class="col-lg-2">
                                <div class="checkbox">
                                    <input type="checkbox"
                                           name="object[elevator]" <?php if ($object->elevator == '1') echo 'checked="checked"'; ?>>
                                </div>
                            </div>
                            <label class="col-lg-4 control-label">Новостройка:</label>
                            <div class="col-lg-2">
                                <div class="checkbox">
                                    <input type="checkbox"
                                           name="object[new_flat]" <?php if ($object->new_flat == '1') echo 'checked="checked"'; ?>>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">

                            <label class="col-lg-4 control-label">Кол-во комнат:</label>
                            <div class="col-lg-2">
                                <input type="text" name="object[rooms]" class="form-control numeric-field field-short"
                                       value="<?= $object->rooms; ?>">
                            </div>

                            <label class="col-lg-3 control-label"> Кол-во комнат в сделке:</label>
                            <div class="col-lg-2">
                                <input type="text" name="object[rooms_offered]"
                                       class="form-control numeric-field field-short"
                                       value="<?= $object->rooms_offered; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Покрытие пола:</label>
                            <div class="col-lg-4">
                                <select name="object[id_floor_covering]" class="form-control">
                                    <option value="">Не выбрано</option>
                                    <?php foreach ($floors->find() as $floor) { ?>
                                        <option
                                            value="<?= $floor->id_floor ?>" <?= ($floor->id_floor == $object->id_floor_covering) ? 'selected' : '' ?>>
                                            <?= $floor->floor_covering_name; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <label class="col-lg-2 control-label">Тип санузла:</label>
                            <div class="col-lg-4">
                                <input type="text" name="object[bathroom_unit]" class="form-control"
                                       placeholder="Тип санузла"
                                       value="<?= $object->bathroom_unit; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Вид из окон:</label>
                            <div class="col-lg-8">
                                <input type="text" name="object[window_view]" class="form-control"
                                       placeholder="Вид из окон"
                                       value="<?= $object->window_view; ?>">
                            </div>
                        </div>
</div>
<div class="forflat">
                        <div class="box-header with-border">
                            Для квартир
                        </div>
                        <div class="form-group">
                            <label class="col-lg-4 control-label">Апартаменты:</label>
                            <div class="col-lg-1">
                                <div class="checkbox">
                                    <input type="checkbox"
                                           name="object[apartments]" <?php if ($object->apartments == '1') echo 'checked="checked"'; ?>>
                                </div>
                            </div>

                            <label class="col-lg-5 control-label">Открытая планировка:</label>
                            <div class="col-lg-1">
                                <div class="checkbox">
                                    <input type="checkbox"
                                           name="object[open_plan]" <?php if ($object->open_plan == '1') echo 'checked="checked"'; ?>>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label class="col-lg-4 control-label">№ квартиры:</label>
                                <div class="col-lg-2">
                                    <input type="text" name="object[flat_number]"
                                           class="form-control numeric-field field-short"
                                           value="<?= $object->flat_number; ?>" onchange="$.ajax({
									url: 'getObject',
									type: 'POST',
									dataType: 'json',
									data: 'query=getObject&flat_number=' + $(this).val() + '&id_address=' + $('#object[id_address]').val() + '&id_category=' + $('#object[id_category]').val(),
									error: function () {alert( 'При выполнении запроса произошла ошибка' );},
									success: function ( data ) {
									        $('#object_form')[0].reset();
									        $('#advert_form')[0].reset();
									        var a = $('#h_number').val().trim().length;
									        if(a>0){
                                                var checkboxes = ['is_elite', 'lift', 'alarm', 'rubbish_chute', 'parking'];
                                                if(!($.isEmptyObject(data['object']))){
                                                /*
                                                var arr3 = data['object'];
                                                var arr4 = data['advert'];
                                                 var ar_chb = ['phone', 'internet', 'toilet', 'room_furniture', 'shower',
                                                'elevator', 'kitchen', 'new_flat', 'apartments', 'open_plan', 'pool',
                                                'sauna', 'heating_supply', 'sewerage_supply', 'water_supply', 'electricity_supply', 'gas_supply'];
                                                var ar_chbox = ['rent_pledge', 'mortgage', 'not_for_agents', 'haggle'];
                                                $.each(arr3, function(index, value){
                                                     if ($.inArray(index, ar_chb) > -1  && value==1){
                                                        var ind = 'object['+index+']';
                                                        $('[name=\''+ind+'\']').prop( 'checked', 'checked' );
                                                     } else {
                                                        var ind = 'object['+index+']';
                                                        $('[name=\''+ind+'\']').prop( 'value', value );
                                                    }
                                                });
                                                $.each(arr4, function(index, value){
                                                     if ($.inArray(index, ar_chbox) > -1  && value==1){
                                                        var ind = 'advert['+index+']';
                                                        $('[name=\''+ind+'\']').prop( 'checked', 'checked' );
                                                     } else {
                                                        var ind = 'advert['+index+']';
                                                        $('[name=\''+ind+'\']').prop( 'value', value );
                                                    }
                                                });
                                                */
                                            }
										}
									});">
                                </div>

                            <label class="col-lg-3 control-label">Этаж:</label>
                            <div class="col-lg-2">
                                <input type="text" name="object[floor]" class="form-control numeric-field field-short"
                                       value="<?= $object->floor; ?>">
                            </div>
</div>
                        </div>
<div class="notforland">
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Тип комнат:</label>
                            <div class="col-lg-4">
                                <input type="text" name="object[rooms_type]" class="form-control"
                                       placeholder="Тип комнат"
                                       value="<?= $object->rooms_type; ?>">
                            </div>

                            <label class="col-lg-2 control-label">Балкон:</label>
                            <div class="col-lg-4">
                                <input type="text" name="object[balcony]" class="form-control" placeholder="Балкон"
                                       value="<?= $object->balcony; ?>">
                            </div>
                        </div>
</div>
<div class="forhouses">
                        <div class="box-header with-border">
                            Для домов c участком
                        </div>
                        <div class="form-group">

                            <label class="col-lg-4 control-label">Бассейн:</label>
                            <div class="col-lg-2">
                                <div class="checkbox">
                                    <input type="checkbox"
                                           name="object[pool]" <?php if ($object->pool == '1') echo 'checked="checked"'; ?>>
                                </div>
                            </div>

                            <label class="col-lg-4 control-label">Сауна:</label>
                            <div class="col-lg-2">
                                <div class="checkbox">
                                    <input type="checkbox"
                                           name="object[sauna]" <?php if ($object->sauna == '1') echo 'checked="checked"'; ?>>
                                </div>
                            </div>

                            <label class="col-lg-4 control-label">Отопление:</label>
                            <div class="col-lg-2">
                                <div class="checkbox">
                                    <input type="checkbox"
                                           name="object[heating_supply]" <?php if ($object->heating_supply == '1') echo 'checked="checked"'; ?>>
                                </div>
                            </div>

                            <label class="col-lg-4 control-label">Водоснабжение:</label>
                            <div class="col-lg-2">
                                <div class="checkbox">
                                    <input type="checkbox"
                                           name="object[water_supply]" <?php if ($object->water_supply == '1') echo 'checked="checked"'; ?>>
                                </div>
                            </div>

                            <label class="col-lg-4 control-label">Канализация:</label>
                            <div class="col-lg-2">
                                <div class="checkbox">
                                    <input type="checkbox"
                                           name="object[sewerage_supply]" <?php if ($object->sewerage_supply == '1') echo 'checked="checked"'; ?>>
                                </div>
                            </div>

                            <label class="col-lg-4 control-label">Электроснабжение:</label>
                            <div class="col-lg-2">
                                <div class="checkbox">
                                    <input type="checkbox"
                                           name="object[electricity_supply]" <?php if ($object->electricity_supply == '1') echo 'checked="checked"'; ?>>
                                </div>
                            </div>

                            <label class="col-lg-4 control-label">Газоснабжение:</label>
                            <div class="col-lg-2">
                                <div class="checkbox">
                                    <input type="checkbox"
                                           name="object[gas_supply]" <?php if ($object->gas_supply == '1') echo 'checked="checked"'; ?>>
                                </div>
                            </div>
                        </div>
</div>
                        <div class="box-footer">
                            <div class="pull-right">
                                <input type="submit" value="<?=(isset($object->id_object) and $object->id_object>0)?'Обновить' : 'Сохранить'?>" class="btn btn-primary">
                            </div>
                        </div>
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
                            <!-- Область для перетаскивания -->
                            <div id="drop-files" ondragover="return false">
                                <p>Перетащите изображение сюда</p>
                                <form id="frm">
                                    <input type="file" id="uploadbtn" class="btn" multiple/>
                                </form>
                            </div>
                            <!-- Область предпросмотра -->
                            <div id="uploaded-holder">
                                <div id="dropped-files">
                                    <!-- Кнопки загрузить и удалить, а также количество файлов -->
                                    <div id="upload-button">

                                        <span>0 Файлов</span>
                                        <a href="#" class="upload btn btn-primary">Загрузить</a>
                                        <a href="#" class="delete btn btn-danger">Удалить</a>
                                        <!-- Прогресс бар загрузки -->
                                        <div id="loading">
                                            <div id="loading-bar">
                                                <div class="loading-color"></div>
                                            </div>
                                            <div id="loading-content"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- Список загруженных файлов -->
                            <div id="file-name-holder">
                                <ul id="uploaded-files">
                                    <h1>Загруженные файлы</h1>
                                </ul>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-11">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Объявление</h3>
                </div>
                <div class="box-body">
                    <form id="advert_form" role="form" class="form-horizontal <?=(isset($advert))? '': 'hidden' ?>" method="post"
                          ENCTYPE="multipart/form-data" action="<?= $action ?>">
                        <div class="box-header with-border">
                            <h3 class="box-title">Основные данные</h3>
                        </div>
                        <!-- form start -->
                        <div class="box-body">
                            <?php
                            $errors = $f3->get('errors');
                            if (count($errors['advert']) > 0) {
                                ?>
                                <div class="callout callout-warning">
                                    <p>Пожалуйста проверьте введенные данные</p>
                                    <?php foreach ($errors['advert'] as $error) { ?>
                                        <p class="text-danger"><i class="fa fa-times-circle-o"></i>Поле <?= $error; ?></p>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <div class="form-group<?= (in_array('object', $f3->get('errors'))) ? ' has-error' : ''; ?>">
                                <input type="hidden" name="advert[id_object]" value="<?= $object->id_object ?>">
                                <!--
							<label class="col-lg-3 control-label">Объект*:</label>

							<div class="col-lg-8">
								<select name="advert[id_object]" class="form-control">
									<option value="">Не выбрано</option>
									<?php
                                if (isset($_GET['object']) and $_GET['object'] > 0) {
                                    if (!isset($advert)) $advert = new \goodman\models\Advert_info();
                                    $advert->id_object = $_GET['object'];
                                }
                                foreach ($objects->find() as $object) { ?>
										<option value="<?= $object->id_object ?>" <?= ($object->id_object == $advert->id_object) ? 'selected' : '' ?>>
											<?= $object->getFullAddress() ?></option>
									<?php } ?>
								</select>
							</div>
							-->
                            </div>
                            <div
                                class="form-group<?= (in_array('property_type', $f3->get('errors'))) ? ' has-error' : ''; ?>">
                                <label class="col-lg-2 control-label">Тип недвижимости:</label>
                                <div class="col-lg-3">
                                    <select name="advert[id_property_type]" class="form-control">
                                        <option value="">Не выбрано</option>
                                        <?php foreach ($property_types->find() as $property_type) { ?>
                                            <option
                                                value="<?= $property_type->id_property_type ?>" <?= ($property_type->id_property_type == $advert->id_property_type) ? 'selected' : '' ?>>
                                                <?= $property_type->property_type ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <label class="col-lg-2 control-label">Цена:</label>
                                <div class="col-lg-3">
                                    <input type="text" name="advert[value]"
                                           class="form-control numeric-field field-medium" placeholder="Цена"
                                           value="<?= number_format($advert->value, 0, '', ' ' ); ?>" onchange="
                                            var str = $(this).val();
                                            str = str.replace(/\s+/g, '');
                                            str = str.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
                                            $(this).prop( 'value', str );
                                    ">
                                    <select name="advert[id_currency]" class="form-control currency-field">
                                        <?php foreach ($currencies->find() as $currency) { ?>
                                            <option
                                                value="<?= $currency->id_currency ?>" <?= ($currency->id_currency == $advert->id_currency) ? 'selected' : '' ?>>
                                                <?= $currency->currency_name; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div
                                class="form-group<?= (in_array('creation_date', $f3->get('errors'))) ? ' has-error' : ''; ?>">
                                <label class="col-lg-2 control-label">Дата создания:</label>
                                <div class="col-lg-2">
                                    <input type="text" name="advert[creation_date]" class="form-control"
                                           disabled="disabled"
                                           value="<?php if (isset($advert->creation_date) and !empty($advert->creation_date)) {
                                               echo $advert->creation_date;
                                           } else {
                                               $date = new \DateTime();
                                               $date = $date->format('d-m-Y H:i:s');
                                               echo $date;
                                           }
                                           ?>">
                                </div>
                                <label class="col-lg-2 control-label">Дата последнего обновления:</label>
                                <div class="col-lg-2">
                                    <input type="text" name="advert[last_update_date]" class="form-control"
                                           disabled="disabled"
                                           value="<?php if (isset($advert->last_update_date) and !empty($advert->last_update_date)) {
                                               echo $advert->last_update_date;
                                           } else {
                                               $date = new \DateTime();
                                               $date = $date->format('d-m-Y H:i:s');
                                               echo $date;
                                           }
                                           ?>">
                                </div>

                                <label class="col-lg-2 control-label">Действует до:</label>
                                <div class="col-lg-2">
                                    <div class="input-group date" data-provide="datepicker"
                                         data-date-format="dd-mm-yyyy">
                                        <input name="advert[expire_date]" type="text" class="form-control"
                                               value="<?= (isset($advert->expire_date) and !empty($advert->expire_date)) ? date('d-m-Y', strtotime($advert->expire_date)) : '' ?>">
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

                            <input type="text" name="advert[id_advert]" class="hidden"
                                   value="<?= $advert->id_advert; ?>">
                            <div
                                class="form-group<?= (in_array('deal_status', $f3->get('errors'))) ? ' has-error' : ''; ?>">
                                <label class="col-lg-3 control-label">Статус сделки*:</label>
                                <div class="col-lg-8">
                                    <select name="advert[id_deal_status]" class="form-control">
                                        <option value="">Не выбрано</option>
                                        <?php foreach ($deal_statuses->find() as $status) { ?>
                                            <option
                                                value="<?= $status->id_deal_status ?>" <?= ($status->id_deal_status == $advert->id_deal_status) ? 'selected' : '' ?>>
                                                <?= $status->deal_status_name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-4 control-label">Не для агентов:</label>
                                <div class="col-lg-2">
                                    <div class="checkbox">
                                        <input type="checkbox"
                                               name="advert[not_for_agents]" <?php if ($advert->not_for_agents == '1') echo 'checked="checked"'; ?>>
                                    </div>
                                </div>

                                <label class="col-lg-4 control-label">Ипотека:</label>
                                <div class="col-lg-2">
                                    <div class="checkbox">
                                        <input type="checkbox"
                                               name="advert[mortgage]" <?php if ($advert->mortgage == '1') echo 'checked="checked"'; ?>>
                                    </div>
                                </div>

                                <label class="col-lg-4 control-label">Торг:</label>
                                <div class="col-lg-2">
                                    <div class="checkbox">
                                        <input type="checkbox"
                                               name="advert[haggle]" <?php if ($advert->haggle == '1') echo 'checked="checked"'; ?>>
                                    </div>
                                </div>

                                <label class="col-lg-4 control-label">Залог:</label>
                                <div class="col-lg-2">
                                    <div class="checkbox">
                                        <input type="checkbox"
                                               name="advert[rent_pledge]" <?php if ($advert->rent_pledge == '1') echo 'checked="checked"'; ?>>
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
                                <input type="submit" value="<?=(isset($advert->id_advert) and $advert->id_advert>0)?'Обновить' : 'Сохранить'?>" class="btn btn-primary">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>


    </div>
</section>
<script src="<?= $f3->get("homeurl") ?>/inc/jscss/admin/plugins/image/imageupload.js"></script>
<script src="<?= $f3->get("homeurl") ?>/inc/jscss/admin/autocomplete.js"></script>

