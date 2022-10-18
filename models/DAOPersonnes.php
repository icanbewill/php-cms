<?php
class DAOPersonnes
{

    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM personnes');
        foreach ($req->fetchAll() as $persons) {
            $list[] = new Person($persons['id'], $persons['name'], $persons['sexe']);
        }
        return $list;
    }

    public static function create(){
        
    }

    public static function find($id)
    {
    }
}
