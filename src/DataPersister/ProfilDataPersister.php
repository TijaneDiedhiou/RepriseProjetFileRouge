<?php

// src/DataPersister

namespace App\DataPersister;

use App\Entity\Profil;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

/**
 *
 */
class ProfilDataPersister implements ContextAwareDataPersisterInterface
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
        return $data instanceof Profil;
    }

    /**
     * @param Profil $data
     */
    public function persist($data, array $context = [])
    {
        return $data;
    }

    public function remove($data, array $context = [])
    {
        $data->setIsDeleted(true);
        $this->_entityManager->persist($data);
        foreach ($data->getUser() as $u) {
            $u->setIsDeleted(true);
        }
        $this->_entityManager->flush();
    }
}