<div class="contact">
    <div class="messages" id="messages"></div>
    <form class="form" id="contact_form" name="contact" role="form" method="post" ENCTYPE="multipart/form-data" action="/contacts">
        <h2 class="headline">Оставьте номер, мы вам перезвоним </h2>
        <div class="control-group">
            <label>Имя:</label> <br/>
            <span class="input">
                <span class="input__box">
                    <input type="text" class="input__control" name="name_client" id="name_client">
                </span>
            </span>
            <div class="error_empty_txt">Заполните поле, пожалуйста</div>
        </div>
        <div class="control-group">
            <label>Телефон:</label> <br/>
            <span class="input">
                <span class="input__box">
                    <input type="text" class="input__control" name="number_client" id="number_client">
                </span>
            </span>
            <div class="error_empty_txt">Заполните поле, пожалуйста</div>
        </div>
        <div class="control-group">
            <input id="contact_me" class="button button_form button_submit contact_me_button" value="Отправить заявку">
        </div>
        <span class="icon icon_helper"></span>
    </form>
</div>