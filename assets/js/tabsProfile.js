const tabsButton = document.querySelectorAll('.single-freelancer-review__tabs span');
const  tabsItems = document.querySelectorAll('.single-freelancer-review__box');
if (tabsButton.length > 0) {
    tabsButton.forEach((button)=> {
        button.addEventListener("click", () => {
            tabsButton.forEach((item, index) => {
                item.classList.remove("active");
                tabsItems[index].classList.remove("active");
            })
            let active = button.getAttribute("data-tabs");
            let newTabsElement = document.querySelectorAll(`[data-tabs="${active}"]`);
            newTabsElement.forEach(item => {
                item.classList.add("active");
            })
        })
    })
}
