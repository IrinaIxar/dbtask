<?php

use Zend\Diactoros\ServerRequestFactory;

require '../src/Repository/ProductRepository.php';
require '../src/Repository/CategoryRepository.php';

class ProductController extends BaseController
{
    /**
     * Products list
     *
     * @param $request
     * @return view of list page
     */
    public function list($request)
    {
        $params = $request->getQueryParams();
        $productRepository = new ProductRepository();
        $pagesCount = ceil(count($productRepository->findAll()) / $params['countPerPage']);
        $sortFields = $this->addSortFieldsArray(['name', 'price', 'count']);
        $sortFields[$params['sort']]['ascending'] = $params['order'] === 'asc' ? true : false;

        return $this->render('Product/list.html', [
            'products' => $productRepository->findBy([], $params['page'], $params['countPerPage'], $params['sort'],
                $params['order']),
            'sortFields' => $sortFields,
            'page' => $params['page'],
            'pagesCount' => $pagesCount
        ]);
    }

    /**
     * Create product page
     *
     * @return mixed view
     */
    public function create()
    {
        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->findAll();

        return $this->render('Product/create.html', [
            'categories' => $categories
        ]);
    }

    /**
     * Add product to DB
     *
     * @param $request
     * @return string
     */
    public function add($request)
    {
        $productRepository = new ProductRepository();
        $result = $productRepository->add($request);

        echo json_encode(['result' => $result]);
    }

    /**
     * Product edit page
     *
     * @param $request
     * @return view of update page
     */
    public function edit($request)
    {
        $path = explode('/', $request->getUri()->getPath());
        $productRepository = new ProductRepository();
        $product = $productRepository->findById(end($path));
        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->findAll();

        return $this->render('Product/edit.html', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    /**
     * Product by id
     *
     * @param $request
     * @return string
     */
    public function update($request)
    {
        $productRepository = new ProductRepository();
        $productRepository->update($request);
        echo json_encode(['result' => 'true']);
    }

    /**
     * Removes product
     *
     * @param $request
     * @return string
     */
    public function delete($request)
    {
        $path = explode('/', $request->getUri()->getPath());
        $productRepository = new ProductRepository();
        $result = $productRepository->remove(end($path));

        echo json_encode(['result' => $result]);
    }
}