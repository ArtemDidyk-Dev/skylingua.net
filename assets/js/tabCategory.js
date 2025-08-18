const Log = require("laravel-mix/src/Log");

document.addEventListener('DOMContentLoaded', () => {
    let buttonTabs = document.querySelectorAll(".projects__left-item");
    let tabsElement = document.querySelectorAll('.projects__item');

    buttonTabs.forEach((button, index) => {
        button.addEventListener("click", () => {
            buttonTabs.forEach((item, index) => {
                item.classList.remove("active");
                tabsElement[index].classList.remove("active");
            })

            let activeEliment = button.getAttribute("data-category");
            let newTabsElement = document.querySelectorAll(`[data-category="${activeEliment}"]`);
            newTabsElement.forEach(item => {
                item.classList.add("active");
            })
        })

    })

    function activeElement() {

    }
});

