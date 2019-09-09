$(document).ready(() => {
    //on sort buttons click
    $('.fa-sort').on('click', (event) => {
        let parent = $(event.target).parent()
        let order = $(parent).attr('abbr')
        window.location = '/categories?sort=' + $(parent).attr('id') + '&order=' + order
    })
})