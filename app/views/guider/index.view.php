@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.AsideGuider')@

<main class="">
    @extend('layout.messages')@
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
                <a href="/guider/profile" class="visit d-block fs-14 bg-blue c-white w-fit btn-shape">Profile</a>
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
            <div class="quick-draft p-20 bg-white rad-10">
                <h2 class="mt-0 mb-10">Quick Draft</h2>
                <p class="mt-0 mb-20 c-grey fs-15">Write A Draft For Your Ideas</p>
                <form>
                    <input class="d-block mb-20 w-full p-10 b-none bg-eee rad-6" type="text" placeholder="Title" />
                    <textarea class="d-block mb-20 w-full p-10 b-none bg-eee rad-6" placeholder="Your Thought"></textarea>
                    <input class="save d-block fs-14 bg-blue c-white b-none w-fit btn-shape" type="submit" value="Save" />
                </form>
            </div>
            <!-- End Quick Draft Widget -->

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
@extend('layout.footer')@