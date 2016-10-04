<?php
namespace goodman\models;
class District extends Model
{
    public $pk = "id_district";
    public $table = "district";
    /**
     * @param $data
     * @return bool
     */
    public function checkDistrictName($data){
        $check = $this->find(array('district_name=? AND id_region=?',$data['district_name'],$data['id_region']));
        if(count($check)>0){
            return false;
        }
        return true;
    }
    /**
     * @return array
     */
    public function checkPost($data){
        foreach ($data as $key=>$value){
            if ($value =="") unset($data[$key]);
        }

        if(isset($data["id_district"]) and !(is_numeric($data["id_district"]))) return false;
        if(isset($data["id_region"]) and !(is_numeric($data["id_region"]))) return false;
        if(isset($data["district_name"])) $data["district_name"] = $this->checkText($data["district_name"]);

        return $data;
    }
}