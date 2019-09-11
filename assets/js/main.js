const countPerPage = 10
const pages = {
    '/products' : 'Product/list',
    '/products/create' : 'Product/create',
    '/products/' : 'Product/edit',
    '/' : 'User/authorization',
    '/user/authorization' : 'User/authorization',
    '/categories' : 'Category/list'
}

$(document).ready(() => {
    script = document.createElement("script")
    if($('.login-box').length) {
        url = 'assets/js/User/authorization.js'
    } else {
        url = 'assets/js/'+pages[window.location.pathname]+'.js'
    }
    script.src = url
    document.getElementsByTagName("head")[0].appendChild(script)
})