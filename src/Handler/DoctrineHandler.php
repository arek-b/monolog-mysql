<?php

namespace MonologHandler\Handler;

use Doctrine\DBAL\Connection;

/**
 * Doctrine Handler
 * 
 * @license     New BSD License
 * @copyright   (c) 2014, Bhavik Patel
 * @author      Bhavik Patel
 */
class DoctrineHandler extends AbstractHandler
{

    /**
     *
     * @var \Doctrine\DBAL\Connection 
     */
    private $db;

    /**
     *
     * @var type 
     */
    private $table_name;

    /**
     * 
     * @param \PDO $db
     */
    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     * Initialization
     */
    public function init($table_name)
    {
        $this->db->query($this->getCreateQuery($table_name));
        $this->table_name = $table_name;
    }

    /**
     * Writes log.
     * 
     * @param   array     $record
     */
    public function write($record)
    {
        $qb = $this->db->createQueryBuilder();

        $record = [
            'channel' => $record['channel'],
            'level' => $record['level'],
            'message' => $record['message'],
            'time' => $record['datetime']->format('U'),
        ];


        $qb->insert($this->table_name);
        foreach ($record as $key => $value)
        {
            $qb->setValue($key, ':' . $key)
                    ->setParameter($key, $value);
        }
        $qb->execute();
    }

}
