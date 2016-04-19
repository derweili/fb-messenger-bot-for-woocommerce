<?php

//namespace pimax\Messages;

/**
 * Class Address
 * 
 * @package pimax\Messages
 */
class Address
{
    /**
     * @var array
     */
    public $data = [];

    /**
     * Address constructor.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get Data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}