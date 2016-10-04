<?php
namespace goodman\models;
class Object_info extends Model
{
    public $pk = "id_object";
    public $table = "object_info";

    public function getCategoryObject()
    {
        if ($this->id_category > 0) {
            $categories = new Category_object();
            return $categories->getAttribute($this->id_category,"category_object_name");
        }
        return false;
    }

    public function getAddressModel()
    {
        if (is_numeric($this->id_address)) {
            $address = new Address();
            $address = $address->findByPk($this->id_address);
            return $address[0];
        }
    }

    public function getImages()
    {
        $images = new Images();
        return $images->find(array('id_object=?', $this->id_object));
    }

    public function getFullAddress()
    {
        if (is_numeric($this->id_address)) {
            $address = $this->getAddressModel();
            if (isset($address)) {
                $full_address = $address->getAddress();
            }
            if (isset($full_address)) {
                if (!empty($this->flat_number)) $full_address .= ', кв.' . $this->flat_number;
                return $full_address;
            }

        }
        return false;
    }

    public function getRenovation()
    {
        if (is_numeric($this->id_renovation)) {
            $renovation = new Renovation();
            $renovation = $renovation->getAttribute($this->id_renovation, 'renovation_name');
            return $renovation;
        }
    }

    public function getQuality()
    {
        if (is_numeric($this->id_quality)) {
            $quality = new Quality();
            $quality = $quality->getAttribute($this->id_quality, 'quality_name');
            return $quality;
        }
        return false;
    }

    public function getAdvert()
    {
        if (is_numeric($this->id_object)) {
            $advert = new Advert_info();
            $advert = $advert->find(array('id_object=?', $this->id_object));
            return $advert[0];
        }
    }

    public function getLot()
    {
        if (is_numeric($this->id_lot_type)) {
            $lot_type = new Lot_type();
            $lot_type = $lot_type->getAttribute($this->id_lot_type, 'lot_type_name');
            return $lot_type;
        }
        return false;
    }

    public function getCategoryAgent()
    {
        if (is_numeric($this->id_category_agent)) {
            $category_agent = new Category_agent();
            $category_agent = $category_agent->getAttribute($this->id_category_agent, 'category_name');
            return $category_agent;
        }
        return false;
    }

    public function getFloorCovering()
    {
        if (is_numeric($this->id_floor_covering)) {
            $floor_covering = new Floor();
            $floor_covering = $floor_covering->getAttribute($this->id_floor_covering, 'floor_covering_name');
            return $floor_covering;
        }
        return false;
    }

    public function isMy()
    {
        if (($this->user_id > 0) and ($this->user_id == $_COOKIE['goodman']['id'])) {
            return true;
        }
        return false;

    }

    public function checkPost($data)
    {
        $f3 = \Base::instance();
        $errors = array();
        $data["gas_supply"] = $this->checkBool($data["gas_supply"]);
        $data["electricity_supply"] = $this->checkBool($data["electricity_supply"]);
        $data["sewerage_supply"] = $this->checkBool($data["sewerage_supply"]);
        $data["water_supply"] = $this->checkBool($data["water_supply"]);
        $data["heating_supply"] = $this->checkBool($data["heating_supply"]);
        $data["sauna"] = $this->checkBool($data["sauna"]);
        $data["pool"] = $this->checkBool($data["pool"]);
        $data["open_plan"] = $this->checkBool($data["open_plan"]);
        $data["apartments"] = $this->checkBool($data["apartments"]);
        $data["new_flat"] = $this->checkBool($data["new_flat"]);
        $data["kitchen"] = $this->checkBool($data["kitchen"]);
        $data["shower"] = $this->checkBool($data["shower"]);
        $data["toilet"] = $this->checkBool($data["toilet"]);
        $data["room_furniture"] = $this->checkBool($data["room_furniture"]);
        $data["internet"] = $this->checkBool($data["internet"]);
        $data["phone"] = $this->checkBool($data["phone"]);
        $data["elevator"] = $this->checkBool($data["elevator"]);

        foreach ($data as $key => $value) {
            if ($value == "") unset($data[$key]);
        }
        
        if(!isset($data['id_address'])){
            $errors[] = 'адрес не заполнено!';
            $f3->set('errors', $errors);
            return false;
        }
        if(!isset($data['id_category'])){
            $errors[] = 'категория не заполнено!';
            $f3->set('errors', $errors);
            return false;
        }
        if(!isset($data['full_space'])){
            $errors[] = 'площадь объекта не заполнено!';
            $f3->set('errors', $errors);
            return false;
        }


        if (isset($data["id_quality"]) and !(is_numeric($data["id_quality"]))){
            $errors[] = 'состояние объекта';
        } 
        if (isset($data["id_category_agent"]) and !(is_numeric($data["id_category_agent"]))) {
            $errors[] = 'категория агента';
        }
        if (isset($data["id_lot_type"]) and !(is_numeric($data["id_lot_type"]))) {
            $errors[] = 'тип участка';
        }
        if (isset($data["living_space"])) $data["living_space"] = $this->checkFloat($data["living_space"]);
        if (isset($data["full_space"])) $data["full_space"] = $this->checkFloat($data["full_space"]);
        if (isset($data["kitchen_space"])) $data["kitchen_space"] = $this->checkFloat($data["kitchen_space"]);
        if (isset($data["lot_area"])) $data["lot_area"] = $this->checkFloat($data["lot_area"]);

        if (isset($data["rooms"]) and !(is_numeric($data["rooms"])))  {
            $errors[] = 'количество комнат';
        }
        if (isset($data["flat_number"]) and !(is_numeric($data["flat_number"])))  {
            $errors[] = 'номер квартиры';
        }
        if (isset($data["floor"]) and !(is_numeric($data["floor"]))) {
            $errors[] = 'этаж';
        }
        if (isset($data["rooms_offered"]) and !(is_numeric($data["rooms_offered"]))) {
            $errors[] = 'число комнат в предложении';
        }
        if (isset($data["toilet_amount"]) and !(is_numeric($data["toilet_amount"])))  {
            $errors[] = 'число ванных комнат';
        }
        if (isset($data["elevator_amount"]) and !(is_numeric($data["elevator_amount"])))  {
            $errors[] = 'число лифтов';
        }
        if (isset($data["id_floor_covering"]) and !(is_numeric($data["id_floor_covering"]))) {
            $errors[] = 'покрытие пола';
        }
        if (isset($data["id_category"]) and !(is_numeric($data["id_category"])))  {
            $errors[] = 'категория объекта';
        }
        //if(isset($data["id_advert"]) and !(is_numeric($data["id_advert"]))) return false;

        if (isset($data["bathroom_unit"])) $data["bathroom_unit"] = $this->checkText($data["bathroom_unit"]);
        if (isset($data["window_view"])) $data["window_view"] = $this->checkText($data["window_view"]);
        if (isset($data["rooms_type"])) $data["rooms_type"] = $this->checkText($data["rooms_type"]);
        if (isset($data["balcony"])) $data["balcony"] = $this->checkText($data["balcony"]);

        if (isset($data["description"])) $data["description"] = $this->checkText($data["description"]);
        if (isset($data["client_name"])) $data["client_name"] = $this->checkText($data["client_name"]);
        if (isset($data["client_number"])) $data["client_number"] = $this->checkText($data["client_number"]);
        if(!isset($data['user_id']) or empty($data['user_id'])) {
            $data['user_id'] = (int)$_COOKIE['goodman']['id'];
        }
        if (count($errors) == 0) {
            return $data;
        } else {
            $f3->set('errors', $errors);
            return false;
        }
        
    }
}
