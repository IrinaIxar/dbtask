$(document).ready(() => {
    $('#auth').validate({
        rules: {
            login: {
                required: true
            },
            password: {
                required: true
            }
        },
        onkeyup: () => {
            $('#auth').valid()
            if ($('#auth').valid()) {
                $('#submit').removeAttr('disabled')
            }
        },
        submitHandler: (form, event) => {
            if ($('#auth').valid()) {
                $.ajax({
                    type: 'POST',
                    url: '/users/login',
                    data: $('#auth').serialize(),
                    dataType: 'json',
                    success: (data) => {
                        if (data === "true") {
                            window.location = '/products'
                        }
                        $('#result').text(data.result)
                    },
                    error: () => {
                        $('#result').text('Authorization failed')
                    }
                })
                return false
            }
        }
    })

    $('#addForm').validate({
        rules: {
            addLogin: {
                required: true
            },
            addPassword: {
                required: true
            },
            passwordRepeat: {
                required: true
            }
        },
        onkeyup: () => {
            if ($('#addForm').valid()) {
                $('#addButton').removeAttr('disabled')
            }
        },
        submitHandler: (form, event) => {
            if ($('#addForm').valid()) {
                $.ajax({
                    type: 'POST',
                    url: window.location.origin + '/users/add',
                    data: $('#addForm').serialize(),
                    dataType: 'json',
                    success: (data) => {
                        $('#result').text(data)
                        if (data === "true") {
                            window.location = '/products'
                        }
                    },
                    error: () => {
                        $('#result').text('User was not added')
                    }
                })

                $('#addForm')[0].reset()
                $('#addButton').attr('disabled', 'disabled')
                return false
            }
        }
    })
})