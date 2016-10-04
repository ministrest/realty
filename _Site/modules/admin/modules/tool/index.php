<?php
/** @var \NMG\Page\Page $page */
$module = 'tool';
$pageTitle = 'Генерируем модели';

function generateModels()
{
    $f3 = \Base::instance();
    $db = $f3->get('db.instance')->exec("SHOW TABLES");
    foreach ($db as $table) {
        $tbl_name = $table["Tables_in_realty"];
        $path = ROOTDIR . '/classes/goodman/models';

        if (is_dir($path)) {
            $file = $path . '/' . ucfirst($tbl_name) . '.php';
            if (!file_exists($file)) {
                $fileHandle = fopen($file, 'w') or die("can't open file");
                fclose($fileHandle);
                $text = '<?php
namespace goodman\models;
class ' . ucfirst($tbl_name) . ' extends Model
{
    public $pk = "id_' . $tbl_name . '";
    public $table = "' . $tbl_name . '";
}';
                $fileHandle = fopen($file, 'a') or die("can't open file");
                fwrite($fileHandle, PHP_EOL . $text);
                fclose($fileHandle);
            }
        } else {
            return false;
        }
    }

    return true;

}

function generateFeed()
{
    $dom = new domDocument("1.0", "utf-8");
    $dom -> formatOutput = true;
    $root = $dom->createElement("realty-feed");
    $root->setAttribute("xmlns", "http://webmaster.yandex.ru/schemas/feed/realty/2010-06");
    $date = $dom->createElement("generation-date", date('c'));

    $dom->appendChild($root);
    $root->appendChild($date);
    $adverts = new \goodman\models\Advert_info();
    $adverts = $adverts->find();
    foreach ($adverts as $advert) {
        $offer = $dom->createElement("offer");
        $offer->setAttribute("internal-id", $advert->id_advert);
        $type = $dom->createElement("type", "продажа");
        $offer->appendChild($type);
        if(isset($advert->id_property_type)) {
            $property_type = $dom->createElement("property-type", $advert->getPropertyType());
            $offer->appendChild($property_type);
        }
        if(isset($advert->id_category)) {
            $category = $dom->createElement("category", $advert->getCategoryObject());
            $offer->appendChild($category);
        }
        $url = $dom->createElement("url", "http://".$_SERVER['SERVER_NAME']."/buy/view/".$advert->id_advert);
        $offer->appendChild($url);
        $creation_date = $dom->createElement("creation-date", date('c',strtotime($advert->creation_date)));
        $offer->appendChild($creation_date);
        $last_update_date = $dom->createElement("last-update-date", date('c',strtotime($advert->last_update_date)));
        $offer->appendChild($last_update_date);
        if(isset($advert->expire_date)) {
            $expire_date = $dom->createElement("expire-date", date('c',strtotime($advert->expire_date)));
            $offer->appendChild($expire_date);
        }
        $address = $advert->getAddress();
        $location = $dom->createElement("location");
        $country = $dom->createElement("country", 'Россия');
        $location->appendChild($country);
        $district_name = $address->getDistrict();
        if(isset($district_name)) {
            $district = $dom->createElement("district", $district_name.' район');
            $location->appendChild($district);
        }
        $region_name = $address->getRegion();
        if(isset($region_name)) {
            $region = $dom->createElement("region", $region_name);
            $location->appendChild($region);
        }
        $locality_name = $address->getLocality();
        if(isset($locality_name)) {
            $locality = $dom->createElement("locality-name", $locality_name);
            $location->appendChild($locality);
        }
        $sublocality_name = $address->getSublocality();
        if(isset($sublocality_name)) {
            $sublocality = $dom->createElement("sub-locality-name", $sublocality_name.' район');
            $location->appendChild($sublocality);
        }
        $address_text = $address->getStreet().((isset($address->house_number))? ', '.$address->house_number : '');
        if(isset($address_text)) {
            $address = $dom->createElement("address", $address_text);
            $location->appendChild($address);
        }
        $offer->appendChild($location);

        $sales_agent = $dom->createElement("sales-agent");
        $agent = $advert->getAgent();
        $name = $dom->createElement("name", $agent->name);
        $sales_agent->appendChild($name);
        $phone = $dom->createElement("phone", $agent->phone);
        $sales_agent->appendChild($phone);
        $organization = $dom->createElement("organization", 'Агентство "Goodman"');
        $sales_agent->appendChild($organization);
        $url = $dom->createElement("url", "http://".$_SERVER['SERVER_NAME']);
        $sales_agent->appendChild($url);
        $email = $dom->createElement("email", $agent->getEmail());
        $sales_agent->appendChild($email);
        $photo = $dom->createElement("photo", $agent->getAvatar());
        $sales_agent->appendChild($photo);
        $offer->appendChild($sales_agent);

        $price = $dom->createElement("price");
        $value = $dom->createElement("value", $advert->value);
        $price->appendChild($value);
        $currency = $dom->createElement("currency", $advert->getCurrency());
        $price->appendChild($currency);
        if(isset($advert->id_unit) and !empty($advert->id_unit)) {
            $unit = $dom->createElement("unit", $advert->getUnit());
            $price->appendChild($unit);
        }
        $offer->appendChild($price);

        if(isset($not_for)) {
            $not_for = $dom->createElement("not-for-agents", $advert->not_for_agents);
            $offer->appendChild($not_for);
        }
        if(isset($haggle)) {
            $haggle = $dom->createElement("haggle", $advert->haggle);
            $offer->appendChild($haggle);
        }
        if(isset($mortgage)) {
            $mortgage = $dom->createElement("mortgage", $advert->mortgage);
            $offer->appendChild($mortgage);
        }
        if(isset($rent_pledge)) {
            $rent_pledge = $dom->createElement("rent-pledge", $advert->rent_pledge);
            $offer->appendChild($rent_pledge);
        }
        $agent_fee = $dom->createElement("agent-fee", '3');
        $offer->appendChild($agent_fee);
        $deal_status = $dom->createElement("deal-status", $advert->getStatus());
        $offer->appendChild($deal_status);

        $object = $advert->getObject();
        if($object->full_space>0) {
            $area = $dom->createElement("area");
            $full_space = $dom->createElement("value", $object->full_space);
            $area->appendChild($full_space);
            $unit = $dom->createElement("unit", 'кв. м');
            $area->appendChild($unit);
            $offer->appendChild($area);
        }
        if($object->living_space>0) {
            $living_space = $dom->createElement("living-space");
            $living_value = $dom->createElement("value", $object->living_space);
            $living_space->appendChild($living_value);
            $unit = $dom->createElement("unit", 'кв. м');
            $living_space->appendChild($unit);
            $offer->appendChild($living_space);
        }
        if($object->kitchen_space>0) {
            $kitchen_space = $dom->createElement("kitchen-space");
            $kitchen_value = $dom->createElement("value", $object->kitchen_space);
            $kitchen_space->appendChild($kitchen_value);
            $unit = $dom->createElement("unit", 'кв. м');
            $kitchen_space->appendChild($unit);
            $offer->appendChild($kitchen_space);
        }
        if($object->lot_area>0) {
            $lot_area = $dom->createElement("lot-area");
            $lot_value = $dom->createElement("value", $object->lot_area);
            $lot_area->appendChild($lot_value);
            $unit = $dom->createElement("unit", 'кв. м');
            $lot_area->appendChild($unit);
            $offer->appendChild($lot_area);
        }
        if(isset($object->lot_type) and !empty($object->lot_type)){
            $lot_type = $dom->createElement("lot-type", $object->lot_type);
            $offer->appendChild($lot_type);
        }
        $obj_images = $object->getImages();
        if (isset($obj_images) and !empty($obj_images)) {
            foreach ($obj_images as $key => $image) {
                $image = $dom->createElement("image",  "http://".$_SERVER['SERVER_NAME']. $image->catalog . $image->filename);
                $offer->appendChild($image);
            }
        }
        if(isset($object->id_renovation ) and !empty($object->id_renovation)){
            $renovation = $dom->createElement("renovation", $object->getRenovation());
            $offer->appendChild($renovation);
        }
        if(isset($object->id_quality ) and !empty($object->id_quality)){
            $quality = $dom->createElement("quality", $object->getQuality());
            $offer->appendChild($quality);
        }
        if(isset($object->description ) and !empty($object->description)){
            $description = $dom->createElement("description", htmlspecialchars($object->description));
            $offer->appendChild($description);
        }
        if(isset($object->rooms_type ) and !empty($object->rooms_type)){
            $rooms_type = $dom->createElement("rooms-type", htmlspecialchars($object->rooms_type));
            $offer->appendChild($rooms_type);
        }
        if(isset($object->balcony ) and !empty($object->balcony)){
            $balcony = $dom->createElement("balcony", htmlspecialchars($object->balcony));
            $offer->appendChild($balcony);
        }
        if(isset($object->bathroom_unit ) and !empty($object->bathroom_unit)){
            $bathroom_unit = $dom->createElement("bathroom-unit", htmlspecialchars($object->bathroom_unit));
            $offer->appendChild($bathroom_unit);
        }
        if(isset($object->window_view ) and !empty($object->window_view)){
            $window_view = $dom->createElement("window-view", htmlspecialchars($object->window_view));
            $offer->appendChild($window_view);
        }
        if(isset($object->id_floor_covering ) and !empty($object->id_floor_covering)){
            $floor_covering = $dom->createElement("floor-covering", $object->getFloorCovering());
            $offer->appendChild($floor_covering);
        }
        if(isset($object->rooms ) and !empty($object->rooms)){
            $rooms = $dom->createElement("rooms", $object->rooms);
            $offer->appendChild($rooms);
        }
        if(isset($object->rooms_offered ) and !empty($object->rooms_offered)){
            $rooms_offered = $dom->createElement("rooms-offered", $object->rooms_offered);
            $offer->appendChild($rooms_offered);
        }
        if(isset($object->floor ) and !empty($object->floor)){
            $floor = $dom->createElement("floor", $object->floor);
            $offer->appendChild($floor);
        }
        if(isset($object->new_flat ) and !empty($object->new_flat)){
            $new_flat = $dom->createElement("new-flat", ($object->new_flat=='1')?'да':'нет');
            $offer->appendChild($new_flat);
        }
        if(isset($object->open_plan ) and !empty($object->open_plan)){
            $open_plan = $dom->createElement("open-plan", ($object->open_plan=='1')?'да':'нет');
            $offer->appendChild($open_plan);
        }
        if(isset($object->apartments ) and !empty($object->apartments)){
            $apartments = $dom->createElement("apartments", ($object->apartments=='1')?'да':'нет');
            $offer->appendChild($apartments);
        }
        if(isset($object->internet ) and !empty($object->internet)){
            $internet = $dom->createElement("internet", ($object->internet=='1')?'да':'нет');
            $offer->appendChild($internet);
        }
        if(isset($object->phone ) and !empty($object->phone)){
            $phone = $dom->createElement("phone", ($object->phone=='1')?'да':'нет');
            $offer->appendChild($phone);
        }
        if(isset($object->room_furniture ) and !empty($object->room_furniture)){
            $room_furniture = $dom->createElement("room-furniture", ($object->room_furniture=='1')?'да':'нет');
            $offer->appendChild($room_furniture);
        }
        if(isset($object->heating_supply ) and !empty($object->heating_supply)){
            $heating_supply = $dom->createElement("heating-supply", ($object->heating_supply=='1')?'да':'нет');
            $offer->appendChild($heating_supply);
        }
        if(isset($object->water_supply ) and !empty($object->water_supply)){
            $water_supply = $dom->createElement("water-supply", ($object->water_supply=='1')?'да':'нет');
            $offer->appendChild($water_supply);
        }
        if(isset($object->sewerage_supply ) and !empty($object->sewerage_supply)){
            $sewerage_supply = $dom->createElement("sewerage-supply", ($object->sewerage_supply=='1')?'да':'нет');
            $offer->appendChild($sewerage_supply);
        }
        if(isset($object->electricity_supply ) and !empty($object->electricity_supply)){
            $electricity_supply = $dom->createElement("electricity-supply", ($object->electricity_supply=='1')?'да':'нет');
            $offer->appendChild($electricity_supply);
        }
        if(isset($object->gas_supply ) and !empty($object->gas_supply)){
            $gas_supply = $dom->createElement("gas-supply", ($object->gas_supply=='1')?'да':'нет');
            $offer->appendChild($gas_supply);
        }
        if(isset($object->sauna ) and !empty($object->sauna)){
            $sauna = $dom->createElement("sauna", ($object->sauna=='1')?'да':'нет');
            $offer->appendChild($sauna);
        }
        if(isset($object->pool ) and !empty($object->pool)){
            $pool = $dom->createElement("pool", ($object->pool=='1')?'да':'нет');
            $offer->appendChild($pool);
        }
        $building = $advert->getBuilding();
        if(isset($building->floors_total ) and !empty($building->floors_total)){
            $floors_total = $dom->createElement("floors-total", $building->floors_total);
            $offer->appendChild($floors_total);
        }
        if(isset($building->id_building_type ) and !empty($building->id_building_type)){
            $building_type = $dom->createElement("building-type", $building->getBuildingType());
            $offer->appendChild($building_type);
        }
        if(isset($building->id_building_state ) and !empty($building->id_building_state)){
            $building_state = $dom->createElement("building-state", $building->getBuildingStateEng());
            $offer->appendChild($building_state);
        }
        if(isset($building->building_series ) and !empty($building->building_series)){
            $building_series = $dom->createElement("building-series",  htmlspecialchars($building->building_series));
            $offer->appendChild($building_series);
        }
        if(isset($building->building_phase ) and !empty($building->building_phase)){
            $building_phase = $dom->createElement("building-phase",  htmlspecialchars($building->building_phase));
            $offer->appendChild($building_phase);
        }
        if(isset($building->building_section ) and !empty($building->building_section)){
            $building_section = $dom->createElement("building-section",  htmlspecialchars($building->building_section));
            $offer->appendChild($building_section);
        }
        if(isset($building->built_year ) and !empty($building->built_year)){
            $built_year = $dom->createElement("built-year",  htmlspecialchars($building->built_year));
            $offer->appendChild($built_year);
        }
        if(isset($building->ready_quarter ) and !empty($building->ready_quarter)){
            $ready_quarter = $dom->createElement("ready-quarter", $building->ready_quarter);
            $offer->appendChild($ready_quarter);
        }
        if(isset($building->ceiling_height ) and !empty($building->ceiling_height)){
            $ceiling_height = $dom->createElement("ceiling-height", $building->ceiling_height);
            $offer->appendChild($ceiling_height);
        }
        if(isset($building->lift ) and !empty($building->lift)){
            $lift = $dom->createElement("lift",($building->lift=='1')?'да':'нет');
            $offer->appendChild($lift);
        }
        if(isset($building->parking ) and !empty($building->parking)){
            $parking = $dom->createElement("parking",($building->parking=='1')?'да':'нет');
            $offer->appendChild($parking);
        }
        if(isset($building->alarm) and !empty($building->alarm)){
            $alarm = $dom->createElement("alarm",($building->alarm=='1')?'да':'нет');
            $offer->appendChild($alarm);
        }
        if(isset($building->rubbish_chute) and !empty($building->rubbish_chute)){
            $rubbish_chute = $dom->createElement("rubbish-chute",($building->rubbish_chute=='1')?'да':'нет');
            $offer->appendChild($rubbish_chute);
        }
        if(isset($building->is_elite) and !empty($building->is_elite)){
            $is_elite = $dom->createElement("is-elite",($building->is_elite=='1')?'да':'нет');
            $offer->appendChild($is_elite);
        }

        $root->appendChild($offer);
    }
    /*
     * # Получаем XML в переменную
    $xml = $dom->saveXML();

    header ("Content-Type: application/octet-stream");
    header ("Accept-Ranges: bytes");
    header ("Content-Length: " . strlen($xml));
    header ("Content-Disposition: attachment; filename=xmlFile.xml");

    # Выводим результат
    echo $xml;
     */
    if ($dom->save("realty.xml")) {
        return true;
    }
    return false;
}

if ($params['action'] == 'generate') {
    if (generateModels()) {
        $action = 'моделей';
        $actions = 'модели';
        include __DIR__ . '/list.php';
    }
}

if ($params['action'] == 'feed') {

    if (generateFeed()) {
        $action = 'фида';
        $actions = 'данные';
        include __DIR__ . '/list.php';
    }
}
    
