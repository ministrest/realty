<?php
/** @var \NMG\Page\Page $page */
$page = $f3->get('pageHelper');
$module = 'buy';
$page->printHead();

?>


        <div class="container">
    <div class="content__main">
        <h1 class="headline headline_main">Страница не найдена</h1>
        <p>Страницы, которую вы искали, не существует. Попробуйте вернуться назад и открыть другую ссылку.</p>
        <div class="search-view">
            <div class="search-view__nav">
                <a href="javascript:history.back();" class="button button_gray">Назад</a>
                <a href="/buy/search" class="button button_gray">Поиск недвижимости</a>
            </div>
        </div>
    </div>
            </div>
<?php

include HOMEDIR . '/inc/tpl/footer.tpl.php';
