<section class="content-header">
    <h1>Контакты агентов</h1>
    <ol class="breadcrumb">
        <li><a href="/admin/"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li class="active">Контакты агентов</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body table-responsive no-padding">
                    <table id="agents_tbl" class="table table-hover">
                        <thead>
                        <tr>
                            <th>ФИО</th>
                            <th>Email</th>
                            <th>Рабочий номер</th>
                            <th>Доп. номер</th>
                            <th>Личный. номер</th>
                            <th>День рождения</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($agents->find() as $agent): ?>
                            <tr>
                                <td><?= $agent->name ?></td>
                                <td><?= $agent->getEmail() ?></td>
                                <td><?= $agent->formatPhone($agent->phone) ?></td>
                                <td><?php if (isset($agent->additional_number)) { ?><?= $agent->formatPhone($agent->additional_number) ?><?php } ?></td>
                                <td><?php if (isset($agent->personal_number) and !empty(($agent->personal_number))) {
                                        if ($agent->number_is_visible == '1') {
                                            ?><?= $agent->formatPhone($agent->personal_number) ?>
                                        <?php } elseif ($agent->number_is_visible == '0') { /*?>номер скрыт<?php*/
                                        }
                                    } ?></td>
                                <td><?= date('d/m', strtotime($agent->birthday)) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?= $f3->get("homeurl") ?>/inc/jscss/admin/plugins/datatable/datatable.min.js"></script>
<script>
    $(document).ready(function () {
        $('#agents_tbl').DataTable();
    });
</script>