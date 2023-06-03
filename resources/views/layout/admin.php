<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" href="/favicon.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>QuickCRM</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="/public/js/style.css" />
</head>

<body>
  <main class="flex" id="app">
    <aside class="h-full sm:hidden lg:block text-gray-100 bg-neutral  min-w-[280px] shadow-2xl">
      <section class="flex shadow-sm h-14 justify-center border-b border-gray-100 border-opacity-20 bg-opacity-20 items-center">
        <h1 class="text-2xl font-bold"><span class="text-gray-400">Quick</span>CRM</h1>
      </section>


      <nav class=" p-3">
        <ul>
          <li class="px-3 flex py-2 gap-5 hover:bg-black hover:bg-opacity-20 cursor-pointer rounded">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>


            <span>Dashboard</span>
          </li>

          <li class="px-3 flex py-2 gap-5 hover:bg-black hover:bg-opacity-20 cursor-pointer rounded">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
            </svg>



            <span>Customers</span>
          </li>

          <li class="px-3 flex py-2 gap-5 hover:bg-black hover:bg-opacity-20 cursor-pointer rounded">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
            </svg>



            <span>Favorites</span>
          </li>
        </ul>
      </nav>
    </aside>

    <div class="w-full h-full overflow-y-scroll">
      <div class="flex w-full px-1 h-14 justify-between items-center shadow-sm border-b  ">
        <button class="btn">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>

        </button>

        <div class="dropdown dropdown-bottom dropdown-end">
          <label tabindex="0" class="btn ">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
          </label>
          <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 z-50">
            <li><a href="/profile">Profile</a></li>
            <li>
              <form method="post" action="/logout">
                <button class="w-full" type="submit">Logout</button>
              </form>
            </li>
          </ul>
        </div>
      </div>

      <div class="p-5">
        @child
      </div>
    </div>

  </main>
  <script type="module" src="/public/js/index.js"></script>
</body>

</html>