<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$subject}}</title>
    <style>
        @import url('https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css');
    </style>
</head>
<body class="bg-gray-100 p-4">
<div class="max-w-md mx-auto bg-white p-8 rounded shadow-md">
    <h2 class="text-3xl font-semibold mb-4">{{$subject}}</h2>
    <p class="mb-4">Dear user,</p>
    <p>This email was sent automatically from PRMS System as a request to change email.</p>
    <div class="container-fluid bg-indigo round-8 justify-content-center">
      <a href="{{$body}}"><h4 class="my-6 ai-copy">Click this linkn to reset your password </h4></a>
      
    </div>
    <p class="mt-4 text-danger">If you did not initiate this password reset, please ignore this email</p>
    <p class="mt-6">Regards, <br> PRMS-Dennis Kim</p>
</div>
</body>
</html>