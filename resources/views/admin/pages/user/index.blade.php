{{-- {{asset("admin/asset/bootstrap/dist/css/bootstrap.min.css")}} --}}

@extends('admin.main')

@php
    use App\Helpers\template as Template;
    
    $xhtmlButtonFilter  = Template::showButtonFilter($controllerName, $itemsStatusCount, $params['filter']['status'], $params['search']);
@endphp

@section("content")

<div class="">
@include('admin.templates.page_header',['pageIndex' => true])
@include('admin.templates.zvn_notily')

<div class="clearfix"></div>

<!-- action list -->
<div class="row">
    <!-- button action -->
    <div class="col-md-12">
    <div class="x_panel">
        <div class="x_title">
        @include('admin.templates.x_title',['title'=>'Bộ lọc'])
        <ul class="nav navbar-right panel_toolbox">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <div class="row">
            <!-- button action -->
            <div class="col-md-6">
            <button type="button" class="btn btn-default">Default</button>
            <button type="button" class="btn btn-primary">Primary</button>
            <button type="button" class="btn btn-success">Success</button>
            <button type="button" class="btn btn-info">Info</button>
            <button type="button" class="btn btn-warning">Warning</button>
            </div>
            <!-- end button action -->
            <!-- search -->
            <div class="col-md-6">
            <div class="input-group">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default dropdown-toggle btn-active-field" data-toggle="dropdown" aria-expanded="false">
                        Search by All <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                        <li><a href="#" class="select-field" data-field="all">Search by All</a></li>
                        <li><a href="#" class="select-field" data-field="id">Search by ID</a></li>
                        <li><a href="#" class="select-field" data-field="username">Search by Username</a>
                        </li>
                        <li><a href="#" class="select-field" data-field="fullname">Search by Fullname</a>
                        </li>
                        <li><a href="#" class="select-field" data-field="email">Search by Email</a></li>
                    </ul>
                </div>
                <input type="text" class="form-control" name="search_value" value="">
                <span class="input-group-btn">
                    <button id="btn-clear" type="button" class="btn btn-success" style="margin-right: 0px">Xóa tìm kiếm</button>
                    <button id="btn-search" type="button" class="btn btn-primary">Tìm kiếm</button>
                </span>
                <input type="hidden" name="search_field" value="all">
            </div>
            </div>
            <!-- end search -->
            <!-- select box -->
            <div class="col-md-2">
                <select name="select_filter" class="form-control" data-field="level">
                    <option value="default" selected="selected">Select Level</option>
                    <option value="admin">Admin</option>
                    <option value="member">Member</option>
                </select>
            </div>
            <!-- end select box -->
        </div>
        </div>
    </div>
    </div>
    <!--end button action -->

</div>
<!-- end list action button -->

<!--- list table -->
    <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        @include('admin.templates.x_title',['title'=>'Danh sách'])
        @include('admin.pages.user.list')
    </div>
    </div>
<!-- end table list -->
@if (count($items) > 0)
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            @include('admin.templates.x_title',['title'=>'Phân trang'])
            <ul class="nav navbar-right panel_toolbox">
                <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>

            </ul>
            <div class="clearfix"></div>
        </div>

        @include('admin.templates.pagination')

    </div>
    </div>
</div>
@endif
@endsection
</div>
