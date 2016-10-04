<?php
namespace goodman\models;
class Sublocality extends Model
{
    public $pk = "id_sublocality";
    public $table = "sublocality";

    /**
     * @param $id_sublocality
     * @return mixed
     */
    public function getCity($id_sublocality){
        $id_locality = $this->getAttribute($id_sublocality, 'id_locality');
        $locality= new Locality();
        $locality->getAttribute($id_locality, 'locality_name');
        return $locality->getAttribute($id_locality, 'locality_name');

    }
    /**
     * @param $data
     * @return bool
     */
    public function checkSublocalityName($data){
        $check = $this->find(array('sublocality_name=? AND id_locality=?',$data['sublocality_name'],$data['id_locality']));
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

        if(isset($data["id_sublocality"]) and !(is_numeric($data["id_sublocality"]))) return false;
        if(isset($data["id_locality"]) and !(is_numeric($data["id_locality"]))) return false;
        if(isset($data["sublocality_name"])) $data["sublocality_name"] = $this->checkText($data["sublocality_name"]);

        return $data;
    }
}