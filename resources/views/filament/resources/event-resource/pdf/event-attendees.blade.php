<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Event Attendees</title>
    <link href="{{ base_path('vendor/iamcal/php-emoji/lib/emoji.css') }}" rel="stylesheet" type="text/css" />
    <style>
        * {
            font-family: 'Arial', sans-serif;
            line-height: 1.4;
        }

        body {
            margin: 40px;
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
            margin-bottom: 30px;
            position: relative;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .logo {
            max-width: 50px;
            /* Adjust size as needed */
            margin-bottom: 20px;
            margin-right: 20px;
        }

        .event-details {
            margin-bottom: 20px;
            padding: 10px;
            background: #f5f5f5;
            border-radius: 4px;
            page-break-inside: avoid;
            /* Keep event details together */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
        }

        /* Keep rows together where possible */
        tr {
            page-break-inside: avoid;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ public_path('images/LCUP.png') }}" class="logo" alt="Logo" />
        <h1>{!! emoji_unified_to_html("Event Attendees List 📋") !!}</h1>
    </div>

    <div class="event-details avoid-break">
        <h2>{!! emoji_unified_to_html($event->name . " 🎯") !!}</h2>
        <p>{!! emoji_unified_to_html("📅 Date: " . $event->start_date->format('M d, Y')) !!}</p>
        <p>{!! emoji_unified_to_html("⌚ Time: " . $event->start_time->format('g:i A') . " - " . $event->end_time->format('g:i A')) !!}
        </p>
        <p>{!! emoji_unified_to_html("📍 Venue: " . $event->venue->name) !!}</p>
    </div>

    @if($attendees->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>{!! emoji_unified_to_html("👤 Name") !!}</th>
                    <th>{!! emoji_unified_to_html("📧 Email") !!}</th>
                    <th>{!! emoji_unified_to_html("📅 Registration Date") !!}</th>
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
        <p>{!! emoji_unified_to_html("No attendees registered for this event. 😕") !!}</p>
    @endif

    <div class="footer">
        <p>{!! emoji_unified_to_html("Generated on " . now()->format('M d, Y g:i A') . " 🕒") !!}</p>
    </div>
</body>

</html>