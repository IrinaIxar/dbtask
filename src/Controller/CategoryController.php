<?php
require '../src/Repository/CategoryRepository.php';

class CategoryController extends BaseController
{
    /**
     * Categories list
     *
     * @param $request
     * @return view of list page
     */
    public function list($request)
    {
        $params = $request->getQueryParams();
        $categoryRepository = new CategoryRepository();
        $sortFields = $sortFields = $this->addSortFieldsArray(['name', 'count']);
        $sortFields[$params['sort']]['ascending'] = $params['order'] === 'asc' ? true : false;
        $categories = $categoryRepository->findAllProductCount($params['sort'], $params['order']);

        return $this->render('Category/list.html', [
            'categories' => $categories,
            'sortFields' => $sortFields
        ]);
    }
}