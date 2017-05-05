<?php

return [

	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => '\\OAuth\\Common\\Storage\\Session',

	/**
	 * Consumers
	 */
	'consumers' => [

		'Facebook' => [
			'client_id'     => env('FACEBOOK_CLIENT_ID'),
			'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
			'scope'         => [],
		],
		'Google' => [
			'client_id'     => env('GOOGLE_ID'),
			'client_secret' => env('GOOGLE_SECRET'),
			'scope'         => ['userinfo_email', 'userinfo_profile', 'https://www.googleapis.com/auth/contacts.readonly'],
		],
		'Yahoo' => [
			'client_id'     => env('YAHOO_ID'),
			'client_secret' => env('YAHOO_SECRET'),
		],
	]

];