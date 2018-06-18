<?php

namespace Helpers;

class QueryBuilder
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function selectAll($table)
    {
        $statement = $this->pdo->prepare("select * from {$table}");

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function insert($table, $parameters)
    {
        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );

        try {
            $statement = $this->pdo->prepare($sql);

            $statement->execute($parameters);
        } catch (Exception $e) {
            //
        }
    }  

    public function update($table, Array $parameters, Array $where_parameters = [])
    {
        $sql = sprintf(
            'update `%s` SET %s WHERE %s',
            $table,
            $this->prepareQuery($parameters),
            $this->prepareQuery($where_parameters, ' AND ')
        );

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute(array_merge($parameters, $where_parameters));
        } catch (Exception $e) {
            //
        }

    }

    protected function prepareQuery($params, $join = ', ')
    {

        if (empty($params)) {
            return 1;
        }

        $queries = [];
        foreach (array_keys($params) as $param) {
            $queries[] = sprintf(
                '`%s` = :%s',
                $param,
                $param
            );
        }

        return implode($join, $queries);
    }

    public function delete($table, $id)
    {
        $sql = "delete from `{$table}` where id = :id";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute(compact('id'));
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return false;
    }
}