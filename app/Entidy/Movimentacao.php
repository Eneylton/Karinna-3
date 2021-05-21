<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;


class Movimentacao
{


    public $id;

    public $data;

    public $valor;

    public $form_pagamento;

    public $tipo;

    public $status;

    public $descricao;

    public $usuarios_id;

    public $catdesp_id;



    public function cadastar()
    {


        $obdataBase = new Database('movimentacoes');

        $this->id = $obdataBase->insert([

            'data'                  => $this->data,
            'valor'                 => $this->valor,
            'form_pagamento'        => $this->form_pagamento,
            'tipo'                  => $this->tipo,
            'status'                => $this->status,
            'descricao'             => $this->descricao,
            'usuario_id'            => $this->usuario_id,
            'catdesp_id'            => $this->catdesp_id

        ]);

        return true;
    }

    public static function getList($where = null, $order = null, $limit = null)
    {

        return (new Database('movimentacoes'))->select($where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getListMov($where = null, $order = null, $limit = null)
    {

        return (new Database('movimentacoes'))->innerjoinMov($where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    public static function getQtdMov($where = null)
    {

        return (new Database('movimentacoes'))->qtdmov($where, null, null, 'COUNT(*) as qtd')
            ->fetchObject()
            ->qtd;
    }


    public static function getQtd($where = null)
    {

        return (new Database('movimentacoes'))->select($where, null, null, 'COUNT(*) as qtd')
            ->fetchObject()
            ->qtd;
    }


    public static function getID($id)
    {
        return (new Database('movimentacoes'))->select('id = ' . $id)
            ->fetchObject(self::class);
    }

    public function atualizar()
    {
        return (new Database('movimentacoes'))->update('id = ' . $this->id, [


            'data'                  => $this->data,
            'valor'                 => $this->valor,
            'form_pagamento'        => $this->form_pagamento,
            'tipo'                  => $this->tipo,
            'status'                => $this->status,
            'descricao'             => $this->descricao,
            'usuario_id'            => $this->usuario_id,
            'catdesp_id'            => $this->catdesp_id
        ]);
    }

    public function excluir()
    {
        return (new Database('movimentacoes'))->delete('id = ' . $this->id);
    }


    public static function getEmail($form_pagamento)
    {

        return (new Database('movimentacoes'))->select('form_pagamento = "' . $form_pagamento . '"')->fetchObject(self::class);
    }

    public static function getPdf()
    {

        return (new Database('movimentacoes'))->pdf($where = null)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }
}
