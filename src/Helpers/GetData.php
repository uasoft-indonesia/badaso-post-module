<?php

namespace Uasoft\Badaso\Module\Blog\Helpers;

use Analytics;
use Spatie\Analytics\Period;

class GetData
{
    public static function getData($model, $request, $relations = [])
    {
        $posts = [];
        $builder_params = [
            'limit'           => isset($request['limit']) ? $request['limit'] : 10,
            'page'            => isset($request['page']) ? $request['page'] : null,
            'order_field'     => isset($request['order_field']) ? $request['order_field'] : 'id',
            'order_direction' => isset($request['order_direction']) ? $request['order_direction'] : 'asc',
            'filter_value'    => isset($request['filter_value']) ? $request['filter_value'] : '',
        ];

        $posts = GetData::serverSide($model, $builder_params, $relations);

        return $posts;
    }

    public static function serverSide($model, $builder_params, $relations = [])
    {
        $fields = $model->getFillable();

        $limit = $builder_params['limit'];
        $order_field = $builder_params['order_field'];
        $order_direction = $builder_params['order_direction'];
        $filter_value = $builder_params['filter_value'];

        $records = [];
        $query = $model::query();
        if ($filter_value) {
            foreach ($fields as $index => $field) {
                if ($index == 0) {
                    $query->where($field, 'LIKE', "%{$filter_value}%");
                } else {
                    $query->orWhere($field, 'LIKE', "%{$filter_value}%");
                }
            }
        }
        if ($order_field) {
            $query->orderBy($order_field, $order_direction);
        }
        if (count($relations) > 0) {
            foreach ($relations as $key => $relation) {
                $query->with($relation);
            }
        }
        $data = $query->paginate($limit ? $limit : 10)->toArray();

        return $data;
    }

    public static function getAnalytics($data)
    {
        $prefix = config('blog_post_url_prefix') ? '/'.config('blog_post_url_prefix').'/' : '/';
        $queries = [];
        foreach ($data['data'] as $key => $item) {
            $url = $prefix.$item['slug'];
            $data['data'][$key]['view_count'] = Analytics::performQuery(
                Period::days(0),
                'ga:pageviews',
                [
                    'metrics' => 'ga:pageviews',
                    'filters' => 'ga:pagePath=='.$url,
                ]
            )->totalsForAllResults['ga:pageviews'];
        }

        return $data;
    }
}
