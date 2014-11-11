<?php
class Registry {
    protected static $_registry = array();
    function construct(){}
    
    public static function set($key, $object){
        $checkIsObjectExists = self::checkIsExistsObject($object);
        if (self::checkIsExistsKey($key) === true){
            throw new Exception('Item already exists',1);
        }elseif($checkIsObjectExists['answer'] === true){
            throw new Exception('Object already exists, key = ' . $checkIsObjectExists['key'], 3);
        }else{
            self::$_registry[$key] = $object;
        }
    }
    
    public static function get($key){
        if( self::checkIsExistsKey($key) === true ){
            return self::$_registry[$key];
        }else{
            throw new Exception('Object with current key is not exists',2);
        }
    }
    
    public static function remove($key){
        if( self::checkIsExistsKey($key) === true ){
            unset(self::$_registry[$key]);
        }else{
            throw new Exception('Object with current key is not exists',2);
        }
    }
    
    private static function checkIsExistsObject( $object ){
        foreach (self::$_registry as $key=>$val) {
            if ($val === $object) {
                return array('answer'=>true, 'key'=>$key);
            }
        }
    }
    
    private static function checkIsExistsKey($key){
        return array_key_exists($key, self::$_registry);
    }
}
