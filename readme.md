# Surface identity - Call Identify API

Surface Identity Web Api 1.0 PHP Sample

## Description

This is a sample project that allow to use Surface Identity Web Api 1.0

## Getting Started

### Dependencies

* PHP >= 7.2.5
* Git
* Composer

### Installing
* Clone repository
* Run command composer install
* Save your *.obj file in the project name. N.B. Use a file that contains vertices
* Set other parameters used by recognition process at the beginning of index.php
```php
// App Id: your app id 
$appId = 'your-app-id';

// App secret: your app secret
$secret = 'your-app-secret';

// Access token URL: surface identity URL used to get access token ('https://is.surfaceidentity.com/connect/token')
$tokenRequestURL = 'https://...';

// Project Ids: set of project that I would like to query
$projectIds = array('projectId-1', 'projectId-2', 'projectId-N');

// Instance name: name of the intance that I am sending to server
$instanceName = 'your-instance-name';

// Unit Of Measure Symbol: unit of measure used in the file i.e. 'm'
$unitOfMeasure = 'your-unit-of-measure';

// Identification Service URL: url of surface identity web service ( i.e. 'https://api.surfaceidentity.com/api/Identify')
$identificationServiceUrl = 'https://...';

// Name of the file that contains the surface to recognize 
$filename = "your-file-name.obj";
```
### Executing program

* Run command line
```
php -S localhost:8082

```
* Navigate to http://localhost:8082 to see the result

## Help

Any advise for common problems or issues.

## Authors

Contributors names and contact info

ex. Beniamino Ferrari info@surfaceidentity.com 

## Acknowledgments

Inspiration, code snippets, etc.
* [guzzlehttp/guzzle](https://github.com/guzzle/guzzle)
* [league/oauth2-client"](https://github.com/thephpleague/oauth2-client)
