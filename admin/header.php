<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin • Art Gallery</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/admin.css">


</head>
<body>
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= BASE_URL ?>admin/dashboard.php">Admin Panel</a>
    <div class="d-flex gap-2">
      <a class="btn btn-sm btn-outline-light" href="<?= BASE_URL ?>" target="_blank"><i class="fa fa-home"></i> Site</a>
      <a class="btn btn-sm btn-danger" href="<?= BASE_URL ?>admin/logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
    </div>
  </div>
</nav>
<div class="container py-4">
