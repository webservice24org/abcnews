<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your News</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        /* Mobile-friendly styles */
        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
                border-radius: 0 !important;
            }
            .header h1 {
                font-size: 20px !important;
            }
            .content {
                font-size: 14px !important;
                padding: 15px !important;
            }
            .news-list li {
                font-size: 14px !important;
            }
            .footer {
                font-size: 12px !important;
                padding: 15px !important;
            }
        }
    </style>
</head>
<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f4f4f4;">

    <table align="center" cellpadding="0" cellspacing="0" width="100%" style="margin-top:20px;">
        <tr>
            <td align="center">
                <table class="container" cellpadding="0" cellspacing="0" width="600" 
                       style="border-collapse:collapse; background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                    
                    <!-- Header -->
                    <tr class="header">
                        <td align="center" bgcolor="#d9230f" style="padding: 20px 10px;">
                            <h1 style="color:#ffffff; margin:0; font-size:24px; font-weight:bold;">Your Daily News</h1>
                        </td>
                    </tr>

                    <!-- Greeting -->
                    <tr>
                        <td class="content" style="padding: 20px; color:#333333; font-size:16px;">
                            <p style="margin:0;">Hello <strong>{{ $subscriber->name ?? 'Subscriber' }}</strong>,</p>
                            <p style="margin:8px 0 16px;">Here are the latest updates we’ve selected for you:</p>
                        </td>
                    </tr>

                    <!-- News List -->
                    <tr>
                        <td style="padding: 0 20px 20px;">
                            <ul class="news-list" style="margin:0; padding:0; list-style:none;">
                                @foreach ($newsList as $news)
                                    <li style="margin-bottom:12px; font-size:15px; line-height:1.4;">
                                        <a href="{{ route('news.show', $news->slug) }}" 
                                           style="color:#d9230f; text-decoration:none; font-weight:bold;">
                                            {{ $news->news_title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td class="footer" bgcolor="#f8f8f8" style="padding: 20px; font-size:13px; color:#666666; text-align:center; border-top:1px solid #e0e0e0;">
                            <p style="margin:0;">Thanks for being with us! <br> © {{ date('Y') }} Your News</p>
                            <p style="margin:10px 0 0;">
                                <a href="{{ route('unsubscribe', ['email' => $subscriber->email]) }}" 
                                   style="color:#d9230f; text-decoration:none;">
                                    Unsubscribe
                                </a>
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
