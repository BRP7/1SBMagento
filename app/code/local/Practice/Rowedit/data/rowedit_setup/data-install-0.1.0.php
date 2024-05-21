<?php
$installer = $this;
$installer->startSetup();

$data = [
    ['name' => 'Item 1', 'description' => 'Description for item 1'],
    ['name' => 'Item 2', 'description' => 'Description for item 2'],
    ['name' => 'Item 3', 'description' => 'Description for item 3'],
];

foreach ($data as $item) {
    $installer->getConnection()->insert($installer->getTable('practice_rowedit/rowedit'), $item);
}

$installer->endSetup();
