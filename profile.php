<?php
include './private/config.php';
include './templates/header.php';
include './templates/nav.php';

if(!isset($_SESSION['user'])){
    header('Location:404.php');
}
var_dump($_SESSION['user']);
global $conn;   
    $result = $conn->query(
    "SELECT *
    FROM country
    ORDER BY `name` ASC");
?>
<h2 class="prose prose-h1 text-xl text-center mx-auto my-8">Update your personal information</h2>
<form action="./private/update-user.php" method="POST" enctype="multipart/form-data">
<div class="grid gap-4 grid-cols-1 md:grid-cols-2 px-4 mx-auto w-full max-w-[1080px]">
<label class="form-control w-full">
  <div class="label">
    <span class="label-text">First Name</span>
  </div>
<input type="text" placeholder="First Name" name="first-name" class="input input-bordered w-full" value="<?= $_SESSION['user']->first_name?>"/>
</label>
<label class="form-control w-full">
  <div class="label">
    <span class="label-text">Last Name</span>
  </div>
<input type="text" placeholder="Last Name" name="last-name" class="input input-bordered w-full" value="<?= $_SESSION['user']->last_name?>" />
    </label>
    <label class="form-control w-full">
  <div class="label">
    <span class="label-text">Username</span>
  </div>
<input type="text" placeholder="Username" name="username" class="input input-bordered w-full"  value="<?= $_SESSION['user']->username?>" />
    </label>
    <label class="form-control w-full">
  <div class="label">
    <span class="label-text">Email</span>
  </div>
<input type="text" placeholder="Email" name="email" class="input input-bordered w-full"  value="<?= $_SESSION['user']->email?>" />
    </label>
    <label class="form-control w-full">
  <div class="label">
    <span class="label-text">Phone number</span>
  </div>
<input type="text" placeholder="Phone" name="phone" class="input input-bordered w-full" value="<?= $_SESSION['user']->phone ?? '' ?>" />
    </label>
    <label class="form-control w-full">
  <div class="label">
    <span class="label-text">Company</span>
  </div>
<input type="text" placeholder="Company" name="company" class="input input-bordered w-full" value="<?= $_SESSION['user']->company ?? '' ?>" />
    </label>
    <label class="form-control w-full">
  <div class="label">
    <span class="label-text">Country</span>
  </div>
<select name="country" class="select select-bordered w-full">
  <option value="0" disabled selected>Select your country</option>
    <?php foreach ($result as $country): ?>
        <option value="<?=$country->id?>"><?=$country->name?></option>
    <?php endforeach; ?>
</select>
</label>
<label class="form-control w-full">
  <div class="label">
    <span class="label-text">City</span>
  </div>
<input type="text" placeholder="City" name="city" class="input input-bordered w-full" value="<?= $_SESSION['user']->city ?? '' ?>" />
    </label>
    <label class="form-control w-full">
  <div class="label">
    <span class="label-text">Street</span>
  </div>
<input type="text" placeholder="Street" name="street" class="input input-bordered w-full" value="<?= $_SESSION['user']->street ?? ''?>" />
    </label>
    <label class="form-control w-full">
  <div class="label">
    <span class="label-text">ZIP or Postal Code</span>
  </div>
<input type="text" placeholder="ZIP or Postal Code" name="zip" class="input input-bordered w-full" value="<?= $_SESSION['user']->zip ?? ''?>" />
    </label>
    <label class="form-control w-full">
  <div class="label">
    <span class="label-text">Appartment</span>
  </div>
<input type="text" placeholder="Apartment" name="apartment" class="input input-bordered w-full" value="<?= $_SESSION['user']->apartment ?? ''?>" />
    </label>
    <label class="form-control w-full">
  <div class="label">
    <span class="label-text">Current password</span>
  </div>
<input type="text" placeholder="Password" name="password" class="input input-bordered w-full" />
    </label>
<label class="form-control w-full">
  <div class="label">
    <span class="label-text">Upload a new profile picture</span>
  </div>
  <input type="file" name="profile" class="file-input file-input-bordered w-full" />
</label>
<label class="form-control w-full">
  <div class="label">
    <span class="label-text">Leave empty if you don't want to change</span>
  </div>
  <input type="text" placeholder="New Password" name="new-pass" class="input input-bordered w-full" />
</label>
<button type="submit" class="btn btn-primary col-span-1 md:col-span-2 w-full">Update</button>
</div>
</form>
<?php
include './templates/footer.php';

