<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $last = count($products) - 1; foreach ($products as $i => $product): ?>
<a<?= $i === $last ? " class='mb-0'" : '' ?> href="<?= site_url('products/'.$product['slug']) ?>"><?= e($product['title']) ?></a>
<?php endforeach; ?>
