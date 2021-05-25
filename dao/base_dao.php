<?php

abstract class BaseDAO
{
    static function all()
    {
        $tableName = get_called_class();
        $dto = substr($tableName, 0, -1);
        $list = [];

        self::requireModel($dto);

        $db = DB::getInstance();
        $req = $db->query('SELECT * FROM ' . $tableName);

        foreach ($req->fetchAll() as $item) {
            $list[] = $dto::createFromDB($item);
        }

        return $list;
    }

    static function find($id)
    {
        $tableName = get_called_class();
        $dto = substr($tableName, 0, -1);

        self::requireModel($dto);

        $db = DB::getInstance();
        $req = $db->prepare(
            'SELECT * FROM ' . $tableName . 
            ' WHERE id = :id'
        );
        $req->execute(array(
            'id' => $id
        ));

        $item = $req->fetch();
        if (isset($item['id'])) {
            return $dto::createFromDB($item);
        }
        return null;
    }

    static function removeById($id)
    {
        $tableName = get_called_class();
        $dto = substr($tableName, 0, -1);

        self::requireModel($dto);

        $db = DB::getInstance();
        $status = $req = $db->prepare(
            'DELETE FROM ' . $tableName . 
            ' WHERE id = :id'
        );
        $req->execute(array(
            'id' => $id
        ));

        if (!$status)
        {
            // Notify error
        }

        return null;
    }

    static function requireModel($modelName)
    {
        $words = array();
        $pieces = preg_split('/(?=[A-Z])/', $modelName);

        array_shift($pieces);

        foreach ($pieces as &$piece) {
            array_push($words, lcfirst($piece));
        }

        $fileName = join("_", $words);
        $fileName .= '.php';

//        if (file_exists('/models/' . $fileName)) {
        require_once('models/' . $fileName);
//        }
    }
}