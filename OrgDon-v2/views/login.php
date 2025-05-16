<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login Page</title>
	<link rel="stylesheet" href="../static/css/loginStyle.css">
</head>
<body class="font-calibri min-h-dvh flex justify-center items-center px-2 bg-slate-50">
	<main class="flex flex-row justify-around items-center w-full max-w-[800px] h-full rounded-xl shadow-lg p-4 gap-1 m-2 bg-slate-100 border-[0.5px] border-slate-200">
		<!-- Pop-up -->
		<?php if(!empty($flash)): ?>
		<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" id="pop-up">
			<div class="bg-white p-8 rounded shadow-2xl max-w-md w-full text-center relative animate-fade-in">
				<!-- Icon -->
				<div class="flex justify-center mb-4">
					<?php if (isset($flash['error'])): ?>
						<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="stroke-red-500"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
					<?php endif; ?>
				</div>
				<!-- Message -->
				<h2 class="text-2xl font-bold mb-2">
					<?php
						if (isset($flash['error'])) {
							echo 'Error!';
						}
					?>
				</h2>

				<!-- Sub Message -->
				<p class="text-gray-600 mb-6">
					<?php
						echo reset($flash);
					?>
				</p>

				<!-- Buttons -->
				<div class="flex gap-4 justify-center">
					<button onclick="closePopup()" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition w-full">Ok</button>
				</div>
			</div>
		</div>
		<?php endif; ?>
	<!-- end -->
		<div class="max-w-1/2 hidden sm:flex justify-center items-center">
			<img src="../static/image/OrgDonLogo.png" alt="Logo Image" class="max-w-80">
		</div>
		<div class="max-w-1/2 flex flex-col justify-center items-center">
			<div class="w-full flex flex-row justify-end items-center p-4 mx-3 text-sm">
				new to Ayurdana ? &nbsp; <a href="/orgdon-v2/auth/register" class="bg-slate-100 text-blue-700 border-[1px] border-blue-700 rounded px-2 py-[2px] font-semibold hover:bg-blue-700 hover:text-slate-100 hover:border-blue-700">Register</a>
			</div>
			<div class="p-4 rounded-md shadow-md border-[0.5px] border-slate-200 w-full max-w-80 bg-slate-50">
				<form action="" method="POST" class="flex flex-col gap-3 justify-center items-center">
					<span class="rounded-full border-t-[2px] border-blue-400 p-2">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-blue-400"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="10" r="3"/><path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"/></svg>
					</span>
					<h1 class="text-2xl font-semibold">Login to you account</h1>
					<p class="text-sm mt-[-10px]">Enter you details to login.</p>
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
							<input type="password" required name="passwordI" id="passwordI" class="flex-1 outline-none bg-slate-50">
							<button id="passEye" type="button">
								<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-slate-500 group-focus-within:stroke-blue-400"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
							</button>
						</div>
					</div>
					<div class="flex justify-end items-center w-full">
						<a href="/orgdon-v2/auth/forgotPass" class="text-blue-600 hover:underline font-semibold">Forgot password?</a>
					</div>
					<button type="submit" class="w-full p-2 font-semibold bg-blue-600 hover:bg-blue-700 rounded text-slate-50">Sign In</button>
				</form>
			</div>
			<div class="w-full flex justify-center text-sm font-semibold p-1">
				<p class="p-1">&copy; 2025 ayurdana.org - Where Life Finds a Second Chance.</p>
			</div>
		</div>
	</main>
	<script type="text/javascript">
		const passI = document.getElementById('passwordI');
		const eyeBtn = document.getElementById('passEye');
		eyeBtn.addEventListener('click', () => {
			if(passI.type === 'password') {
				passI.type = 'text';
				eyeBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-slate-500 group-focus-within:stroke-blue-400"><path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"/><path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"/><path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"/><path d="m2 2 20 20"/></svg>`;
			} else {
				passI.type = 'password';
				eyeBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-slate-500 group-focus-within:stroke-blue-400"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>`;
			}
		});
	</script>
	<script type="text/javascript">
		function closePopup() {
        	document.getElementById('pop-up').remove();
		}
	</script>
</body>
</html>