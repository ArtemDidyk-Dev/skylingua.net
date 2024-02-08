let faqTitles = document.querySelectorAll('.faq__title');
let faqContents = document.querySelectorAll(".faq__content");
faqTitles.forEach((faqItem, index) => {
    faqItem.addEventListener('click', ()=> {
        faqItem.classList.toggle('active');
        faqContents[index].classList.toggle('active');
    })
})