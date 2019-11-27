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
        ],
    ]);
    session()->put('token', json_decode((string) $response->getBody(), true));

    return redirect('/resource');
});

Route::get('/resource/{id}', function ($id) {
    $url = 'https://oauth.test/api/resource/'.$id;
    $response = (new GuzzleHttp\Client)->get($url, [
        'headers' => [
            'Authorization' => 'Bearer '.session()->get('token.access_token')
        ],
        'verify' => false,
    ]);
    $json = json_decode((string) $response->getBody(), true);
    return json_decode(json_encode($json, JSON_PRETTY_PRINT), true);
});

Route::get('/resource', function () {
    $response = (new GuzzleHttp\Client)->get('https://oauth.test/api/resource', [
        'headers' => [
            'Authorization' => 'Bearer '.session()->get('token.access_token')
        ],
        'verify' => false,
    ]);
    $json = json_decode((string) $response->getBody(), true);
    return json_decode(json_encode($json, JSON_PRETTY_PRINT), true);
});



Route::get('/contact', function () {
    $response = (new GuzzleHttp\Client)->get('https://oauth.test/api/contact', [
        'headers' => [
            'Authorization' => 'Bearer '.session()->get('token.access_token')
        ],
        'verify' => false,
    ]);
    return json_decode((string) $response->getBody(), true);
//    return json_decode(json_encode($json, JSON_PRETTY_PRINT), true);
});

Route::get('/describe-connection', function () {
    $response = (new GuzzleHttp\Client)->get('https://oauth.test/api/describe-connection', [
        'headers' => [
            'Authorization' => 'Bearer '.session()->get('token.access_token')
        ],
        'verify' => false,
    ]);
    return json_decode((string) $response->getBody(), true);
//    return json_decode(json_encode($json, JSON_PRETTY_PRINT), true);
});
