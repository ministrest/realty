<?php
namespace goodman\models;
class Advert_info extends Model
{
    public $pk = "id_advert_info";
    public $table = "advert_info";

    public function getAddress()
    {
        $object = $this->getObject();
        $address = $object->getAddressModel();
        return $address;
    }
    public function getCategoryObject()
    {
        if ($this->id_category > 0) {
            $categories = new Category_object();
            return $categories->getAttribute($this->id_category,"category_object_name");
        }
        return false;
    }

    public function getStatus()
    {
        if ($this->id_deal_status > 0) {
            $status = new Deal_status();
            return $status->getAttribute($this->id_deal_status,"deal_status_name");
        }
        return false;
    }

    public function getCurrency()
    {
        if ($this->id_currency > 0) {
            $status = new Currency();
            return $status->getAttribute($this->id_currency,"currency_name");
        }
        return false;
    }

    public function getUnit()
    {
        if ($this->id_unit > 0) {
            $status = new Unit();
            return $status->getAttribute($this->id_unit,"unit_name");
        }
        return false;
    }

    public function getBuilding()
    {
        $address = $this->getAddress();
        $building = $address->getBuilding();
        return $building;
    }

    public function getObject()
    {
        if ($this->id_object > 0) {
            $object = new Object_info();
            $object = $object->findByPk($this->id_object);
            return $object[0];
        }
        return false;
    }

    public function getAgent()
    {
        if ($this->user_id > 0) {
            $agents = new Sales_agent_info();
            $agent = $agents->find(array('id_user=?', $this->user_id));
            return $agent[0];
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

    public function getRooms()
    {
        $object = $this->getObject();
        if($object->rooms>0) return $object->rooms;
        return false;
    }

    public function getPropertyType()
    {
        if(isset($this->id_property_type)) {
            $property_types = new Property_type();
            return $property_types->getAttribute($this->id_property_type, "property_type");
        }
        return false;
    }

    /**
     * @return array
     */
    public function checkPost($data)
    {
        $f3 = \Base::instance();
        $errors = array();
        if (!isset($data["not_for_agents"])) {
            $data["not_for_agents"] = '0';
        } else {
            $data["not_for_agents"] = $this->checkBool($data["not_for_agents"]);
        }
        if (!isset($data["mortgage"])) {
            $data["mortgage"] = '0';
        } else {
            $data["mortgage"] = $this->checkBool($data["mortgage"]);
        }
        if (!isset($data["haggle"])) {
            $data["haggle"] = '0';
        } else {
            $data["haggle"] = $this->checkBool($data["haggle"]);
        }
        if (!isset($data["rent_pledge"])) {
            $data["rent_pledge"] = '0';
        } else {
            $data["rent_pledge"] = $this->checkBool($data["rent_pledge"]);
        }

        foreach ($data as $key => $value) {
            if ($value == "") unset($data[$key]);
        }

        if(!isset($data['id_object'])){
            $errors[] = 'объект не заполнено!';
            $f3->set('errors', $errors);
            return false;
        }
        if(!isset($data['user_id'])){
            $errors[] = 'пользователь не заполнено!';
            $f3->set('errors', $errors);
            return false;
        }
        if(!isset($data['value']) or $data['value']==0){
            $errors[] = 'стоимость не заполнено!';
            $f3->set('errors', $errors);
            return false;
        }
        if(!isset($data['id_property_type'])){
            $errors[] = 'тип недвижимости не заполнено!';
            $f3->set('errors', $errors);
            return false;
        }

        if (isset($data["id_object"]) and !(is_numeric($data["id_object"])))  {
            $errors[] = 'объект';
        }
        if (isset($data["user_id"]) and !(is_numeric($data["user_id"])))  {
            $errors[] = 'пользователь';
        }
        if (isset($data["id_address"]) and !(is_numeric($data["id_address"])))  {
            $errors[] = 'адрес';
        }
        if (isset($data["id_category"]) and !(is_numeric($data["id_category"])))  {
            $errors[] = 'категория объекта';
        }
        if (isset($data["id_currency"]) and !(is_numeric($data["id_currency"])))  {
            $errors[] = 'валюта';
        }
        if (isset($data["id_unit"]) and !(is_numeric($data["id_unit"])))  {
            $errors[] = 'единица измерения';
        }
        if (isset($data["value"])){
            $data["value"] = str_replace(" ","",$data["value"]);
            $data["value"] = $this->checkFloat($data["value"]);
        }

        if (isset($data["id_property_type"]) and !(is_numeric($data["id_property_type"])))  {
            $errors[] = 'тип собственности';
        }
        // if(isset($data["railway_station"])) $data["railway_station"] = $this->checkText($data["railway_station"]);

        if (isset($data["expire_date"])) $data["expire_date"] = $this->checkDate($data["expire_date"]);

        if (count($errors) == 0) {
            return $data;
        } else {
            $f3->set('errors', $errors);
            return false;
        }
    }
}