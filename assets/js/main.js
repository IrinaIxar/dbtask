const countPerPage = 10
const pages = {
    '/products': 'Product/list',
    '/products/create': 'Product/create',
    '/products/': 'Product/edit',
    '/': 'User/authorization',
    '/user/authorization': 'User/authorization',
    '/categories': 'Category/list'
}

$(document).ready(() => {
    script = document.createElement("script")
    if ($('.login-box').length) {
        url = 'User/authorization'
    } else {
        if(window.location.pathname.match(/\w+\/\d+/)) { //if current uri is edit page with id in the end, matches to Product/edit uri
            str = window.location.pathname.split('/')
            str.pop()
            url = pages[str.join('/')+'/']
        } else {
            url = pages[window.location.pathname]
        }
    }
    script.src = window.location.origin+ '/assets/js/' + url + '.js'
    document.getElementsByTagName("head")[0].appendChild(script)
})