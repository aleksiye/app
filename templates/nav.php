<?php if(isset($_SESSION['user']) &&  ($_SESSION['user']->role == 'user')): ?>
  <div class="navbar bg-base-100">
  <div class="flex-1">
  <ul class="menu menu-horizontal bg-base-200 rounded-box">
    <li>
      <a>
        Home
      </a>
    </li>
    <li>
      <a>
        About
      </a>
    </li>
    <li>
    <div class="dropdown dropdown-end relative">
        <div tabindex="0" role="button" class="">
          <span>Docs</span>
        </div>
        <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52 absolute top-8 left-0">
          <li><a>Usage Docs</a></li>
          <li><a>Code</a></li>
          <li><a>Author</a></li>
        </ul>
      </div>
    </li>
</ul>
  </div>
 <div class="flex-none">
    <div class="dropdown dropdown-end">
      <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
        <div class="indicator">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
          <span class="badge badge-sm indicator-item">8</span>
        </div>
      </div>
      <div tabindex="0" class="mt-3 z-[1] card card-compact dropdown-content w-52 bg-base-100 shadow">
        <div class="card-body">
          <span class="font-bold text-lg">8 Items</span>
          <span class="text-info">Subtotal: $999</span>
          <div class="card-actions">
            <button class="btn btn-primary btn-block">View cart</button>
          </div>
        </div>
      </div>
    </div>
    <div class="dropdown dropdown-end">
      <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
        <div class="w-10 rounded-full">
        <?php if (isset($_SESSION['user']->profile)): ?>
            <img src="<?=$_SESSION['user']->profile?>" alt="User's profile picture">
        <?php else:?>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
          </svg>
        <?php endif;?>
        </div>
      </div>
      <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
        <li>
          <a href="./profile.php" class="justify-between">
            Profile
          </a>
        </li>
        <li><a>Settings</a></li>
        <li><a href="./private/logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
 </div>

<?php elseif(isset($_SESSION['user']) && ($_SESSION['user']->role == 'seller') ): ?>
  <div class="navbar bg-base-100">
  <div class="navbar-start">
    <div class="dropdown">
      <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /></svg>
      </div>
      <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
        <li><a>Homepage</a></li>
        <li><a>Portfolio</a></li>
        <li><a>About</a></li>
      </ul>
    </div>
  </div>
  <div class="navbar-center">
    <a class="btn btn-ghost text-xl">daisyUI</a>
  </div>
  <div class="navbar-end">
    <button class="btn btn-ghost btn-circle">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
    </button>
    <button class="btn btn-ghost btn-circle">
      <div class="indicator">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
        <span class="badge badge-xs badge-primary indicator-item"></span>
      </div>
    </button>
    <div class="dropdown dropdown-end">
      <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
        <div class="w-10 rounded-full">
          <img alt="Tailwind CSS Navbar component" src="https://daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg">
        </div>
      </div>
      <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
        <li>
          <a class="justify-between">
            Profile
            <span class="badge">New</span>
          </a>
        </li>
        <li><a>Settings</a></li>
        <li><a>Logout</a></li>
      </ul>
    </div>
  </div>
</div>
<?php elseif(isset($_SESSION['user']) && ($_SESSION['user']->role == 'admin') ): ?>

<?php else:?>
  <div class="navbar bg-base-100">
  <div class="navbar-start">
  <div class="dropdown">
      <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /></svg>
      </div>
      <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
        <li><a>Item 1</a></li>
        <li>
          <a>Parent</a>
          <ul class="p-2">
            <li><a>Submenu 1</a></li>
            <li><a>Submenu 2</a></li>
          </ul>
        </li>
        <li><a>Item 3</a></li>
      </ul>
    </div>
  </div>
  <div class="navbar-center hidden md:block">    
    <a class="btn btn-ghost text-xl">turboMARKET</a>
  </div>
  <div class="navbar-end">
  <button class="btn btn-neutral" onclick="authenticate.showModal()">Sign In</button>
    <dialog id="authenticate" class="modal modal-bottom sm:modal-middle">
      <div class="modal-box">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
      </form>
      <h3 class="font-bold text-lg">Wellcome back!</h3>
      <form action="./private/login.php" method="POST">
        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Identifier:</span>
            <span class="label-text-alt">email</span>
          </div>
          <input type="text" name="identifier" placeholder="Your identification" class="input input-bordered w-full" />
          <div class="label">
            <span class="label-text-alt">username</span>
            <span class="label-text-alt">phone number</span>
          </div>
        </label>
        <input type="text" name="auth-pass" placeholder="Password" class="input input-bordered grow w-full" />
        <button type="submit" class="btn btn-primary w-full mt-4">Sign In</button>
      </form>
      </div>
    </dialog>

    <button class="btn btn-primary ml-2" onclick="register.showModal()">Sign Up</button>
    <dialog id="register" class="modal modal-bottom sm:modal-middle">
      <div class="modal-box w-11/12 max-w-5xl">
      <form method="dialog">
        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
      </form>
      <h3 class="font-bold text-lg">Register to fully experience our platform</h3>
      <form action="./private/register.php" method="POST">
          <div class="flex gap-2 my-2">
            <input type="text" name="first-name" placeholder="First name" class="input input-bordered grow w-full max-w-xs" />
            <input type="text" name="last-name"placeholder="Last name" class="input input-bordered grow w-full max-w-xs" />
          </div>
          <div class="flex gap-2 my-2">
            <input type="text" name="username" placeholder="Username" class="input input-bordered  w-full" />
          </div>
          <div class="flex gap-2 my-2">
            <input type="text" name="email" placeholder="Email" class="input input-bordered  w-full" />
          </div>
          <div class="flex gap-2 my-2">
            <input type="text" name="password" placeholder="Password" class="input input-bordered grow w-full" />
          </div>
          <div class="flex gap-2 my-2">
            <input type="text" name="confirm-password"placeholder="Confirm Password" class="input input-bordered grow w-full" />
          </div>
          <div class="flex gap-2 my-4">
            <label class="form-control w-full max-w-xs">
             <input type="text" name="phone" placeholder="Phone number" class="input input-bordered grow w-full max-w-xs" />
              <div class="label">
                <span class="label-text-alt">+123456789</span>
                <span class="label-text-alt">Optional</span>
              </div>
            </label>
            <label class="form-control w-full max-w-xs">
            <input type="text" name="company" placeholder="Company" class="input input-bordered grow w-full max-w-xs" />
            <div class="label">
              <span class="label-text-alt"></span>
              <span class="label-text-alt">Optional</span>
            </div>
            </label>
          </div>
          <div class="flex gap-2">
            <button type="submit" class="btn btn-primary w-full">Sign Up</button>
          </div>
      </form>
      </div>
    </dialog>

  </div>
</div>
<?php endif;?>