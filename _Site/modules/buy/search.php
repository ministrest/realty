<?php
use goodman\models\Category_object;
use goodman\models\Building_type;
use goodman\models\Advert_info;
use goodman\helpers\Search;

$page = $f3->get('pageHelper');
$module = 'buy';
setcookie("goodman[module]", $module, time() + 60 * 60 * 24 * 30);

// создаем хелпер для поиска
$helper = new Search($f3, 'filters');

// Если пришел флаг сброса фильтра - сбрасываем и перезагружаем страницу
if (filter_input(INPUT_GET,'refresh')) {
	$helper->refresh();
	$f3->reroute('/buy/search');
}

// если пришли данные с фильтра применим их
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$helper->applyParams($_POST['search']);
	$f3->reroute('/buy/search');
}

$category = filter_input(INPUT_GET, 'category', FILTER_VALIDATE_INT);
if ($category) {
	$helper->applyCategory($category);
}

$searchResult = $helper->getSearchResult();
// если есть такие объявления продолжим работу
if (is_array($searchResult)) {
	$filters = $helper->getFilters();
		$end_element = array_pop($searchResult);
		foreach ($searchResult as $result) {
			$condition_res .= $result['id_advert'] . ',';
		}
		$condition_res .= $end_element['id_advert'];
	$filter = array('id_advert IN ('.$condition_res.')');
	$limit = 10;
	$page_p = \Pagination::findCurrentPage();
	$option = array('order' => 'creation_date DESC');

	$adverts = new Advert_info();
	$subset = $adverts->paginate($page_p - 1, $limit, $filter, $option);

	$result_search = $subset['subset'];
	$pages = new Pagination($subset['total'], $subset['limit']);
}

$categories     = new Category_object();
$building_types = new Building_type();

$page->css[] = '/inc/jscss/ionSlider/css/normalize.css';
$page->css[] = '/inc/jscss/ionSlider/css/ion.rangeSlider.css';
$page->css[] = '/inc/jscss/ionSlider/css/ion.rangeSlider.skinHTML5.css';
$page->css[] = '/inc/jscss/fotorama/fotorama.css';
$page->js[]  = '/inc/jscss/fotorama/fotorama.js';
$page->js[]  = '/inc/jscss/ionSlider/js/ion.rangeSlider.min.js';
$page->pageTitle = "Покупка недвижимости в Саратове - цены и предложения ";

$page->printHead();
include HOMEDIR . '/inc/tpl/header.tpl.php';
include HOMEDIR . '/inc/tpl/navigation.tpl.php';
include __DIR__ .  '/list.tpl.php';
include HOMEDIR . '/inc/tpl/sider_right.tpl.php';
include HOMEDIR . '/inc/tpl/footer.tpl.php';