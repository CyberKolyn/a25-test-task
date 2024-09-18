<?php

use sdbh\sdbh;

require_once __DIR__ . '/../Infrastructure/sdbh.php';

class DB {

    protected $provider;

    private static $instance = null;

    public function __construct()
    {
        $this->provider = new Sdbh();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function rawQuery(string $sql) : array
    {
        return $this->provider->make_query($sql);
    }
    public function read(
        $tbl_name,
        $select_array,
        $from,
        $amount,
        $order_by,
        $order = Null,
        $deadlock_up = False,
        $lock_mode = Null
    ) : array
    {
        return $this->provider->mselect_rows(
            $tbl_name,
            $select_array,
            $from,
            $amount,
            $order_by,
            $order,
            $deadlock_up,
            $lock_mode
        );
    }

    public function create($tbl_name, $rows, $deadlock_up = False)
    {
        $this->provider->insert_rows($tbl_name, $rows, $deadlock_up = False);
    }

    public function update(
        $tbl_name,
        $update_array,
        $select_array,
        $deadlock_up
    )
    {
        $this->provider->update_rows(
            $tbl_name,
            $update_array,
            $select_array,
            $deadlock_up
        );
    }

    public function delete($tbl_name, $delete_array, $deadlock_up = False)
    {
        return $this->provider->delete_rows($tbl_name, $delete_array, $deadlock_up);
    }


}