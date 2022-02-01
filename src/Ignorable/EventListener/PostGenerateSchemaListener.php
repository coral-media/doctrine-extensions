<?php

declare(strict_types=1);

namespace CoralMedia\Component\Doctrine\Extensions\Ignorable\EventListener;

use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;
use CoralMedia\Component\Doctrine\Extensions\Ignorable\IgnorableInterface;
use ReflectionClass;
use ReflectionException;

class PostGenerateSchemaListener
{
    /**
     * @param GenerateSchemaEventArgs $args
     * @throws ReflectionException
     * @throws SchemaException
     */
    public function postGenerateSchema(GenerateSchemaEventArgs $args)
    {
        $schema = $args->getSchema();
        $entityManager = $args->getEntityManager();
        $entityClasses = $entityManager->getConfiguration()
            ->getMetadataDriverImpl()->getAllClassNames();

        foreach ($entityClasses as $entityClass) {
            $reflectionClass = new ReflectionClass($entityClass);
            if ($reflectionClass->implementsInterface(IgnorableInterface::class)) {
                $schema->dropTable(
                    $entityManager->getClassMetadata($reflectionClass->getName())->getTableName()
                );
            }
        }
    }
}
