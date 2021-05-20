<?php

require_once 'dao/base_dao.php';

class Accounts extends BaseDAO
{
//    public static $tableName = 'accounts';

    static function findAccountByUserName($userName)
    {
        $tableName = get_called_class();
        $dto = substr($tableName, 0, -1);

        self::requireModel($dto);

        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM ' . $tableName . ' WHERE user_name = :user_name');
        $req->execute(array('user_name' => $userName));

        $item = $req->fetch();
        if (isset($item['id'])) {
            return $dto::createFromDB($item);
        }
        return null;
    }
}