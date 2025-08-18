let form = document.querySelector('.contacts-form');
if (form) {
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        let name = document.querySelector('[name="name"]').value;
        let email = document.querySelector('[name="email"]').value;
        let subject = document.querySelector('[name="subject"]').value;
        let message = document.querySelector('[name="message"]').value;
        let result = document.querySelector('.result');
        let data = {
            name: name,
            email: email,
            subject: subject,
            message: message
        }


        fetch('/contact-send-ajax', {
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
                result.innerHTML = "";
                if (data.success) {
                    result.innerHTML = `<p>${data.data}</p>`
                    return form.reset();
                }
                for (const key in data.data) {
                    result.innerHTML += `<p>${data.data[key]}</p>`
                }
            })

    });
}
