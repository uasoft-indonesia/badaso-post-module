<?php

namespace Uasoft\Badaso\Module\Post\Helpers;

class GetData
{
    public static function getPopularPosts($model, $request, $relations)
    {
        $posts = [];
        $result = [];

        $query = $model::query();
        $token = self::getToken();

        if (count($relations) > 0) {
            foreach ($relations as $key => $relation) {
                $query->with($relation);
            }
        }

        $query = $query
            ->where('published', true);

        // result if nullable token
        if (! isset($token)) {
            return $query
                ->skip(0)
                ->take($request->limit ?? 10)
                ->get()
                ->toArray();
        }

        $client = new \GuzzleHttp\Client();
        $propertyId = env('MIX_ANALYTICS_WEBPROPERTY_ID');

        $body = [
            'metrics' => [
                [
                    'name' => 'activeUsers'
                ],
                [
                    'name' => 'screenPageViews'
                ]
            ],
            'dimensions' => [
                [
                    'name' => 'unifiedScreenName'
                ]
            ],
            'minuteRanges' => [
                [
                    'name' => '0-29 minutes ago',
                    'startMinutesAgo' => 29
                ]
            ],
            'orderBys' => [
                [
                    'metric' => [
                        'metricName' => 'screenPageViews'
                    ]
                ]
            ],
            'limit' => '10'
        ];

        $options = [
            'json' => $body,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ]
        ];

        $res = $client->post('https://analyticsdata.googleapis.com/v1beta/properties/'.$propertyId. ':runRealtimeReport', $options);

        $response = json_decode($res->getBody()->getContents());
        $get_posts = $query->get();

        if (array_key_exists('rows', (array) $response)) {

            foreach ($response->rows as $row)
            {
                foreach ($row->dimensionValues as $dimension)
                {
                    $value = $dimension->value;

                    foreach($get_posts as $post)
                    {
                        if(str_starts_with($value, $post->title))
                        {
                            $title = $post->title;
                            array_push($result,$title);
                        }

                    }
                }

            }
        }
        $posts = $query->whereIn('title', $result)->get()->toArray();

        return $posts;
    }

    private static function getToken()
    {
        $credential_path = storage_path('app/analytics/service-account-credentials.json');

        if (! file_exists($credential_path)) {
            return;
        }

        $client = new \Google\Client();
        $client->setAuthConfig($credential_path);

        $client->addScope('https://www.googleapis.com/auth/analytics.readonly');
        $client->setApplicationName('GoogleAnalytics');
        $client->refreshTokenWithAssertion();
        $token = $client->getAccessToken();

        return $token['access_token'];
    }
}
