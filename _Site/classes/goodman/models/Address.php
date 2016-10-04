<?php
namespace goodman\models;
class Address extends Model
{
    public $pk = "id_address";
    public $table = "address";

    public function getAddress()
    {
        $street = new Street();
        $locality = new Sublocality();
        $full_address = $street->getCity($this->id_street);
        $full_address .= ', '.$locality->getAttribute($this->id_sublocality,"sublocality_name").' р-он';
        $full_address .=  ", ул.".$street->getAttribute($this->id_street,"street_name");
        $full_address .= (isset($this->house_number))? ", д.".$this->house_number : "" ;
        return $full_address;
    }

    public function getSublocalityModel()
    {
        if ($this->id_sublocality > 0) {
            $sublocality = new Sublocality();
            $sublocality = $sublocality->findByPk($this->id_sublocality);
            return $sublocality[0];
        }
        return false;
    }

    public function getSublocality()
    {
        $sublocality = $this->getSublocalityModel();
        return $sublocality->sublocality_name;
    }
    
    public function getStreet()
    {
        $street = new Street();
        return $street->getAttribute($this->id_street,"street_name");
    }
    
    public function getLocalityModel()
    {
        $sublocality = $this->getSublocalityModel();
        if ($sublocality->id_locality > 0) {
            $locality = new Locality();
            $locality = $locality->findByPk($sublocality->id_locality);
            return $locality[0];
        }
        return false;
    }

    public function getLocality()
    {
        $locality = $this->getLocalityModel();
        return $locality->locality_name;
    }
    
    public function getDistrictModel()
    {
        $locality = $this->getLocalityModel();
        if ($locality->id_district > 0) {
            $district = new District();
            $district = $district->findByPk($locality->id_district);
            return $district[0];
        }
        return false;
    }

    public function getDistrict()
    {
        $district = $this->getDistrictModel();
        return $district->district_name;
    }

    public function getRegionModel()
    {
        $district = $this->getDistrictModel();
        if ($district->id_region > 0) {
            $region = new Region();
            $region = $region->findByPk($district->id_region);
            return $region[0];
        }
        return false;
    }

    public function getRegion()
    {
        $region = $this->getRegionModel();
        return $region->region_name;
    }

    public function getBuilding()
    {
        if (is_numeric($this->id_address)) {
            $building = new Building_description();
            $building = $building->find(array('id_address=?', $this->id_address));
            return $building[0];
        }
    }

    public function getObject()
    {
        if (is_numeric($this->id_address)) {
            $object = new Object_info();
            $object = $object->find(array('id_address=?', $this->id_address));
            return $object[0];
        }
    }
    /**
     * @param $data
     * @return bool
     */
    public function checkAddressName($data){
        $check = $this->find(array('id_street=? AND id_sublocality=? AND house_number=?',$data['id_street'],$data['id_sublocality'],$data['house_number']));
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
        if(isset($data["id_street"]) and !(is_numeric($data["id_street"]))) return false;
        if(isset($data["nonadmin_sublocality"])) $data["nonadmin_sublocality"] = $this->checkText($data["nonadmin_sublocality"]);
        if(isset($data["house_number"])) $data["house_number"] = $this->checkText($data["house_number"]);

        return $data;
    }
}