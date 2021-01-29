<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class Paginator
{
    private $entityClass;
    private $limit = 10;
    private $currentPage = 1;
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function getData($figure = null)
    {
        // 1. Calculer l'offset
        $offset = $this->currentPage * $this->limit - $this->limit;

        // 2. Demander au repo de trouver les elements
        $repo = $this->manager->getRepository($this->entityClass);
        
        if ($figure == null) {
            $data = $repo->findBy([],[], $this->limit, $offset);
        } else {
            $data = $repo->findBy(['figure' => $figure],[], $this->limit, $offset);
        }

        // 3. Renvorer le résultat
        return $data;
    }

    public function getPages($figure = null)
    {
        $repo = $this->manager->getRepository($this->entityClass);
        
        if ($figure == null) {
            $total = count($repo->findBy([],[]));
        } else {
            $total = count($repo->findBy(['figure' => $figure],[]));
        }        
        $pages = ceil($total / $this->limit);

        return $pages;
    }

    /**
     * Get the value of entityClass
     */ 
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * Set the value of entityClass
     *
     * @return  self
     */ 
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;

        return $this;
    }

    /**
     * Get the value of limit
     */ 
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Set the value of limit
     *
     * @return  self
     */ 
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Get the value of page
     */ 
    public function getPage()
    {
        return $this->currentPage;
    }

    /**
     * Set the value of page
     *
     * @return  self
     */ 
    public function setPage($currentPage)
    {
        $this->currentPage = $currentPage;

        return $this;
    }
}