const { forEach } = require("lodash");

	
document.addEventListener('DOMContentLoaded', () => {
    const burger = document.querySelector('.header__burger');
    const menu = document.querySelector('.header__menu');
    const arrowHeaders = document.querySelectorAll('.has-submenu .arrow');
    const headerMenus = document.querySelectorAll('.has-submenu');
    const profile = document.querySelectorAll('.header-profile__wrapper');
    if (profile) {
        let profileMore = document.querySelectorAll('.dropdown-menu');

        profile.forEach((item, index) => {
            item.addEventListener('click', () => {
                profileMore[index].classList.toggle('emp');
            })
        });
    }
    burger.addEventListener('click', () => {
        classToggle(burger, 'active');
        classToggle(menu, 'active');
    })

    arrowHeaders.forEach((arrow, index) => {
        arrow.addEventListener('click', () => {
            headerMenus[index].classList.toggle('active')
        })
    });
    function classToggle(element, classAdd) {
        element.classList.toggle(classAdd);
    }
});
