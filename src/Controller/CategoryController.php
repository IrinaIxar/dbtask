<?php
require '../src/Repository/CategoryRepository.php';

class CategoryController extends BaseController {
	/**
     * Categories list
     *
     * @param $request
     * @return view of list page
     */ 
	public function list($request) {
		$params = $request->getQueryParams();
		$categoryRepository = new CategoryRepository();
		$categories = $categoryRepository->findAllProductCount($params['sort'], $params['order']);
		return $this->render('Category/list.html', [
			'categories' => $categories, 
			'sort' => $params['sort'], 
			'order' => $params['order']
		]);
	}
}