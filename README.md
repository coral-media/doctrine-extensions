# doctrine-extensions
Intended to override and/or extend [Doctrine](https://www.doctrine-project.org) functionality in [Symfony](https://symfony.com) development environments.

## Installation and configuration
Install this package using composer.

`composer require coral-media/doctrine-extensions`

For further configuration check following sections.

## The IgnorableInterface
Sometimes you need to map read-only tables and views and `Symfony/Doctrine` schema manipulation tools give you headaches everytime you interact with the database.
Or maybe for any other reason you want your entity being ignored by those schema tools. If that is your scenario, just implements de `IgnorableInterface`
in your entity classes and the `PostGenerateSchemaListener` will do the rest.

Don't forget to include `PostGenerateSchemaListener` in your `services.yaml` as follows:

```yaml
...
CoralMedia\Component\Doctrine\Extensions\Ignorable\EventListener\PostGenerateSchemaListener:
    tags:
        -   {name: doctrine.event_listener, event: postGenerateSchema}
...
```
