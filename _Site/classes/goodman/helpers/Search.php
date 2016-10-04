<?php
/**
 * @author Andrey A. Nechaev <nechaev@nmgcom.ru>
 * @copyright Copyright (c) 2016 Nechaev Marketing Group (http://www.nmgcom.ru)
 */
namespace goodman\helpers;

/**
 * Class Search
 * Helper для работы с поиском через фильтры
 * @package goodman\helpers
 */
class Search
{

    protected $f3;

    /**
     * @var string имя параметра cookie где лежат параметры фильтра
     */
    protected $cookieName;

    /**
     * @var bool|int категория для выборки
     */
    protected $category = false;

    /**
     * @var string условия для выборки
     */
    protected $condition = '1';

    /**
     * Search constructor.
     * @param \Base $f3 экземпляр FatFree
     * @param string $cookie имя параметра cookie где лежат параметры фильтра
     */
    public function __construct($f3, $cookie)
    {
        $this->f3 = $f3;
        $this->cookieName = $cookie;
    }

    /**
     * функция сбрасывает параметры поиска
     */
    public function refresh()
    {
        setcookie($this->cookieName, '', 1);
    }

    /**
     * Функция устанавливает параметры поиска
     * @param array $params массив с параметрами
     */
    public function applyParams($params)
    {
        $filters = $this->secureParams($params);
        setcookie($this->cookieName, json_encode($filters), time() + 3600 * 24 * 10);
    }

    /**
     * Функция применяет категорию к выборке
     * @param int $id id категории
     */
    public function applyCategory($id)
    {
        $this->category = $id;
    }

    /**
     * Возвращает массив id объявлений по фильтру либо 0
     * @return mixed
     */
    public function getSearchResult()
    {
        $filters = $this->getFiltersParams();
        $condition = $this->getCondition($filters);
        $this->condition = $condition;

        //найдем id объявлений, которые подходят
        $sql = 'SELECT advert_info.id_advert
			  	  FROM advert_info, object_info, building_description
			 	 WHERE advert_info.id_object = object_info.id_object
			   	   AND building_description.id_address = object_info.id_address
			   	   AND ' . $condition;
        $results = $this->f3->get('db.instance')->exec($sql);
        return (count($results) == 0) ? 0 : $results;
    }

    /**
     * Возвращает количество объявлений по категориям
     * @return mixed
     */
    public function getFilters()
    {
        $sql_f = 'SELECT count(id_advert) as summ,
					 advert_info.id_category,
					 category_object.category_object_name as category
				FROM advert_info,
					 category_object,
					 object_info,
					 building_description
			   WHERE advert_info.id_category = category_object.id_category_object
			     AND advert_info.id_object = object_info.id_object
				 AND building_description.id_address = object_info.id_address
				 AND ' . $this->condition . '
			   GROUP BY id_category';
        $filters = $this->f3->get('db.instance')->exec($sql_f);
        return $filters;
    }

    /**
     * Функция возвращает условия выборки для запроса (после WHERE)
     * @param array $filters массив с фильтрами
     * @return string условие выборки
     */
    protected function getCondition($filters)
    {
        // если фильтры пусты возвращаем 1
        if (count($filters) == 0 && !$this->category) {
            return '1';
        }
        $conditions = array();
        foreach ($filters as $key => $val) {
            if ($key == 'square_start' && $val > 0) {
                $conditions[] = 'object_info.full_space >= ' . $val;
            }
            if ($key == 'square_end' && $val > 0) {
                $conditions[] = 'object_info.full_space <= ' . $val;
            }
            if ($key == 'price_start' && $val > 0) {
                $conditions[] = 'advert_info.value >= ' . $val;
            }
            if ($key == 'price_end' && $val > 0) {
                $conditions[] = 'advert_info.value <= ' . $val;
            }
            if ($key == 'range') {
                $range = explode(";", $val);
                if (empty($range[0])) $range[0] = 0;
                if (!isset($range[1]) or $range[1] == 4) {
                    $conditions[] = 'object_info.rooms >= ' . $range[0];
                } else {
                    $conditions[] = ' object_info.rooms >= ' . $range[0] . ' AND object_info.rooms <= ' . $range[1];
                }
            }
            if ($key == 'balcony' && $val == 1) {
                $conditions[] = 'object_info.balcony NOT IN (NULL, "нет", 0)';
            }
            if ($key == 'toilet_amount' && $val > 0 && !isset($filters['any_toilet'])) {
                $conditions[] = 'object_info.toilet_amount >= ' . $val;
            }
            if ($key == 'toilet_type' && !isset($filters['any_toilet'])) {
                $conditions[] = 'object_info.bathroom_unit ="' . $val . '"';
            }
            if ($key == 'elevator_amount' && $val >= 0) {
                $conditions[] = 'object_info.elevator_amount >= ' . $val;
            }
            if ($key == 'images') {
                $conditions[] = '(SELECT count(id_image) FROM images WHERE images.id_object=object_info.id_object) > 0';
            }
            if ($key == 'mortgage') {
                $conditions[] = 'advert_info.mortgage = 1';
            }
            if ($key == 'new_flat' && !isset($filters['old_flat'])) {
                $conditions[] = 'object_info.new_flat = 1';
            }
            if ($key == 'old_flat' && !isset($filters['new_flat'])) {
                $conditions[] = 'object_info.new_flat = 0';
            }
            if ($key == 'square_kitchen_start' && $val > 0) {
                $conditions[] = 'object_info.kitchen_space >= ' . $val;
            }
            if ($key == 'square_kitchen_end' && $val > 0) {
                $conditions[] = 'object_info.kitchen_space <= ' . $val;
            }
            if ($key == 'floor_start' && $val > 0) {
                $conditions[] = 'object_info.floor >= ' . $val;
            }
            if ($key == 'floor_end' && $val > 0) {
                $conditions[] = 'object_info.floor <= ' . $val;
            }
            if ($key == 'floor_first') {
                $conditions[] = 'object_info.floor > 1';
            }
            if ($key == 'floor_last') {
                $conditions[] = 'object_info.floor < building_description.floors_total';
            }
            if ($key == 'floors_start' && $val > 0) {
                $conditions[] = 'building_description.floors_total >= ' . $val;
            }
            if ($key == 'floors_end' && $val > 0) {
                $conditions[] = 'building_description.floors_total <= ' . $val;
            }
            if ($key == 'building_type' && !isset($filters['any_building']) && is_array($val)) {
                $conditions[] = 'building_description.id_building_type IN (' . implode(',', $val) . ')';
            }
            if ($key == 'realty_type' && $val > 0) {
                $conditions[] = 'advert_info.id_category = ' . $val;
            }
        }
        if ($this->category) {
            $conditions[] = 'advert_info.id_category = ' . $this->category;
        }
        return implode(' AND ', $conditions);
    }

    /**
     * Функция возвращает параметры фильтров
     * @return array
     */
    protected function getFiltersParams()
    {
        return (isset($_COOKIE[$this->cookieName])) ? json_decode($_COOKIE[$this->cookieName], true) : array();
    }

    /**
     * Функция фильтрует параметры для безопасности
     * @param  array $params переданные параметры
     * @return array отфильтрованные параметры
     */
    protected function secureParams($params)
    {
        foreach ($params as $key => $val) {
            $options = array(
                'options' => array(
                    'default' => 0,
                    'min_range' => 0
                ),
                'flags' => FILTER_NULL_ON_FAILURE
            );

            if ($key == 'square_start') {
                $val = str_replace(',', '.', $val);
                if (filter_var($val, FILTER_VALIDATE_FLOAT)) {
                    $params['square_start'] = $val;
                } else {
                    unset($params['square_start']);
                }
            }
            if ($key == 'square_end') {
                $val = str_replace(',', '.', $val);
                if (filter_var($val, FILTER_VALIDATE_FLOAT)) {
                    if ($params['square_start'] >= 0 and $val < $params['square_start']) {
                        $params['square_end'] = $params['square_start'];
                    } else {
                        $params['square_end'] = $val;
                    }
                }else {
                    unset($params['square_end']);
                }
            }
            if ($key == 'price_start') {
                $params['price_start'] = filter_var($val, FILTER_VALIDATE_INT, $options);
            }
            if ($key == 'price_end') {
                $params['price_end'] = filter_var($val, FILTER_VALIDATE_INT, $options);
                if ($params['price_start'] >= 0 and $val < $params['price_start']) {
                    $params['price_end'] = $params['price_start'];
                }
            }
            if ($key == 'range') {
                $range = explode(";", $val);
                $range[0] = filter_var($range[0], FILTER_VALIDATE_INT, $options);
                $range[1] = filter_var($range[1], FILTER_VALIDATE_INT, $options);
                $params['range'] = implode(";", array($range[0], $range[1]));
            }
            if ($key == 'balcony') {
                $params['balcony'] = filter_var($val, FILTER_VALIDATE_BOOLEAN, array('flags' => FILTER_NULL_ON_FAILURE));
            }
            if ($key == 'toilet_amount') {
                $params['toilet_amount'] = filter_var($val, FILTER_VALIDATE_INT, $options);
            }
            if ($key == 'toilet_type') {
                $params['toilet_type'] = filter_var($val, FILTER_SANITIZE_STRING);
            }
            if ($key == 'elevator_amount') {
                $params['elevator_amount'] = filter_var($val, FILTER_VALIDATE_INT, $options);
            }
            if ($key == 'images') {
                $params['images'] = filter_var($val, FILTER_VALIDATE_BOOLEAN, array('flags' => FILTER_NULL_ON_FAILURE));
            }
            if ($key == 'mortgage') {
                $params['mortgage'] = filter_var($val, FILTER_VALIDATE_BOOLEAN, array('flags' => FILTER_NULL_ON_FAILURE));
            }
            if ($key == 'new_flat') {
                $params['new_flat'] = filter_var($val, FILTER_VALIDATE_BOOLEAN, array('flags' => FILTER_NULL_ON_FAILURE));
            }
            if ($key == 'old_flat') {
                $params['old_flat'] = filter_var($val, FILTER_VALIDATE_BOOLEAN, array('flags' => FILTER_NULL_ON_FAILURE));
            }
            if ($key == 'square_kitchen_start') {
                $val = str_replace(',', '.', $val);
                if (filter_var($val, FILTER_VALIDATE_FLOAT)) {
                    $params['square_kitchen_start'] = $val;
                } else {
                    unset($params['square_kitchen_start']);
                }
            }
            if ($key == 'square_kitchen_end') {
                $val = str_replace(',', '.', $val);
                if (filter_var($val, FILTER_VALIDATE_FLOAT)) {
                    if ($params['square_kitchen_start'] >= 0 and $val < $params['square_kitchen_start']) {
                        $params['square_kitchen_end'] = $params['square_kitchen_start'];
                    } else {
                        $params['square_kitchen_end'] = $val;
                    }
                } else {
                    unset($params['square_kitchen_end']);
                }
            }
            if ($key == 'floor_start') {
                $params['floor_start'] = filter_var($val, FILTER_VALIDATE_INT, $options);
            }
            if ($key == 'floor_end' && $val > 0) {
                $params['floor_end'] = filter_var($val, FILTER_VALIDATE_INT, $options);
                if ($params['floor_start'] >= 0 and $val < $params['floor_start']) {
                    $params['floor_end'] = $params['floor_start'];
                }
            }
            if ($key == 'floor_first') {
                $params['floor_first'] = filter_var($val, FILTER_VALIDATE_BOOLEAN, array('flags' => FILTER_NULL_ON_FAILURE));
            }
            if ($key == 'floor_last') {
                $params['floor_last'] = filter_var($val, FILTER_VALIDATE_BOOLEAN, array('flags' => FILTER_NULL_ON_FAILURE));
            }
            if ($key == 'floors_start') {
                $params['floors_start'] = filter_var($val, FILTER_VALIDATE_INT, $options);
            }
            if ($key == 'floors_end' && $val > 0) {
                $params['floors_end'] = filter_var($val, FILTER_VALIDATE_INT, $options);
                if ($params['floors_start'] >= 0 and $val < $params['floors_start']) {
                    $params['floors_end'] = $params['floors_start'];
                }
            }
            if ($key == 'building_type') {
                foreach ($params['building_type'] as $key => $type) {
                    $params['building_type'][$key] = filter_var($type, FILTER_VALIDATE_INT, $options);
                }
            }
            if ($key == 'realty_type') {
                $params['realty_type'] = filter_var($val, FILTER_VALIDATE_INT, $options);
            }
        }
        //var_dump($params); die();
        return $params;
    }
}