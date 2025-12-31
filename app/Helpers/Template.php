<?php
namespace App\Helpers;
class Template{
    public static function showButtonFilter($controllerName,$itemsStatusCount,$currentFilterStatus,$paramsSearch,$currentParams = null){

        $xhtml          = '';
        $tmplStatus     = config('zvn.template.status');

        if(count($itemsStatusCount) > 0){

            array_unshift($itemsStatusCount,[
                'count' =>array_sum(array_column($itemsStatusCount,'count')),
                'status'=>'all'
            ]);

            foreach($itemsStatusCount as $item){
                $statusValue    = $item['status'];
                $statusValue    =  array_key_exists($statusValue,$tmplStatus) ? $statusValue:'default';

                $currentTemplateStatus  = $tmplStatus[$statusValue];
                   //$value['status'] active inactive block
                $link    = route($controllerName) . "?filter_status=" . $statusValue;

                if($paramsSearch['value'] != ''){
                    $link .= '&search_field='.$paramsSearch['field'] . '&search_value=' . $paramsSearch['value'];
                }

                foreach (['display', 'is_home', 'category', 'type','date'] as $filterKey) {
                    if (isset($currentParams['filter'][$filterKey]) && $currentParams['filter'][$filterKey] != '') {
                        $link .= "&filter_$filterKey=" . $currentParams['filter'][$filterKey];
                    }
                }
                $class   = ($currentFilterStatus == $statusValue) ? 'btn-danger' : 'btn-primary';
                $xhtml  .= sprintf('<a href="%s" type="button" class="btn %s"> %s <span class="badge bg-white">%s</span></a>',
                                    $link,$class,$currentTemplateStatus['name'],$item['count']
                                );
            }
        }

        return $xhtml;
    }
}
