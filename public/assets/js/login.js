$(function() {
    const LESS_THAN_6_ERROR_MSG = "Jumlah karakter tidak boleh kurang dari 6"
    const USERNAME_EMPTY_ERROR_MSG = "Username tidak boleh kosong!"
    const PASSWORD_EMPTY_ERROR_MSG = "Password tidak boleh kosong!"
    const USERNAME_OR_PASSWORD_INVALID_MSG = "Username atau password salah!"

    const loginLoading = $("#login-loading")

    $("#username").keyup(function(e) {
        const input = $(this)
        if (input.val().length >= 6) {
            input.removeClass("is-invalid")
            input.addClass("is-valid")
            input.next()
                .next()
                .next()
                .text("Ok")
        } else {
            input.removeClass("is-valid")
            input.addClass("is-invalid")
            input.next()
                .next()
                .text(LESS_THAN_6_ERROR_MSG)
        }
    })

    $("#password").keyup(function(e) {
        const input = $(this)
        if (input.val().length >= 6) {
            input.removeClass("is-invalid")
            input.addClass("is-valid")
            input.next()
                .next()
                .next()
                .text("Ok")
        } else {
            input.removeClass("is-valid")
            input.addClass("is-invalid")
            input.next()
                .next()
                .text(LESS_THAN_6_ERROR_MSG)
        }
    })

    $("#form-login").submit(function(e) {
        e.preventDefault()

        let isValidUsername
        let isValidPassword

        const usernameInput = $(this).find("#username")
        const passwordInput = $(this).find("#password")

        const username = $.trim(usernameInput.val())
        const password = $.trim(passwordInput.val())

        if (username.length === 0) {
            usernameInput.removeClass("is-valid")
            usernameInput.addClass("is-invalid")
            usernameInput.next().next()
                .text(USERNAME_EMPTY_ERROR_MSG)
            isValidUsername = false
        } else if (username.length < 6) {
            usernameInput.removeClass("is-valid")
            usernameInput.addClass("is-invalid")
            usernameInput.next().next()
                .text(LESS_THAN_6_ERROR_MSG)
            isValidUsername = false
        } else {
            usernameInput.removeClass("is-invalid")
            usernameInput.removeClass("is-valid")
            isValidUsername = true
        }

        if (password.length === 0) {
            passwordInput.removeClass("is-valid")
            passwordInput.addClass("is-invalid")
            passwordInput.next().next()
                .text(PASSWORD_EMPTY_ERROR_MSG)
            isValidPassword = false
        } else if (password.length < 6) {
            passwordInput.removeClass("is-valid")
            passwordInput.addClass("is-invalid")
            passwordInput.next().next()
                .text(LESS_THAN_6_ERROR_MSG)
            isValidPassword = false
        } else {
            passwordInput.removeClass("is-invalid")
            passwordInput.removeClass("is-valid")
            isValidPassword = true
        }

        if (isValidUsername && isValidPassword) {
            loginLoading.show()
            const data = {
                username: username,
                password: password
            }
        
            axios.post('/api/v1/login', data)
                .then(function(res) {
                    const responseData = res.data
                    const token = responseData.data.token

                    localStorage.setItem("user_token", token)

                    usernameInput.val("")
                    passwordInput.val("")

                    loginLoading.hide()

                    window.location.href = window.location.origin + "/dashboard/admin"
                })
                .catch(function(err) {
                    usernameInput.removeClass("is-valid")
                    usernameInput.addClass("is-invalid")
                    usernameInput.next().next()
                        .text(USERNAME_OR_PASSWORD_INVALID_MSG)

                    passwordInput.removeClass("is-valid")
                    passwordInput.addClass("is-invalid")
                    passwordInput.next().next()
                        .text(USERNAME_OR_PASSWORD_INVALID_MSG)

                    loginLoading.hide()
                })
        }
    })

        let value = $('#username').val()
        if (value.length > 0) {
            $('#username').next('label').css({
                fontWeight: 'bold',
                color: '#001F54',
                fontSize: '.7rem',
                top: '-.9rem'
            })
        }

        /* BUG: label tidak kembali seperti semula */
        $('#username').change(function() {
            let value = $(this).val()
            if (value.length > 0) {
                $(this).next('label').css({
                    fontWeight: 'bold',
                    color: '#001F54',
                    fontSize: '.7rem',
                    top: '-.9rem'
                })
            }
        })

        $('#password').change(function() {
            let value = $(this).val()
            if (value.length > 0) {
                $(this).next('label').css({
                    fontWeight: 'bold',
                    color: '#001F54',
                    fontSize: '.7rem',
                    top: '-.9rem'
                })
            }
        })
})