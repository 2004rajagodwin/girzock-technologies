<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e($title) ?> | <?= e(setting('company_name')) ?></title>
    <link rel="icon" type="image/png" href="<?= e(media_url(setting('favicon'))) ?>">
    <link rel="stylesheet" href="<?= asset('assets/admin/css/admin.css') ?>">
</head>
<body class="gz-auth">
<main class="gz-auth-card">
    <img class="gz-auth-logo" src="<?= e(media_url(setting('logo_color'))) ?>" alt="<?= e(setting('company_name')) ?>">
    <h1><?= e($title) ?></h1>
