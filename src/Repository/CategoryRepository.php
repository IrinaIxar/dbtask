<?php

namespace Repository;

use Entity\Category;

class CategoryRepository
{
    protected $em;
    protected $categoryRepository;

    public function __construct()
    {
        $this->em = \App\DoctrineEM::getInstance();
        $this->categoryRepository = $this->em->getRepository('\Entity\Category');
    }

    /**
     * Categories list
     *
     * @param  string  $field  object field is sorted
     * @param  string  $order  asc/desc sort
     * @return array categories
     */
    public function findAll($field = 'name', $order = 'ASC')
    {
        return $this->categoryRepository->findBy(['deleted' => 0], [$field => $order]);
    }

    /**
     * Categories list with products count for each category
     *
     * @param  string  $field  object field is sorted
     * @param  string  $order  asc/desc sort
     * @return array categories
     */
    public function findAllProductCount($field = '', $order = '')
    {
        $qb = $this->em->createQueryBuilder();
        $qb->from('\Entity\Product', 'p')
            ->select('c.name as name')
            ->where('p.deleted = 0')
            ->andWhere('c.deleted = 0')
            ->addSelect('count(p.id) as count')
            ->join('p.category', 'c')
            ->groupby('c.id');

        if ($field) {
            $qb->addOrderBy($field, $order);
        }

        return $qb->getQuery()->execute();
    }

    /**
     * Category by id
     *
     * @param  integer  $id  category identifier
     * @return Category
     */
    public function findById($id)
    {
        return $this->categoryRepository->findOneBy(['id' => $id]);
    }
}