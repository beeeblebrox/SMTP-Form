/* Form */

let forms = document.querySelectorAll('.js-form');

if (forms.length > 0) {
  forms.forEach(elem => {
    elem.addEventListener('submit', function (e) {
      e.preventDefault();
      
      const form = this;
      const formData = new FormData(form);
      
      const resp = fetch('mail/send.php', {
        method: 'POST',
        body: formData
      }).then(response => {
        if (!response.ok) {
          throw new Error(`Error in ${response.url}, status ${response.status}`);
        }
        else {
          // console.log(`Success. Status: ${response.status}`);
          form.classList.add('is-sended');
          setTimeout(function () {
            form.reset();
            form.classList.remove('is-sended');
          }, 2000)

        }
      })
        .catch((err) => console.error(err));
    })
  })

}