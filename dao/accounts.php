<?php

require_once 'dao/base_dao.php';

class Accounts extends BaseDAO
{
    static function findAccountByUserName($userName)
    {
        $tableName = get_called_class();
        $dto = substr($tableName, 0, -1);

        self::requireModel($dto);

        $db = DB::getInstance();
        $req = $db->prepare(
            'SELECT * FROM ' . $tableName . 
            ' WHERE username = :username'
        );
        $req->execute(array(
            'username' => $userName
        ));

        $item = $req->fetch();
        if (isset($item['id'])) {
            return $dto::createFromDB($item);
        }
        return null;
    }

    static function addNewAccount($userName, $pass, $ava_url = '', $acc_type = 0)
    {
        $tableName = get_called_class();
        $dto = substr($tableName, 0, -1);

        self::requireModel($dto);

        $db = DB::getInstance();
        $req = $db->prepare(
            'INSERT INTO `accounts` (`id`, `username`, `password`, `ava_url`, `acc_type`) 
            VALUES (NULL, :username, :pass, :ava_url, :acc_type)'
        );
        $req->execute(array(
            'username' => $userName,
            'pass' => $pass,
            'ava_url' => $ava_url,
            'acc_type' => $acc_type
        ));

        if (!$db->lastInsertId())
        {
            // Notify error
            return null;
        }

        return self::find($db->lastInsertId());
    }

    static function updateAccountInfo($id, $new_name, $new_pass, $new_url = '', $new_type = 0)
    {
        $tableName = get_called_class();
        $dto = substr($tableName, 0, -1);

        self::requireModel($dto);

        $db = DB::getInstance();
        $req = $db->prepare(
            'UPDATE `accounts` 
            SET `username` = :username, `password` = :pass, `ava_url` = :ava_url, `acc_type` = :acc_type 
            WHERE `accounts`.`id` = :id'
        );
        $req->execute(array(
            'username' => $new_name,
            'pass' => $new_pass,
            'ava_url' => $new_url,
            'acc_type' => $new_type,
            'id' => $id
        ));

        if (!$db->lastInsertId())
        {
            // Notify error
        }

        return $db->lastInsertId();
    }
}