<?php

include('block.php');
include('CuteDB.php');

class Blockchain
{
	const dbFile = 'blockchain';
	const lastHashField = 'lasthash';

	private $_db = null;
	private $_lastHash = null;

	public function __construct()
	{
		$this->_db = new CuteDB();

		if (!$this->_db->open(Blockchain::dbFile)) {
			exit("Failed to create/open blockchian database");
		}

		$this->_lastHash = $this->_db->get(Blockchain::lastHashField);
		if (!$this->_lastHash) {
			$block = new Block('', 'Genesis Block');
			$hash = $block->getBlockHash();
			$this->_db->set($hash, serialize($block));
			$this->_db->set(Blockchain::lastHashField, $hash);
			$this->_lastHash = $hash;
		}
	}

	public function addBlock($data)
	{
		$newBlock = new Block($this->_lastHash, $data);

		$hash = $newBlock->getBlockHash();

		$this->_db->set($hash, serialize($newBlock));
		$this->_db->set(Blockchain::lastHashField, $hash);

		$this->_lastHash = $hash;
	}

	public function printBlockchain()
	{
		$lastHash = $this->_lastHash;

		while (true) {
			$block = $this->_db->get($lastHash);
			if (!$block) {
				break;
			}

			$block = unserialize($block);

			printf("PrevHash: %s\n", $block->prevHash);
			printf("Hash: %s\n", $block->hash);
			printf("Data: %s\n", $block->data);
			printf("Nonce: %s\n\n\n", $block->nonce);

			$lastHash = $block->prevHash;
		}
	}
}
