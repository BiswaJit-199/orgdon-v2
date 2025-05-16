const profileMenu = document.getElementById('menuProfile');
const profileBtn = document.getElementById('profileBtn');
var currentPage = 1;
var prev = document.getElementById('prevPageBtn');
var next = document.getElementById('nextPageBtn');
let currentDonationId = "";

function closePop() {
	document.getElementById('pop-up').remove();
}

profileBtn.addEventListener('click', () => {
	profileMenu.classList.toggle('hidden');
});

function openPopup(id) {
	document.getElementById(id).classList.remove('hidden');
}

function closePopup(id) {
	document.getElementById(id).classList.add('hidden');
}

function setTableData(page=1) {
	prev.classList.remove('cursor-not-allowed');
	next.classList.remove('cursor-not-allowed');
	prev.classList.add('cursor-pointer');
	next.classList.add('cursor-pointer');

	fetch(`/orgdon-v2/api/organs?page=${page}`)
	.then(response => response.json())
	.then(data => {		
		const tbody = document.getElementById('organTableBody');
		tbody.innerHTML = '';

		data.records.forEach(organ => {
			const tr = document.createElement('tr');
			tr.className = 'hover:bg-indigo-50';
			tr.innerHTML = `
				<td class="border px-3 py-2">${organ.user_id}</td>
				<td class="border px-3 py-2">${organ.full_name}</td>
				<td class="border px-3 py-2">${organ.organ_type}</td>
				<td class="border px-3 py-2">${organ.availability}</td>
				<td class="border px-3 py-2">${organ.blood_group}</td>
				<td class="border px-3 py-2">${organ.is_fit_for_donation === 1 ? 'Yes' : 'No'}</td>
				<td class="border px-3 py-2">
					<button type="button" onclick="viewDetails('${organ.user_id}', '${organ.organ_type}')" class="text-indigo-600 hover:underline">
						<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="stroke-indigo-600"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
					</button>
				</td>
			`;
			tbody.appendChild(tr);
			currentPage = data.page;

            prev.disabled = currentPage === 1;
			if(currentPage === 1){prev.classList.remove('cursor-pointer');prev.classList.add('cursor-not-allowed');}
            next.disabled = currentPage === data.totalPages;
			if(currentPage === data.totalPages){next.classList.remove('cursor-pointer');next.classList.add('cursor-not-allowed');}
		});
		openPopup('searchOrganPopup');
	})
	.catch(err => {
		console.error("Error loading organ data:", err);
	});
}

document.getElementById('prevPageBtn').onclick = () => {
    if (currentPage > 1) setTableData(currentPage - 1);
};

document.getElementById('nextPageBtn').onclick = () => {
    setTableData(currentPage + 1);
};

function viewDetails(userId, organ_type) {
    fetch(`/orgdon-v2/api/organ-details?user_id=${userId}&organ_type=${organ_type}`)
        .then(res => res.json())
        .then(data => {
			currentDonationId = data.id; // Capture donation ID

            document.getElementById('popupContent').innerHTML = `
                <p><strong>Name:</strong> ${data.full_name}</p>
                <p><strong>Organ:</strong> ${data.organ_type}</p>
                <p><strong>Mobile:</strong> <a href='tel:+91${data.mobile_number}' class="hover:text-blue-600 hover:underline">${data.mobile_number}</a></p>
                <p><strong>Availability:</strong> ${data.availability}</p>
                <p><strong>Status:</strong> ${data.donation_status}</p>
                <p><strong>Blood Group:</strong> ${data.blood_group}</p>
                <p><strong>Notes:</strong> ${data.notes}</p>
                <p><strong>Created At:</strong> ${data.created_at}</p>
				<div class="mt-4">
					<label for="statusSelect" class="block mb-1 font-semibold text-sm">Update Donation Status:</label>
					<select id="statusSelect" class="border rounded px-3 py-2 w-full">
						<option value="Pending">Pending</option>
						<option value="Approved">Approved</option>
						<option value="Rejected">Rejected</option>
					</select>
					<button onclick="submitStatusUpdate()" class="bg-blue-600 text-white px-4 py-2 mt-3 rounded hover:bg-indigo-700">Update Status</button>
				</div>
            `;
	        document.getElementById('statusSelect').value = data.donation_status;
            document.getElementById('organPopup').classList.remove('hidden');
            document.getElementById('organPopup').classList.add('flex');
        });
}

function submitStatusUpdate() {
    const newStatus = document.getElementById('statusSelect').value;

    fetch('/orgdon-v2/api/update-donation-status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            donation_id: currentDonationId,
            donation_status: newStatus
        })
    })
    .then(res => res.json())
    .then(response => {
        alert(response.message);
        closePopup('organPopup');
        setTableData(currentPage); // refresh the table
    });
}
