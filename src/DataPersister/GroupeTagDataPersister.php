<?php

// src/DataPersister

namespace App\DataPersister;

use Doctrine\ORM\EntityManagerInterface;
use App\DataPersister\GroupeTagDataPersister;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

/**
 *
 */
class GroupeTagDataPersister implements ContextAwareDataPersisterInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $_entityManager;

    public function __construct( EntityManagerInterface $entityManager ) 
    {
        $this->_entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof GroupeTag;
    }

    /**
     * @param GroupeTag $data
     */
    public function persist($data, array $context = [])
    {
        return $data;
    }

    public function remove($data, array $context = [])
    {
        $data->setIsDeleted(true);
        $this->_entityManager->persist($data);
        foreach ($data->getTags() as $u) {
            $u->setIsDeleted(true);
        }
        $this->_entityManager->flush();
    }
}