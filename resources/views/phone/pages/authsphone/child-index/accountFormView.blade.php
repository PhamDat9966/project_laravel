@php

@endphp

<section class="faq-section section-b-space">
    <div class="container">
        <div class="row">

            @include('phone.pages.authsphone.child-index.accountSidebar',['active'=>'authsphone/accountForm'])

            <div class="col-lg-9">
                <div class="dashboard-right">
                    <div class="dashboard">
                        <form action="" method="post" id="admin-form" class="theme-form">

                            <div class="form-group">
                                <label for="username">Tên tài khoảng</label>
                                <input type="text" name="form[fullname]" value="{{ $user['username'] }}" class="form-control"
                                    id="fullname">
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="form[email]" value="{{ $user['email'] }}" class="form-control"
                                    id="email" readonly="1">
                            </div>

                            <div class="form-group">
                                <label for="fullname">Họ tên</label>
                                <input type="text" name="form[fullname]" value="{{ $user['fullname'] }}" class="form-control"
                                    id="fullname">
                            </div>

                            <input type="hidden" id="form[token]" name="form[token]" value="1599258345"><button
                                type="submit" id="submit" name="submit" value="Cập nhật thông tin"
                                class="btn btn-solid btn-sm">Cập nhật thông tin</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
