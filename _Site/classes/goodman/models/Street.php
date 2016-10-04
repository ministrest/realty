<?php
namespace goodman\models;
class Street extends Model
{
    public $pk = "id_street";
    public $table = "street";

    public function getCity($id_street){
        $id_locality = $this->getAttribute($id_street, 'id_locality');
        $locality= new Locality();
        $locality->getAttribute($id_locality, 'locality_name');
        return $locality->getAttribute($id_locality, 'locality_name');

    }

    /**
     * @param $data
     * @return bool
     */
    public function checkStreetName($data){
        $check = $this->find(array('street_name=? AND id_locality=?',$data['street_name'],$data['id_locality']));
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

        if(isset($data["id_street"]) and !(is_numeric($data["id_street"]))) return false;
        if(isset($data["id_locality"]) and !(is_numeric($data["id_locality"]))) return false;
        if(isset($data["street_name"])) $data["street_name"] = $this->checkText($data["street_name"]);

        return $data;
    }
}