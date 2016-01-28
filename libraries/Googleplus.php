<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Googleplus {
	
	public function __construct() {
		
		$this->CI =& get_instance();
		$this->CI->load->config('googleplus');		
				
		require APPPATH .'third_party/google-api-php-client/src/Google_Client.php';
		require APPPATH .'third_party/google-api-php-client/src/contrib/Google_PlusService.php';
		
		$cache_path = $this->CI->config->item('cache_path');
		$GLOBALS['apiConfig']['ioFileCache_directory'] = ($cache_path == '') ? APPPATH .'cache/' : $cache_path;
		
		$this->client = new Google_Client();
		$this->client->setApplicationName($this->CI->config->item('application_name', 'googleplus'));
		$this->client->setClientId($this->CI->config->item('client_id', 'googleplus'));
		$this->client->setClientSecret($this->CI->config->item('client_secret', 'googleplus'));
		$this->client->setRedirectUri($this->CI->config->item('redirect_uri', 'googleplus'));
		$this->client->setDeveloperKey($this->CI->config->item('api_key', 'googleplus'));
		$this->client->setScopes("profile email");
		
		$this->plus = new Google_PlusService($this->client);
	}
	
	public function login() {
		$code = $this->CI->input->get('code');
		
		if ($code) {
	       	$this->client->authenticate();
    		$this->CI->session->set_userdata('gplustoken', $this->client->getAccessToken());
	   	}

	   	if ($this->CI->session->userdata('gplustoken')) {
	   		$token = $this->CI->session->userdata('gplustoken');
	   		$this->client->setAccessToken($token);
	   	}

	   	if (!$this->client->getAccessToken()) {
	   		$authUrl = $this->client->createAuthUrl();
	       	redirect($authUrl);
	   	}
	   	$aGData = $this->plus->people->get('me');
	   		
		if(!$this->CI->ion_auth_model->identity_check($aGData['emails'][0]['value'])){
			$register = $this->CI->ion_auth->register($aGData['displayName'], 'googleplusdoesnothavepass123^&*%', $aGData['emails'][0]['value'], array('name' => $aGData['displayName'], 'gender' => $aGData['gender'], 'id_googleplus' => $aGData['id'], 'profile' => $aGData['image']['url']));
		} else {
			$login = $this->CI->ion_auth->login($aGData['emails'][0]['value'], 'googleplusdoesnothavepass123^&*%', 1);
		}
		return true;
	}
}
?>