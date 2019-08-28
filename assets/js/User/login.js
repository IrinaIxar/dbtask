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
            if ($('#auth').valid()){
                $('#submit').removeAttr('disabled')
            }
        },
        submitHandler: (form, event) => {
            if ($('#auth').valid()){
                $.ajax({
                    type: 'POST',
                    url: window.location.origin+'/user/login',
                    data: $('#auth').serialize(),
                    dataType: 'json',
                    success: (data) => {
                        if(data.result === 'true') {
                            window.location='/product/list'
                        }
                        $('#result').text(data.result)
                    },
                    error: (xhr, status, error) => {
                        $('#result').text('Authorization failed')
                    }
                })

                $('#auth')[0].reset()
                $('#submit').attr('disabled', 'disabled')
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
            if ($('#addForm').valid()){
                $('#addButton').removeAttr('disabled')
            }
        },
        submitHandler: (form, event) => {
            if ($('#addForm').valid()){
                $.ajax({
                    type: 'POST',
                    url: window.location.origin+'/user/add',
                    data: $('#addForm').serialize(),
                    dataType: 'json',
                    success: (data) => {
                        $('#result').text(data.result)
                    },
                    error: () => {
                        $('#result').text('Authorization failed')
                    }
                })

                $('#addForm')[0].reset()
                $('#addButton').attr('disabled', 'disabled')
                return false
            }
        }
    })
})