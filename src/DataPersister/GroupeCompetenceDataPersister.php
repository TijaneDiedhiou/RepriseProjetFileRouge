<?php

// src/DataPersister

namespace App\DataPersister;

use App\Entity\GroupeCompetence;
use Doctrine\ORM\EntityManagerInterface;
use App\DataPersister\GroupeCompetenceDataPersister;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

/**
 *
 */
class GroupeCompetenceDataPersister implements ContextAwareDataPersisterInterface
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
        return $data instanceof GroupeCompetence;
    }

    /**
     * @param GroupeCompetence $data
     */
    public function persist($data, array $context = [])
    {
        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
        return $data;
    }

    public function remove($data, array $context = [])
    {
        $data->setIsDeleted(true);
        $this->_entityManager->persist($data);
        foreach ($data->getCompetence() as $u) {
            $u->setIsDeleted(true);
        }
        $this->_entityManager->flush();
    }
}