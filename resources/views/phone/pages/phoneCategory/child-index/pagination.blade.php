@php
    $total                  =   $items->total();
    $totalElementPerPage    =   $items->perPage();
    $totalPage              =   $items->lastPage();
    $currentPage            =   $items->currentPage();

    $firstItem              =   $items->firstItem();
    $lastItem               =   $items->lastItem();


@endphp
<div class="product-pagination">
    <div class="theme-paggination-block">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-xl-6 col-md-6 col-sm-12">
                    {{ $items->appends(request()->input())->links('pagination.pagination_phonetheme',['paginator'=>$items]) }}
                </div>
                <div class="col-xl-6 col-md-6 col-sm-12">
                    <div class="product-search-count-bottom">
                        {{-- <h5>Showing Items 1-12 of 55 Result</h5> --}}
                        <h5>Showing Items {{ $firstItem }}-{{$lastItem}} of {{$total}} Result</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
