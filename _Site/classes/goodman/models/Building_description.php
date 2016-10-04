<?php
namespace goodman\models;
class Building_description extends Model
{
    public $pk = "id_building_description";
    public $table = "building_description";

    public function getBuildingType()
    {
        if ($this->id_building_type > 0) {
            $types = new Building_type();
            return $types->getAttribute($this->id_building_type,"building_type_name");
        }
        return false;
    }
    public function getBuildingStateEng()
    {
        if ($this->id_building_state > 0) {
            $types = new Building_state();
            return $types->getAttribute($this->id_building_state,"building_state_eng");
        }
        return false;
    }
    /**
     * @param $data
     * @return bool
     */
    public function checkBuildingName($data){
        $check = $this->find(array('id_address=? AND id_building_type=?',$data['id_address'],$data['id_building_type']));
        if(count($check)>0){
            return false;
        }
        return true;
    }

    /**
     * @param $data
     * @return bool
     */
    public function checkPost($data){
        $f3 = \Base::instance();
        $errors = array();
        $data["alarm"] = $this->checkBool($data["alarm"]);
        $data["parking"] = $this->checkBool($data["parking"]);
        $data["is_elite"] = $this->checkBool($data["is_elite"]);
        $data["rubbish_chute"] = $this->checkBool($data["rubbish_chute"]);
        $data["lift"] = $this->checkBool($data["lift"]);

        foreach ($data as $key=>$value){
            if ($value =="") unset($data[$key]);
        }

        if(!isset($data['id_address'])){
            $errors[] = 'адрес не заполнено!';
            $f3->set('errors', $errors);
            return false;
        }
        if(!isset($data['floors_total'])){
            $errors[] = 'количество этажей не заполнено!';
            $f3->set('errors', $errors);
            return false;
        }
        if(!isset($data['id_building_type'])){
            $errors[] = 'тип здания не заполнено!';
            $f3->set('errors', $errors);
            return false;
        }
        if(!isset($data['built_year'])){
            $errors[] = 'год постройки не заполнено!';
            $f3->set('errors', $errors);
            return false;
        }

        if(isset($data["ceiling_height"])) $data["ceiling_height"] = $this->checkFloat($data["ceiling_height"]);
        if(isset($data["id_building"]) and !(is_numeric($data["id_building"]))) {
            $errors[] = 'здание';
        }
        if(isset($data["id_address"]) and !(is_numeric($data["id_address"]))) {
            $errors[] = 'адрес';
        }
        if(isset($data["floors-total"]) and !(is_numeric($data["floors_total"]))) {
            $errors[] = 'число этажей';
        }
        if(isset($data["id_building_type"]) and !(is_numeric($data["id_building_type"]))) {
            $errors[] = 'тип здания';
        }
        if(isset($data["id_building_state"]) and !(is_numeric($data["id_building_state"])))  {
            $errors[] = 'стадия строительства';
        }
        if(isset($data["ready_quarter"]) and !(is_numeric($data["ready_quarter"])))  {
            $errors[] = 'квартал';
        }

        if(isset($data["building_series"])) $data["building_series"] = $this->checkText($data["building_series"]);
        if(isset($data["building_phase"])) $data["building_phase"] = $this->checkText($data["building_phase"]);
        if(isset($data["building_section"])) $data["building_section"] = $this->checkText($data["building_section"]);
        if(isset($data["built_year"])) $data["built_year"] = $this->checkText($data["built_year"]);

        if (count($errors) == 0) {
            return $data;
        } else {
            $f3->set('errors', $errors);
            return false;
        }
    }
}