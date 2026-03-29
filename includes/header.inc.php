<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle).' — ' : ''; ?>MoveMovie</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?php echo $baseUrl ?>assets/css/style.css">
  <script>
    // Run BEFORE <body> — add class to <html> to prevent flash
    (function() {
      if (localStorage.getItem('mm_theme') === 'light') {
        document.documentElement.classList.add('light-mode');
      }
    })();
  </script>
</head>
<body>