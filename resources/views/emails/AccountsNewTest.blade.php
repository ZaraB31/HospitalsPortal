<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Test</title>
</head>
<body>
    <div>
        <h2>New Test Result</h2>
        <p>A new test has been uploaded to the portal and is ready for invoicing.</p>
        <a href="http://localhost:8000/Hospitals/Boards/{{ $test->board_id }}">View the Test</a>

        <p>Once the invoice has been raised, please log it <a href="http://localhost:8000/Hospitals/Admin/Invoices">Here</a>.</p>
    </div>
</body>
</html>
