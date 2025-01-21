
<?php
//echo 1;exit;
$address = !empty($_GET['walletAddress']) ? $_GET['walletAddress'] : "0xe1c4c75011b9bf2f4cb35ccb9d3844f5fc671359";
$externalTransactionId =  !empty($_GET['order_id']) ? $_GET['order_id'] : date("YmdHis") .rand(1111,9999);



$host = 'https://buy.moonpay.io';


$payment = "&enabledPaymentMethods=credit_debit_card%2Capple_pay%2Cgoogle_pay%2Csamsung_pay%2Csepa_bank_transfer%2Cgbp_bank_transfer%2Cgbp_open_banking_payment";
$query = '?apiKey=pk_live_f40MCIRWivRJtQHc13Fr40KGxvwaC6&currencyCode=usdt&walletAddress=' . $address."&externalTransactionId=" .$externalTransactionId . $payment;

$signature  = base64_encode(hash_hmac('sha256', $query, 'sk_live_1Izfh4DK1TerbWoWKYKitL2aB4qgWTB', true));

$url = $host . $query . "&signature=" . urlencode($signature);



?>
<html><head>
    <script type="text/javascript">
      function runMoonPaySafariFix() {
        var isSafari = navigator.userAgent.indexOf("Safari") > -1;

        if (!isSafari) {
          return;
        }

        var isChrome = navigator.userAgent.indexOf("Chrome") > -1;

        if (isChrome) {
          return;
        }

        if (!document.cookie.match(/^(.*;)?\s*moonpay-fixed\s*=\s*[^;]+(.*)?$/)) {
          document.cookie =
            "moonpay-fixed=fixed; expires=Tue, 19 Jan 2038 03:14:07 UTC; path=/";
          window.location.replace("https://buy.moonpay.io/safari_fix");
        }
      }

      runMoonPaySafariFix();
    </script>
    <style>
      html,
      body {
        height: 100%;
        margin: 0px;
      }
    </style>
  </head>
  <body>
    <iframe frameborder="0" height="100%" src="<?php echo $url;?>" style="display:block;" width="100%" allow="accelerometer; autoplay; camera; encrypted-media; gyroscope; payment">
      <p>Your browser does not support iframes.</p>
    </iframe>
  
</body></html>
