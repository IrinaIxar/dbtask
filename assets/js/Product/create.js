$(document).ready(() => {
    //validation for create form
    $('#addForm').validate({
        rules: {
            product_name: {
                required: true
            },
            product_count: {
                required: false,
                digits: true
            },
            product_price: {
                required: false,
                digits: true
            },
            category_id: {
                required: true
            }
        },
        onkeyup: () => {
            $('#addForm').valid()
            if ($('#addForm').valid()) {
                $('#add').removeAttr('disabled')
            }
        },
        submitHandler: (form, event) => {
            if ($('#addForm').valid()) {
                $.ajax({
                    type: 'POST',
                    url: window.location.origin + '/products/add',
                    data: $('#addForm').serialize(),
                    dataType: 'json',
                    success: (data) => {
                        if (data === true) $('#result').text('Product was successfully added')
                        else $('#result').text(data)
                    },
                    error: (xhr, status, error) => {
                        $('#result').text('Product was not added')
                    }
                })

                $('#addForm')[0].reset()
                $('#add').attr('disabled', 'disabled')
                if (confirm('Do you want to add more?')) {
                    return false
                } else {
                    window.location.pathname = '/products'
                }
            }
        }
    })
})