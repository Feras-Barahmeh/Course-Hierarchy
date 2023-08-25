@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.aside')@

<main class="">
    <h1 class="main-title">
        <i class="fa-solid fa-crown"></i>
        <span class="name-student">
            <span class=""><?= $user->Name  ?></span>
        </span>
    </h1>

    @extend('layout.messages')@
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
@extend('layout.footer')@