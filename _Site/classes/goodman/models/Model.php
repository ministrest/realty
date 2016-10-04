<?php
namespace goodman\models;
use DB;
class Model extends DB\SQL\Mapper {

    public $pk = "id";
    public $table = "table";

    function __construct()
    {
        $f3 = \Base::instance();
        $db = $f3->get('db.instance');
        parent::__construct($db, $this->table);
    }
    public function all() {
        $this->load();
        return $this->query;
    }

    public function checkText($text)
    {
        $text = trim($text);
        $text = strip_tags($text);
        $text = htmlspecialchars($text);
        return $text;
    }

    public function checkDate($date)
    {
        $date = trim($date);
        $date = strip_tags($date);
        $date = date('Y-m-d H:i:s', strtotime($date));

        return $date;
    }

    public function checkBool($bool){
        if(!isset($bool)) {
            return '0';
        } else {
            return ($bool =='on')? '1' : '0';
        }
    }

    public function checkFloat($flo){
        $flo = str_replace(',', '.', $flo);
        if(filter_var($flo, FILTER_VALIDATE_FLOAT)){
            return $flo;
        }
        return false;
    }

    public function add() {
        $this->copyFrom('POST');
        $this->save();
    }

    public function getById($id) {
        $this->load(array($this->pk.'=?',$id));
        $this->copyTo('POST');
    }

    public function findByPk($id) {
        $result = $this->find(array($this->pk.'=?',$id));
        if (!empty($result)) return $result;
    }

    public function edit($id) {
        $this->load(array($this->pk.'=?',$id));
        $this->copyFrom('POST');
        $this->update();
    }

    public function delete($id) {
        $this->load(array($this->pk.'=?',$id));
        $this->erase();
    }

    public function getAttribute($id,$attribute) {
        $result = $this->find(array($this->pk.'=?',$id));
        if (!empty($result[0]->$attribute)) return $result[0]->$attribute;
    }
    
}
