<?php

namespace MonologHandler\Handler;

/**
 * Description of AbstractHandler.
 * 
 * @license     New BSD License
 * @copyright   (c) 2014, Bhavik Patel
 * @author      Bhavik Patel
 */
abstract class AbstractHandler
{

    /**
     * Returns table creation query.
     * 
     * @param   string      $table_name
     * @return  string
     */
    protected function getCreateQuery($table_name)
    {
        return 'CREATE TABLE IF NOT EXISTS ' . $table_name . ' ('
                . 'log_id BIGINT NOT NULL AUTO_INCREMENT,'
                . 'channel VARCHAR(255), '
                . 'level INTEGER, '
                . 'message LONGTEXT, '
                . 'time INTEGER UNSIGNED,'
                . 'PRIMARY KEY (log_id)'
                . ')';
    }

    /**
     * Initialization.
     */
    public abstract function init($table_name);

    /**
     * Writes logs.
     * 
     * @param   array   $record
     */
    public abstract function write($record);
}
