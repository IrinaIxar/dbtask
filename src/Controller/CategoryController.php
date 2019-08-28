<?php
require '../src/Repository/CategoryRepository.php';

class CategoryController extends BaseController {
	/**
     * Categories list
     *
     * @param string $sort object field by which categories are sorted
     * @param string $order asc/desc sort
     * @return view of list page
     */ 
	public function list($sort='name', $order='ASC') {
		$categoryRepository = new CategoryRepository();
		$categories = $categoryRepository->findAllProductCount($sort, $order);
		echo $this->render('Category/list.html', ['categories' => $categories, 'sort' => $sort, 'order' => $order], false);
	}
}