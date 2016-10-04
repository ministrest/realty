<section class="content">
    <div class="row">
        <form role="form" class="form-horizontal" name="agent" method="post" ENCTYPE="multipart/form-data"
              action="<?= $action ?>">
            <div class="col-lg-7">
                <div class="box box-primary">
                    <!-- form start -->
                    <div class="box-body">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Пользователь:</label>
                            <div class="col-lg-8">
                                <select name="agent[id_user]" class="form-control">
                                    <?php foreach ($users->find() as $user) { ?>
                                        <option
                                            value="<?= $user->id_user ?>" <?= ($agent->id_user == $user->id_user) ? 'selected' : '' ?>>
                                            <?= $user->login ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">ФИО:</label>
                            <div class="col-lg-8">
                                <input type="text" name="agent[name]" class="form-control" placeholder="Имя"
                                       value="<?= $agent->name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Телефон:</label>
                            <div class="col-lg-8">
                                <input type="text" name="agent[phone]" class="form-control" placeholder="89*********"
                                       value="<?= $agent->phone; ?>">
                                <p>
                                    <small>Введите номер начиная с восьмёрки либо шестизначный номер</small>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Доп. номер:</label>
                            <div class="col-lg-8">
                                <input type="text" name="agent[additional_number]" class="form-control" placeholder=""
                                       value="<?= $agent->additional_number; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Персональный номер:</label>
                            <div class="col-lg-4">
                                <input type="text" name="agent[personal_number]" class="form-control" placeholder=""
                                       value="<?= $agent->personal_number; ?>">
                            </div>
                            <label class="col-lg-3 control-label">Показывать:</label>
                            <div class="col-lg-2">
                                <div class="checkbox">
                                    <input type="checkbox"
                                           name="agent[number_is_visible]" <?php if ($agent->number_is_visible == '1') echo 'checked="checked"'; ?>>
                                </div>
                            </div>
                        </div>
                        <div class="form-group<?= (isset($errors['birthday'])) ? ' has-error' : ''; ?>">
                            <label class="col-lg-3 control-label">Дата рождения:</label>
                            <div class="col-lg-8">
                                <input type="text" name="agent[birthday]" class="form-control" placeholder="01-01-2001"
                                       value="<?= date('d-m-Y', strtotime($agent->birthday)); ?>">
                                <?php if (isset($errors['birthday'])): ?>
                                    <p class="text-danger"><i
                                            class="fa fa-times-circle-o"></i> <?= $errors['birthday']; ?></p>
                                <?php endif; ?>
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
        </form>
        <div class="col-lg-5">
            <div class="box">
                <div class="box-body">
                    <?php
                    if ($users->checkAccess('users', $f3)) {
                        if (isset($agent->id_user)) {
                            ?>
                            <p>
                                <a href="<?= $f3->get("homeurl") ?>/admin/users/edit/<?= $agent->id_user ?>"
                                   class="form-control btn btn-primary">
                                    Посмотреть пользователя</a>
                            </p>
                            <p>
                                <a href="<?= $f3->get("homeurl") ?>/admin/adverts/list<?= ($agent->id_user > 0) ? "?user=" . $agent->id_user : '' ?>"
                                   class="form-control btn btn-primary"> Все объявления пользователя</a>
                            </p>
                        <?php } ?>
                        <p>
                            <a href="<?= $f3->get("homeurl") ?>/admin/users/list" class="form-control btn btn-primary">
                                Список пользоватеей</a>
                        </p>
                    <?php } elseif ($users->checkAccess('agents', $f3)) {
                        if (isset($agent->id_user)) {
                            ?>
                            <p>
                                <a href="<?= $f3->get("homeurl") ?>/admin/adverts/list<?= ($agent->id_user > 0) ? "?user=" . $agent->id_user : '' ?>"
                                   class="form-control btn btn-primary"> Все объявления пользователя</a>
                            </p>
                        <?php } ?>
                        <p>
                            <a href="<?= $f3->get("homeurl") ?>/admin/agents/contacts"
                               class="form-control btn btn-primary">
                                Контакты агентов</a>
                        </p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>