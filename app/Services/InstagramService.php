<?php

namespace App\Services;

use App\Models\Instagram;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\RedirectResponse;
// use Psr\Http\Message\ResponseInterface;
// use GuzzleHttp\Exception\RequestException;

class InstagramService
{
	protected $authUrl = 'https://api.instagram.com/oauth/authorize/';
	protected $tokenUrl = 'https://api.instagram.com/oauth/access_token';
	protected $mediaUrl = 'https://api.instagram.com/v1/users/self/media/recent/';
	protected $client_id;
	protected $client_secret;
	protected $redirect;

	public function __construct($config)
	{
		$this->client_id = $config['client_id'];
		$this->client_secret = $config['client_secret'];
		$this->redirect = $config['redirect'];
	}

	protected function getAuthourizationUrl()
	{
		return $this->authUrl . '?client_id='.$this->client_id.'&redirect_uri='.$this->redirect.'&response_type=code';
	}

	public function auth()
	{
		return new RedirectResponse($this->getAuthourizationUrl());
	}

	protected function getAccessToken($code)
	{
		if($code){
			$response = $this->getHttpClient()->post($this->tokenUrl, [
					'form_params'	=> [
						'client_id'		=> $this->client_id,
						'client_secret'	=> $this->client_secret,
						'grant_type'	=> 'authorization_code',
						'redirect_uri'	=> $this->redirect,
						'code'			=> $code
					],
					'headers' => ['Accept' => 'application/json'],
				]);

			return json_decode($response->getBody());
		} else {
			return false;
		}

	}

	public function getUser(Request $request)
	{
		// dd($request->user());
		$user = $this->getAccessToken($request->code);
		
		if($user){
			$check = $request->user()->instagram()->first();
			if(!$check){
				$instagram = $request->user()->instagram()->create([
					'access_token'	=> $user->access_token,
					'full_name'		=> $user->user->full_name,
					'username'		=> $user->user->username,
					'instagram_id'	=> $user->user->id,
				]);
				return $instagram;
			} else {
				$check->access_token = $user->access_token;
				$check->save();
				return $check;
			}		
		} else {
			return false;
		}
	}

	public function getUserRecentMedia($token)
	{
		$response = $this->getHttpClient()->get($this->mediaUrl, [
				'query'	=> [
					'access_token'	=> $token
				],
				'headers' => [
					'Accept' => 'application/json'
				],
			]);
		return json_decode($response->getBody());
		
	}

	protected function getHttpClient()
	{
		return new Client();
	}

}




