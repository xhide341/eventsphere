<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Event Attendees</title>
    <style>
        * {
            font-family: 'Arial', sans-serif;
            line-height: 1.2;
            font-size: 12px;
        }

        body {
            margin: 25px;
        }

        /* Page break utilities */
        .page-break {
            page-break-after: always;
        }

        .avoid-break {
            page-break-inside: avoid;
        }

        /* Header with Logo */
        .header {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .logo {
            max-width: 35px;
        }

        .header h1 {
            font-size: 18px;
            margin: 0;
            color: #035AA6;
            /* primary */
        }

        .event-details {
            margin-bottom: 20px;
            padding: 12px 15px;
            background-color: #F0F8FF;
            /* alice-blue */
            border-radius: 6px;
            border-left: 4px solid #035AA6;
        }

        .event-details h2 {
            font-size: 14px;
            margin: 0 0 5px 0;
            color: #074973;
            /* broad-blue */
        }

        .event-details p {
            margin: 3px 0;
            color: #0B2147;
            /* navy-blue */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px 10px;
            border: 1px solid #B8C6D9;
            /* angora-blue */
            text-align: left;
            font-size: 12px;
            background-color: #FCFFF5;
            /* milk-white */
        }

        th {
            background-color: #035AA6;
            color: #FFFFFF;
            font-weight: bold;
        }

        /* Keep rows together where possible */
        tr {
            page-break-inside: avoid;
        }

        .footer {
            margin-top: 30px;
            padding-top: 10px;
            text-align: center;
            font-size: 12px;
            position: fixed;
            bottom: 0;
            width: 100%;
            color: #6B7280; // Slightly darker for better readability
            border-top: 1px solid #E5E7EB; // Add subtle top border
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="file://{{ str_replace('\\', '/', public_path('images/LCUP.png')) }}" class="logo" alt="Logo" />
        <h1>Event Attendees List</h1>
    </div>

    <div class="event-details avoid-break">
        <h2>{{ $event->name }}</h2>
        <p>Date: {{ $event->start_date->format('M d, Y') }}</p>
        <p>Time: {{ $event->start_time->format('g:i A') }} - {{ $event->end_time->format('g:i A') }}</p>
        <p>Venue: {{ $event->venue->name }}</p>
    </div>

    @if($attendees->count() > 0)
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Registration Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendees as $index => $attendee)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $attendee->name }}</td>
                        <td>{{ $attendee->email }}</td>
                        <td>{{ \Carbon\Carbon::parse($attendee->registration_date)->format('M d, Y g:i A') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No attendees registered for this event.</p>
    @endif

    <div class="footer">
        <p>Generated on {{ now()->format('M d, Y g:i A') }}</p>
    </div>
</body>

</html>