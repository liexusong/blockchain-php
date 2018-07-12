<?php

include('blockchain.php');

$bc = new Blockchain();

$bc->addBlock('This is block1');
$bc->addBlock('This is block2');

foreach ($bc->blocks as $block) {
	printf("PrevHash: %s\n", $block->prevHash);
	printf("Hash: %s\n", $block->hash);
	printf("Data: %s\n", $block->data);
	printf("\n");
}
