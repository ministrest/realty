<?php
/** @var \NMG\Page\Page $page */

$page = $f3->get('pageHelper');
if (isset($_COOKIE['goodman']['module'])) {
    $module = $_COOKIE['goodman']['module'];
} else {
    $module = 'buy';
}
$page->js[] = 'https://api-maps.yandex.ru/2.1/?lang=ru_RU';
$page->js[] = '/inc/jscss/contact.js';

if(isset($_POST['name_client'])){

        $message  = "Имя пользователя: " . $_POST['name_client'] . "<br/>";
        $message .= "Телефон пользователя: " . $_POST['number_client'] . "<br/>";
        $agent = new \goodman\models\Category_agent();
        $agent->send_mail($message); // отправим письмо
        $msg_box = "<div class='messages_content'><h2 class=\"headline\">Спасибо за Ваше обращение к нам!</h2><p>Сообщение отправлено, скоро наш сотрудник с Вами свяжется.</p></div>";


    // делаем ответ на клиентскую часть в формате JSON
    echo json_encode(array(
        'result' => $msg_box
    ));

} else {
    $page->pageTitle = "Купить и продать недвижимость в Саратове - контакты ";
    $page->printHead();

    include HOMEDIR . '/inc/tpl/header.tpl.php';
    include HOMEDIR . '/inc/tpl/navigation.tpl.php';

    include __DIR__ . '/index.tpl.php';

    include HOMEDIR . '/inc/tpl/sider_right.tpl.php';
    include HOMEDIR . '/inc/tpl/footer.tpl.php';
}