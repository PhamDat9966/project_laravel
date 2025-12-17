<!DOCTYPE html>
<html lang="en">
  <head>
    @include("admin.elements.head")
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
            @include("admin.elements.sidebar")
        </div>

        <!-- top navigation -->
        @include("admin.elements.top_navigation")
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            @yield("content")
        </div>
        <!-- /page content -->

        <!-- footer content -->
        @include("admin.elements.footer")
        <!-- /footer content -->
      </div>
    </div>
    @include("admin.elements.script")
  </body>
</html>
