<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>QuickCRM</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="/public/js/style.css" />
</head>

<body>
  <main class="flex bg-[#f3f3f3]" id="app">
    <sidebar></sidebar>

    <div class="w-full h-full overflow-y-scroll">
      <navbar></navbar>

      <div class="p-5">
        @child
      </div>
    </div>

  </main>
  <script type="module" src="/public/js/index.js"></script>
</body>

</html>