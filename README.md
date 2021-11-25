Symfony Health Check Bundle
=================================

This project is based on https://github.com/MacPaw/symfony-health-check-bundle
The project has been modified that check if one of the health checks is not healthy, the endpoint wil return a (500) error
In addition, the doctrine connection check is modified to working version

Installation
============

Step 1: Download the Bundle
----------------------------------
Open a command console, enter your project directory and execute:

###  Applications that use Symfony Flex

```console
$ composer require jpvdw86/symfony-health-check-bundle
```

### Applications that don't use Symfony Flex

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require jpvdw86/symfony-health-check-bundle
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Step 2: Enable the Bundle
----------------------------------
Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            SymfonyHealthCheckBundle\SymfonyHealthCheckBundle::class => ['all' => true],
        );

        // ...
    }

    // ...
}
```

Create Symfony Health Check Bundle Config:
----------------------------------
`config/packages/symfony_health_check.yaml`

Configurating health check - all available you can see [here](https://github.com/jpvdw86/symfony-health-check-bundle/tree/master/src/Check).

```yaml
symfony_health_check:
  health_checks:
    - id: symfony_health_check.status_up_check
    - id: symfony_health_check.doctrine_check
    - id: symfony_health_check.environment_check
```

Create Symfony Health Check Bundle Routing Config:
----------------------------------
`config/routes/symfony_health_check.yaml`

```yaml
health_check:
    resource: '@SymfonyHealthCheckBundle/Resources/config/routes.xml'
```

Step 3: Configuration
=============

Security Optional:
----------------------------------
`config/packages/security.yaml`

If you are using [symfony/security](https://symfony.com/doc/current/security.html) and your health check is to be used anonymously, add a new firewall to the configuration

```yaml
    firewalls:
        healthcheck:
            pattern: ^/health
            security: false
```

Step 4: Additional settings
=============

Add Custom Check:
----------------------------------
It is possible to add your custom health check:

```php
<?php

declare(strict_types=1);

namespace YourProject\Check;

class CustomCheck implements CheckInterface
{
    private const CHECK_RESULT_KEY = 'customConnection';
    
    public function isHealthy(): bool
    {
        return true;
    }
    
    public function check(): array
    {
         return [
            'name' => self::CHECK_RESULT_KEY,
            'status' => $this->isHealthy()
        ];
    }
}
```

Then we add our custom health check to collection

```yaml
symfony_health_check:
  health_checks:
    - id: symfony_health_check.status_up_check
    - id: symfony_health_check.doctrine_check
    - id: symfony_health_check.environment_check
    - id: custom_health_check
```

How Change Route:
----------------------------------
You can change the default behavior with a light configuration, remember to return to Step 3 after that:
```yaml
health:
    path: /your/custom/url
    methods: GET
    controller: SymfonyHealthCheckBundle\Controller\HealthController::healthCheckAction

```