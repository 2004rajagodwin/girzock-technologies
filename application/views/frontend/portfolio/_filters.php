<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<li>
    <a data-filter="*">All</a>
</li>
<?php foreach ($categories as $category): ?>
<li>
    <a data-filter=".item<?= (int) $category['id'] ?>"><?= e($category['name']) ?></a>
</li>
<?php endforeach; ?>
