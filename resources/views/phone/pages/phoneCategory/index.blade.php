@extends('phone.main')
@section('content')
    @include('phone.block.breadcrumb',['nameBreadcrumb'=>$nameBreadcrumb])

    <section class="section-b-space j-box ratio_asos">
        <div class="collection-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 collection-filter">
                        <!-- side-bar colleps block stat -->
                        @include('phone.pages.phoneCategory.child-index.categoryList',[
                                                                                        'categoryPhones' => $categoryPhones,
                                                                                        'lastSegment'    => $lastSegment
                                                                                        ])
                        @include('phone.block.phoneSmallShowItems',[
                                                                                    'items'     => $productsFeature,
                                                                                    'title'     => 'Sản phẩm nổi bật',
                                                                                    'maxCount'  => 4
                                                                                ])
                        <!-- silde-bar colleps block end here -->
                    </div>
                    <div class="collection-content col">
                        <div class="page-main-content">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="collection-product-wrapper">

                                        @include('phone.pages.phoneCategory.child-index.productTopFilter')
                                        @include('phone.pages.phoneCategory.child-index.categoryItems',['items'=>$items])

                                        @if (count($items) > 0)
                                            @include('phone.pages.phoneCategory.child-index.pagination')
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('phone.block.phonering')
    @include('phone.block.quick-view')
    @include('phone.block.message')

@endsection

