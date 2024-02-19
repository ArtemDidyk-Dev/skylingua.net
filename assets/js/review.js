let reviewForm = document.querySelector(".review-form");

reviewForm.addEventListener('submit', (e) => {
    e.preventDefault();
    let route = reviewForm.getAttribute('action');
    let name = document.querySelector('[name="name"]').value
    let email = document.querySelector('[name="email"]').value;
    let message = document.querySelector('[name="message"]').value;
    let rating = +document.querySelector('.promo__rating-items').getAttribute('rating');
    let resultForm = document.querySelector('.review-form__result');

    let data = {
        "name": name,
        'rating': rating,
        'email': email
    }
     for (const dataKey in data) {
       if (data[dataKey] == '') {
             return  resultForm.innerHTML = `<p> ${dataKey.toUpperCase()} should not be empty</p>`
        }
     }
    data['message'] = message;
    resultForm.innerHTML = "";
    fetch(route, {
        method: "POST",
        headers: {
            'Content-Type': 'application/json;charset=utf-8',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                'content')
        },
        body: JSON.stringify(data)

    })
        .then(response => {
            return response.json();
        })
        .then(data => {
            if(data.errors) {
                for (const key in data.errors) {
                    for (const keyError in data.errors[key]) {
                        let dataError =  data.errors[key];
                        resultForm.innerHTML += `<p>${dataError[keyError]}</p>`
                    }
                }
            }
            if(data.success) {
                resultForm.innerHTML = "";
                resultForm.innerHTML = "<p>Your message has been sent for admin approval</p>"
            }

        })

})



const ratings = document.querySelectorAll('.promo__recall-rating');
if (ratings.length > 0) {
    initRatings();
}
function initRatings() {
    let ratingActive, ratingValue;
    for (let index = 0; index < ratings.length; index++) {
        const rating = ratings[index];
        initRatings(rating);

    }

    function initRatings(rating) {
        initRatingsVars(rating);
        setRatingActiveWidth();
       return  setRating(rating)
    }

    function initRatingsVars(rating) {
        ratingActive = rating.querySelector('.promo__rating-active');
        ratingValue = rating.querySelector('.promo__rating-value');
    }

    function setRatingActiveWidth(index = ratingValue.innerHTML) {
        if (+index >= 10) {
            ratingValue.classList.add("maxRating");
        }
        const ratingActiveWidth = index /  0.05;
        ratingActive.style.width = `${ratingActiveWidth}%`;

    }
    function setRating(rating) {

        const ratingItems = document.querySelectorAll('.promo__rating-item');
        for (let index = 0; index < ratingItems.length; index++) {
            const ratingItem = ratingItems[index];
            ratingItem.addEventListener("mouseenter", function () {
                initRatingsVars(rating);
                setRatingActiveWidth(ratingItem.value);

            });


            ratingItem.addEventListener("click", function (e) {
                initRatingsVars(rating);
                document.querySelector('.promo__rating-items').setAttribute('rating', ratingItem.value)
                return setRatingActiveWidth(ratingItem.value);

            });

        }

    }

}

