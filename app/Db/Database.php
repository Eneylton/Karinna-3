<?php

namespace App\Db;

use \PDO;
use \PDOException;

class Database
{

    const HOST = 'localhost';
    const NAME = 'db_karina-2';
    const USER = 'root';
    const PASS = '';


    private $table;

    /**
     * @var PDO
     */
    private $connection;


    public function __construct($table = null)
    {

        $this->table = $table;
        $this->setConnection();
    }

    private function setConnection()
    {

        try {
            $this->connection = new PDO('mysql:host=' . self::HOST . ';dbname=' . self::NAME, self::USER, self::PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {

            die('ERROR: ' . $e->getMessage());
        }
    }


    /**
     * @param string
     * @param array
     * @return PDOStatement
     */

    public function execute($query, $params = [])
    {

        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {

            die('ERROR: ' . $e->getMessage());
        }
    }



    public function select($where = null, $order = null, $limit = null, $fields = '*')
    {

        $where = strlen($where) ? 'as p WHERE ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';

        $query = 'SELECT ' . $fields . ' FROM ' . $this->table . ' ' . $where . ' ' . $order . ' ' . $limit;

        return $this->execute($query);
    }


    public function rank()
    {

        $query = 'SELECT 
        e.nome AS nome, COUNT(e.produtos_id) AS contagem
                  FROM estatisticas AS e GROUP BY e.nome order by contagem DESC LIMIT 10';

        return $this->execute($query);
    }

    public function despesas()
    {

        $query = 'SELECT sum(e.subtotal) as total FROM estatisticas as e ';

        return $this->execute($query);
    }

    public function receitas()
    {

        $query = 'SELECT sum(v.subtotal) as total FROM vendas as v ';

        return $this->execute($query);
    }


    public function receber($where = null, $order = null, $limit = null, $fields = '*')
    {

        $where = strlen($where) ? 'AND ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';

        $query = 'SELECT ' . $fields . ' FROM ' . $this->table . ' as p WHERE p.status = 1 ' . $where . ' ' . $order . ' ' . $limit;

        return $this->execute($query);
    }

    public function qtdmov($where = null, $order = null, $limit = null, $fields = '*')
    {
        $where = strlen($where) ? 'WHERE ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';


        $query = 'SELECT ' . $fields . '
        
            FROM
            movimentacoes AS m
            INNER JOIN
            catdespesas AS c ON (m.catdesp_id = c.id)
            INNER JOIN
            usuarios AS u ON (m.usuarios_id = u.id)
            ' . $where . ' ' . $order . ' ' . $limit;

        return $this->execute($query);
    }



    public function qtd($where = null, $order = null, $limit = null, $fields = '*')
    {
        $where = strlen($where) ? 'WHERE ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';


        $query = 'SELECT ' . $fields . '
        
    FROM
        produtos AS p
            INNER JOIN
            categorias AS c ON (p.categorias_id = c.id)
            ' . $where . ' ' . $order . ' ' . $limit;

        return $this->execute($query);
    }


    public function qtdCli($where = null, $order = null, $limit = null, $fields = '*')
    {
        $where = strlen($where) ? 'WHERE ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';


        $query = 'SELECT ' . $fields . '
        
        FROM
        clientes AS c
        INNER JOIN
        marcas AS m ON (c.marcas_id = m.id)
            ' . $where . ' ' . $order . ' ' . $limit;

        return $this->execute($query);
    }



    public function qtdBaixo($where = null, $order = null, $limit = null, $fields = '*')
    {
        $where = strlen($where) ? ' AND ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';


        $query = 'SELECT ' . $fields . '
        
    FROM
        produtos AS p
            INNER JOIN
            categorias AS c ON (p.categorias_id = c.id) WHERE p.estoque <= 3
            ' . $where . ' ' . $order . ' ' . $limit;

        return $this->execute($query);
    }


    public function relacionadas($where = null, $order = null, $limit = null)
    {

        $where = strlen($where) ? 'WHERE ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';


        $query = 'SELECT 
        p.id as id,
        p.codigo as codigo,
        p.barra as barra,
        p.data as data,
        p.nome as nome,
        p.foto as foto,
        p.estoque as estoque,
        p.valor_compra as valor_compra,
        p.valor_venda as valor_venda,
        c.nome as categoria
        
    FROM
        produtos AS p
            INNER JOIN
        categorias AS c ON (p.categorias_id = c.id)
        ' . $where . ' ' . $order . ' ' . $limit;

        return $this->execute($query);
    }



    public function selectService($where, $order = null, $limit = null)
    {

        $where = strlen($where) ? 'WHERE ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';


        $query = 'SELECT 
        os.id As id,
        s.nome AS nome, 
        os.obs AS obs,
        s.valor AS valor
        FROM
        ordem_servicos AS os
        INNER JOIN
        servicos AS s ON (os.servicos_id = s.id)
        '. $where. ' AND os.status = 0 ' . $order . ' ' . $limit;

        return $this->execute($query);
    }

    public function selectService2($where, $order = null, $limit = null)
    {

        $where = strlen($where) ? 'WHERE ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';


        $query = 'SELECT 
        os.id  AS id,
        s.nome AS nome, 
        os.obs AS obs,
        s.valor AS valor
        FROM
        ordem_servicos AS os
        INNER JOIN
        servicos AS s ON (os.servicos_id = s.id)
        '. $where. ' ' . $order . ' ' . $limit;

        return $this->execute($query);
    }



    public function innerjoin($where = null, $order = null, $limit = null)
    {

        $where = strlen($where) ? 'WHERE ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';


        $query = 'SELECT 
        c.id as id,
        c.nome as nome,
        c.telefone as telefone,
        c.email as email,
        c.placa as placa,
        m.nome as marca
        
        FROM
        
        clientes AS c
        INNER JOIN
        marcas AS m ON (c.marcas_id = m.id)
        ' . $where . ' ' . $order . ' ' . $limit;

        return $this->execute($query);
    }


    public function innerjoinMov($where = null, $order = null, $limit = null)
    {

        $where = strlen($where) ? 'WHERE ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';


        $query = 'SELECT 
          m.id as id,
          m.data AS data,
          m.valor AS valor,
          m.catdesp_id AS catdesp_id,
          m.form_pagamento AS pagamento,
          m.descricao as descricao,
          m.tipo as tipo,
          m.status as status,
          c.nome as categoria,
          u.nome as usuario

        FROM
        
        movimentacoes AS m
        INNER JOIN
        catdespesas AS c ON (m.catdesp_id = c.id)
	    INNER JOIN
        usuarios AS u ON (m.usuarios_id = u.id)
        ' . $where . ' ' . $order . ' ' . $limit;

        return $this->execute($query);
    }



    public function innerjoinVeiculo($where = null, $order = null, $limit = null)
    {

        $where = strlen($where) ? 'WHERE ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';


        $query = 'SELECT 
                v.id as id,
                v.nome as nome,
                m.nome as marca
                FROM
                veiculos AS v
                INNER JOIN
                marcas AS m ON (v.marca_id = m.id)
                ' . $where . ' ' . $order . ' ' . $limit;

        return $this->execute($query);
    }


    public function baixo($where = null, $order = null, $limit = null)
    {

        $where = strlen($where) ? 'AND ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';


        $query = 'SELECT 
        p.id as id,
        p.codigo as codigo,
        p.barra as barra,
        p.data as data,
        p.nome as nome,
        p.foto as foto,
        p.estoque as estoque,
        p.valor_compra as valor_compra,
        c.nome as categoria
        
    FROM
        produtos AS p
            INNER JOIN
        categorias AS c ON (p.categorias_id = c.id) WHERE p.estoque <= 3 ' . $where . '' . $order . ' ' . $limit;

        return $this->execute($query);
    }



    public function insert($values)
    {

        $fields = array_keys($values);
        $binds  = array_pad([], count($fields), '?');

        $query = 'INSERT INTO ' . $this->table . ' (' . implode(',', $fields) . ') VALUE (' . implode(',', $binds) . ')';

        $this->execute($query, array_values($values));

        return $this->connection->lastInsertId();
    }

    public function update($where, $values)
    {

        $fields = array_keys($values);

        $query = 'UPDATE ' . $this->table . ' SET ' . implode('=?,', $fields) . '=? WHERE ' . $where;
        $this->execute($query, array_values($values));
        return true;
    }


    public function delete($where)
    {

        $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $where;
        $this->execute($query);
        return true;
    }

    public function pdf($where = null)
    {

        $where = strlen($where) ? 'WHERE ' . $where : '';


        $query = 'SELECT * FROM ' . $this->table . ' ' . $where . ' ORDER BY id desc';

        return $this->execute($query);
    }

    public function consultar($id)
    {

        $query = 'SELECT * FROM galerias as g WHERE ' . $id;

        return $this->execute($query);
    }
}
