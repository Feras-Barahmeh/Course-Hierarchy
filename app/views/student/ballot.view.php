@extend('layout.header')@
@extend('layout.nav')@
@extend('layout.AsideStudent')@

<main class="">
    <h1 class="main-title">
        <i class="fa-solid fa-square-poll-horizontal"></i>
        <span class="name-student">
            <span class=""><?= $vote->Title ?></span>
        </span>
    </h1>

    @extend('layout.messages')@




    <div class="">

        <div class="container header mb-25" id="header">
            <h2 class="mt-0 mb-20"><?= $select_the_courses_you_wish_to_take ?></h2>

            <div class="alert alert-danger p-1 hidden" id="danger-alert">
                <?= $mch ?>
            </div>


            <div class="chosen-courses">
                <ul>

                    <?php
                        if ($coursesChosen && \App\Helper\Handel::ifBallot($vote->VoteID)) {
                            foreach ($coursesChosen as $course) {
                                ?>
                                    <li id="<?= $course->CourseID ?>" name-course="<?= $course->CourseName ?>" hours="<?= $course->NumberHourCourse ?>">
                                        <?= $course->CourseName ?>
                                    </li>
                                <?php
                            }
                        } else {
                            echo  $ncacy;
                        }
                    ?>
                </ul>
                <div class="footer-ul"><span><?= $hoursChosen ?? '0' ?></span> <?= $chosen_hour ?></div>
            </div>

            <div class="input-group flex-nowrap">
                <button class="input-group-text hover" name="search" type="submit" id="addon-wrapping"><i class="fa fa-search mr-15 main-color"></i> </button>
                <input type="text" class="form-control" name="value_search" id="search-course" placeholder="<?= $search_name_course  ?>">
            </div>


        </div>
        <form class=" g-3 wrapper courses d-grid gap-20" method="POST" id="courses-form" >

            <?php
            foreach ($courses as $course) {

                ?>

                <div class="task-row between-flex course" id="<?= $course->CourseID ?>" number-Hoers="<?= $course->NumberHourCourse ?>">

                    <div class="info">
                        <h3 class="mt-0 fs-15" id="nameCourse"><?= $course->CourseName ?></h3>
                        <p class="m-0 c-grey"><?= $number_course_hour ?> <?= $course->NumberHourCourse ?></p>
                    </div>
                    <label for="courses">
                        <input
                                type="checkbox"
                                name="courses[]"
                            <?= in_array( $course->CourseID, $coursesIDs) ? 'checked' : '' ?> value="<?=  $course->CourseID ?>"
                                class="checkbox-input">
                    </label>
                    <i class="fa-solid fa-check chased <?= in_array( $course->CourseID, $coursesIDs) ? '' : 'hidden' ?>"></i>
                </div>
                <?php
            }
            ?>

            <div class="col-12">
                <button class="main-btn" name="vote" type="submit"><?= 'vote' ?></button>
            </div>
        </form>
    </div>
</main>

@extend('layout.footer')@