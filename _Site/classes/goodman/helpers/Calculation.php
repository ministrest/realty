<?php
namespace goodman\helpers;

/**
 * Helper для ипотечного калькулятора
 * @package goodman\helpers
 */
class Calculation
{
    protected $errors = array();
    protected $check = false;

    /**
     * @param $post
     * @return mixed
     */
    public function checkPost($post)
    {
        $post["period"] = str_replace(" ","",$post["period"]);
        $post["price"] = str_replace(" ","",$post["price"]);
        $post["procent"] = str_replace(" ","",$post["procent"]);
        $post["initial_fee"] = str_replace(" ","",$post["initial_fee"]);
        foreach($post as $key=>$value) {
            if ($post[$key] == 0 or !is_numeric($post[$key])) {
                $this->errors[$key] = true;
            }
        }
        return $post;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }
    /**
     * @return mixed
     */
    public function getCheck()
    {
        return $this->check;
    }
}