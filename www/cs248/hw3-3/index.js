const formElement = document.querySelector('.needs-validation')
formElement.addEventListener('submit', (event) => {
  const passwordInput = document.querySelector('#password-input')

  if (!formElement.checkValidity()) {
    // Stop default behavior
    event.preventDefault()

    // reset
    document.querySelector('#form-feedback').innerHTML = ''
    document.querySelector('#form-success').innerHTML = ''
    document.querySelectorAll('.validate-me').forEach(input => {
      input.setCustomValidity('')
      input.classList.remove('is-invalid')
    })

    document.querySelectorAll('.validate-me').forEach(input => {
      if (!input.checkValidity()) {
        input.classList.add('is-invalid')
      }
    })

    const emailValue = document.querySelector('#email-input').value
    const passwordValue = passwordInput.value
    // Build list of errors
    const errorList = []
    if (emailValue !== '' && !document.querySelector('#email-input').checkValidity()) {
      errorList.push('Email is not valid')
    }

    if (emailValue === '' || passwordValue === '') {
      errorList.push('All fields are required')
    }

    document.querySelector('#form-feedback').innerHTML = `
    <div class="alert alert-danger">
        ${errorList.join('<br/>')}
    </div>
    `
  }
})
