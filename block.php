<?php

class Block
{
	public $prevHash;
	public $hash;
	public $timeStamp;
	public $data;

	public function __construct($prevHash, $data)
	{
		$this->prevHash = $prevHash;
		$this->timeStamp = time();
		$this->data = $data;
		$this->setBlockHash();
	}

	public function setBlockHash()
	{
		$data = serialize($this);
		$this->hash = hash('sha256', $data);
	}

	public function getBlockHash()
	{
		return $this->hash;
	}
}
