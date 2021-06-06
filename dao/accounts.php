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

    static function addNewAccount(
        $userName,
        $pass,
        $fullname = null,
        $ava_url = DEFAULT_AVA_URL,
        $acc_type = 0,
        $tel_no = null,
        $email = null
    ) {
        $tableName = get_called_class();
        $dto = substr($tableName, 0, -1);

        self::requireModel($dto);

        $db = DB::getInstance();
        $req = $db->prepare(
            'INSERT INTO `accounts` (`username`, `password`, `fullname`, `ava_url`, `acc_type`, `tel_no`, `email`) 
            VALUES (:username, :pass, :fullname, :ava_url, :acc_type, :tel_no, :email)'
        );
        $status = $req->execute(array(
            'username' => $userName,
            'pass' => $pass,
            'fullname' => $fullname,
            'ava_url' => $ava_url,
            'acc_type' => $acc_type,
            'tel_no' => $tel_no,
            'email' => $email
        ));

        if (!$status) {
            // Notify error
            return null;
        }

        return self::find($db->lastInsertId());
    }

    static function updateAccountInfo($id, $username, $fullname, $ava_url, $acc_type, $tel_no, $email)
    {
        $tableName = get_called_class();
        $dto = substr($tableName, 0, -1);

        self::requireModel($dto);

        $db = DB::getInstance();

        $acc = Accounts::find($id);

        // Check new update:
        if (is_null($username)) {
            $username = $acc->username;
        }
        if (is_null($fullname)) {
            $fullname = $acc->fullname;
        }
        if (is_null($ava_url)) {
            $ava_url = $acc->avaUrl;
        }
        if (is_null($acc_type)) {
            $acc_type = $acc->type;
        }
        if (is_null($tel_no)) {
            $tel_no = $acc->tel_no;
        }
        if (is_null($email)) {
            $email = $acc->email;
        }

        $req = $db->prepare(
            'UPDATE `accounts` 
                SET `username` = :username, `fullname` = :fullname, `ava_url` = :ava_url, `acc_type` = :acc_type, `tel_no` = :tel_no, `email` = :email 
                WHERE `accounts`.`id` = :id'
        );
        $status = $req->execute(array(
            'username' => $username,
            'ava_url' => $ava_url,
            'acc_type' => $acc_type,
            'tel_no' => $tel_no,
            'email' => $email,
            'fullname' => $fullname,
            'id' => $id
        ));

        if (!$status) {
            // Notify error
            return -1;
        }

        return $id;
    }

    static function updateAccountPassword($id, $password)
    {
        $tableName = get_called_class();
        $dto = substr($tableName, 0, -1);

        self::requireModel($dto);

        $db = DB::getInstance();
        // Check new update:

        if (is_null($password) || is_null($id)) {
            return -1;
        }

        $req = $db->prepare(
            'UPDATE `accounts` 
                SET `password` = :new_password
                WHERE `accounts`.`id` = :id'
        );

        $status = $req->execute(array(
            'new_password' => $password,
            'id' => $id
        ));

        if (!$status) {
            // Notify error
            return -1;
        }

        return $id;
    }
}
