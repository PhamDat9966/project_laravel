{{-- {{asset("admin/asset/bootstrap/dist/css/bootstrap.min.css")}} --}}

@extends('admin.main')

@section("content")
<div class="">
    <div class="page-header zvn-page-header clearfix">
        <div class="zvn-page-header-title">
            <h3>Danh sách User</h3>
        </div>
        <div class="zvn-add-new pull-right">
            <a href="/form" class="btn btn-success"><i
                    class="fa fa-plus-circle"></i> Thêm mới</a>
        </div>
    </div>

    <div class="clearfix"></div>

    <!-- action list -->
    <div class="row">
        <!-- button action -->
        <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
            <h2>Bộ lọc </h2>
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
            @include('admin.pages.user.list')
        </div>
        </div>
    <!-- end table list -->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Phân trang
                </h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>

                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <div class="row">
                    <div class="col-md-6">
                        <p class="m-b-0">Số phần tử trên trang: <b>2</b> trên <span class="label label-success label-pagination">3 trang</span></p>
                        <p class="m-b-0">Hiển thị<b> 1 </b> đến<b> 2</b> trên<b> 6</b> Phần tử</p>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination zvn-pagination">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">«</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">»</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
