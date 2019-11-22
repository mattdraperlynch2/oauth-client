<?php

use Illuminate\Http\Request;

Route::get('/', function () {
    $query = http_build_query([
        'client_id' => getenv('OAUTH_CLIENT_ID'), // Replace with Client ID
        'redirect_uri' => 'http://oauth-client.test/callback',
        'response_type' => 'code',
        'scope' => ''
    ]);

    return redirect('https://oauth.test/oauth/authorize?'.$query);
});

Route::get('/callback', function (Request $request) {
    $response = (new GuzzleHttp\Client)->post('https://oauth.test/oauth/token', [
        'verify' => false,
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => getenv('OAUTH_CLIENT_ID'), // Replace with Client ID
            'client_secret' => getenv('OAUTH_CLIENT_SECRET'), // Replace with client secret
            'redirect_uri' => 'http://oauth-client.test/callback',
            'code' => $request->code,
        ]
    ]);

    session()->put('token', json_decode((string) $response->getBody(), true));

    return redirect('/user');
});

Route::get('/user', function () {
    $response = (new GuzzleHttp\Client)->get('https://oauth.test/api/user', [
        'headers' => [
            'Authorization' => 'Bearer '.session()->get('token.access_token')
        ],
        'verify' => false,
    ]);
    return json_decode((string) $response->getBody(), true);
});
