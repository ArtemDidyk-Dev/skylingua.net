document.addEventListener('DOMContentLoaded', function () {
    let modalActive = document.querySelector('.model-active');
    if (modalActive) {
        let model = document.querySelector('#proposal');
        let body = document.querySelector("body");
        modalActive.addEventListener("click", () => {
            model.classList.add('fade');
            body.classList.add('model')
        })
        let closeModel = document.querySelector('.modal-close');
        closeModel.addEventListener("click", () => {
            model.classList.remove('fade');
            body.classList.remove('model')
        })
    }
});