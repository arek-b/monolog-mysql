<?php

namespace MonologHandler\Handler;

use mysqli;

/**
 * MySQLi Handler
 * 
 * @license     New BSD License
 * @copyright   (c) 2014, Bhavik Patel
 * @author      Bhavik Patel
 */
class MySQLiHandler extends AbstractHandler
{

    /**
     *
     * @var \mysqli 
     */
    private $db;

    /**
     *
     * @var \mysqli_stmt
     */
    private $statement;

    /**
     * 
     * @param \mysqli $db
     */
    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    /**
     * Initialization.
     * 
     * @param   string  $table_name
     */
    public function init($table_name)
    {
        $this->db->query($this->getCreateQuery($table_name));

        $query = 'INSERT INTO ' . $table_name . ' (channel,level,message,time) '
                . 'VALUES(?,?,?,?)';
        $this->statement = $this->db->prepare($query);
    }

    /**
     * Writes log.
     * 
     * @param   array     $record
     */
    public function write($record)
    {
        $this->statement->bind_param('ssss', $record['channel'], $record['level'], $record['message'], $record['datetime']->format('U'));
        $this->statement->execute();
    }

}
