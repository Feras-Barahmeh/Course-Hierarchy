<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?></title>
    <link rel="icon" href="<?= IMG . 'logo.png'  ?>">
    <link rel="stylesheet" href="<?= BOOTSTRAP_CSS . 'bootstrap.min.css'  ?>">
    <link rel="stylesheet" href="<?= BOOTSTRAP_CSS . 'bootstrap.min.css.map'  ?>">
    <link rel="stylesheet" href="<?= '/css/shortcut.css' ?>">
    <link rel="stylesheet" href="<?= '/css/all.min.css' ?>">
    <link rel="stylesheet" href="<?= CSS . $lang . DS . "main.css" ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= CSS . $lang . DS . $file_css  . ".css"  ?>">
</head>
    <body>


<nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm bg-black z-3" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="http://www.ttu.edu.jo/">
            <img src="<?= IMG . 'logo.png' ?>" alt="TTU Logo" class="logo w-25 h-25 mr-15">
            <span><?= $TTU ?></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= $student_links ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="https://webapp.ttu.edu.jo:2011/login.aspx">
                                <i class="fa-solid fa-toilets-portable mr-15"></i>
                                <span><?= $student_ported ?></span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="http://www.ttu.edu.jo/wp-content/uploads/2021/09/cal.pdf">
                                <i class="fa-solid fa-calendar mr-15"></i>
                                <span><?= $calender  ?></span>
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="http://www.ttu.edu.jo/admission/bachelors-degree/">
                                <i class="fa-solid fa-folder-tree mr-15"></i>
                                <span><?= $student_plans  ?></span>
                            </a>
                        </li>


                    </ul>
                </li>


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span><?= $collages_links  ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="http://www.ttu.edu.jo/college-of-engineering/">
                                <i class="fa-solid fa-gear mr-15"></i>
                                <span><?= $engineering  ?></span>
                            </a>
                        </li>

                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
<aside class="d-flex flex-column bg-black p-20 gap-20 " id="main-aside" expanded="false">
    <button class="aside-toggle d-flex align-items-center gap-10" btn-aside-toggel>
        <i class="fa-solid fa-angles-left"></i>
    </button>
    <header class="header d-flex gap-20 align-items-center ">
        <figure class="user-img object-fit-cover m-0 justify-content-between overflow-hidden">
            <img src="<?= IMG . 'avatar_student_default.png' ?>" class="w-100 object-fit-cover" alt="User Image">
        </figure>
        <div class="user-details">

            <p class="name mb-0 fw-bold fs-14">
                <?= $user->GuideName ?>
            </p>
        </div>
    </header>

    <nav class="d-flex flex-column flex-1 relative">
        <div class="menu">
            <p class="title fs-15 fw-500 text-truncate"><?= $main ?> </p>
            <ul class="plr-10">
                <li class="li-aside-menu <?= $controller->compareURL('/guider') === true ? 'active' : '' ?>"
                    has-sub-menu="false" title="<?= $home ?>">

                    <a href="/guider" class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa fa-home"></i>
                        <span class="text"><?= $home  ?></span>
                    </a>
                </li>

            <!-- Start vote -->
                <li class="li-aside-menu
                    <?= $controller->compareURL(['/guider/add', '/guider/vote']) === true ? 'active' : '' ?>"
                    has-sub-menu="true" title="<?= $text_votes ?>">

                    <button class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa-solid fa-vote-yea"></i>
                        <span class="text"><?= $text_votes ?></span>
                        <i class="fa-solid fa-arrow-down arrow"></i>
                    </button>
                    <ul class="aside-sub-menu" sub-menu open="false">
                        <li class="li-aside-menu">
                            <a href="/guider/votes" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10">
                                <i class="fa-solid fa-eye"></i>
                                <span class="text"><?= $text_votes ?></span>
                            </a>
                        </li>
                        <li class="li-aside-menu">
                            <a href="/guider/add" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10">
                                <i class="fa-solid fa-plus"></i>
                                <span class="text"><?= $add_vote ?></span>
                            </a>
                        </li>

                    </ul>
                </li>
            <!-- End vote -->

            </ul>
        </div>



        <div class="menu">
            <p class="title fs-15 fw-500 text-truncate"><?= $settings ?> </p>
            <ul class="plr-10">
                <!-- Start With Settings -->
                <li class="li-aside-menu
                    <?= $controller->compareURL(['/settings/language', '/settings']) === true ? 'active' : '' ?>"
                    has-sub-menu="true" title="<?= $settings ?>">

                    <button class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa fa-gears"></i>
                        <span class="text"><?= $settings ?></span>
                        <i class="fa-solid fa-arrow-down arrow"></i>
                    </button>
                    <ul class="aside-sub-menu" sub-menu open="false">
                        <li class="li-aside-menu">
                            <a href="/settings/language" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10">
                                <i class="fa-solid fa-language"></i>
                                <span class="text"><?= $change_language ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End With Settings -->
            </ul>
        </div>



        <!-- Start Account -->
        <div class="menu">
            <p class="title fs-15 fw-500 text-truncate"><?= $account ?> </p>
            <ul class="plr-10">
                <li class="li-aside-menu <?= $controller->compareURL('/help') === true ? 'active' : '' ?> " has-sub-menu="false"  title="<?= $help ?>">
                    <a href="#" class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa fa-info-circle"></i>
                        <span class="text"><?= $help ?></span>
                    </a>
                </li>
                <li class="li-aside-menu <?= $controller->compareURL('/logout') === true ? 'active' : '' ?> " has-sub-menu="false"  title="<?= $logout ?>">
                    <a href="/auth/logout" class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa fa-arrow-left"></i>
                        <span class="text"><?= $logout ?></span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Account -->




    </nav>
</aside>

<main class="">
    <h1 class="main-title">
        <i class="fa-solid fa-square-poll-vertical"></i>
        <span class="">
            <?= $text_vote  ?>
        </span>
    </h1>

    
<?php

use App\Core\Session;

$messages =  Session::flash("message");

if ($messages) {
    ?>
        <div class="container">
            <?php
                foreach ($messages as $message) {

                    $type = is_object($message[1]) ? strtolower($message[1]->name) : strtolower($message[1]);
                    $message = $message[0];
                    ?>
                    <div class="alert alert-<?= $type ?> between-element p-2 " kick-out="7000" role="alert">
                        <span class="flex f-align-center"><?= $message ?></span>
                    </div>
                    <?php
                }
            ?>
        </div>
    <?php


}
?>

    <div class="container">
        <div class="row mb-20">
            <div class="action col-lg-12 col-md-4 d-flex">
                <a href="/guider/" class="ml-auto">
                    <button class="btn main-btn plr-10"> <i class="fa fa-arrow-left main-color mr-5"></i><?= $to_dashboard  ?></button>
                </a>
            </div>
        </div>

    </div>
    <div class="container mt-20 container-form">

        <div class="alert alert-primary mt-3" >
            <span class="highlight"><?= $hint ?></span>
        </div>
        <form class="row g-3" method="POST" >
            <div class="col-md-6 input" required>
                <label for="Title" class="form-label mb-1">Title Vote</label>
                <input type="text" class="form-control" id="Title" name="Title"  value="<?= $controller->getStorePost("Title") ?>" required>
                <div class="invalid-feedback">
                    <?= $invalid_feedback ?>
                </div>
                <div class="valid-feedback">
                    <?= $valid_feedback ?>
                </div>
            </div>

            <div class="col-md-6">
                <label for="ForYear" class="form-label mb-1"><?= $text_years ?></label>
                <select class="form-select" id="ForYear" name="ForYear">
                    <option value=""></option>

                    <?php
                        foreach ($years as $value => $year) {
                            ?>
                                <option <?= $controller::setSelectedAttribute($value, $controller->getStorePost("ForYear") ) ?>
                                        value="<?= $value ?>">
                                    <?= $year ?>
                                </option>
                            <?php
                        }
                    ?>

                </select>
                <div class="invalid-feedback">
                    <?= $invalid_feedback ?>
                </div>
            </div>




            <div class="col-md-6">
                <label for="ForMajor" class="form-label mb-1"><?= $text_majors ?></label>
                <select class="form-select" id="ForMajor" name="ForMajor">
                    <option value=""></option>

                    <?php
                    foreach ($majors as $major) {

                        ?>
                        <option <?= $controller::setSelectedAttribute($major->MajorID, $controller->getStorePost("ForMajor") ) ?>
                                value="<?= $major->MajorID ?>">
                            <?= $major->MajorName ?>
                        </option>
                        <?php
                    }
                    ?>

                </select>
                <div class="invalid-feedback">
                    <?= $invalid_feedback ?>
                </div>
            </div>


            <div class="col-md-6 input" required>
                <label for="TimeExpired" class="form-label mb-1">TimeExpired Vote</label>
                <input type="datetime-local" class="form-control" id="TimeExpired" name="TimeExpired"  value="<?= $controller->getStorePost("TimeExpired") ?>" required>
                <div class="invalid-feedback">
                    <?= $invalid_feedback ?>
                </div>
                <div class="valid-feedback">
                    <?= $valid_feedback ?>
                </div>
            </div>


            <div class="col-12">
                <button class="main-btn" name="share" type="submit"><?= $share_vote ?></button>
            </div>
        </form>


    </div>

</main>




    <footer></footer>
    <script src="<?= JS . "main"      . ".js" ?>"></script>
    <script src="<?=  JS . "shortcut"  . ".js" ?>"></script>
    <script src="<?=  JS . "all.min"  . ".js" ?>"></script>
    <script src="<?=  BOOTSTRAP_JS . "bootstrap.bundle"  . ".js" ?>"></script>
    <script src="<?=  JS . $file_js  . ".js" ?>"></script>
    </body>
</html>