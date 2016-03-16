<?php

namespace MonologHandler;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;

/**
 * Description of MySQLHandler
 * 
 * @license     New BSD License
 * @copyright   (c) 2014, Bhavik Patel
 * @author      Bhavik Patel
 */
class MySQLHandler extends AbstractProcessingHandler
{

    /**
     * Flag to indicate that initialization has been done or not.
     * 
     * @var boolean 
     */
    private $init = FALSE;

    /**
     * Handler mapping.
     * 
     * @var array 
     */
    private $handler_mapping = [
        "Doctrine\DBAL\Connection" => Handler\DoctrineHandler::class,
        "mysqli" => Handler\MySQLiHandler::class,
        "PDO" => Handler\PDOHandler::class
    ];

    /**
     * Handler instance.
     * 
     * @var \MonologHandler\Handler\DoctrineHandler|\MonologHandler\Handler\MySQLiHandler|\MonologHandler\Handler\PDOHandler 
     */
    private $handler;

    /**
     *
     * @var type 
     */
    private $table = 'monolog';

    /**
     * 
     * @param   mixed       $db
     * @param   int         $level
     * @param   boolean     $bubble
     */
    public function __construct($db, $table = NULL, $level = Logger::DEBUG, $bubble = true)
    {
        parent::__construct($level, $bubble);
        $this->table = $table;
        $this->setHandler($db);
    }

    /**
     * Sets handler.
     * 
     * @param mixed $db
     */
    private function setHandler($db)
    {
        $this->handler = new $this->handler_mapping[get_class($db)]($db);
    }

    /**
     * 
     * @param type $record
     */
    protected function write(array $record)
    {
        if (!$this->init)
        {
            $this->handler->init($this->table);
            $this->init = TRUE;
        }
        $this->handler->write($record);
    }

}
