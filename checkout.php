<?php
    require_once 'vendor/autoload.php'; // You have to require the library from your Composer vendor folder


    // Sandbox
    // Public Key: TEST-d42aa87c-fabc-4251-bb69-c3cb6f89c652
    // Access Token: TEST-2063854499225375-082023-84377aa005b9dffc2151658d4486f0f2-309907681
    $mpSandboxPublicKey = "TEST-d42aa87c-fabc-4251-bb69-c3cb6f89c652";
    $mpSandboxAccessToken = "TEST-2063854499225375-082023-84377aa005b9dffc2151658d4486f0f2-309907681";
    
    // Production
    // Public Key: APP_USR-e98c92b8-45cf-4d05-bb97-da5d652ec437
    // Access Token: APP_USR-6485615606771202-082022-885ad45d790220cf161869f7b76cd42d-143471194
    $mpProductionPublicKey = "APP_USR-7eb0138a-189f-4bec-87d1-c0504ead5626";
    $mpProductionAccessToken = "APP_USR-6317427424180639-042414-47e969706991d3a442922b0702a0da44-469485398";

    MercadoPago\SDK::setAccessToken($mpProductionAccessToken); // Either Production or SandBox AccessToken
    MercadoPago\SDK::setIntegratorId("dev_24c65fb163bf11ea96500242ac130004");

    // Crea un objeto de preferencia
    $preference = new MercadoPago\Preference();
    $preference->external_reference = "lucas@kubeymachine.com";

    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://");
    $actual_link =  "https://" . $_SERVER['HTTP_HOST'];

    //echo 'Protocol' . $protocol;

    if ($_SERVER['HTTP_HOST'] != "127.0.0.16") 
    {
        $preference->back_urls = array(
            "success" => $actual_link . "/success.php",
            "failure" => $actual_link . "/failure.php",
            "pending" => $actual_link . "/pending.php"
        );

        $preference->auto_return = "approved";
        $preference->notification_url = $actual_link . "/api/notifications";
    }

    $preference->payment_methods = array(
        "excluded_payment_methods" => array(
          array("id" => "amex")
        ),
        "excluded_payment_types" => array(
          array("id" => "atm")
        ),
        "installments" => 6
      );

    // Crea un ítem en la preferencia
    $item = new MercadoPago\Item();
    $item->id = "1234";
    $item->title = $_POST['title'];
    $item->description = "Dispositivo móvil de Tienda e-commerce";
    $item->category_id = "home";
    $item->picture_url = $_POST['img'];
    $item->quantity = 1;
    $item->currency_id = "ARS";
    $item->unit_price = $_POST['price'];
    $preference->items = array($item);

    // Payer
    $payer = new MercadoPago\Payer();
    $payer->name = "Lalo";
    $payer->surname = "Landa";
    $payer->email = "test_user_63274575@testuser.com";
    $payer->date_created = "2018-06-02T12:58:41.425-04:00";
    $payer->phone = array(
      "area_code" => "11",
      "number" => "22223333"
    );
    
    $payer->identification = array(
      "type" => "DNI",
      "number" => "12345678"
    );
    
    $payer->address = array(
      "street_name" => "False",
      "street_number" => 123,
      "zip_code" => "1111"
    );
    $preference->payer = $payer;

    // Save Preference
    $preference->save();

?>

<!DOCTYPE html>
<html class="supports-animation supports-columns svg no-touch no-ie no-oldie no-ios supports-backdrop-filter as-mouseuser" lang="en-US"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
<meta name="viewport" content="width=1024">
<title>Tienda e-commerce</title>

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="format-detection" content="telephone=no">

<script
src="https://code.jquery.com/jquery-3.4.1.min.js"
integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
crossorigin="anonymous"></script>

<link rel="stylesheet" href="./assets/category-landing.css" media="screen, print">

<link rel="stylesheet" href="./assets/category.css" media="screen, print">

<link rel="stylesheet" href="./assets/merch-tools.css" media="screen, print">

<link rel="stylesheet" href="./assets/fonts" media="">
<style>
    .as-filter-button-text {
        font-size: 26px;
        font-weight: 700;
        color: #333;
    }
    .row.as-fixed-nav {
        border-bottom: 1px solid #ddd;
    }
    .as-producttile-tilehero.with-paddlenav.with-paddlenav-onhover {
        height: 330px;
    }
    .as-footnotes {
        background: #333;
        color: #fff;
        padding: 16px 40px;
    }
    .Checkout 
    {
        display: flex;
        justify-content: center;
        padding: 50px;
    }
    .Checkout form
    {

    }
    .Checkout button
    {

    }
</style>
<style type="text/css"> @keyframes loading-rotate { 100% { transform: rotate(360deg); } } @keyframes loading-dash { 0% { stroke-dasharray: 1, 200; stroke-dashoffset: 0; } 50% { stroke-dasharray: 100, 200; stroke-dashoffset: -20px; } 100% { stroke-dasharray: 89, 200; stroke-dashoffset: -124px; } } @keyframes loading-fade-in { from { opacity: 0; } to { opacity: 1; } } .mp-spinner { position: absolute; top: 100px; left: 50%; font-size: 70px; margin-left: -35px; animation: loading-rotate 2.5s linear infinite; transform-origin: center center; width: 1em; height: 1em; } .mp-spinner-path { stroke-dasharray: 1, 200; stroke-dashoffset: 0; animation: loading-dash 1.5s ease-in-out infinite; stroke-linecap: round; stroke-width: 2px; stroke: #009ee3; } </style><style type="text/css"> .mercadopago-button { padding: 0 1.7142857142857142em; font-family: "Helvetica Neue", Arial, sans-serif; font-size: 0.875em; line-height: 2.7142857142857144; background: #009ee3; border-radius: 0.2857142857142857em; color: #fff; cursor: pointer; border: 0; } </style><style type="text/css"> @keyframes loading-rotate { 100% { transform: rotate(360deg); } } @keyframes loading-dash { 0% { stroke-dasharray: 1, 200; stroke-dashoffset: 0; } 50% { stroke-dasharray: 100, 200; stroke-dashoffset: -20px; } 100% { stroke-dasharray: 89, 200; stroke-dashoffset: -124px; } } @keyframes loading-fade-in { from { opacity: 0; } to { opacity: 1; } } .mp-spinner { position: absolute; top: 100px; left: 50%; font-size: 70px; margin-left: -35px; animation: loading-rotate 2.5s linear infinite; transform-origin: center center; width: 1em; height: 1em; } .mp-spinner-path { stroke-dasharray: 1, 200; stroke-dashoffset: 0; animation: loading-dash 1.5s ease-in-out infinite; stroke-linecap: round; stroke-width: 2px; stroke: #009ee3; } </style><style type="text/css"> .mercadopago-button { padding: 0 1.7142857142857142em; font-family: "Helvetica Neue", Arial, sans-serif; font-size: 0.875em; line-height: 2.7142857142857144; background: #009ee3; border-radius: 0.2857142857142857em; color: #fff; cursor: pointer; border: 0; } </style><style type="text/css"> @keyframes loading-rotate { 100% { transform: rotate(360deg); } } @keyframes loading-dash { 0% { stroke-dasharray: 1, 200; stroke-dashoffset: 0; } 50% { stroke-dasharray: 100, 200; stroke-dashoffset: -20px; } 100% { stroke-dasharray: 89, 200; stroke-dashoffset: -124px; } } @keyframes loading-fade-in { from { opacity: 0; } to { opacity: 1; } } .mp-spinner { position: absolute; top: 100px; left: 50%; font-size: 70px; margin-left: -35px; animation: loading-rotate 2.5s linear infinite; transform-origin: center center; width: 1em; height: 1em; } .mp-spinner-path { stroke-dasharray: 1, 200; stroke-dashoffset: 0; animation: loading-dash 1.5s ease-in-out infinite; stroke-linecap: round; stroke-width: 2px; stroke: #009ee3; } </style><style type="text/css"> .mercadopago-button { padding: 0 1.7142857142857142em; font-family: "Helvetica Neue", Arial, sans-serif; font-size: 0.875em; line-height: 2.7142857142857144; background: #009ee3; border-radius: 0.2857142857142857em; color: #fff; cursor: pointer; border: 0; } </style><style type="text/css"> @keyframes loading-rotate { 100% { transform: rotate(360deg); } } @keyframes loading-dash { 0% { stroke-dasharray: 1, 200; stroke-dashoffset: 0; } 50% { stroke-dasharray: 100, 200; stroke-dashoffset: -20px; } 100% { stroke-dasharray: 89, 200; stroke-dashoffset: -124px; } } @keyframes loading-fade-in { from { opacity: 0; } to { opacity: 1; } } .mp-spinner { position: absolute; top: 100px; left: 50%; font-size: 70px; margin-left: -35px; animation: loading-rotate 2.5s linear infinite; transform-origin: center center; width: 1em; height: 1em; } .mp-spinner-path { stroke-dasharray: 1, 200; stroke-dashoffset: 0; animation: loading-dash 1.5s ease-in-out infinite; stroke-linecap: round; stroke-width: 2px; stroke: #009ee3; } </style><style type="text/css"> .mercadopago-button { padding: 0 1.7142857142857142em; font-family: "Helvetica Neue", Arial, sans-serif; font-size: 0.875em; line-height: 2.7142857142857144; background: #009ee3; border-radius: 0.2857142857142857em; color: #fff; cursor: pointer; border: 0; } </style><style type="text/css"> @keyframes loading-rotate { 100% { transform: rotate(360deg); } } @keyframes loading-dash { 0% { stroke-dasharray: 1, 200; stroke-dashoffset: 0; } 50% { stroke-dasharray: 100, 200; stroke-dashoffset: -20px; } 100% { stroke-dasharray: 89, 200; stroke-dashoffset: -124px; } } @keyframes loading-fade-in { from { opacity: 0; } to { opacity: 1; } } .mp-spinner { position: absolute; top: 100px; left: 50%; font-size: 70px; margin-left: -35px; animation: loading-rotate 2.5s linear infinite; transform-origin: center center; width: 1em; height: 1em; } .mp-spinner-path { stroke-dasharray: 1, 200; stroke-dashoffset: 0; animation: loading-dash 1.5s ease-in-out infinite; stroke-linecap: round; stroke-width: 2px; stroke: #009ee3; } </style><style type="text/css"> .mercadopago-button { padding: 0 1.7142857142857142em; font-family: "Helvetica Neue", Arial, sans-serif; font-size: 0.875em; line-height: 2.7142857142857144; background: #009ee3; border-radius: 0.2857142857142857em; color: #fff; cursor: pointer; border: 0; } </style><style type="text/css"> @keyframes loading-rotate { 100% { transform: rotate(360deg); } } @keyframes loading-dash { 0% { stroke-dasharray: 1, 200; stroke-dashoffset: 0; } 50% { stroke-dasharray: 100, 200; stroke-dashoffset: -20px; } 100% { stroke-dasharray: 89, 200; stroke-dashoffset: -124px; } } @keyframes loading-fade-in { from { opacity: 0; } to { opacity: 1; } } .mp-spinner { position: absolute; top: 100px; left: 50%; font-size: 70px; margin-left: -35px; animation: loading-rotate 2.5s linear infinite; transform-origin: center center; width: 1em; height: 1em; } .mp-spinner-path { stroke-dasharray: 1, 200; stroke-dashoffset: 0; animation: loading-dash 1.5s ease-in-out infinite; stroke-linecap: round; stroke-width: 2px; stroke: #009ee3; } </style><style type="text/css"> .mercadopago-button { padding: 0 1.7142857142857142em; font-family: "Helvetica Neue", Arial, sans-serif; font-size: 0.875em; line-height: 2.7142857142857144; background: #009ee3; border-radius: 0.2857142857142857em; color: #fff; cursor: pointer; border: 0; } </style></head>

<script src="https://www.mercadopago.com/v2/security.js" view="checkout"></script>


<body class="as-theme-light-heroimage">

    <div class="stack">
        
        <div class="as-search-wrapper" role="main">
            <div class="as-navtuck-wrapper">
                <div class="as-l-fullwidth  as-navtuck" data-events="event52">
                    <div>
                        <div class="pd-billboard pd-category-header">
                            <div class="pd-l-plate-scale">
                                <div class="pd-billboard-background">
                                    <img src="./assets/music-audio-alp-201709" alt="" width="1440" height="320" data-scale-params-2="wid=2880&amp;hei=640&amp;fmt=jpeg&amp;qlt=95&amp;op_usm=0.5,0.5&amp;.v=1503948581306" class="pd-billboard-hero ir">
                                </div>
                                <div class="pd-billboard-info">
                                    <h1 class="pd-billboard-header pd-util-compact-small-18">Tienda e-commerce</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="as-search-results as-filter-open as-category-landing as-desktop" id="as-search-results">

                <div id="accessories-tab" class="as-accessories-details">
                    <div class="as-accessories" id="as-accessories">
                        <div class="as-accessories-header">
                            <div class="as-search-results-count">
                                <span class="as-search-results-value"></span>
                            </div>
                        </div>
                        <div class="as-searchnav-placeholder" style="height: 77px;">
                            <div class="row as-search-navbar" id="as-search-navbar" style="width: auto;">
                                <div class="as-accessories-filter-tile column large-6 small-3">

                                    <button class="as-filter-button" aria-expanded="true" aria-controls="as-search-filters" type="button">
                                        <h2 class=" as-filter-button-text">
                                            Checkout
                                        </h2>
                                    </button>


                                </div>

                            </div>
                        </div>
                        <div class="as-accessories-results  as-search-desktop">
                            <div class="width:60%">
                                <div class="as-producttile-tilehero with-paddlenav " style="float:left;"></div>
                                
                                <div class="Checkout">
                                
                                    <a href="<?php echo $preference->init_point; ?>">Pagar la compra</a>
                                
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div role="alert" class="as-loader-text ally" aria-live="assertive"></div>
        <div class="as-footnotes">
            <div class="as-footnotes-content">
                <div class="as-footnotes-sosumi">
                    Todos los derechos reservados Tienda Tecno 2019
                </div>
            </div>
        </div>

</div>
<div class="mp-mercadopago-checkout-wrapper" style="z-index:-2147483647;display:block;background:rgba(0, 0, 0, 0.7);border:0;overflow:hidden;visibility:hidden;margin:0;padding:0;position:fixed;left:0;top:0;width:0;opacity:0;height:0;transition:opacity 220ms ease-in;"> <svg class="mp-spinner" viewBox="25 25 50 50"> <circle class="mp-spinner-path" cx="50" cy="50" r="20" fill="none" stroke-miterlimit="10"></circle> </svg> </div><div class="mp-mercadopago-checkout-wrapper" style="z-index:-2147483647;display:block;background:rgba(0, 0, 0, 0.7);border:0;overflow:hidden;visibility:hidden;margin:0;padding:0;position:fixed;left:0;top:0;width:0;opacity:0;height:0;transition:opacity 220ms ease-in;"> <svg class="mp-spinner" viewBox="25 25 50 50"> <circle class="mp-spinner-path" cx="50" cy="50" r="20" fill="none" stroke-miterlimit="10"></circle> </svg> </div><div class="mp-mercadopago-checkout-wrapper" style="z-index:-2147483647;display:block;background:rgba(0, 0, 0, 0.7);border:0;overflow:hidden;visibility:hidden;margin:0;padding:0;position:fixed;left:0;top:0;width:0;opacity:0;height:0;transition:opacity 220ms ease-in;"> <svg class="mp-spinner" viewBox="25 25 50 50"> <circle class="mp-spinner-path" cx="50" cy="50" r="20" fill="none" stroke-miterlimit="10"></circle> </svg> </div><div class="mp-mercadopago-checkout-wrapper" style="z-index:-2147483647;display:block;background:rgba(0, 0, 0, 0.7);border:0;overflow:hidden;visibility:hidden;margin:0;padding:0;position:fixed;left:0;top:0;width:0;opacity:0;height:0;transition:opacity 220ms ease-in;"> <svg class="mp-spinner" viewBox="25 25 50 50"> <circle class="mp-spinner-path" cx="50" cy="50" r="20" fill="none" stroke-miterlimit="10"></circle> </svg> </div><div class="mp-mercadopago-checkout-wrapper" style="z-index:-2147483647;display:block;background:rgba(0, 0, 0, 0.7);border:0;overflow:hidden;visibility:hidden;margin:0;padding:0;position:fixed;left:0;top:0;width:0;opacity:0;height:0;transition:opacity 220ms ease-in;"> <svg class="mp-spinner" viewBox="25 25 50 50"> <circle class="mp-spinner-path" cx="50" cy="50" r="20" fill="none" stroke-miterlimit="10"></circle> </svg> </div><div class="mp-mercadopago-checkout-wrapper" style="z-index:-2147483647;display:block;background:rgba(0, 0, 0, 0.7);border:0;overflow:hidden;visibility:hidden;margin:0;padding:0;position:fixed;left:0;top:0;width:0;opacity:0;height:0;transition:opacity 220ms ease-in;"> <svg class="mp-spinner" viewBox="25 25 50 50"> <circle class="mp-spinner-path" cx="50" cy="50" r="20" fill="none" stroke-miterlimit="10"></circle> </svg> </div><div id="ac-gn-viewport-emitter"> </div></body></html>