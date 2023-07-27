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
    <link rel="stylesheet" href="<?= CSS . "main.css" ?>">
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
                <input class="form-control me-2 search-nav" type="search" placeholder="Search" aria-label="Search">
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
            <p class="title fs-15 fw-500 text-truncate">Main </p>
            <ul class="plr-10">
                <li class="li-aside-menu <?= $controller->compareURL('/') === true ? 'active' : '' ?>"
                    has-sub-menu="false" title="Home">

                    <a href="/" class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa fa-home"></i>
                        <span class="text">Home</span>
                    </a>
                </li>


                <!-- Start With Sub menu -->
                <li class="li-aside-menu
                    <?= $controller->compareURL(['/students/add', '/students']) === true ? 'active' : '' ?>"
                    has-sub-menu="true" title="Students >> ">
                    <button  class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa fa-users"></i>
                        <span class="text">Students</span>
                        <i class="fa-solid fa-arrow-down arrow ml-auto"></i>
                    </button>
                    <ul class="aside-sub-menu" sub-menu open="false">
                        <li class="li-aside-menu" >
                            <a href="#" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10 ">
                                <i class="fa fa-plus"></i>
                                <span class="text">Add Student</span>
                            </a>
                        </li>
                        <li class="li-aside-menu">
                            <a href="#" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10 ">
                                <i class="fa fa-trash"></i>
                                <span class="text">Delete Student</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End With Sub menu -->

                <!-- Start With Sub menu -->
                <li class="li-aside-menu
                    <?= $controller->compareURL(['/instructors/add', '/instructors']) === true ? 'active' : '' ?>"
                    has-sub-menu="true" title="Instructors >> ">

                    <button class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa-solid fa-certificate"></i>
                        <span class="text">Doctors</span>
                        <i class="fa-solid fa-arrow-down arrow ml-auto"></i>
                    </button>
                    <ul class="aside-sub-menu" sub-menu open="false">
                        <li class="li-aside-menu">
                            <a href="/instructors" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10">
                                <i class="fa-solid fa-eye"></i>
                                <span class="text">Instructors</span>
                            </a>
                        </li>
                        <li class="li-aside-menu">
                            <a href="/instructors/add" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10">
                                <i class="fa fa-plus"></i>
                                <span class="text">Add Instructor</span>
                            </a>
                        </li>

                    </ul>
                </li>
                <!-- End With Sub menu -->


                <li class="li-aside-menu
                    <?= $controller->compareURL('/vote') === true ? 'active' : '' ?>"
                    has-sub-menu="false" title="New Vote">
                    <a href="#" class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa fa-vote-yea"></i>
                        <span class="text">New Vote</span>
                    </a>
                </li>
            </ul>
        </div>


        <!-- Start Setting -->
        <div class="menu">
            <p class="title fs-15 fw-500 text-truncate">Settings </p>
            <ul class="plr-10">
                <li class="li-aside-menu
                    <?= $controller->compareURL('/settings') === true ? 'active' : '' ?>"
                    has-sub-menu="false"  title="Setting"
                >

                    <a href="#" class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa fa-gears"></i>
                        <span class="text">Settings</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Setting -->



        <!-- Start Account -->
        <div class="menu">
            <p class="title fs-15 fw-500 text-truncate">Account </p>
            <ul class="plr-10">
                <li class="li-aside-menu <?= $controller->compareURL('/help') === true ? 'active' : '' ?> " has-sub-menu="false"  title="Help">
                    <a href="#" class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa fa-info-circle"></i>
                        <span class="text">Help</span>
                    </a>
                </li>
                <li class="li-aside-menu <?= $controller->compareURL('/logout') === true ? 'active' : '' ?> " has-sub-menu="false"  title="Logout">
                    <a href="#" class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa fa-arrow-left"></i>
                        <span class="text">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Account -->




    </nav>
</aside>

<main class="">
    <h1 class="main-title">
        <i class="fa-solid fa-user-plus"></i>
        <span class="">
            Add Instructor
        </span>
    </h1>

    <div class="container mt-20 container-form">
        <?php
            if ($messages != null) {
                foreach ($messages as $message) {
                    ?>
                        <div class="alert alert-danger plr-10 ptb-5 " role="alert">
                            <?= $message[0]  ?>
                        </div>
                    <?php
                }
            }
        ?>
        <form class="row g-3" method="POST" >
            <div class="col-md-4">
                <label for="FirstName" class="form-label mb-1">First name</label>
                <input type="text" class="form-control" id="FirstName" between="2,50" name="FirstName" value="<?= $controller->getStorePost("FirstName") ?>" required autocomplete="none">
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    First Name must between 2 and 50 character
                </div>
            </div>

            <div class="col-md-4">
                <label for="LastName" class="form-label mb-1">Last name</label>
                <input type="text" class="form-control" id="LastName" between="2,50" name="LastName" value="<?= $controller->getStorePost("LastName") ?>" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Last Name must between 2 and 50 character
                </div>
            </div>


            <div class="col-md-4">
                <label for="Email" class="form-label mb-1">Email</label>
                <input type="email" class="form-control" id="Email" name="Email" email-input value="<?= $controller->getStorePost("Email") ?>" required>
                <div class="invalid-feedback">
                    Please provide a valid
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>


            <div class="col-md-4">
                <label for="Password" class="form-label mb-1">Password</label>
                <input type="password" class="form-control" id="Password" name="Password" value="<?= $controller->getStorePost("Password") ?>"  required>

                <button class="show-password" show-password="false" description="show Password">
                    <i class="fa-solid fa-eye"></i>
                </button>

                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <div class="col-md-4">
                <label for="ConfirmPassword" class="form-label mb-1">Confirm Password</label>
                <input type="password" class="form-control" id="ConfirmPassword" name="ConfirmPassword"  value="<?= $controller->getStorePost("ConfirmPassword") ?>" required>
                <button class="show-password" show-password="false" description="show Password">
                    <i class="fa-solid fa-eye"></i>
                </button>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>


            <div class="col-md-4">
                <label for="NationalIdentificationNumber" class="form-label mb-1">National Identification Number</label>
                <input type="text" class="form-control" id="NationalIdentificationNumber" name="NationalIdentificationNumber"  between="11, 11" value="<?= $controller->getStorePost("NationalIdentificationNumber") ?>" required>
                <div class="invalid-feedback">
                    National Identification Number Must be 11 digit
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>


            <div class="col-md-2">
                <label for="State" class="form-label mb-1">State</label>
                <input type="text" class="form-control" id="State" name="State" value="<?= $controller->getStorePost("State") ?>" required>
                <div class="invalid-feedback">
                    Please provide a valid State.
                </div>
            </div>

            <div class="col-md-2">
                <label for="Country" class="form-label mb-1">Country</label>
                <input type="text" class="form-control" id="Country" name="Country" value="<?= $controller->getStorePost("Country") ?>" required>
                <div class="invalid-feedback">
                    Please provide a Country.
                </div>
            </div>

            <div class="col-md-2">
                <label for="PhoneNumber" class="form-label mb-1">PhoneNumber</label>
                <input type="text" class="form-control" id="PhoneNumber" between="10, 10" name="PhoneNumber" value="<?= $controller->getStorePost("PhoneNumber") ?>" required>
                <div class="invalid-feedback">
                    Phone number Must be 10 character
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <div class="col-md-6">
                <label for="Address" class="form-label mb-1">Address</label>
                <input type="text" class="form-control" id="Address" name="Address" value="<?= $controller->getStorePost("Address") ?>" required>
                <div class="invalid-feedback">
                    Please provide a valid Address.
                </div>
            </div>

            <div class="col-md-2">
                <label for="DOB" class="form-label mb-1">DOB</label>
                <input type="text" class="form-control" id="DOB" name="DOB" value="<?= $controller->getStorePost("DOB") ?>" required>
                <div class="invalid-feedback">
                    Please provide a DOB.
                </div>
            </div>

            <div class="col-md-2">
                <label for="HireDate" class="form-label mb-1">Hire Date</label>
                <input type="text" class="form-control" id="HireDate" name="HireDate" value="<?= $controller->getStorePost("HireDate") ?>" required>
                <div class="invalid-feedback">
                    Please provide a DOB.
                </div>
            </div>


            <div class="col-md-2">
                <label for="Salary" class="form-label mb-1">Salary</label>
                <input type="number" class="form-control" id="Salary" name="Salary" value="<?= $controller->getStorePost("Salary") ?>" required>
                <div class="invalid-feedback">
                    Please provide a DOB.
                </div>
            </div>


            <div class="col-md-2">
                <label for="YearsOfExperience" class="form-label mb-1">Years Of Experience</label>
                <input type="number" class="form-control" id="YearsOfExperience" name="YearsOfExperience" min="0" value="<?= $controller->getStorePost("YearsOfExperience") ?>" required>
                <div class="invalid-feedback">
                    Please provide a DOB.
                </div>
            </div>


            <div class="col-md-2">
                <label for="IfFullTime" class="form-label mb-1">If Full Time</label>
                <select class="form-select" id="IfFullTime" name="IfFullTime" required>
                    <option selected disabled value="<?= $controller->getStorePost("IfFullTime") ?>">
                        <?= $controller->getStorePost("IfFullTime") ? 'Yes' : "No" ?>
                    </option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                <div class="invalid-feedback">
                    Please select a valid state.
                </div>
            </div>

            <div class="col-md-2">
                <label for="IsActive" class="form-label mb-1">Is Active</label>
                <select class="form-select" id="IsActive" name="IsActive" required>
                    <option selected disabled value="<?= $controller->getStorePost("IsActive") ?>">
                        <?= $controller->getStorePost("IsActive") ? 'Yes' : "No" ?>
                    </option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                <div class="invalid-feedback">
                    Please select a valid state.
                </div>
            </div>


            <div class="col-12">
                <button class="main-btn" name="add" type="submit">Submit form</button>
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