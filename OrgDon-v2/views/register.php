<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register Page</title>
	<link rel="stylesheet" href="../static/css/registerStyle.css">
</head>
<body class="font-calibri min-h-dvh flex justify-center items-center px-2 bg-slate-50">
	<main class="flex flex-row justify-around items-center w-full max-w-[800px] h-full rounded-xl shadow-lg p-4 gap-1 m-2 bg-slate-100 border-[0.5px] border-slate-200">
		<!-- Pop-up -->
			<?php if(!empty($flash)): ?>
			<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" id="pop-up">
				<div class="bg-white p-8 rounded shadow-2xl max-w-md w-full text-center relative animate-fade-in">
					<!-- Icon -->
					<div class="flex justify-center mb-4">
						<?php if (isset($flash['success'])): ?>
							<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="stroke-green-500"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
						<?php elseif (isset($flash['error'])): ?>
							<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="stroke-red-500"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
						<?php elseif (isset($flash['emailExist'])): ?>
							<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="stroke-yellow-500"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
						<?php endif; ?>
					</div>
					<!-- Message -->
					<h2 class="text-2xl font-bold mb-2">
						<?php
							if (isset($flash['success'])) {
								echo 'Success!';
							} elseif (isset($flash['error'])) {
								echo 'Error!';
							} elseif (isset($flash['emailExist'])) {
								echo 'Email Exists!';
							}
						?>
					</h2>

					<!-- Sub Message -->
					<p class="text-gray-600 mb-6">
						<?php
							echo reset($flash); // gets the first value inside flash array
						?>
					</p>

					<!-- Buttons -->
					<div class="flex gap-4 justify-center">
						<a href="/orgdon-v2/auth/login" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Go to Login</a>
						<button onclick="closePopup()" class="px-6 py-2 border border-gray-300 rounded hover:bg-gray-100 transition">Stay Here</button>
					</div>
			
					<!-- Close button (optional) -->
					<button onclick="closePopup()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="stroke-slate-800 hover:stroke-red-600"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
					</button>

				</div>
			</div>
			<?php endif; ?>
		<!-- end -->
		<div class="max-w-1/2 hidden sm:flex justify-center items-center">
			<img src="../static/image/OrgDonLogo.png" alt="Logo Image" class="max-w-80">
		</div>
		<div class="max-w-1/2 flex flex-col justify-center items-center">
			<div class="w-full flex flex-row justify-end items-center p-4 mx-3 text-sm">
				new to Ayurdana ? &nbsp; <a href="/orgdon-v2/auth/login" class="bg-slate-100 text-blue-700 border-[1px] border-blue-700 rounded px-2 py-[2px] font-semibold hover:bg-blue-700 hover:text-slate-100 hover:border-blue-700">Login</a>
			</div>
			<div class="p-4 rounded-md shadow-md border-[0.5px] border-slate-200 w-full max-w-80 bg-slate-50">
				<form action="" method="POST" class="flex flex-col gap-2 justify-center items-center">
					<span class="rounded-full border-t-[2px] border-blue-400 p-2">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-blue-400"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="10" r="3"/><path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"/></svg>
					</span>
					<h1 class="text-2xl font-semibold">Welcome to the Ayurdana</h1>
					<p class="text-sm mt-[-10px]">Enter you details to sign-up.</p>
					<div class="gap-1 w-full max-w-80">
						<label for="emailI" class="font-semibold">Email</label>
						<div class="flex flex-row justify-start items-center border-slate-500 rounded border-[1.5px] p-1 gap-1 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 group">
							<!-- Icon Here -->
							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-slate-500 group-focus-within:stroke-blue-400"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
							<input type="email" required placeholder="e.g: abc@example.com" name="emailI" id="emailI" class="flex-1 outline-none bg-slate-50">
						</div>
					</div>
					<div class="gap-1 w-full max-w-80">
						<label for="passwordI" class="font-semibold">Password</label>
						<div class="flex flex-row justify-start items-center border-slate-500 rounded border-[1.5px] p-1 gap-1 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 group">
							<!-- Icon Here -->
							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-slate-500 group-focus-within:stroke-blue-400"><circle cx="12" cy="16" r="1"/><rect x="3" y="10" width="18" height="12" rx="2"/><path d="M7 10V7a5 5 0 0 1 10 0v3"/></svg>
							<input type="password" required name="passwordI" id="passwordI" class="flex-1 outline-none bg-slate-50" placeholder="Enter a strong password">
						</div>
					</div>
					<div class="gap-1 w-full max-w-80">
						<label for="confirmPassI" class="font-semibold">Confirm password</label>
						<div class="flex flex-row justify-start items-center border-slate-500 rounded border-[1.5px] p-1 gap-1 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 group">
							<!-- Icon Here -->
							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-slate-500 group-focus-within:stroke-blue-400"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg>
							<input type="text" required name="confirmPassI" id="confirmPassI" class="flex-1 outline-none bg-slate-50" placeholder="Same as Password">
						</div>
					</div>
					<div class="gap-1 w-full max-w-80">
						<label for="fullname" class="font-semibold">Fullname</label>
						<div class="flex flex-row justify-start items-center border-slate-500 rounded border-[1.5px] p-1 gap-1 focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 group">
							<!-- Icon Here -->
							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-slate-500 group-focus-within:stroke-blue-400"><path d="M16 10h2"/><path d="M16 14h2"/><path d="M6.17 15a3 3 0 0 1 5.66 0"/><circle cx="9" cy="11" r="2"/><rect x="2" y="5" width="20" height="14" rx="2"/></svg>
							<input type="text" required name="fullname" id="fullname" class="flex-1 outline-none bg-slate-50" placeholder="e.g: Dr. Joseph Murray">
						</div>
					</div>
					<div class="gap-1 w-full max-w-80">
						<label class="font-semibold">Role</label>
						<div class="flex flex-row justify-start items-center py-1 gap-1">
							<input type="radio" name="role" value="doctor" id="doctorRadio">
							<label for="doctorRadio" class="font-semibold mr-1">Doctor</label>
							<input type="radio" name="role" value="user" id="userRadio" checked>
							<label for="userRadio" class="font-semibold mr-1">User</label>						
						</div>
					</div>
					<button type="submit" class="w-full p-2 font-semibold bg-blue-600 hover:bg-blue-700 rounded text-slate-50">Sign Up</button>
				</form>
			</div>
			<div class="w-full flex justify-center text-sm font-semibold p-1">
				<p class="p-1">&copy; 2025 ayurdana.org - Where Life Finds a Second Chance.</p>
			</div>
		</div>
	</main>
	<script type="text/javascript">
		function closePopup() {
        	document.getElementById('pop-up').remove();
		}
	</script>
</body>
</html>