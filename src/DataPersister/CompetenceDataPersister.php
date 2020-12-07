<?php

// src/DataPersister

namespace App\DataPersister;

use App\Entity\Competence;
use Doctrine\ORM\EntityManagerInterface;
use App\DataPersister\CompetenceDataPersister;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

/**
 *
 */
class CompetenceDataPersister implements ContextAwareDataPersisterInterface
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
        return $data instanceof Competence;
    }

    /**
     * @param Competenceg $data
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
        foreach ($data->getGroupeCompetences() as $u) {
            $u->setIsDeleted(true);
        }
        $this->_entityManager->flush();
    }
}