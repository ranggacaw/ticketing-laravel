<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ticket #{{ substr($ticket->uuid, 0, 8) }}</title>
    <style>
        @page { margin: 0; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 40px;
            background-color: #f8fafc;
        }
        .ticket-container {
            background-color: #ffffff;
            width: 500px;
            margin: 0 auto;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            overflow: hidden;
            position: relative;
        }
        .main-header {
            background-color: #4f46e5;
            padding: 30px;
            text-align: center;
            color: #ffffff;
        }
        .main-header .brand {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
            opacity: 0.8;
        }
        .main-header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .ticket-body {
            padding: 40px;
        }
        .guest-section {
            margin-bottom: 30px;
        }
        .guest-section .label {
            font-size: 10px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        .guest-section .name {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
        }
        .info-grid {
            width: 100%;
            margin-bottom: 30px;
        }
        .info-grid td {
            vertical-align: top;
            padding-bottom: 20px;
        }
        .info-item .label {
            font-size: 10px;
            text-transform: uppercase;
            color: #64748b;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }
        .info-item .value {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
        }
        .seat-highlight {
            color: #4f46e5;
            font-size: 24px !important;
        }
        .divider {
            border-top: 2px dashed #e2e8f0;
            margin: 0 -40px 30px -40px;
            position: relative;
        }
        .divider:before, .divider:after {
            content: '';
            position: absolute;
            top: -10px;
            width: 20px;
            height: 20px;
            background-color: #f8fafc;
            border-radius: 50%;
        }
        .divider:before { left: -11px; }
        .divider:after { right: -11px; }

        .barcode-section {
            text-align: center;
        }
        .barcode-container {
            background-color: white;
            padding: 15px;
            border: 1px solid #f1f5f9;
            display: inline-block;
            border-radius: 16px;
        }
        .barcode-data {
            font-family: monospace;
            font-size: 11px;
            color: #94a3b8;
            margin-top: 15px;
            letter-spacing: 2px;
        }
        .footer {
            background-color: #f8fafc;
            padding: 20px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="main-header">
            <span class="brand">TicketScan Internal</span>
            <h1>ENTRY PASS</h1>
        </div>
        <div class="ticket-body">
            <div class="guest-section">
                <div class="label">Primary Attendee</div>
                <div class="name">{{ $ticket->user_name }}</div>
            </div>

            <table class="info-grid">
                <tr>
                    <td width="50%">
                        <div class="info-item">
                            <div class="label">Category</div>
                            <div class="value">{{ $ticket->type }}</div>
                        </div>
                    </td>
                    <td width="50%">
                        <div class="info-item">
                            <div class="label">Seat Number</div>
                            <div class="value seat-highlight">{{ $ticket->seat_number }}</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="info-item">
                            <div class="label">Order ID</div>
                            <div class="value" style="font-family: monospace; font-size: 12px;">#{{ substr($ticket->uuid, 0, 8) }}</div>
                        </div>
                    </td>
                    <td>
                        <div class="info-item">
                            <div class="label">Issued Date</div>
                            <div class="value">{{ $ticket->created_at->format('M d, Y') }}</div>
                        </div>
                    </td>
                </tr>
            </table>

            <div class="divider"></div>

            <div class="barcode-section">
                <div class="barcode-container">
                    <img src="data:image/svg+xml;base64,{{ $qrCode }}" width="150" height="150">
                </div>
                <div class="barcode-data">{{ $ticket->barcode_data }}</div>
            </div>
        </div>
        <div class="footer">
            This document serves as your official entry pass.<br>
            Validated by TicketScan System • Non-Transferable
        </div>
    </div>
</body>
</html>
