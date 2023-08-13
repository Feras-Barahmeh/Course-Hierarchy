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


                <!-- start vote -->
                <li class="li-aside-menu
                    <?= $controller->compareURL(['/vote/add', '/vote']) === true ? 'active' : '' ?>"
                    has-sub-menu="true" title="<?= $votes ?>">

                    <button class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa-solid fa-vote-yea"></i>
                        <span class="text"><?= $votes ?></span>
                        <i class="fa-solid fa-arrow-down arrow"></i>
                    </button>
                    <ul class="aside-sub-menu" sub-menu open="false">
                        <li class="li-aside-menu">
                            <a href="/vote" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10">
                                <i class="fa-solid fa-eye"></i>
                                <span class="text"><?= $votes ?></span>
                            </a>
                        </li>
                        <li class="li-aside-menu">
                            <a href="/vote/add" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10">
                                <i class="fa fa-plus"></i>
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
        <i class="fa-solid fa-building"></i>
        <span class="">

            <?= $text_colleges ?>
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

    <!-- Start Table -->
        <div class="container">
            <div class="row mb-20">
                <form action="" class="col-lg-6 col-md-4" METHOD="POST">
                    <div class="input-group flex-nowrap">
                        <button class="input-group-text hover" name="search" type="submit" id="addon-wrapping"><i class="fa fa-filter mr-15 main-color"></i> <?= $search  ?></button>
                        <button class="input-group-text hover" name="resit" type="submit" id="addon-wrapping"><i class="fa fa-arrow-rotate-back mr-15 main-color"></i> <?= $resit ?></button>
                        <input type="text" class="form-control" name="value_search" placeholder="<?= $search_college  ?>" aria-label="Username" aria-describedby="addon-wrapping">
                    </div>
                </form>

                <div class="action col-lg-6 col-md-4 d-flex">
                    <a href="/colleges/add" class="ml-auto">
                        <button class="btn main-btn"> <i class="fa fa-plus main-color mr-5"></i> <?= $add_college  ?></button>
                    </a>
                </div>
            </div>



            <?php
                if ($colleges) {
                    ?>
                        <div class="container-table responsive-table">
                                <table class="table pagination-table upper">
                                    <thead class="table-dark">
                                        <tr>
                                            <td><?= $id  ?></td>
                                            <td><?= $name_college ?></td>
                                            <td><?= $count_students  ?></td>
                                            <td><?= $controls  ?></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($colleges as $collage) {
                                            ?>
                                            <tr>
                                                <td><?= $collage->CollegeID ?></td>
                                                <td><?= $collage->CollegeName ?></td>
                                                <td><?= $collage->TotalStudentsInCollege ?></td>
                                                <td class="exclude-hover">
                                                    <a href="/colleges/edit/<?= $collage->CollegeID ?>">
                                                        <button type="button" class="btn btn-success description" description="<?= $edit ?>">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    </a>

                                                    <button type="button" class="btn btn-danger description" btn-popup description="<?= $delete ?>">
                                                        <i class="fa fa-trash"></i>
                                                    </button>

                                                    <!-- start popup -->
                                                    <div class="popup confirm">
                                                        <div class="content">
                                                            <div class="header">
                                                                <div class="icon color-danger bg-danger"><i class="fa fa-exclamation"></i></div>
                                                                <h4 class="title">
                                                                    <?= $are_you_sure_delete ?>
                                                                    <span class="highlight"><?= $collage->CollegeName ?></span>
                                                                </h4>

                                                                <button class="close-btn" close><i class="fa-solid fa-x"></i></button>
                                                            </div>

                                                            <div class="confirm">
                                                                <div class="row g-3 align-items-center">
                                                                    <div class="col-12 input-container">
                                                                        <label for="confirmText" class="col-form-label no-select">
                                                                            <?= $to_confirm ?> <span class="fw-bold" get-used-to><?= $collage->CollegeName ?></span>
                                                                            <?= $this_box ?>
                                                                        </label>
                                                                        <input type="text" id="confirmText" class="form-control">
                                                                        <div class="buttons mt-10">
                                                                            <button class="btn border-1 btn-light cansel" close> <?= $cansel ?> </button>
                                                                            <a href="/colleges/delete/<?= $collage->CollegeID ?>" >
                                                                                <button class="btn btn-danger" apply> <?= $apply  ?> </button>
                                                                            </a>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End popup -->
                                                </td>
                                            </tr>
                                            <?php

                                        }
                                        ?>
                                    </tbody>
                                </table>
                        </div>
                    <?php
                }
                else {
                    ?> <div class="alert alert-info p-2"><?= $no_college ?></div> <?php
                }
            ?>


        </div>
    <!-- End Table -->

</main>




    <footer></footer>
    <script src="<?= JS . "main"      . ".js" ?>"></script>
    <script src="<?=  JS . "shortcut"  . ".js" ?>"></script>
    <script src="<?=  JS . "all.min"  . ".js" ?>"></script>
    <script src="<?=  BOOTSTRAP_JS . "bootstrap.bundle"  . ".js" ?>"></script>
    <script src="<?=  JS . $file_js  . ".js" ?>"></script>
    </body>
</html>