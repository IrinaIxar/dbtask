function redirect(page) {
	window.location='/products?page='+page+'&countPerPage='+countPerPage+'&sort='+$('#sort').val()+'&order='+$('#order').val()
}

$(document).ready(() => {
	//on sort buttons click
	$('.fa-sort').on('click', (event) => {
		let parent = $(event.target).parent()
		let order = $(parent).attr('abbr')
		$('#sort').val($(parent).attr('id'))
		$('#order').val(order)
		redirect($('li[class="page-item disabled"] > a').text())
	})

	$('.page-link').on('click', (event) => {
		redirect(parseInt($(event.target).text()))
	})

	$('.fa-pencil').on('click', (event) => {
		let parent = $(event.target).parent()
		parent = $(parent).parent()
		window.location.href = window.location.origin+'/products/'+$(parent).attr('id')
	})

	$('.fa-trash').on('click', (event) => {
		if(confirm("Are you sure?")){
			let parent = $(event.target).parent()
			parent = $(parent).parent()
			$.ajax({
				type: 'DELETE',
				url: '/products/'+$(parent).attr('id'),
				dataType: 'json',
				success: (data) => {
					if (data.result === 'deleted') {
						$('#deleteResult').text('Product was deleted')
						redirect(1)
					} else {
						$('#deleteResult').text(data.result)
					}
				},
				error: (xhr, status, error) => {
					$('#deleteResult').text('Product was not deleted')
				}
			})
		}	
	})
})