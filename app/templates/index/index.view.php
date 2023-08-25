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
            <p class="title fs-10 fw-500 text-truncate">
                Intelligent System Engineering
            </p>
            <p class="name mb-0 fw-bold fs-14">
                Feras Barhmeh
            </p>
        </div>
    </header>

    <nav class="d-flex flex-column flex-1 relative">
        <div class="menu">
            <p class="title fs-15 fw-500 text-truncate"><?= $main ?> </p>
            <ul class="plr-10">
                <li class="li-aside-menu <?= $controller->compareURL('/') === true ? 'active' : '' ?>"
                    has-sub-menu="false" title="<?= $home ?>">

                    <a href="/" class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa fa-home"></i>
                        <span class="text"><?= $home  ?></span>
                    </a>
                </li>


                <!-- Start With Student -->
                <li class="li-aside-menu
                    <?= $controller->compareURL(['/students/add', '/students']) === true ? 'active' : '' ?>"
                    has-sub-menu="true" title="<?= $text_students ?> ">
                    <button  class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa fa-users"></i>
                        <span class="text"><?= $text_students  ?></span>
                        <i class="fa-solid fa-arrow-down arrow "></i>
                    </button>
                    <ul class="aside-sub-menu" sub-menu open="false">
                        <li class="li-aside-menu">
                            <a href="/students" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10 ">
                                <i class="fa-solid fa-eye"></i>
                                <span class="text"><?= $text_students ?></span>
                            </a>
                        </li>
                        <li class="li-aside-menu" >
                            <a href="/students/add" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10 ">
                                <i class="fa fa-plus"></i>
                                <span class="text"><?= $add_student ?></span>
                            </a>
                        </li>

                    </ul>
                </li>
                <!-- End With Student -->



                <!-- Start With major -->
                <li class="li-aside-menu
                    <?= $controller->compareURL(['/majors/add', '/majors']) === true ? 'active' : '' ?>"
                    has-sub-menu="true" title="<?= $text_majors ?> ">
                    <button  class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa-solid fa-book"></i>
                        <span class="text"><?= $text_majors  ?></span>
                        <i class="fa-solid fa-arrow-down arrow "></i>
                    </button>
                    <ul class="aside-sub-menu" sub-menu open="false">
                        <li class="li-aside-menu">
                            <a href="/majors" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10 ">
                                <i class="fa-solid fa-eye"></i>
                                <span class="text"><?= $text_majors ?></span>
                            </a>
                        </li>
                        <li class="li-aside-menu" >
                            <a href="/majors/add" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10 ">
                                <i class="fa fa-plus"></i>
                                <span class="text"><?= $add_major ?></span>
                            </a>
                        </li>

                    </ul>
                </li>
                <!-- End With major -->


                <!-- Start With Instructor -->
                <li class="li-aside-menu
                    <?= $controller->compareURL(['/instructors/add', '/instructors']) === true ? 'active' : '' ?>"
                    has-sub-menu="true" title="<?= $text_instructors ?>">

                    <button class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa-solid fa-person-chalkboard"></i>
                        <span class="text"><?= $text_instructors ?></span>
                        <i class="fa-solid fa-arrow-down arrow"></i>
                    </button>
                    <ul class="aside-sub-menu" sub-menu open="false">
                        <li class="li-aside-menu">
                            <a href="/instructors" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10">
                                <i class="fa-solid fa-eye"></i>
                                <span class="text"><?= $text_instructors ?></span>
                            </a>
                        </li>
                        <li class="li-aside-menu">
                            <a href="/instructors/add" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10">
                                <i class="fa fa-plus"></i>
                                <span class="text"><?= $add_instructor ?></span>
                            </a>
                        </li>

                    </ul>
                </li>
                <!-- End With Instructor -->


                <!-- Start With Instructor -->
                <li class="li-aside-menu
                    <?= $controller->compareURL(['/guides/add', '/guides']) === true ? 'active' : '' ?>"
                    has-sub-menu="true" title="<?= $text_guides ?>">

                    <button class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa-solid fa-compass"></i>
                        <span class="text"><?= $text_guides ?></span>
                        <i class="fa-solid fa-arrow-down arrow"></i>
                    </button>
                    <ul class="aside-sub-menu" sub-menu open="false">
                        <li class="li-aside-menu">
                            <a href="/guides" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10">
                                <i class="fa-solid fa-eye"></i>
                                <span class="text"><?= $text_guides ?></span>
                            </a>
                        </li>
                        <li class="li-aside-menu">
                            <a href="/guides/add" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10">
                                <i class="fa fa-plus"></i>
                                <span class="text"><?= $add_guide ?></span>
                            </a>
                        </li>

                    </ul>
                </li>
                <!-- End With Instructor -->




                <!-- Start With colleges -->
                <li class="li-aside-menu
                    <?= $controller->compareURL(['/colleges/add', '/colleges']) === true ? 'active' : '' ?>"
                    has-sub-menu="true" title="<?= $collages ?>">

                    <button class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa-solid fa-building-columns"></i>
                        <span class="text"><?= $collages ?></span>
                        <i class="fa-solid fa-arrow-down arrow"></i>
                    </button>
                    <ul class="aside-sub-menu" sub-menu open="false">
                        <li class="li-aside-menu">
                            <a href="/colleges" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10">
                                <i class="fa-solid fa-eye"></i>
                                <span class="text"><?= $collages ?></span>
                            </a>
                        </li>
                        <li class="li-aside-menu">
                            <a href="/colleges/add" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10">
                                <i class="fa fa-plus"></i>
                                <span class="text"><?= $add_collage ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End With colleges -->

            <!-- Start With Departments -->

                <li class="li-aside-menu
                    <?= $controller->compareURL(['/departments/add', '/departments']) === true ? 'active' : '' ?>"
                    has-sub-menu="true" title="<?= $text_departments ?>">

                    <button class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa-solid fa-layer-group"></i>
                        <span class="text"><?= $text_departments ?></span>
                        <i class="fa-solid fa-arrow-down arrow"></i>
                    </button>
                    <ul class="aside-sub-menu" sub-menu open="false">
                        <li class="li-aside-menu">
                            <a href="/departments" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10">
                                <i class="fa-solid fa-eye"></i>
                                <span class="text"><?= $text_departments ?></span>
                            </a>
                        </li>
                        <li class="li-aside-menu">
                            <a href="/departments/add" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10">
                                <i class="fa fa-plus"></i>
                                <span class="text"><?= $add_department ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
            <!-- End With Departments -->

                <!-- start Courses -->
                <li class="li-aside-menu
                    <?= $controller->compareURL(['/courses/add', '/courses']) === true ? 'active' : '' ?>"
                    has-sub-menu="true" title="<?= $text_courses ?>">

                    <button class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa-solid fa-book"></i>
                        <span class="text"><?=  $text_courses ?></span>
                        <i class="fa-solid fa-arrow-down arrow"></i>
                    </button>
                    <ul class="aside-sub-menu" sub-menu open="false">
                        <li class="li-aside-menu">
                            <a href="/courses" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10">
                                <i class="fa-solid fa-eye"></i>
                                <span class="text"><?= $text_courses ?></span>
                            </a>
                        </li>
                        <li class="li-aside-menu">
                            <a href="/courses/add" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10">
                                <i class="fa fa-plus"></i>
                                <span class="text"><?= $add_course ?></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End Courses -->

                <!-- start vote -->
<!--                <li class="li-aside-menu-->
<!--                    --><?php //= $controller->compareURL(['/votes/add', '/votes']) === true ? 'active' : '' ?><!--"-->
<!--                    has-sub-menu="true" title="--><?php //= $votes ?><!--">-->
<!---->
<!--                    <button class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">-->
<!--                        <i class="fa-solid fa-vote-yea"></i>-->
<!--                        <span class="text">--><?php //= $votes ?><!--</span>-->
<!--                        <i class="fa-solid fa-arrow-down arrow"></i>-->
<!--                    </button>-->
<!--                    <ul class="aside-sub-menu" sub-menu open="false">-->
<!--                        <li class="li-aside-menu">-->
<!--                            <a href="/votes" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10">-->
<!--                                <i class="fa-solid fa-eye"></i>-->
<!--                                <span class="text">--><?php //= $votes ?><!--</span>-->
<!--                            </a>-->
<!--                        </li>-->
<!--                        <li class="li-aside-menu">-->
<!--                            <a href="/votes/add" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10">-->
<!--                                <i class="fa fa-plus"></i>-->
<!--                                <span class="text">--><?php //= $add_vote ?><!--</span>-->
<!--                            </a>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                </li>-->
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
        <i class="fa-solid fa-crown"></i>
        <span class="name-student">
            <span class=""><?= $user->Name  ?></span>
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
    <div class="content w-full">

        <div class="wrapper d-grid gap-20">
            <!-- Start Welcome Widget -->
            <div class="welcome bg-white rad-10 txt-c-mobile block-mobile">
                <div class="intro p-20 d-flex space-between bg-eee">
                    <div>
                        <h2 class="m-0"><?= $welcome ?></h2>
                        <p class="c-grey mt-5"><?= $user->Name ?></p>
                    </div>
                    <img class="hide-mobile" src="<?= IMG ?>welcome.png" alt="" />
                </div>
                <img src="<?= IMG ?>avatar.png" alt="" class="avatar" />
                <div class="body txt-c d-flex p-20 mt-20 mb-20 block-mobile">
                    <div><?= $user->Name  ?> <span class="d-block c-grey fs-14 mt-10"><?= $admin ?></span></div>

                </div>
            </div>
            <!-- End Welcome Widget -->


            <!-- Start Ticket Widget -->
            <div class="tickets p-20 bg-white rad-10">
                <h2 class="mt-0 mb-10"><?= $info ?></h2>
                <div class="d-flex txt-c gap-20 f-wrap">
                    <div class="box p-20 rad-10 fs-13 c-grey">
                        <i class="fa-solid fa-users fa-2x mb-10 c-orange"></i>
                        <span class="d-block c-black fw-bold fs-25 mb-5"><?= $numberStudents ?></span>
                        <?= $number_students ?>
                    </div>

                    <div class="box p-20 rad-10 fs-13 c-grey">
                        <i class="fa-solid fa-chalkboard-user fa-2x mb-10 c-blue"></i>
                        <span class="d-block c-black fw-bold fs-25 mb-5"><?= $numberInstructors ?></span>
                        <?= $number_instructors ?>
                    </div>
                    <div class="box p-20 rad-10 fs-13 c-grey">
                        <i class="fa-solid fa-swatchbook fa-2x mb-10 c-red"></i>
                        <span class="d-block c-black fw-bold fs-25 mb-5"><?= $numberDepartments ?></span>
                        <?= $number_department ?>
                    </div>
                    <div class="box p-20 rad-10 fs-13 c-grey">
                        <i class="fa-solid fa-swatchbook fa-2x mb-10 c-grey"></i>
                        <span class="d-block c-black fw-bold fs-25 mb-5"><?= $numberCourses ?></span>
                        <?= $number_courses ?>
                    </div>
                    <div class="box p-20 rad-10 fs-13 c-grey">
                        <i class="fa-solid fa-swatchbook fa-2x mb-10 c-green"></i>
                        <span class="d-block c-black fw-bold fs-25 mb-5"><?= $numberMajors ?></span>
                        <?= $number_majors ?>
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