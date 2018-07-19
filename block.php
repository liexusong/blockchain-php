<?php

class Block
{
	public $prevHash;
	public $hash;
	public $timeStamp;
	public $data;
	public $nonce;

	public function __construct($prevHash, $data)
	{
		$this->prevHash = $prevHash;
		$this->timeStamp = time();
		$this->data = $data;
		$this->findBlockHash();
	}

	public function getBlockHash()
	{
		return $this->hash;
	}

	public function prepareData($nonce)
	{
		return json_encode([
			$this->prevHash,
			$this->timeStamp,
			$this->data,
			$nonce,
		]);
	}

	public function findBlockHash()
	{
		$found = false;
		$condition = '0000';
		$condlength = strlen($condition);

		printf("Mining the block containing \"%s\"\n", $this->data);

		for ($nonce = 0; $nonce < PHP_INT_MAX; $nonce++) {

			$data = $this->prepareData($nonce);

			$hash = hash('sha256', $data);

			printf("\r%d: %s", $nonce, $hash);

			if (substr($hash, 0, $condlength) === $condition) {
				$found = true;
				break;
			}
		}

		print("\n\n");

		if ($found) {
			$this->nonce = $nonce;
			$this->hash = $hash;
		}

		return $found;
	}

	public function validate()
	{
		$condition = '0000';
		$condlength = strlen($condition);

		$data = $this->prepareData($this->nonce);

		return substr(hash('sha256', $data), 0, $condlength) === $condition;
	}
}
