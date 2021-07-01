<?php
session_start();
require('vendor/autoload.php');

// App Id: your app id 
$appId = 'your-app-id';

// App secret: your app secret
$secret = 'your-app-secret';

// Access token URL: surface identify URL used to get access token
$tokenRequestURL = 'https://is.surfaceidentity.com/connect/token';

// Project Ids: set of project that I would like to query
$projectIds = array('projectId-1', 'projectId-2', 'projectId-N');

// Instance name: name of the instance that I am sending to server
$instanceName = 'your-instance-name';

// Unit Of Measure Symbol: unit of measure used in the file
$unitOfMeasure = 'your-unit-of-measure';

// Identification Service URL: url of surface identity web service
$identificationServiceUrl = 'https://api.surfaceidentity.com/api/Identify';

// The obj filename
$filename = "your-file-name.obj";

// Note: the GenericProvider requires the `urlAuthorize` option, even though
// it's not used in the OAuth 2.0 client credentials grant type.
$provider = new League\OAuth2\Client\Provider\GenericProvider([
    'clientId'                => $appId,    					// The client ID assigned to you by the provider
    'clientSecret'            => $secret,    					// The client secret assigned to you by the provider
    'urlAuthorize'            => '',
    'urlAccessToken'          => $tokenRequestURL,				// Access token url
    'urlResourceOwnerDetails' => ''
]);

try {	
    // Try to get an access token using the client credentials grant.
	if(!isset($_SESSION['accessToken'])) {
		$_SESSION['accessToken'] = serialize($provider->getAccessToken('client_credentials'));
	} else {
		$accessToken = unserialize($_SESSION['accessToken']);
		if($accessToken->hasExpired()) {
			$_SESSION['accessToken'] = serialize($provider->getAccessToken('client_credentials'));
			$accessToken = unserialize($_SESSION['accessToken']);
		}

		$objectFilename = fopen($filename, "r") or die("Unable to open file!");

		$x =  $y =  $z = [];
		$xVal = $yVal = $zVal = 0.0;	
		
		while(!feof($objectFilename)) {
			$line = fgets($objectFilename);  			
			if(substr($line, 0, 1) == "v"){
				sscanf($line,"v %f %f %f",$xVal,$yVal,$zVal);
				array_push($x, $xVal);
				array_push($y, $yVal);
				array_push($z, $zVal);
			}
		}
		fclose($objectFilename);
	  
	    $body = array(
		  "projectIds" => $projectIds,
		  "instanceName" => $instanceName,
		  "x" => $x,
		  "y" => $y,
		  "z" => $z,
		  "unitOfMeasure" => $unitOfMeasure
		);
		
		$options['body'] = json_encode($body);
		$options['headers']['content-type'] = 'application/json';
	
	    // The provider provides a way to get an authenticated API request for
	    // the service, using the access token; it returns an object conforming
	    // to Psr\Http\Message\RequestInterface.
	    $request = $provider->getAuthenticatedRequest(
	        'POST',
	        $identificationServiceUrl,
	        $accessToken,
	        $options
	    );
	    $response = $provider->getResponse($request);
	    
		$body = $response->getBody();

		print "Access Token {$accessToken} <br><br>";
		
		foreach(json_decode($body) as $projectId => $project) {
			print $project->found ? 
			"Object {$project->objectName} (id: {$project->objectId}), with surface {$project->surfaceName} (id: {$project->surfaceId}) found in project id {$projectId} <br>" : 
			"Not found in project id: {$projectId} <br>";
		}
	}

} catch (League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

    // Failed to get the access token
    exit($e->getMessage());

} catch (\Exception $e) {
	exit($e->getMessage());
}
?>