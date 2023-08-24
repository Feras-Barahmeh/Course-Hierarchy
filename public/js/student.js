/**
 *  Check input When Click Course
 */
let courses = document.querySelectorAll(".course");
let chosenCourses = document.querySelector(".chosen-courses");
let courseChosenUl = chosenCourses.querySelector("ul");
let hoursChosenContainer = chosenCourses.querySelector(".footer-ul").querySelector("span");
let courseChosen = {};
let hoursChosen = Number(hoursChosenContainer.textContent);

function setNameCoursesChosen() {
    courseChosenUl.innerHTML = '';
    for (const courseChosenElement in courseChosen) {
        let li = document.createElement("li");
        console.log(courseChosen[courseChosenElement])
        li.textContent = courseChosen[courseChosenElement].name;
        courseChosenUl.appendChild(li);
    }
}
courseChosenUl.querySelectorAll("li").forEach(li => {
    let id = li.getAttribute("id");
    courseChosen[id] = {
        "name" : li.getAttribute("name-course"),
        "hour"  : Number(li.getAttribute("hours"))
    };
});
courses.forEach(course => {
    course.addEventListener("click", () => {
        let inputCheckBox = course.querySelector("input");

        let hours = Number(course.getAttribute("number-Hoers"));
        let alterMessage = document.getElementById("header").querySelector("#danger-alert");

        if (inputCheckBox.checked) {
            inputCheckBox.checked = false;
            let id = course.getAttribute("id");
            delete  courseChosen[id];
            course.querySelector(".chased").classList.add("hidden");
            hoursChosen -= hours;
            if (hoursChosen < 18) {
                alterMessage.classList.add("hidden");
            }

            hoursChosenContainer.textContent = hoursChosen.toString();
            setNameCoursesChosen();
        }
        else {
            if (hours + hoursChosen > 18) {
                alterMessage.classList.remove("hidden");
            } else {
                alterMessage.classList.add("hidden");
                inputCheckBox.checked = true;
                let id = course.getAttribute("id");
                courseChosen[id] = {
                    "hours" : hours,
                    "name"  : course.querySelector("#nameCourse").textContent
                };
                hoursChosen += hours;
                course.querySelector(".chased").classList.remove("hidden")
            }

            setNameCoursesChosen();
            hoursChosenContainer.textContent = hoursChosen.toString();

        }


    });
});

/**
 * Search course by name
 */

let searchCourse = document.getElementById("search-course")
searchCourse.addEventListener("keyup", () => {
    let nameSearched = searchCourse.value.toLowerCase();
    courses.forEach(course => {
       let nameCourse = course.querySelector("#nameCourse").textContent.trim().toLowerCase();
        if ( nameCourse.search(nameSearched) === -1 && nameSearched !== '') {
            course.classList.add("kick-out")
        } else {
            course.classList.remove("kick-out");
        }
    });
});