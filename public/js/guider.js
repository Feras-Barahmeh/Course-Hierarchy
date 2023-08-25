let buttonsStatistics = document.querySelectorAll(".btn-statistic");
function setCoursesCount(container, data) {

    if (container.childElementCount === 0) {
        for (let row of data) {
            let course = document.createElement("div");
            course.classList.add("course");
            let h6 = document.createElement("h6");
            h6.textContent = row["CourseName"];
            course.appendChild(h6);

            let div = document.createElement("div");

            let spanNumberHourCourse =  document.createElement("span");
            spanNumberHourCourse.classList.add("hours");
            spanNumberHourCourse.textContent = row["NumberHourCourse"];

            let spanVotedNumber =  document.createElement("span");
            spanVotedNumber.classList.add("count-chosen");
            spanVotedNumber.textContent = row["VotedNumber"];

            div.appendChild(spanNumberHourCourse);
            div.appendChild(spanVotedNumber);
            course.appendChild(div);
            container.appendChild(course)
        }
    }


}
buttonsStatistics.forEach(btnStatistics => {
    btnStatistics.addEventListener("click", () => {

        // Get statistics for this vote
        let voteID = btnStatistics.getAttribute("id");
        let statisticsPopup = btnStatistics.closest(".vote").querySelector(".statistics");


        fetch("http://precatalog.local/ajax/getStatisticsVote", {
            "method": "POST",
            "headers": {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            "body": `id=${voteID}`,
        })
            .then(function(res){ return res.json(); })
            .then(function(data){
                let coursesCountContainer = statisticsPopup.querySelector(".courses");
                setCoursesCount(coursesCountContainer, data);
            })

        // show popup
        statisticsPopup.classList.toggle("show");
        let btnClosePopup =statisticsPopup.querySelector(".btn-close");
        btnClosePopup.addEventListener("click", () => {
            statisticsPopup.classList.remove("show");
        });
    });
});
