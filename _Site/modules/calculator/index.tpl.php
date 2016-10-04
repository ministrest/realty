<div class="content__main">
    <h1 class="headline headline_main">Хорошие сделки для хороших людей </h1>
    <div class="calculator">
        <form class="form" id="calculator_form" name="calculator" role="form" method="post" ENCTYPE="multipart/form-data" action="/calculator">
            <h2 class="headline">Ипотечный калькулятор</h2>
            <div class="control-group control-group_big">
                <label>Стоимость квартиры, рубли:</label> <br/>
                <span class="input">
                    <span class="input__box">
                        <input type="text" class="input__control <?=(isset($errors['price'])?' error':'')?>" name="calculator[price]" value="<?=$_POST['calculator']['price']?>" onchange="
                                            var str = $(this).val();
                                            str = str.replace(/\s+/g, '');
                                            str = str.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
                                            $(this).prop( 'value', str );
                                    ">
                    </span>
                </span>
            </div>
            <div class="control-group control-group_big">
                <label>Первоначальный взнос, рубли:</label> <br/>
                <span class="input">
                    <span class="input__box">
                        <input type="text" class="input__control <?=(isset($errors['initial_fee'])?' error':'')  ?>" name="calculator[initial_fee]" value="<?=$_POST['calculator']['initial_fee']?>" onchange="
                                            var str = $(this).val();
                                            str = str.replace(/\s+/g, '');
                                            str = str.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
                                            $(this).prop( 'value', str );
                                    ">
                    </span>
                </span>
            </div>
            <div class="control-group control-group_small">
                <label>Процент, %:</label> <br/>
                <span class="input">
                    <span class="input__box">
                        <input type="text" class="input__control <?=(isset($errors['procent'])?' error':'')  ?>" name="calculator[procent]"  value="<?=$_POST['calculator']['procent']?>">
                    </span>
                </span>
            </div>
            <div class="control-group control-group_small">
                <label>Срок кредитования:</label> <br/>
                <div class="select select_medium">
                    <select class="select__control select_medium" name="calculator[period]" size="1">
                        <?php for($i=5;$i<45;$i=$i+5){ ?>
                        <option value="<?=$i?>" <?= ($_POST['calculator']['period'] == $i )? 'selected' : '' ?>><?=$i?> лет</option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <?php
            if(isset($ap) and $ap>0){?>
                <p> <label> Сумма кредита:</label> <span class="calculation-result"><?= number_format($kp, 2, ' . ', ' '); ?> &#8381;</span></p>
                <p> <label> Полная сумма платежа:</label> <span class="calculation-result"><?= number_format($ap*$t, 2, ' . ', ' '); ?> &#8381;</span></p>
                <p> <label> Размер ежемесячного платежа:</label>  <span class="calculation-result"><?= number_format(($ap), 2, ' . ', ' '); ?> &#8381;</span></p>
                <p> <label> Переплата за кредит:</label>  <span class="calculation-result"><?= number_format(($ap*$t-$kp), 2, ' . ', ' '); ?> &#8381;</span></p>
                <p> <label> Начало выплат:</label>  <?= date('Y') ?></p>
                <p> <label> Окончание выплат:</label>  <?= (date('Y')+$_POST["calculator"]["period"]) ?></p>
            <?php } ?>
            <div class="control-group control-group__submit">
                <input  type="submit" id="calculate_me" class="button button_form button_submit calculate_me_button" value="Рассчитать">
            </div>
            <span class="icon icon_helper"></span>
        </form>
    </div>
    <?php if(isset($ap) and $ap>0){?>
        <?php include HOMEDIR . '/modules/contacts/_form.php'; ?>
    <?php } else {?>
        <p class="paragraf">Здесь Вы можете самостоятельно рассчитать размер ежемесячных выплат по погашению ипотечного кредита,
            ппроанализировать условия кредитования, предлагаемые различными банками и выбрать предложение, которое будет устраивать
            именно Вас. </p>
        <p class="paragraf">Чтобы получить интересующий результат необходимо заполнить поля формы данными и нажать на кнопку "Рассчитать".
            В поле "Стоимость квартиры" введите сумму кредита, который вы планируете взять. В поле "Процент" введите процентную ставку по кредиту.
            В поле "Начальный взнос" внесите сумму, которую вы планируете внести в счет погашения кредита сразу. </p>
    <?php } ?>
</div>