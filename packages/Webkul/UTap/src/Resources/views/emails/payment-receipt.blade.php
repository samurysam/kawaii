<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment Confirmation — Kawaii Blessings</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #fff5f8;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      color: #33282c;
      -webkit-font-smoothing: antialiased;
    }
    .wrapper {
      width: 100%;
      background-color: #fff5f8;
      padding: 30px 15px;
    }
    .card {
      max-width: 580px;
      margin: 0 auto;
      background: #ffffff;
      border-radius: 24px;
      overflow: hidden;
      border: 1px solid #f6d1dd;
      box-shadow: 0 14px 40px rgba(226, 116, 157, 0.12);
    }
    .header {
      background: linear-gradient(135deg, #fff0f5 0%, #ffe3ed 100%);
      padding: 32px 24px 24px;
      text-align: center;
      border-bottom: 1px solid #f6d5e1;
    }
    .logo {
      max-height: 56px;
      max-width: 200px;
      margin-bottom: 14px;
    }
    .badge {
      display: inline-block;
      background: linear-gradient(135deg, #f58aab, #ed6e98);
      color: #ffffff;
      font-size: 11px;
      font-weight: 800;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      padding: 5px 14px;
      border-radius: 999px;
      margin-bottom: 12px;
    }
    .title {
      margin: 0 0 6px;
      color: #2b1f24;
      font-size: 24px;
      font-weight: 800;
    }
    .subtitle {
      margin: 0;
      color: #826671;
      font-size: 14px;
    }
    .body {
      padding: 30px 28px;
    }
    .amount-box {
      background: linear-gradient(135deg, #fff8fb 0%, #fff0f5 100%);
      border: 2px dashed #f2becf;
      border-radius: 18px;
      padding: 20px;
      text-align: center;
      margin-bottom: 26px;
    }
    .amount-label {
      font-size: 12px;
      font-weight: 700;
      color: #926d7c;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 4px;
    }
    .amount-val {
      font-size: 34px;
      font-weight: 900;
      color: #ed5287;
      margin: 0;
      line-height: 1.1;
    }
    .table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 24px;
    }
    .table td {
      padding: 10px 0;
      font-size: 13.5px;
      border-bottom: 1px solid #fcedf2;
    }
    .table td.label {
      color: #8c6f7b;
      font-weight: 600;
      width: 40%;
    }
    .table td.val {
      color: #2e2327;
      font-weight: 700;
      text-align: right;
      width: 60%;
    }
    .reason-box {
      background: #fdf5f8;
      border-left: 4px solid #f38cad;
      padding: 12px 16px;
      border-radius: 0 12px 12px 0;
      margin-bottom: 24px;
      font-size: 13.5px;
      color: #4f3b43;
    }
    .reason-title {
      font-weight: 800;
      color: #ed5287;
      margin-bottom: 4px;
      font-size: 12px;
      text-transform: uppercase;
    }
    .footer {
      background: #fff7fa;
      padding: 22px 24px;
      text-align: center;
      border-top: 1px solid #f6d8e2;
      font-size: 12px;
      color: #917580;
      line-height: 1.6;
    }
    .footer strong {
      color: #e86392;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="card">
      <div class="header">
        <span class="badge">✨ Payment Verified</span>
        <h1 class="title">Payment Receipt 💖</h1>
        <p class="subtitle">Thank you for your payment, {{ $paymentLink->name }}!</p>
      </div>

      <div class="body">
        <div class="amount-box">
          <div class="amount-label">Amount Paid</div>
          <div class="amount-val">AED {{ number_format((float) $paymentLink->amount, 2) }}</div>
        </div>

        <div class="reason-box">
          <div class="reason-title">Purpose / Reason for Payment:</div>
          <div>{{ $paymentLink->reason }}</div>
        </div>

        <table class="table">
          <tr>
            <td class="label">Reference Code</td>
            <td class="val">#{{ strtoupper($paymentLink->link_code) }}</td>
          </tr>
          @if($paymentLink->utap_txn_id)
          <tr>
            <td class="label">Transaction ID</td>
            <td class="val">{{ $paymentLink->utap_txn_id }}</td>
          </tr>
          @endif
          <tr>
            <td class="label">Payment Date</td>
            <td class="val">{{ $paymentLink->paid_at ? $paymentLink->paid_at->format('d M Y, h:i A') : now()->format('d M Y, h:i A') }}</td>
          </tr>
          <tr>
            <td class="label">Payer Name</td>
            <td class="val">{{ $paymentLink->name }}</td>
          </tr>
          <tr>
            <td class="label">Payer Email</td>
            <td class="val">{{ $paymentLink->email }}</td>
          </tr>
          @if($paymentLink->phone)
          <tr>
            <td class="label">Payer Phone</td>
            <td class="val">{{ $paymentLink->phone }}</td>
          </tr>
          @endif
          <tr>
            <td class="label">Payment Gateway</td>
            <td class="val">uTap by e&</td>
          </tr>
          <tr>
            <td class="label">Status</td>
            <td class="val" style="color:#10b981;">✓ Completed</td>
          </tr>
        </table>
      </div>

      <div class="footer">
        <p style="margin:0 0 6px;">
          ✦ <strong>Kawaii Blessings</strong> — Delivering kawaii joy across the UAE ✦
        </p>
        <p style="margin:0;">
          If you have questions regarding this payment, feel free to contact us at 
          <a href="mailto:{{ core()->getSenderEmailDetails()['email'] }}" style="color:#ed5287;text-decoration:none;font-weight:700;">{{ core()->getSenderEmailDetails()['email'] }}</a>
        </p>
      </div>
    </div>
  </div>
</body>
</html>
