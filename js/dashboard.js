// Set today's date in receipt when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    const receiptDate = document.getElementById('receipt-date');
    if (receiptDate) {
        receiptDate.innerText = new Date().toLocaleDateString();
    }
});

// Navigation Logic
function navigate(event, sectionId) {
    event.preventDefault();

    // 1. Remove active class from all sidebar links
    document.querySelectorAll('.sidebar nav a').forEach(link => {
        link.classList.remove('active');
    });

    // 2. Add active class to clicked link
    event.currentTarget.classList.add('active');

    // 3. Hide all sections
    document.querySelectorAll('.section').forEach(section => {
        section.classList.remove('active');
    });

    // 4. Show target section
    document.getElementById(sectionId).classList.add('active');

    // 5. Close sidebar on mobile after selection
    if (window.innerWidth <= 768) {
        toggleSidebar();
    }
}

// Mobile Sidebar Toggle
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.overlay');
    sidebar.classList.toggle('open');
    overlay.classList.toggle('active');
}

// Table Filter Logic
function filterTable(inputId, tableBodyId) {
    const input = document.getElementById(inputId);
    const filter = input.value.toLowerCase();
    const tbody = document.getElementById(tableBodyId);
    const rows = tbody.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('td');
        let rowText = '';
        for (let j = 0; j < cells.length; j++) {
            rowText += cells[j].textContent || cells[j].innerText;
        }

        row.style.display = rowText.toLowerCase().indexOf(filter) > -1 ? "" : "none";
    }
}

// Load Receipt Data
function loadReceipt(event, button) {
    event.preventDefault();

    // 1. Switch to Receipt Section manually
    document.querySelectorAll('.section').forEach(section => section.classList.remove('active'));
    document.getElementById('create-receipt').classList.add('active');

    // 2. Update Sidebar Active State
    document.querySelectorAll('.sidebar nav a').forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === '#create-receipt') {
            link.classList.add('active');
        }
    });

    // 3. Populate Receipt Data
    const total = parseFloat(button.getAttribute('data-total')).toFixed(2);
    const price = parseFloat(button.getAttribute('data-price')).toFixed(2);
    
    document.getElementById('receipt-date').innerText = button.getAttribute('data-date');
    document.getElementById('receipt-supplier').innerText = button.getAttribute('data-supplier');
    document.getElementById('receipt-id').innerText = '#' + button.getAttribute('data-id');
    document.getElementById('receipt-item').innerText = `${button.getAttribute('data-item')} (x${button.getAttribute('data-qty')})`;
    document.getElementById('receipt-price').innerText = '$' + price;
    document.getElementById('receipt-total').innerText = '$' + total;
}