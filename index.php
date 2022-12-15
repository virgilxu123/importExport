<?php
 include 'config.php';
 include 'import.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Export data from MySQL table to CSV file using php</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

<a href="exportdata.php" class="btn btn-primary">Export Data</a>
    <form class="md-form"  action='#' method="post" enctype="multipart/form-data" style="margin-top:50px;">
        <div class="file-field">
        <div class="btn btn-primary btn-sm float-left">
        <span>Choose file</span>
        <input type="file" name="file">
        </div>
        </div><br/><br/>
        <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
</body>
</html>
