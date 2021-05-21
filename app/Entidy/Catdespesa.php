<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;


class Catdespesa
{


    public $id;

    public $nome;

    public function cadastar()
    {


        $obdataBase = new Database('catdespesas');

        $this->id = $obdataBase->insert([

            'nome'         => $this->nome

        ]);

        return true;
    }

    public static function getList($where = null, $order = null, $limit = null)
    {

        return (new Database('catdespesas'))->select($where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQtd($where = null)
    {

        return (new Database('catdespesas'))->select($where, null, null, 'COUNT(*) as qtd')
            ->fetchObject()
            ->qtd;
    }


    public static function getID($id)
    {
        return (new Database('catdespesas'))->select('id = ' . $id)
            ->fetchObject(self::class);
    }

    public static function getIDCAT($id)
    {
        return (new Database('catdespesas'))->select('id = ' . $id)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public function atualizar()
    {
        return (new Database('catdespesas'))->update('id = ' . $this->id, [


            'nome'         => $this->nome

        ]);
    }

    public function excluir()
    {
        return (new Database('catdespesas'))->delete('id = ' . $this->id);
    }


    public static function getEmail($foto)
    {

        return (new Database('catdespesas'))->select('foto = "' . $foto . '"')->fetchObject(self::class);
    }

    public static function getPdf()
    {

        return (new Database('catdespesas'))->pdf($where = null)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }
}
