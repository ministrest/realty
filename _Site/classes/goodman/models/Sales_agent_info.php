<?php
namespace goodman\models;
class Sales_agent_info extends Model
{
    public $pk = "id_sales_agent_info";
    public $table = "sales_agent_info";

    public function getUser()
    {
        if ($this->id_user > 0) {
            $users = new Users();
            $user = $users->findByPk($this->id_user);
            return $user[0];
        }
        return false;
    }

    public function getEmail()
    {
        $user = $this->getUser();
        return $user->email;
    }

    public function getAvatar()
    {
        $user = $this->getUser();
        if($user) return $user->getAvatar();
        return false;
    }

    public function formatPhone($phone)
    {
        //$phone = $this->phone;
        $phone = trim($phone);
        $phone = preg_replace("/[^0-9A-Za-z]/", "", $phone);
        $cod = '';
        if (strlen($phone) == 6) {
            $cod = '+7 (8452) ';
            $phone = implode("-", str_split($phone, 2));
        } elseif (strlen($phone) == 11) {
            $cod = '+7 ';
            $sArea = substr($phone, 1,3);
            $sPrefix = substr($phone,4,3);
            $sNumber = substr($phone,7,2);
            $sNumber2 = substr($phone,9,2);
            $phone = "(".$sArea.") ".$sPrefix."-".$sNumber."-".$sNumber2;
        }
        
        return $cod . $phone;
    }

    public function checkPost($data)
    {
        foreach ($data as $key => $value) {
            if ($value == "") unset($data[$key]);
        }
        $data['birthday'] = $this->checkDate($data['birthday']);
        if (isset($data["id_user"]) and !(is_numeric($data["id_user"]))) return false;
        if (isset($data["name"])) $data["name"] = $this->checkText($data["name"]);
        if (isset($data["phone"])) $data["phone"] = $this->checkText($data["phone"]);
        if (isset($data["additional_number"])) $data["additional_number"] = $this->checkText($data["additional_number"]);
        if (isset($data["personal_number"])) $data["personal_number"] = $this->checkText($data["personal_number"]);
        if (!isset($data["number_is_visible"])) {
            $data["number_is_visible"] = '0';
        } else {
            $data["number_is_visible"] = $this->checkBool($data["number_is_visible"]);
        }
        return $data;
    }
}