<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload and Read</title>
</head>
<body>
    <h2>Upload Files</h2>
    <form action="process_upload.php" method="post" enctype="multipart/form-data">
        <label for="file">Choose XML, Excel, or CSV file:</label><br>
        <input type="file" id="file" name="file" accept=".xml, .xlsx, .csv"><br><br>
        <input type="submit" value="Upload File" name="submit">
    </form>
</body>
</html>