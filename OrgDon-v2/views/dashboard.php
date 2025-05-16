<?php
    function getRandomTailwindBgColor() {
        $colors = [
            'bg-blue-500', 'bg-purple-500', 'bg-indigo-500', 'bg-teal-500', 'bg-orange-500', 'bg-lime-500', 'bg-emerald-500', 'bg-cyan-500'
        ];

        return $colors[array_rand($colors)];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dashboard</title>
	<link rel="stylesheet" href="./static/css/dashboardStyle.css">
</head>
<body class="font-calibri bg-white">
    <!-- Header start -->
    <header class="bg-white w-full py-1 sm:px-5 px-1 shadow-sm border-b-[1px] border-slate-200 flex flex-row justify-between items-center sticky top-0 left-0">
        <div class="flex flex-row justify-center items-center">
            <img src="./static/image/OrgDonLogo.png" width="60" alt="logoImage" class="hidden sm:flex">
        </div>
        <div class="flex flex-row justify-center items-center gap-2">
            <div class="justify-center flex items-center p-1 rounded-md border border-slate-200 hover:bg-slate-50 w-[54px] h-[54px] cursor-not-allowed" title="Notification">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-slate-700"><path d="M10.268 21a2 2 0 0 0 3.464 0"/><path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326"/></svg>
            </div>
            <div class="flex justify-center items-center" id="profileBtn">
                <button class="justify-center flex flex-row items-center py-1 px-2 rounded-md border border-slate-200 gap-2 hover:bg-slate-50">
                    <span class="rounded-full w-10 h-10 flex justify-center items-center font-bold font-sans text-xl text-slate-50 <?= getRandomTailwindBgColor(); ?>"><?= strtoupper(substr($_SESSION['log_cred']['full_name'], 0, 1)) ?></span>
                    <span class="h-[80%] flex flex-col justify-around items-start">
                        <span class="font-semibold"><?= $_SESSION['log_cred']['full_name'] ?></span>
                        <span class="text-sm text-slate-400"><?= $_SESSION['log_cred']['role'] ?></span>
                    </span>
                    <span id="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="stroke-slate-600"><path d="m6 9 6 6 6-6"/></svg>
                    </span>
                </button>
            </div>
        </div>
        <!-- Profile Menu Start -->
        <div id="menuProfile" class="hidden z-30 absolute flex flex-col gap-1 top-[66px] sm:top-[72px] bg-white shadow-sm right-1 sm:right-5 rounded-md border border-slate-200 py-2 px-1 w-[248px]">
            <a href="/orgdon-v2/logout" class="w-full flex flex-row justify-start items-center px-2 py-1 cursor-pointer gap-1.5 hover:bg-slate-100 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-slate-900"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                <span class="flex-1 font-semibold text-slate-900">Logout</span>
            </a>
        </div>
    </header>
    <!-- Header End -->
    <main class="h-full">
	    <?php
		    $showHealthPopup = empty($_SESSION['log_cred']['health_id']);
	    ?>
	<!-- Your normal Dashboard HTML -->
    
    <!-- Dashboard Widgets Section -->
<section class="p-6">
    <h2 class="text-2xl font-semibold mb-4 text-slate-800">Welcome, <?= $_SESSION['log_cred']['full_name'] ?> 👋</h2>
    
    <div class="grid sm:grid-cols-2 md:grid-cols-3 grid-cols-1 gap-6">
        <!-- Register as Donor -->
        <div onclick="openPopup('registerDonorPopup')" class="cursor-pointer p-6 rounded-lg shadow hover:shadow-lg transition border border-slate-200 bg-white flex items-center gap-4 hover:bg-blue-50">
            <div class="p-3 bg-blue-100 rounded-full">
                <!-- Heart Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 stroke-blue-600"><path d="M11 14h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 16"/><path d="m7 20 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9"/><path d="m2 15 6 6"/><path d="M19.5 8.5c.7-.7 1.5-1.6 1.5-2.7A2.73 2.73 0 0 0 16 4a2.78 2.78 0 0 0-5 1.8c0 1.2.8 2 1.5 2.8L16 12Z"/></svg>
            </div>
            <div>
                <h3 class="font-semibold text-lg text-slate-800">Become a Donor</h3>
                <p class="text-sm text-slate-500">Register and save lives</p>
            </div>
        </div>

        <!-- View Donation Status -->
        <div onclick="openPopup('donationStatusPopup')" class="cursor-pointer p-6 rounded-lg shadow hover:shadow-lg transition border border-slate-200 bg-white flex items-center gap-4 hover:bg-green-50">
            <div class="p-3 bg-green-100 rounded-full">
                <!-- Check Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 stroke-blue-600"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></svg>
            </div>
            <div>
                <h3 class="font-semibold text-lg text-slate-800">Donation Status</h3>
                <p class="text-sm text-slate-500">Track your donations</p>
            </div>
        </div>

        <!-- Edit Health Profile -->
        <div onclick="openPopup('healthProfilePopup')" class="cursor-pointer p-6 rounded-lg shadow hover:shadow-lg transition border border-slate-200 bg-white flex items-center gap-4 hover:bg-yellow-50">
            <div class="p-3 bg-yellow-100 rounded-full">
                <!-- Edit Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 stroke-yellow-600"><path d="M12 20h9"/><path d="M16.376 3.622a1 1 0 0 1 3.002 3.002L7.368 18.635a2 2 0 0 1-.855.506l-2.872.838a.5.5 0 0 1-.62-.62l.838-2.872a2 2 0 0 1 .506-.854z"/></svg>
            </div>
            <div>
                <h3 class="font-semibold text-lg text-slate-800">Health Profile</h3>
                <p class="text-sm text-slate-500">Update medical data</p>
            </div>
        </div>

        <!-- View Donation History -->
        <div onclick="openPopup('donationHistoryPopup')" class="cursor-pointer p-6 rounded-lg shadow hover:shadow-lg transition border border-slate-200 bg-white flex items-center gap-4 hover:bg-purple-50">
            <div class="p-3 bg-purple-100 rounded-full">
                <!-- Clock Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 stroke-violet-600"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M12 7v5l4 2"/></svg>
            </div>
            <div>
                <h3 class="font-semibold text-lg text-slate-800">Donation History</h3>
                <p class="text-sm text-slate-500">Your past records</p>
            </div>
        </div>

        <!-- Awareness -->
        <div onclick="openPopup('awarenessPopup')" class="cursor-pointer p-6 rounded-lg shadow hover:shadow-lg transition border border-slate-200 bg-white flex items-center gap-4 hover:bg-orange-50">
            <div class="p-3 bg-orange-100 rounded-full">
                <!-- Info Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 stroke-orange-600"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
            </div>
            <div>
                <h3 class="font-semibold text-lg text-slate-800">Awareness</h3>
                <p class="text-sm text-slate-500">Learn & educate</p>
            </div>
        </div>

        <!-- Support -->
        <div onclick="openPopup('supportPopup')" class="cursor-pointer p-6 rounded-lg shadow hover:shadow-lg transition border border-slate-200 bg-white flex items-center gap-4 hover:bg-red-50">
            <div class="p-3 bg-red-100 rounded-full">
                <!-- Help Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 stroke-red-600"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
            </div>
            <div>
                <h3 class="font-semibold text-lg text-slate-800">Support</h3>
                <p class="text-sm text-slate-500">Get help anytime</p>
            </div>
        </div>
    </div>
</section>
<!-- widget PopUp Modals-->
<!-- Register Donor Popup -->
<div id="registerDonorPopup" class="hidden fixed inset-0 z-50 bg-black bg-opacity-60 flex items-center justify-center overflow-x-auto">
    <div class="bg-white p-6 rounded-md shadow-lg w-full max-w-lg relative">
        <h2 class="text-2xl font-semibold text-blue-700 mb-4">Register as a Donor</h2>

        <form action="/orgdon-v2/register-donor" method="POST" class="space-y-4">
            <div>
                <label for="organ_type" class="block text-sm font-medium text-slate-700">Select Organ</label>
                <select name="organ_type" id="organ_type" required class="w-full border border-slate-300 rounded py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Choose Organ --</option>
                    <option value="Kidney">Kidney</option>
                    <option value="Liver">Liver</option>
                    <option value="Heart">Heart</option>
                    <option value="Lungs">Lungs</option>
                </select>
            </div>

            <div>
                <label for="availability" class="block text-sm font-medium text-slate-700">Availability</label>
                <input type="text" name="availability" id="availability" required placeholder="e.g., Available in 2 weeks" class="w-full border border-slate-300 rounded py-2 px-3">
            </div>

            <div>
                <label for="mobile_number" class="block text-sm font-medium text-gray-700">Mobile Number</label>
                <input type="text" name="mobile_number" id="mobile_number" required
                placeholder="Enter your 10-digit mobile number"
                pattern="[0-9]{10}"
                class="w-full border border-slate-300 rounded py-2 px-3 mt-1">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div>
                    <label for="city" class="block text-sm font-medium text-slate-700">City</label>
                    <input type="text" name="city" id="city" class="w-full border border-slate-300 rounded py-2 px-3">
                </div>
                <div>
                    <label for="state" class="block text-sm font-medium text-slate-700">State</label>
                    <input type="text" name="state" id="state" class="w-full border border-slate-300 rounded py-2 px-3">
                </div>
                <div>
                    <label for="country" class="block text-sm font-medium text-slate-700">Country</label>
                    <input type="text" name="country" id="country" value="India" class="w-full border border-slate-300 rounded py-2 px-3">
                </div>
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-slate-700">Additional Notes (Optional)</label>
                <textarea name="notes" id="notes" rows="3" placeholder="Any health condition, message, etc." class="w-full border border-slate-300 rounded py-2 px-3 resize-none"></textarea>
            </div>

            <div class="flex justify-end gap-2 pt-4">
                <button type="button" onclick="closePopup('registerDonorPopup')" class="px-4 py-2 text-slate-700 hover:bg-slate-100 rounded">Cancel</button>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- Donation Status -->
<!-- Donation Status Modal -->
<div id="donationStatusPopup" class="hidden fixed inset-0 z-50 bg-black bg-opacity-60 flex items-center justify-center overflow-x-auto">
    <div class="bg-white p-6 rounded-md shadow-lg w-full max-w-2xl relative overflow-y-auto max-h-[90vh]">
        <h2 class="text-2xl font-semibold text-green-700 mb-4">My Donation Status</h2>
        <?php
        $validDonations = array_filter($donations, fn($donation) => !empty($donation['organ_type']));
        ?>

        <?php if (!empty($validDonations)): ?>
            <div class="space-y-4">
                <?php foreach ($validDonations as $donation): ?>
                    <div class="border border-green-300 rounded-lg p-4 bg-green-50 shadow-sm">
                        <ul class="text-slate-700 space-y-1">
                            <li><strong>Organ:</strong> <?= htmlspecialchars($donation['organ_type']) ?></li>
                            <li><strong>Status:</strong> <?= htmlspecialchars($donation['donation_status']) ?></li>
                            <li><strong>Registered on:</strong> <?= htmlspecialchars($donation['created_at']) ?></li>
                            <li><strong>Mobile:</strong> <?= htmlspecialchars($donation['mobile_number']) ?></li>
                            <li><strong>Location:</strong> 
                                <?= htmlspecialchars($donation['city'] . ', ' . $donation['state'] . ', ' . $donation['country']) ?>
                            </li>
                            <?php if (!empty($donation['notes'])): ?>
                                <li><strong>Notes:</strong> <?= htmlspecialchars($donation['notes']) ?></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-slate-600">No organ donations have been registered yet.</p>
        <?php endif; ?>

        <div class="text-right pt-4">
        <button onclick="closePopup('donationStatusPopup')" class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Close</button>
    </div>
</div>
</div>

<!-- Health Profile Modal -->
<div id="healthProfilePopup" class="hidden fixed inset-0 z-50 bg-black bg-opacity-60 flex items-center justify-center overflow-x-auto">
    <div class="bg-white p-6 rounded-md shadow-lg w-full max-w-lg relative">
        <h2 class="text-2xl font-semibold text-indigo-700 mb-4">My Health Profile</h2>
        <?php $health = $health[0] ?>
        <form action="/orgdon-v2/update-health" method="POST" class="space-y-4">
            <input type="hidden" name="user_id" value="<?= $_SESSION['log_cred']['user_id'] ?>">

            <div>
                <label class="block text-sm font-medium">Blood Group</label>
                <select name="blood_group" class="w-full border rounded py-2 px-3" required>
    <?php
    $blood_groups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'rhNull'];
    foreach ($blood_groups as $group):
        $selected = ($health['blood_group'] ?? '') === $group ? 'selected' : '';
    ?>
        <option value="<?= $group ?>" <?= $selected ?>><?= $group ?></option>
    <?php endforeach; ?>
</select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Diabetic?</label>
                    <select name="is_diabetic" class="w-full border rounded py-2 px-3">
                        <option value="No" <?= $health['is_diabetic'] === 'No' ? 'selected' : '' ?>>No</option>
                        <option value="Yes" <?= $health['is_diabetic'] === 'Yes' ? 'selected' : '' ?>>Yes</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Cancer?</label>
                    <select name="is_cancer" class="w-full border rounded py-2 px-3">
                        <option value="No" <?= $health['is_cancer'] === 'No' ? 'selected' : '' ?>>No</option>
                        <option value="Yes" <?= $health['is_cancer'] === 'Yes' ? 'selected' : '' ?>>Yes</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium">Other Notes</label>
                <textarea name="other_notes" class="w-full border rounded py-2 px-3"><?= htmlspecialchars($health['other_notes']) ?></textarea>
            </div>

            <div class="flex justify-end pt-4 gap-2">
                <button type="button" onclick="closePopup('healthProfilePopup')" class="px-4 py-2 text-slate-700 hover:bg-slate-100 rounded">Cancel</button>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Update Profile</button>
            </div>
        </form>
    </div>
</div>


<!-- Donation History Modal -->
<div id="donationHistoryPopup" class="hidden fixed inset-0 z-50 bg-black bg-opacity-60 flex items-center justify-center">
    <div class="bg-white p-6 rounded-md shadow-lg w-full max-w-md relative">
        <h2 class="text-2xl font-semibold text-indigo-700 mb-4">Donation History</h2>

        <div class="text-gray-600 text-center py-6">
            <p>Your donation history will appear here once you’ve made a donation.</p>
        </div>

        <div class="flex justify-end pt-4">
            <button onclick="closePopup('donationHistoryPopup')" class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Close</button>
        </div>
    </div>
</div>

<!-- Awareness Programs Popup -->
<div id="awarenessPopup" class="hidden fixed inset-0 z-50 bg-black bg-opacity-60 flex items-center justify-center">
<div class="bg-white p-6 rounded-md shadow-lg w-full max-w-2xl relative">
    <h2 class="text-xl font-semibold text-slate-800 mb-4 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-blue-600"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/><path d="M12 5 9.04 7.96a2.17 2.17 0 0 0 0 3.08c.82.82 2.13.85 3 .07l2.07-1.9a2.82 2.82 0 0 1 3.79 0l2.96 2.66"/><path d="m18 15-2-2"/><path d="m15 18-2-2"/></svg>
        Awareness Programs
    </h2>

    <!-- Example Static List (replace with DB if needed) -->
    <ul class="space-y-3 text-slate-700">
        <li>
            <span class="font-semibold">Organ Donation Camp</span><br>
            📍 Community Hall, Sector 45 - Noida<br>
            📅 25 May 2025 — 10:00 AM
        </li>
        <li>
            <span class="font-semibold">Online Webinar: Myths about Organ Donation</span><br>
            📅 1 June 2025 — 6:00 PM<br>
            🔗 <a href="#" class="text-blue-600 underline">Join Webinar</a>
        </li>
        <li>
            <span class="font-semibold">Awareness Walk</span><br>
            📍 Cubban Park, Bangalore<br>
            📅 5 June 2025 — 8:00 AM
        </li>
    </ul>

    <div class="flex justify-end mt-6">
        <button onclick="closePopup('awarenessPopup')" class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Close</button>
    </div>
</div>
</div>

<!-- Support Popup -->
<div id="supportPopup" class="hidden fixed inset-0 z-50 bg-black bg-opacity-60 flex items-center justify-center">
<div class="bg-white p-6 rounded-md shadow-lg w-full max-w-lg relative">
    <h2 class="text-xl font-semibold text-slate-800 mb-4 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-blue-600"><path d="M13.5 19.5 12 21l-7-7c-1.5-1.45-3-3.2-3-5.5A5.5 5.5 0 0 1 7.5 3c1.76 0 3 .5 4.5 2 1.5-1.5 2.74-2 4.5-2a5.5 5.5 0 0 1 5.402 6.5"/><path d="M15 15h6"/><path d="M18 12v6"/></svg>
        Contact Support
    </h2>

    <form action="/orgdon-v2/send-support-query" method="POST" class="space-y-4">
        <div>
            <label class="text-sm font-medium text-slate-700">Subject</label>
            <input type="text" name="subject" required class="mt-1 w-full border border-slate-300 rounded px-3 py-2 focus:border-blue-500 outline-none" placeholder="Ex: Unable to update profile">
        </div>

        <div>
            <label class="text-sm font-medium text-slate-700">Message</label>
            <textarea name="message" rows="4" required class="mt-1 w-full border border-slate-300 rounded px-3 py-2 focus:border-blue-500 outline-none" placeholder="Describe your issue..."></textarea>
        </div>

        <div class="flex justify-end pt-2 gap-2">
            <button type="button" onclick="closePopup('supportPopup')" class="px-4 py-2 text-slate-700 hover:bg-slate-100 rounded">Cancel</button>
            <button type="submit" disabled class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 cursor-not-allowed" title="Still Under Developement">Send</button>
        </div>
    </form>
</div>
</div>
<!-- Widget popup modal end here -->

<!-- Doctor View -->
<!-- Doctor Tools Section -->
<?php if ($_SESSION['log_cred']['role'] === 'doctor'): ?>

    <?php
        [$allUsers, $totalUsers, $totalPages] = $paginatedData;
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    ?>
    <div class="m-6 space-y-6">
        <h2 class="text-2xl font-bold text-indigo-800">Doctor Tools</h2>

        <!-- Search Organ Widget -->
        <!-- Doctor Widgets Container -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <!-- Search Organ Widget -->
        <div class="bg-white shadow rounded p-6 border border-indigo-300 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="text-indigo-600 text-3xl">
                    <i class="fas fa-search"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-indigo-800">Search Organ</h3>
                    <p class="text-sm text-gray-600">Find organs registered for donation</p>
                </div>
            </div>
            <button onclick="setTableData()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                Search
            </button>
        </div>
        </div>

        <!-- Popup code doctorExclusiveView -->
        <div id="searchOrganPopup" class="fixed inset-0 z-50 bg-black bg-opacity-40 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-6xl relative overflow-x-auto">
        <h2 class="text-xl font-semibold mb-4 text-indigo-700">Available Organs</h2>
    
        <div class="overflow-x-auto border rounded shadow-sm">
        <table class="min-w-full text-sm text-left border border-gray-300">
            <thead class="bg-indigo-50 text-indigo-800">
                <tr>
                    <th class="border px-3 py-2">ID</th>
                    <th class="border px-3 py-2">Donor Name</th>
                    <th class="border px-3 py-2">Organ</th>
                    <th class="border px-3 py-2">Availability</th>
                    <th class="border px-3 py-2">Blood Group</th>
                    <th class="border px-3 py-2">Fit for Donation</th>
                    <th class="border px-3 py-2">Action</th>
                </tr>
            </thead>
            <tbody id="organTableBody">
                
            </tbody>
        </table>
        </div>
        <div id="paginationControls" class="flex justify-between mt-4">
            <button id="prevPageBtn" class="px-3 py-1 border rounded text-indigo-700 hover:bg-indigo-100">Previous</button>
            <button id="nextPageBtn" class="px-3 py-1 border rounded text-indigo-700 hover:bg-indigo-100">Next</button>
        </div>

        <!-- Popup for view -->
        <div id="organPopup" class="fixed inset-0 bg-black bg-opacity-40 hidden z-50 items-center justify-center">
            <div class="bg-white p-6 rounded w-full max-w-2xl shadow relative">
                <h2 class="text-xl font-semibold mb-4 text-indigo-700">Donor Details</h2>
                <div id="popupContent">
                    
                </div>
                <div class="text-right mt-4">
                    <button onclick="closePopup('organPopup')" class="px-4 py-2 text-slate-900 hover:bg-slate-100 bg-slate-50 rounded">Close</button>
                </div>
            </div>
        </div>
        <div class="text-right mt-4">
            <button onclick="closePopup('searchOrganPopup')" class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Close</button>
        </div>
    </div>
</div>

        <!-- Popup code doctorExclusiveView -->

        <!-- All Users Table Widget -->
        <div class="bg-white shadow rounded p-4 border border-indigo-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">User Health Overview</h3>
            <?php if (!empty($allUsers)): ?>
        <div class="overflow-x-auto border rounded shadow-sm">
            <table class="min-w-full text-sm text-left border border-gray-300">
                <thead class="bg-indigo-50 text-indigo-800">
                    <tr>
                        <th class="border px-3 py-2">User ID</th>
                        <th class="border px-3 py-2">Blood Group</th>
                        <th class="border px-3 py-2">Diabetic</th>
                        <th class="border px-3 py-2">Cancer</th>
                        <th class="border px-3 py-2">Fit to Donate</th>
                        <th class="border px-3 py-2">Other Notes</th>
                        <th class="border px-3 py-2">Update Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allUsers as $user): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="border px-3 py-2"><?= htmlspecialchars($user['user_id']) ?></td>
                            <td class="border px-3 py-2"><?= htmlspecialchars($user['blood_group']) ?></td>
                            <td class="border px-3 py-2"><?= ($user['is_diabetic'] === 1) ? 'Yes' : 'No' ?></td>
                            <td class="border px-3 py-2"><?= ($user['is_cancer'] === 1) ? 'Yes' : 'No' ?></td>
                            <td class="border px-3 py-2"><?= ($user['is_fit_for_donation'] === 1) ? 'Yes' : 'No' ?></td>
                            <td class="border px-3 py-2"><?= ($user['other_notes']) ?></td>
                            <td class="border px-3 py-2">
                                <form method="POST" action="/orgdon-v2/doctor/update-fit-status" class="flex gap-2 items-center">
                                    <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                    <select name="is_fit_for_donation" class="border rounded px-2 py-1">
                                        <option value="1" <?= $user['is_fit_for_donation'] === 1 ? 'selected' : '' ?>>Yes</option>
                                        <option value="0" <?= $user['is_fit_for_donation'] === 0 ? 'selected' : '' ?>>No</option>
                                    </select>
                                    <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Controls -->
        <div class="mt-4 flex justify-between items-center">
            <div class="text-sm text-gray-600">
                Showing page <?= $page ?> of <?= $totalPages ?> (<?= $totalUsers ?> users total)
            </div>
            <div class="flex gap-2">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>" class="px-3 py-1 border rounded text-indigo-700 hover:bg-indigo-100">Previous</a>
                <?php endif; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>" class="px-3 py-1 border rounded text-indigo-700 hover:bg-indigo-100">Next</a>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <p class="text-gray-500">No user health records found.</p>
    <?php endif; ?>

        </div>
    </div>
<?php endif; ?>

<!-- Doctor View -->
    <!-- Dashboard END -->
    <?php if(!empty($_SESSION['flash'])): ?>
		<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" id="pop-up">
			<div class="bg-white p-8 rounded shadow-2xl max-w-md w-full text-center relative animate-fade-in">
				<!-- Icon -->
				<div class="flex justify-center mb-4">
					<?php if (isset($_SESSION['flash']['error'])): ?>
						<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="stroke-red-500"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
					<?php elseif(isset($_SESSION['flash']['success'])): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="stroke-green-500"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                    <?php endif; ?>
				</div>
				<!-- Message -->
					<?php
						if (isset($_SESSION['flash']['error'])) {
							echo '<h2 class="text-2xl font-bold mb-2">Error</h2>';
                            echo '<p class="text-gray-600 mb-6">' . $_SESSION['flash']['error'] . '</p>';
						} elseif (isset($_SESSION['flash']['success'])) {
                            echo '<h2 class="text-2xl font-bold mb-2">Success</h2>';
                            echo '<p class="text-gray-600 mb-6">' . $_SESSION['flash']['success'] . '</p>';
                        } else {
                            // code...
                        }
					?>

				<!-- Buttons -->
				<div class="flex gap-4 justify-center">
					<button onclick="closePop()" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition w-full">Ok</button>
				</div>
			</div>
		</div>
        <?php unset($_SESSION['flash']); ?>
	<?php endif; ?>

	<?php if($showHealthPopup): ?>
		<!-- Modal Background -->
		<div id="healthModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60">
			<!-- Modal Content -->
    	<div class="relative w-full max-w-xl p-6 bg-white rounded-lg shadow-lg m-1n">
		<h2 class="text-2xl font-semibold text-slate-800 mb-4">Complete Your Health Profile</h2>
	    <form action="/orgdon-v2/complete-profile" method="POST" class="space-y-3">
            <div>
                <label for="blood_group" class="block text-sm font-medium text-slate-700">Blood Group</label>
                <select id="blood_group" name="blood_group" required class="mt-1 block w-full rounded border-slate-300 border outline-none focus:border-blue-500 py-2">
                    <option value="">Select Blood Group</option>
                    <option value="A+">A+</option>
					<option value="A-">A-</option>
					<option value="B+">B+</option>
					<option value="B+">B-</option>
					<option value="O+">O+</option>
					<option value="O-">O-</option>
					<option value="AB+">AB+</option>
					<option value="AB-">AB-</option>
					<option value="rhNull">rhNull</option>
                </select>
            </div>

            <div>
                <span class="block text-sm font-medium text-slate-700">Diabetic?</span>
                <div class="flex space-x-4 mt-1">
                    <label class="flex items-center">
                        <input type="radio" name="is_diabetic" value="1" required class="text-blue-600">
                        <span class="ml-2">Yes</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="is_diabetic" value="0" required class="text-blue-600">
                        <span class="ml-2">No</span>
                    </label>
                </div>
            </div>

            <div>
                <span class="block text-sm font-medium text-slate-700">Cancer History?</span>
                <div class="flex space-x-4 mt-1">
                    <label class="flex items-center">
                        <input type="radio" name="is_cancer" value="1" required class="text-blue-600">
                        <span class="ml-2">Yes</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="is_cancer" value="0" required class="text-blue-600">
                        <span class="ml-2">No</span>
                    </label>
                </div>
            </div>

            <div>
                <label for="other_notes" class="block text-sm font-medium text-slate-700">Other Health Notes</label>
                <textarea id="other_notes" name="other_notes" rows="3" class="mt-1 block w-full rounded border-slate-300 border outline-none focus:border-blue-500 p-2"></textarea>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Save and Continue
                </button>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>
</main>
<!-- Footer -->
<footer class="w-full flex justify-center text-sm font-semibold p-1">
    <p class="p-1">&copy; 2025 ayurdana.org - Where Life Finds a Second Chance.</p>
</footer>

<script src="/orgdon-v2/static/js/dashboard.js"></script>
</body>
</html>