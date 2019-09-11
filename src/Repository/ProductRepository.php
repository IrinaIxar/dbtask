<?php

namespace Repository;
use Entity\Product;

class ProductRepository
{
    protected $em;
    protected $productRepository;

    public function __construct()
    {
        $this->em = \App\DoctrineEM::getInstance();
        $this->productRepository = $this->em->getRepository('\Entity\Product');
    }

    /**
     * Products list
     *
     * @param  string  $field  object field is sorted
     * @param  string  $order  asc/desc sort
     * @return array products
     */
    public function findAll($field = 'price', $order = 'ASC')
    {
        return $this->productRepository->findBy(['deleted' => 0], [$field => $order]);
    }

    /**
     * Products list by criteria per page
     *
     * @param  array  $params  params for search
     * @param  string  $page  page number
     * @param  string  $countPerPage  how many objects to show on single SQL request
     * @param  string  $field  object property by which is sorted result array
     * @param  string  $order  asc/desc order
     * @return array products
     */
    public function findBy($params = array(), $page = '1', $countPerPage = '10', $field = 'price', $order = 'ASC')
    {
        $params['deleted'] = 0;
        return $this->productRepository->findBy($params, [$field => $order], $countPerPage,
            ($countPerPage * ($page - 1)));
    }

    /**
     * Product by id
     *
     * @param  integer  $id  product identifier
     * @return Product
     */
    public function findById($id)
    {
        return $this->productRepository->findOneBy(['id' => $id]);
    }

    /**
     * Adds new product
     *
     * @param $request
     * @return string
     */
    public function add($request)
    {
        $params = $request->getParsedBody();
        $categoryRepository = $this->em->getRepository('\Entity\Category');
        $category = $categoryRepository->find($params['category_id']);

        $product = new Product();
        $product->setName($params['name']);
        $product->setPrice((float) $params['price']);
        $product->setCategory($category);
        $product->setCount((int) $params['count']);

        $this->em->persist($product);
        $this->em->flush();

        return $this->em->contains($product);
    }

    /**
     * Removes product by id
     *
     * @param  integer  $id
     * @return string
     */
    public function remove($id)
    {
        $product = $this->productRepository->findOneBy(['id' => $id]);
        if (!empty($product)) {
            $product->setDeleted(1);
            $this->em->flush();
            $result = 'deleted';
        } else {
            $result = 'Product was not found';
        }
        return $result;
    }

    /**
     * Updates product
     *
     * @param $request
     */
    public function update($request)
    {
        $params = $request->getParsedBody();
        $categoryRepository = $this->em->getRepository('\Entity\Category');
        $category = $categoryRepository->find($params['category_id']);
        $product = $this->productRepository->findOneBy(['id' => $params['id']]);

        $product->setName($params['name']);
        $product->setPrice((float) $params['price']);
        $product->setCategory($category);
        $product->setCount((int) $params['count']);

        $this->em->flush();
    }
}