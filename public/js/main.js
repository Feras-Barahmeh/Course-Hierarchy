// Start Aside
let aside = document.getElementById("main-aside");

let nav = aside.querySelector("nav");
let lis = nav.querySelectorAll("li");

function closeAllSubMenusOpened(lis, currentSubMenuWillOpened) {
    lis.forEach(li => {
        let subMenus = document.querySelectorAll("[sub-menu]");
        subMenus.forEach(menu => {
            if (menu !== currentSubMenuWillOpened) {
                menu.setAttribute("open", "false");
            }
        });
    });
}

// Start Set Aside expand status stored in local storage
if (localStorage.getItem('expandMainAsideStatus')) {
    aside.setAttribute("expanded", localStorage.getItem('expandMainAsideStatus'));
}
// End Set Aside expand status stored in local storage
lis.forEach(li => {
    li.addEventListener("click", () => {

        // if it has sub menu open it
        if (li.getAttribute("has-sub-menu") === "true") {
            // rotate angle
            li.querySelector(".arrow").classList.toggle("rotate");

            let ul = li.querySelector("[sub-menu]");

            // Close all sub menus opened
            closeAllSubMenusOpened(lis, ul);

            if (ul.getAttribute("open") === "true") {
                ul.setAttribute("open", "false");
            } else {
                ul.setAttribute("open", "true");
            }

            // Toggle Arrow
            let i = li.querySelector("[arrow]");

        }

    });
});
// Start Toggle aside
const asideToggleBtn = document.querySelector("[btn-aside-toggel]");
asideToggleBtn.addEventListener("click", () => {
    console.log(asideToggleBtn)
    if (aside.getAttribute("expanded") === "true") {
        aside.setAttribute("expanded", "false");
        localStorage.setItem('expandMainAsideStatus', "false");
    } else {
        aside.setAttribute("expanded", "true");
        localStorage.setItem('expandMainAsideStatus', "true");
    }
});
// End Toggle aside
// End Aside

// Start kick out Alter
let alerts = document.querySelectorAll("[kick-out]");
alerts.forEach(alert => {
    let time = alert.getAttribute("kick-out");
    setTimeout(()=> {
        alert.remove();
    }, Number(time))
});
// End kick out Alter


// start validation forms
(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
    })
})()
// End validation forms

// Start Popup
let buttonsPopup = document.querySelectorAll("[btn-popup]");

buttonsPopup.forEach(btnPopup => {
    btnPopup.addEventListener("click", () => {
        let popup = btnPopup.parentElement.querySelector(".popup");
        popup.classList.add("fed");
        let div = document.createElement("div");
        div.classList.add("landing");

        document.body.appendChild(div);

        //  Start Focus in cansel button
        popup.querySelector(".cansel").focus();
        popup.querySelector(".cansel").classList.add("focus");
        //  End Focus in cansel button

        // Start Close Buttons
        let closeButtons = document.querySelectorAll(".popup [close]");
        closeButtons.forEach(btn => {
           btn.addEventListener("click", () => {
               let popup = btn.closest(".popup");
               popup.classList.remove("fed");
               document.body.lastChild.remove();
           });
        });
        // End Close Buttons

        // Start apply Button
        let applyButtons = document.querySelectorAll(".popup [apply]");

        applyButtons.forEach(btn => {

            const btnClickHandler = (event) => {
                let textConfirm = btn.closest(".popup").querySelector("[get-used-to]");

                let input = textConfirm.closest(".input-container").querySelector("input");
                event.preventDefault();

                if (input.value === textConfirm.textContent) {
                    btn.removeEventListener('click', btnClickHandler);
                    input.value = '';
                    btn.click()
                } else {

                }

            };

            btn.addEventListener('click', btnClickHandler);

        });


        // End apply Button

    });
});

// End Popup