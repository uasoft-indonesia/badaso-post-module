<?php

namespace Uasoft\Badaso\Module\Blog\Helpers;

use Analytics;
use Carbon\Carbon;
use Spatie\Analytics\Period;

class GetData
{
    public static function getData($model, $request, $relations = [])
    {
        $posts = [];
        $builder_params = [
            'limit'           => isset($request['limit']) ? $request['limit'] : 10,
            'page'            => isset($request['page']) ? $request['page'] : null,
            'category'            => isset($request['category']) ? $request['category'] : null,
            'tag'            => isset($request['tag']) ? $request['tag'] : null,
            'order_field'     => isset($request['order_field']) ? $request['order_field'] : 'id',
            'order_direction' => isset($request['order_direction']) ? $request['order_direction'] : 'asc',
            'search'    => isset($request['search']) ? $request['search'] : '',
        ];

        $posts = GetData::serverSide($model, $builder_params, $relations);

        return $posts;
    }

    public static function serverSide($model, $builder_params, $relations = [])
    {
        $fields = $model->getFillable();

        $limit = $builder_params['limit'];
        $category = $builder_params['category'];
        $tag = $builder_params['tag'];
        $order_field = $builder_params['order_field'];
        $order_direction = $builder_params['order_direction'];
        $search = $builder_params['search'];

        $records = [];
        $query = $model::query();
        if ($search) {
            foreach ($fields as $index => $field) {
                if ($index == 0) {
                    $query->where($field, 'LIKE', "%{$search}%");
                } else {
                    $query->orWhere($field, 'LIKE', "%{$search}%");
                }
            }
        }

        $query->when($tag, function ($query, $tag) {
            return $query->whereHas('tags', function ($q) use ($tag) {
                $q->where('slug', $tag)->orWhere('title', $tag);
            });
        })->when($category, function ($query, $category) {
            return $query->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category)->orWhere('title', $category);
            });
        });

        if ($order_field) {
            $query->orderBy($order_field, $order_direction);
        }
        if (count($relations) > 0) {
            foreach ($relations as $key => $relation) {
                $query->with($relation);
            }
        }
        $data = $query->paginate($limit ?? 10)->toArray();

        return $data;
    }

    public static function getAnalytics($data, $oldest = null)
    {
        $token = self::getToken();
        $prefix = config('blog_post_url_prefix') ? '/'.config('blog_post_url_prefix').'/' : '/';
        $url = [];

        if (gettype($oldest) !== 'array' && !empty($oldest)) {
            $oldest = $oldest->toArray();
        }

        $period = Period::create(Carbon::parse($oldest['created_at']), now()->addDay());

        foreach ($data['data'] as $key => $value) {
            $url[] = 'ga:pagePath==/' . $value['slug'];
        }

        $rows = self::getAnalyticsData($token, $url, $data, $period);

        foreach ($data['data'] as $key => $value) {
            $search = array_search('/' . $value['slug'], array_keys($rows));
            if (gettype($search) === 'integer') {
                $data['data'][$key]['view_count'] = $search;
            } else {
                $data['data'][$key]['view_count'] = 0;
            }
        }

        return $data;
    }

    private static function getAnalyticsData($token, $url = [], $data, $period)
    {
        if (count($url) > 0) {
            $client = new \GuzzleHttp\Client();
            $data = [];
            $params = [
                'query' => [
                    'ids' => 'ga:' . env('MIX_ANALYTICS_VIEW_ID', null),
                    'start-date' => $period->startDate->format('Y-m-d'),
                    'end-date' => $period->endDate->format('Y-m-d'),
                    'metrics' => 'ga:pageviews',
                    'dimensions' => 'ga:pagePath',
                    'filters' => implode(',', $url),
                    'access_token' => $token
                ]
            ];

            $res = $client->request('GET', 'https://www.googleapis.com/analytics/v3/data/ga', $params);
            $response = json_decode($res->getBody()->getContents());

            if (array_key_exists('rows', $response)) {
                foreach ($response->rows as $key => $row) {
                    $data[$row[0]] = $row[1];
                }
            }

            return $data;
        }
    }

    private static function getToken()
    {
        $credential_path = storage_path('app/analytics/service-account-credentials.json');
        $client = new \Google\Client();
        $client->setAuthConfig($credential_path);
        
        $client->addScope('https://www.googleapis.com/auth/analytics.readonly');
        $client->setApplicationName("GoogleAnalytics");
        $client->refreshTokenWithAssertion();
        $token = $client->getAccessToken();

        return $token['access_token'];
    }
}
