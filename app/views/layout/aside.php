<aside class="d-flex flex-column bg-black p-20 gap-20 " id="main-aside" expanded="false">
    <button class="aside-toggle d-flex align-items-center gap-10" btn-aside-toggel>
        <i class="fa-solid fa-angles-left"></i>
        <!--        <span>Expand</span>-->
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
                <li class="li-aside-menu active" has-sub-menu="false" title="Home">
                    <a href="/" class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa fa-home"></i>
                        <span class="text">Home</span>
                    </a>
                </li>
                <!-- Start With Sub menu -->
                <li class="li-aside-menu" has-sub-menu="true" title="Students >> ">
                    <a href="#" class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa fa-users"></i>
                        <span class="text">Students</span>
                        <i class="fa-solid fa-arrow-down arrow ml-auto"></i>
                    </a>
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
                <li class="li-aside-menu" has-sub-menu="true" title="Doctor >> ">
                    <a href="#" class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa-solid fa-certificate"></i>
                        <span class="text">Doctors</span>
                        <i class="fa-solid fa-arrow-down arrow ml-auto"></i>
                    </a>
                    <ul class="aside-sub-menu" sub-menu open="false">
                        <li class="li-aside-menu">
                            <a href="#" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10 ">
                                <i class="fa fa-plus"></i>
                                <span class="text">Add Doctor</span>
                            </a>
                        </li>
                        <li class="li-aside-menu">
                            <a href="#" class="aside-link d-flex gap-10 align-items-center fs-15 plr-5 ptb-10 ">
                                <i class="fa fa-trash"></i>
                                <span class="text">Delete Doctor</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End With Sub menu -->


                <li class="li-aside-menu " has-sub-menu="false" title="New Vote">
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
                <li class="li-aside-menu " has-sub-menu="false"  title="Setting">
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
                <li class="li-aside-menu " has-sub-menu="false"  title="Help">
                    <a href="#" class="aside-link d-flex gap-10 align-items-center fs-15 plr-10 ptb-15 ">
                        <i class="fa fa-info-circle"></i>
                        <span class="text">Help</span>
                    </a>
                </li>
                <li class="li-aside-menu " has-sub-menu="false"  title="Logout">
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