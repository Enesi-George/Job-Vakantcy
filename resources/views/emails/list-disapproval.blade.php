<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <title>Verify Your Email</title>
    <style>
        body {
            font-family: 'Nunito', sans-serif !important;
            background-color: #e2e8f0 !important;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 5px;
            border-top-left-radius: 0px;
            border-top-right-radius: 0px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #f8fafc;
            /* background-color: #ffffff; */

        }
        .company{
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
            font-weight: bold;
            padding: 20px;
            font-size: 35px;
            border-radius: 5px;
            border-bottom-left-radius: 0px;
            border-bottom-right-radius: 0px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #ef4444;
            margin-top: 30px;
            margin-bottom: 15px;
            
        }
        .company .job{
            color: white;
        }
        .company .vakantcy{
            color: #1f2937;
        }
        h1 {
            color: #1f2937;
        }
        p {
            color: #666666;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #ffffff;
            background-color: #1f2937;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            transition: 0.3s;
        }
        .button:hover {
            opacity: 0.8;
        }
        footer{
            margin: 10px 0pc;
        }
        footer .copyright{
            text-align: center;
            font-size: 10px;
            color: gray;
        }
    </style>
</head>
<body>
        <header class="company"> 
            <span class="job">JOB</span> 
            <span class="vakantcy">VAKANTCY</span> 
        </header>
        <div class="container">
            <p>Hello {{ $user->name }}!,</p>
            <p>We are sorry to inform you that your post was not approved due to it not meeting the necessary requirement</p>
            <p> For further enquiry please contact the administrative</p>
            <p>Thanks,<br>{{ config('app.name') }}</p>
        </div>
        <footer>
            <div class="copyright"> 
                <span> 
                    © 2024 {{ config('app.name') }}. All rights reserved. 
                </span>       
            </div>
        </footer>

</body>
</html>

