<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ticket - {{ $ticket->uuid }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .ticket {
            border: 2px solid #ddd;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 10px;
            overflow: hidden;
        }
        .header {
            background-color: #4f46e5;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .content {
            padding: 30px;
        }
        .details {
            margin-bottom: 30px;
        }
        .details table {
            width: 100%;
            border-collapse: collapse;
        }
        .details td {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .label {
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
        }
        .value {
            font-weight: bold;
            font-size: 16px;
            text-align: right;
        }
        .barcode-section {
            text-align: center;
            border-top: 1px dashed #ccc;
            padding-top: 30px;
            margin-top: 20px;
        }
        .barcode-section img {
            width: 150px;
            height: 150px;
        }
        .data-string {
            font-family: monospace;
            font-size: 10px;
            color: #999;
            margin-top: 10px;
        }
        .footer {
            background-color: #f9fafb;
            padding: 15px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="header">
            <h1>Official Ticket</h1>
        </div>
        <div class="content">
            <div class="details">
                <table>
                    <tr>
                        <td class="label">Attendee</td>
                        <td class="value">{{ $ticket->user_name }}</td>
                    </tr>
                    <tr>
                        <td class="label">Seat Number</td>
                        <td class="value" style="color: #4f46e5;">{{ $ticket->seat_number }}</td>
                    </tr>
                    <tr>
                        <td class="label">Category</td>
                        <td class="value">{{ $ticket->type }}</td>
                    </tr>
                    <tr>
                        <td class="label">Ticket ID</td>
                        <td class="value" style="font-family: monospace; font-size: 12px;">{{ substr($ticket->uuid, 0, 13) }}</td>
                    </tr>
                </table>
            </div>

            <div class="barcode-section">
                <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code">
                <div class="data-string">{{ $ticket->barcode_data }}</div>
            </div>
        </div>
        <div class="footer">
            This ticket is valid for the registered attendee only. Keep this barcode secure.<br>
            Generated on {{ now()->format('Y-m-d H:i') }}
        </div>
    </div>
</body>
</html>
