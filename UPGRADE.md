# UPGRADE 2.x

Removed Type hints to support PHP 7.0

# UPGRADE 4.x

## Drops 
* PHP 7 Support

### Updates 
* SonataMediaBundle minimum requirement ^4.x
* SonataAdminBundle minimum requirement ^4.x

### Adds
* Twig Bundle
* Symfony Twig Bridge
* Configuration key `providers` **REQUIRED**

### Removals

In favor of Sonata making their media provider final and to avoid overriding every provider, I removed the 
`MultiUploadTrait` and changed the behaviour. You need to use the previously introduced new `providers` key in the 
configuration of this bundle.
