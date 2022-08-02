<!doctype html>
<html lang="en">

<head>
    <title>Codeigniter Web Application</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url('public/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('public/css/style.css') ?>">
</head>

<body>
    <!-- Header start -->
    <header class="bg-light">
        <div class="container">
            <!-- Nav start -->
            <nav class="navbar navbar-expand-lg navbar-light pt-3 pb-3">
                <a class="navbar-brand" href="<?php echo base_url();?>">Codeigniter Web Application</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse right-align" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="<?php echo base_url();?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('index.php/page/about')?>">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('index.php/page/services')?>">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('index.php/blog')?>">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('index.php/blog/categories')?>">Categories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact Us</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!--Nav end -->
        </div>
    </header>
    <!-- Header end -->