@php

    $xhtmlCategoryList = '';
    $xhtmlCategoryList = buildMenuNav($categoryPhones,$controllerName,$childText = '',$lastSegment);

    function buildMenuNav($categoryPhones, $controllerName, $childText = '', $lastSegment)
    {
        $xhtml = '';
        foreach ($categoryPhones as $categoryPhone) {
            $id         = $categoryPhone['id'];
            $url        = route($controllerName, ['id' => $id]);

            // Kiểm tra node hiện tại hoặc con cháu có đang active không
            $isActiveSelf = ($id == $lastSegment);
            $isActiveDescendant = hasDescendantActive($categoryPhone, $lastSegment);
            $activeText = ($isActiveSelf || $isActiveDescendant) ? 'my-text-primary' : 'text-dark';

            $xhtml .= '<div class="custom-control custom-checkbox collection-filter-checkbox pl-0 category-item">
                            <a class="' . $activeText . '" href="' . $url . '">' . $childText . $categoryPhone['name'] . '</a>
                        </div>';

            if (!empty($categoryPhone['children'])) {
                $nextLevelPrefix = $childText . '<i class="fa  fa-angle-right" aria-hidden="true"></i>'.' ';
                $xhtml .= buildMenuNav($categoryPhone['children'], $controllerName, $nextLevelPrefix, $lastSegment);
            }
        }

        return $xhtml;
    }

    //Hàm phụ, kiểm tra xem có `con` nào khớp với id ($lastSegment) của url không?
    function hasDescendantActive($node, $lastSegment) {
        if (!empty($node['children'])) {
            foreach ($node['children'] as $child) {
                if ($child['id'] == $lastSegment || hasDescendantActive($child, $lastSegment)) {
                    return true;
                }
            }
        }
        return false;
    }
@endphp
<div class="collection-filter-block">
    <!-- brand filter start -->
    <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left"
                aria-hidden="true"></i> back</span></div>
    <div class="collection-collapse-block open">
        <h3 class="collapse-block-title">Danh mục</h3>
        <div class="collection-collapse-block-content">
            <div class="collection-brand-filter">
                {!! $xhtmlCategoryList !!}
            </div>
        </div>
    </div>
</div>
