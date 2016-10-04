<?php
namespace goodman\models;
class Region extends Model
{
    public $pk = "id_region";
    public $table = "region";
    /**
     * @param $data
     * @return bool
     */
    public function checkRegionName($data){
        $check = $this->find(array('region_name=?',$data['region_name']));
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

        if(isset($data["id_region"]) and !(is_numeric($data["id_region"]))) return false;
        if(isset($data["region_name"])) $data["region_name"] = $this->checkText($data["region_name"]);

        return $data;
    }
}