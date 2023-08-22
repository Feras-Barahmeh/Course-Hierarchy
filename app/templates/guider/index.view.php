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
            <form class="d-flex" role="search">
                <input class="form-control me-2 search-nav" type="search" placeholder="<?= $search ?>" aria-label="Search">
                <button class="btn border-1 border-black btn-search" type="submit">
                    <?= $search  ?>
                </button>
            </form>
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
                    has-sub-menu="true" title="<?= $votes ?>">

                    <button class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa-solid fa-vote-yea"></i>
                        <span class="text"><?= $votes ?></span>
                        <i class="fa-solid fa-arrow-down arrow"></i>
                    </button>
                    <ul class="aside-sub-menu" sub-menu open="false">
                        <li class="li-aside-menu">
                            <a href="/guider/vote" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10">
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
    <div class="content w-full">
        <!-- Start Head -->
        <div class="head bg-white p-15 between-flex ">
            <div class="search p-relative">
                <input class="p-10" type="search" placeholder="Type A Keyword" />
            </div>
            <div class="icons d-flex align-center">
            <span class="notification p-relative">
              <i class="fa-regular fa-bell fa-lg"></i>
            </span>
                <img src="<?= IMG ?>avatar.png" alt="" />
            </div>
        </div>
        <!-- End Head -->
        <h1 class="p-relative">Dashboard</h1>
        <div class="wrapper d-grid gap-20">
            <!-- Start Welcome Widget -->
            <div class="welcome bg-white rad-10 txt-c-mobile block-mobile">
                <div class="intro p-20 d-flex space-between bg-eee">
                    <div>
                        <h2 class="m-0">Welcome</h2>
                        <p class="c-grey mt-5"><?= $user->GuideName ?></p>
                    </div>
                    <img class="hide-mobile" src="<?= IMG ?>welcome.png" alt="" />
                </div>
                <img src="<?= IMG ?>avatar.png" alt="" class="avatar" />
                <div class="body txt-c d-flex p-20 mt-20 mb-20 block-mobile">
                    <div><?= $user->GuideName  ?> <span class="d-block c-grey fs-14 mt-10">Guider</span></div>
<!--                    <div>80 <span class="d-block c-grey fs-14 mt-10">Projects</span></div>-->
<!--                    <div>$8500 <span class="d-block c-grey fs-14 mt-10">Earned</span></div>-->
                </div>
<!--                <a href="/guider/profile" class="visit d-block fs-14 bg-blue c-white w-fit btn-shape">Profile</a>-->
            </div>
            <!-- End Welcome Widget -->
            <!-- Start Tasks Widget -->
            <div class="tasks p-20 bg-white rad-10">
                <h2 class="mt-0 mb-20">Latest vote</h2>
                <div class="task-row between-flex">
                    <div class="info">
                        <h3 class="mt-0 mb-5 fs-15">Record One New Video</h3>
                        <p class="m-0 c-grey">Record Python Create Exe Project</p>
                    </div>
                    <i class="fa-regular fa-trash-can delete"></i>
                </div>
                <div class="task-row between-flex">
                    <div class="info">
                        <h3 class="mt-0 mb-5 fs-15">Write Article</h3>
                        <p class="m-0 c-grey">Write Low Level vs High Level Languages</p>
                    </div>
                    <i class="fa-regular fa-trash-can delete"></i>
                </div>
                <div class="task-row between-flex done">
                    <div class="info">
                        <h3 class="mt-0 mb-5 fs-15">Attend The Meeting</h3>
                        <p class="m-0 c-grey">Attend The Project Business Analysis Meeting</p>
                    </div>
                    <i class="fa-regular fa-trash-can delete"></i>
                </div>

            </div>
            <!-- End Tasks -->

            <!-- Start Quick Draft Widget -->
<!--            <div class="quick-draft p-20 bg-white rad-10">-->
<!--                <h2 class="mt-0 mb-10">Quick Draft</h2>-->
<!--                <p class="mt-0 mb-20 c-grey fs-15">Write A Draft For Your Ideas</p>-->
<!--                <form>-->
<!--                    <input class="d-block mb-20 w-full p-10 b-none bg-eee rad-6" type="text" placeholder="Title" />-->
<!--                    <textarea class="d-block mb-20 w-full p-10 b-none bg-eee rad-6" placeholder="Your Thought"></textarea>-->
<!--                    <input class="save d-block fs-14 bg-blue c-white b-none w-fit btn-shape" type="submit" value="Save" />-->
<!--                </form>-->
<!--            </div>-->
            <!-- End  Quick Draft Widget -->

            <!-- Start Ticket Widget -->
            <div class="tickets p-20 bg-white rad-10">
                <h2 class="mt-0 mb-10">Statistics</h2>
                <p class="mt-0 mb-20 c-grey fs-15">Everything About</p>
                <div class="d-flex txt-c gap-20 f-wrap">
                    <div class="box p-20 rad-10 fs-13 c-grey">
                        <i class="fa-regular fa-rectangle-list fa-2x mb-10 c-orange"></i>
                        <span class="d-block c-black fw-bold fs-25 mb-5">2500</span>
                        Total votes
                    </div>
                    <div class="box p-20 rad-10 fs-13 c-grey">
                        <i class="fa-solid fa-spinner fa-2x mb-10 c-blue"></i>
                        <span class="d-block c-black fw-bold fs-25 mb-5">500</span>
                        Pending votes
                    </div>
                    <div class="box p-20 rad-10 fs-13 c-grey">
                        <i class="fa-regular fa-circle-check fa-2x mb-10 c-green"></i>
                        <span class="d-block c-black fw-bold fs-25 mb-5">1900</span>
                        last vote
                    </div>
                    <div class="box p-20 rad-10 fs-13 c-grey">
                        <i class="fa-regular fa-rectangle-xmark fa-2x mb-10 c-red"></i>
                        <span class="d-block c-black fw-bold fs-25 mb-5">100</span>
                        Deleted vote
                    </div>
                </div>
            </div>
            <!-- End Ticket Widget -->
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