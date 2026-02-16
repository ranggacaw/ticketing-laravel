<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ticket - {{ $ticket->event->title ?? 'Event' }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #000;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px dashed #ccc;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .event-title {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            color: #E61F27; /* Red Primary */
        }
        .event-meta {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }
        .content {
            display: table;
            width: 100%;
        }
        .details {
            display: table-cell;
            width: 60%;
            vertical-align: top;
        }
        .qr-section {
            display: table-cell;
            width: 40%;
            text-align: center;
            vertical-align: middle;
        }
        .label {
            font-size: 10px;
            text-transform: uppercase;
            color: #999;
            margin-bottom: 2px;
        }
        .value {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="event-title">{{ $ticket->event->title ?? 'Event Ticket' }}</h1>
            <div class="event-meta">
                {{ $ticket->event->start_time?->format('l, F j, Y') }} at {{ $ticket->event->start_time?->format('h:i A') }}
            </div>
            <div class="event-meta">
                {{ $ticket->event->location ?? 'Venue TBA' }}
            </div>
        </div>

        <div class="content">
            <div class="details">
                <div class="label">ATTENDEE</div>
                <div class="value">{{ $ticket->user->name ?? 'Guest' }}</div>

                <div class="label">TICKET TYPE</div>
                <div class="value">{{ $ticket->ticketType->name ?? 'General Admission' }}</div>

                <div class="label">SEAT</div>
                <div class="value">{{ $ticket->seat_number ?? 'General Admission' }}</div>

                <div class="label">TICKET ID</div>
                <div class="value">{{ $ticket->uuid }}</div>
            </div>

            <div class="qr-section">
                <img src="data:image/png;base64,{{ $qrCode }}" alt="Ticket QR" width="150">
                <div style="font-size: 10px; margin-top: 5px;">Scan at entrance</div>
            </div>
        </div>

        <div class="footer">
            Ticket ID: {{ $ticket->uuid }} | Purchase Date: {{ $ticket->created_at->format('Y-m-d') }}
            <br>
            Please present this ticket at the entrance.
        </div>
    </div>
</body>
</html>
