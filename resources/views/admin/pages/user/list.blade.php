@php
    //dd($items->toArray());
@endphp
<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Username</th>
                    <th class="column-title">Email</th>
                    <th class="column-title">Fullname</th>
                    <th class="column-title">Avatar</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Level</th>
                    <th class="column-title">Tạo mới</th>
                    <th class="column-title">Chỉnh sửa</th>
                    <th class="column-title">Hành động</th>
                </tr>
            </thead>
            <tbody>

            @if (count($items) > 0)
                @foreach ($items as $key=>$item)
                    @php
                        // /dd($item->toArray());
                        $index = $key + 1;
                        $class = ($index % 2 == 0 ) ? 'even' : 'odd';
                        $userName   = $item['username'];
                        $email      = $item['email'];
                        $fullName   = $item['fullname'];
                        $created    = $item['created'];
                        $createdBy  = $item['created_by'];
                        $modified   = $item['modified'];
                        $modifiedBy = $item['modified_by'];
                    @endphp
                    <tr class="{{ $class }}} pointer">
                        <td class="">{{ $index }}</td>
                        <td width="10%">{{ $userName }}</td>
                        <td>{{ $email }}</td>
                        <td>{{ $fullName }}</td>
                        <td width="5%"><img src="{{asset("admin/img/img.jpg")}}"
                                            alt="admin" class="zvn-thumb"></td>
                        <td><a href="/change-status-active/1"
                                type="button" class="btn btn-round btn-success">Active</a></td>
                        <td width="10%">
                            <select name="select_change_attr" class="form-control"
                                    data-url="/change-level-value_new/1">
                                <option value="admin" selected="selected">Admin</option>
                                <option value="member">Member</option>
                            </select>
                        </td>
                        <td>
                            <p><i class="fa fa-user"></i> {{ $created }}</p>
                            <p><i class="fa fa-clock-o"></i> {{ $createdBy }}</p>
                        </td>
                        <td>
                            <p><i class="fa fa-user"></i> {{ $modified }}</p>
                            <p><i class="fa fa-clock-o"></i> {{ $modifiedBy }}</p>
                        </td>
                        <td class="last">
                            <div class="zvn-box-btn-filter"><a
                                    href="/form/1"
                                    type="button" class="btn btn-icon btn-success" data-toggle="tooltip"
                                    data-placement="top" data-original-title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a><a href="/delete/1"
                                    type="button" class="btn btn-icon btn-danger btn-delete"
                                    data-toggle="tooltip" data-placement="top"
                                    data-original-title="Delete">
                                <i class="fa fa-trash"></i>
                            </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif

            </tbody>
        </table>
    </div>
</div>
</div>
