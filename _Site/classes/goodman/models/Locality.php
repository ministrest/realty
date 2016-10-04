<?php
namespace goodman\models;
class Locality extends Model
{
    public $pk = "id_locality";
    public $table = "locality";
    /**
     * @param $data
     * @return bool
     */
    public function checkLocalityName($data){
        $check = $this->find(array('locality_name=? AND id_district=?',$data['locality_name'],$data['id_district']));
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

        if(isset($data["id_locality"]) and !(is_numeric($data["id_locality"]))) return false;
        if(isset($data["id_district"]) and !(is_numeric($data["id_district"]))) return false;
        if(isset($data["locality_name"])) $data["locality_name"] = $this->checkText($data["locality_name"]);

        return $data;
    }
}