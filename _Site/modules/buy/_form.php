<h1 class="headline headline_main">Хорошие сделки для хороших людей </h1>
<div class="search">
    <form name="search" class="form" role="form" method="post" ENCTYPE="multipart/form-data" action="/buy/search">

        <h2 class="headline">Поиск по базе недвижимости</h2>

        <div class="control-group">
            <div class="radio">
                <div class="radio__item">
                    <input class="radio__button" type="radio" name="option" id="simple_search" value="simple_search" onchange="checkSearch()" checked/>
                    <label class="radio__label" for="simple_search">Обычный поиск</label>
                </div>
                <div class="radio__item">
                    <input class="radio__button" type="radio" name="option" id="advance_search"
                           value="advance_search" onchange="checkSearch()"/>
                    <label class="radio__label" for="advance_search">Расширенный</label>
                </div>
            </div>
            <br/>
        </div>
        <div class="control-group">
            <label class="label">Общая площадь, м<sup>2</sup>:</label>
                <span class="input">
                    <span class="input__box">
                        <input type="text" class="input__control" name="search[square_start]" value="<?= (isset($search['square_start'])) ? $search['square_start'] : ''?>" placeholder="от">
                    </span>
                </span>
                <span class="input">
                    <span class="input__box">
                        <input type="text" class="input__control" name="search[square_end]" value="<?= (isset($search['square_end'])) ? $search['square_end'] : '' ?>" placeholder="до">
                    </span>
                </span>
        </div>
        <div class="control-group">
            <label class="label">Количество комнат:<sup> </sup></label>
            <div>
                <input type="text" id="range" value="" name="search[range]"/>
            </div>
            <script type="text/javascript">
                $(function () {
                    $("#range").ionRangeSlider({
                        hide_min_max: true,
                        keyboard: true,
                        min: 0,
                        max: 4,
                        hide_from_to: true,
                        from: 1,
                        to: 3,
                        type: 'double',
                        step: 1,
                        grid: true
                    });

                });
            </script>
        </div>
        <div class="control-group">
            <label class="label">Цена:<sup> </sup></label>
            <span class="input">
                <span class="input__box">
                    <input type="text" class="input__control" id="price_start" value="<?= (isset($search['price_start'])) ? $search['price_start'] : ''  ?>" name="search[price_start]" placeholder="от">
                </span>
            </span>
            <span class="input">
                <span class="input__box">
                    <input type="text" class="input__control" id="price_end" value="<?= (isset($search['price_end'])) ? $search['price_end'] : '' ?>" name="search[price_end]" placeholder="до">
                </span>
            </span>
        </div>
        <div class="form__advance">
            <div class="control-group">
                <label class="label">Площадь кухни, м<sup>2</sup>:</label>
                <span class="input">
                    <span class="input__box">
                        <input type="text" class="input__control" name="search[square_kitchen_start]" value="<?= (isset($search['square_kitchen_start'])) ? $search['square_kitchen_start']:'' ?>" placeholder="от">
                    </span>
                </span>
                <span class="input">
                    <span class="input__box">
                        <input type="text" class="input__control" name="search[square_kitchen_end]" value="<?= (isset($search['square_kitchen_end'])) ? $search['square_kitchen_end'] : '' ?>" placeholder="до">
                    </span>
                </span>
                <br/>
                <div class="control-group">
                    <label class="label">Тип дома:</label>
                    <input type="checkbox" class="checkbox" name="search[any_building]" value="" id="all_buildings" checked="checked"> Любой<br/>
                    <?php foreach ($building_types->find() as $building_type) { ?>
                        <input type="checkbox" class="checkbox check_building disabled" name="search[building_type][]"
                               value="<?= $building_type->id_building_type ?>"
                            <?= (isset($search['building_type']) && is_array($search['building_type']) && in_array($building_type->id_building_type, $search['building_type'])) ? 'checked="checked"' : '' ?> disabled>
                        <?= $building_type->building_type_name; ?>
                        <br/>
                    <?php } ?>
                </div>
            </div>

            <div class="control-group">
                <label class="label">Выберите что вам нужно<sup></sup>:</label>
                <div class="select select_big">
                    <select class="select__control select_big" name="search[realty_type]" size="1">
                        <option value="">Не выбрано</option>
                        <?php foreach ($categories->find() as $category) { ?>
                            <option value="<?= $category->id_category_object ?>" <?= (isset($search['realty_type']) && $category->id_category_object == $search['realty_type']) ? 'selected' : '' ?>>
                                <?= $category->category_object_name ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="control-group">
                    <label class="label">Этаж:</label>
                    <span class="input">
                        <span class="input__box">
                            <input type="text" class="input__control" name="search[floor_start]" value="<?= (isset($search['floor_start'])) ? $search['floor_start'] : '' ?>" id="floor_start" placeholder="от">
                        </span>
                    </span>
                    <span class="input">
                        <span class="input__box">
                            <input type="text" class="input__control" name="search[floor_end]" value="<?= (isset($search['floor_end'])) ? $search['floor_end'] : '' ?>" id="floor_end" placeholder="до">
                        </span>
                    </span>
                    <br/>
                    <p class="paragraf">
                        <input type="checkbox" class="checkbox" name="search[floor_first]" value="1"/>Только не первый этаж<br/>
                        <input type="checkbox" class="checkbox" name="search[floor_last]" value="2"/>Только не последний этаж<br/>
                    </p>
                    <label class="label">Этажность дома:</label>
                    <span class="input">
                        <span class="input__box">
                            <input type="text" class="input__control" id="floors_start" name="search[floors_start]" value="<?= (isset($search['floors_start'])) ? $search['floors_start'] : '' ?>" placeholder="от">
                        </span>
                    </span>
                    <span class="input">
                        <span class="input__box">
                            <input type="text" class="input__control" id="floors_end" name="search[floors_end]" value="<?= (isset($search['floors_end'])) ? $search['floors_end'] : '' ?>" placeholder="до">
                        </span>
                    </span>
                </div>
            </div>
        </div>
        <div class="form__advance">
            <div class="control-group search__settings">
                <input type="checkbox" class="checkbox" name="search[images]" value="1"/>Только с фотографией<br/>
                <input type="checkbox" class="checkbox" name="search[balcony]" value="2"/>Только с балконом/лоджией<br/>
                <input type="checkbox" class="checkbox" name="search[mortgage]" value="3"/>Возможна ипотека<br/>
                <input type="checkbox" class="checkbox" name="search[new_flat]" value="4"/>Новостройки<br/>
                <input type="checkbox" class="checkbox" name="search[old_flat]" value="5"/>Вторичка<br/>
                <div class="control-group">
                    <label class="label">Санузел:</label>
                    <input type="checkbox" class="checkbox" id="any_toilet" name="search[any_toilet]" checked="checked" value="0"/>Не важно<br/>
                    <div class="select_toilet disabled">
                        от
                        <div class="select select_small">
                            <select class="select__control select_small" name="search[toilet_amount]" size="1">
                                <option selected="selected" value="">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                        <div class="select select_medium">
                            <select class="select__control select_medium" name="search[toilet_type]" size="1">
                                <option selected="selected" value="">Любой</option>
                                <option value="Раздельный">Раздельный</option>
                                <option value="Совмещенный">Совмещенный</option>
                            </select>
                        </div>
                    </div>

                    <p><label class="label">Лифты:</label></p>
                    минимум
                    <div class="select select_small">
                        <select class="select__control select_small" name="search[elevator_amount]" size="1">
                            <option selected="selected" value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="control-group control-group_left">
            <a href="/buy/all" class="button button_form">Показать всю недвижимость (<?php
                $adverts = new \goodman\models\Advert_info();
                $count_adverts = $adverts->count();
                echo $count_adverts;
                ?>)</a>
        </div>
        <div class="control-group control-group_right">
            <?php if (count($search)>0) { ?>
                <a href="/buy/search?refresh=true" class="button button_underline">Сбросить</a>
            <?php } else { ?>
                <input type="reset" class="button button_underline" id="reset" value="Очистить поля">
            <?php } ?>

            <input type="submit" class="button button_form" id="flat_search" value="Показать">
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        document.getElementById("all_buildings").onclick = function () {
            var elems = document.getElementsByClassName("check_building");
            for (var i = 0; i < elems.length; i++) {
                if (elems[i].type == "checkbox" && elems[i].className.split(" ").in_array("disabled")) {
                    if (this.checked) {
                        elems[i].checked = true;
                        elems[i].disabled = true;
                    } else {
                        elems[i].checked = false;
                        elems[i].disabled = false;
                    }
                }
            }
        }

        document.getElementById("any_toilet").onclick = function () {
            $(".select_toilet").toggleClass("disabled");
        }

        Array.prototype.in_array = function (name) {
            for (var i = 0; i < this.length; i++) {
                if (this[i] == name) {
                    return true;
                }
            }
            return false;
        }
    });
</script>