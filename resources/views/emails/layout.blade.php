<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <style type="text/css">
        /*Coupons */
        .coupons {
          position: relative;
          margin-bottom: 20px;
          border-radius: 4px;
          min-height: 60px;
          text-align: center;
          box-shadow: 0 1px 1px rgba(0,0,0, .05);
          background: #c6d5d3;
        }
        .coupons-inner {
          margin-left: 50px;
          font-size: 0.9em;
          font-weight: 600;
          border-left: 5px dashed #fff;
          padding: 15px;
          background: #ddd
        }
        .coupons:before {
          content: "";
          position: absolute;
          top: 45%;
          left: 15px;
          width: 15px;
          height: 15px;
          background: #fff;
          border-radius: 50%;
        }
        .coupons-code {
          font-size: 1.5em;
          font-weight: 800;
          color: #fff;
          padding: 5px;
          margin-top: 5px;
          background-color: #858689;
        }
        .coupons .one-time {
          margin-top: 10px;
          color: #999;
          border: 2px solid #999;
          display: inline-block;
          padding: 3px 7px;
          font-weight: 800;
          font-size: 1em;
        }
        .overline {
          text-decoration: line-through;
        }
    </style>
</head>

<body bgcolor="#FFFFFF" style="-webkit-font-smoothing:antialiased; -webkit-text-size-adjust:none; 
    width: 700px;  height: 100%;  margin-left: auto; margin-right: auto;">

    <!-- HEADER -->
    <table class="head-wrap" bgcolor="#fff" style="width: 100%; border-bottom: 2px solid #eee;">
        <tr>
            <td class="header container" style="text-align: center !important;">  
                <div class="content">
                <table bgcolor="#fff">
                    <tr>
                        <td><a href="{{ url('/') }}" target="_blank">
                         {{  Settings::get('app_name') }}
                        </a></td>
                    </tr>
                </table>
                </div>      
            </td>
        </tr>
    </table>
    <!-- /HEADER -->

    <div class="content-body" style="min-height: 100px; padding: 15px">
    @yield('content')
    </div>
    
    <!-- FOOTER -->
    <table class="footer-wrap" style="  width: 100%;    
        clear:both!important;
        background-color: rgb(249, 249, 249);
        margin-top: 15px;
        height: 50px;
        border-top: 2px solid #eee;">
        <tr>
            <td class="container" style="text-align: center;">
                <p style="line-height: 10px;">{{ Settings::get('app_name') }}</p>
            </td>
        </tr>  
    </table>
    <!-- /FOOTER -->

</body>
</html>