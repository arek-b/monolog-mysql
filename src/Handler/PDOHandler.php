<?php

namespace MonologHandler\Handler;

use PDO;

/**
 * PDO Handler
 * 
 * @license     New BSD License
 * @copyright   (c) 2014, Bhavik Patel
 * @author      Bhavik Patel
 */
class PDOHandler extends AbstractHandler
{

    /**
     *
     * @var \PDO 
     */
    private $db;

    /**
     *
     * @var \PDOStatement
     */
    private $statement;

    /**
     * 
     * @param \PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Initialization
     */
    public function init($table_name)
    {
        $this->db->exec($this->getCreateQuery($table_name));

        $query = 'INSERT INTO ' . $table_name . ' (channel,level,message,time) '
                . 'VALUES(:channel,:level,:message,:time)';
        $this->statement = $this->db->prepare($query);
    }

    /**
     * Writes log.
     * 
     * @param   array     $record
     */
    public function write($record)
    {
        $record = [
            'channel' => $record['channel'],
            'level' => $record['level'],
            'message' => $record['message'],
            'time' => $record['datetime']->format('U'),
        ];
        $this->statement->execute($record);
    }

}
