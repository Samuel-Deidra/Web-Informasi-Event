// ========================================
// TAB SWITCHING LOGIC
// ========================================

// Get tab elements
const tabEvent = document.getElementById('tabEvent');
const tabHistory = document.getElementById('tabHistory');

// Get section elements
const eventSection = document.getElementById('eventSection');
const historySection = document.getElementById('historySection');

// Get table actions (Add Event button and Search box)
const tableActions = document.getElementById('tableActions');

// Function to show Event tab
function showEventTab() {
    historySection.style.display = 'none';
    eventSection.style.display = 'block';
    tableActions.style.display = 'block';
    
    tabEvent.classList.add('active');
    tabHistory.classList.remove('active');
}

// Function to show History tab
function showHistoryTab() {
    eventSection.style.display = 'none';
    historySection.style.display = 'block';
    tableActions.style.display = 'none';
    
    tabHistory.classList.add('active');
    tabEvent.classList.remove('active');
}

// Add click event listeners
tabEvent.addEventListener('click', (e) => {
    e.preventDefault();
    showEventTab();
});

tabHistory.addEventListener('click', (e) => {
    e.preventDefault();
    showHistoryTab();
});

// Initialize: Show Event tab by default
showEventTab();


// ========================================
// USER DROPDOWN LOGIC
// ========================================
const userIcon = document.getElementById('userIcon');
const logoutMenu = document.getElementById('logoutMenu');

userIcon.addEventListener('click', (e) => {
    e.stopPropagation();
    logoutMenu.classList.toggle('show');
});

document.addEventListener('click', (e) => {
    if (!userIcon.contains(e.target) && !logoutMenu.contains(e.target)) {
        logoutMenu.classList.remove('show');
    }
});


// ========================================
// MODAL LOGIC (Add/Edit Event)
// ========================================
const addEventBtn = document.getElementById('addEvent-Btn');
const eventModal = document.getElementById('eventModal');
const cancelBtn = document.getElementById('cancelBtn');
const nextBtn = document.getElementById('nextBtn');
const backBtn = document.getElementById('backBtn');
const formStep1 = document.getElementById('formStep1');
const formStep2 = document.getElementById('formStep2');

addEventBtn.addEventListener('click', () => {
    eventModal.style.display = 'flex';
    formStep1.classList.add('active');
    formStep2.classList.remove('active');
    document.getElementById('modalTitle').textContent = 'Add New Event';
});

cancelBtn.addEventListener('click', () => {
    eventModal.style.display = 'none';
});

nextBtn.addEventListener('click', () => {
    const dateInput = document.getElementById('dateInput');
    const nameInput = document.getElementById('nameInput');
    const feeInput = document.getElementById('feeInput');
    
    if (!dateInput.value || !nameInput.value || !feeInput.value) {
        alert('Please fill in all required fields');
        return;
    }
    
    formStep1.classList.remove('active');
    formStep2.classList.add('active');
});

backBtn.addEventListener('click', () => {
    formStep2.classList.remove('active');
    formStep1.classList.add('active');
});

eventModal.addEventListener('click', (e) => {
    if (e.target === eventModal) {
        eventModal.style.display = 'none';
    }
});


// ========================================
// EVENT TABLE - TOGGLE DESCRIPTION ON CLICK
// ========================================
const eventRows = document.querySelectorAll('.data-row');

eventRows.forEach((row) => {
    row.addEventListener('click', (e) => {
        // Don't trigger if clicking buttons
        if (e.target.tagName === 'BUTTON') return;
        
        const descRow = row.nextElementSibling;
        const descBox = descRow ? descRow.querySelector('.desc-box') : null;
        
        if (!descBox) return;

        // Close all other descriptions in event list
        document.querySelectorAll('.event-list .desc-box').forEach(box => {
            if (box !== descBox) box.classList.remove('active');
        });

        // Toggle current description
        descBox.classList.toggle('active');
    });
});


// ========================================
// HISTORY TABLE - TOGGLE DESCRIPTION ON CLICK
// ========================================
const historyRows = document.querySelectorAll('.history-data-row');

historyRows.forEach((row) => {
    row.addEventListener('click', (e) => {
        // Don't trigger if clicking buttons
        if (e.target.tagName === 'BUTTON') return;
        
        const descRow = row.nextElementSibling;
        const descBox = descRow ? descRow.querySelector('.desc-box') : null;
        
        if (!descBox) return;

        // Close all other descriptions in history list
        document.querySelectorAll('.history-list .desc-box').forEach(box => {
            if (box !== descBox) box.classList.remove('active');
        });

        // Toggle current description
        descBox.classList.toggle('active');
    });
});


// ========================================
// SEARCH FUNCTIONALITY
// ========================================
const searchInput = document.getElementById('searchInput');
const searchBtn = document.getElementById('searchBtn');
const dataRows = document.querySelectorAll('.data-row');

function searchEvents() {
    const searchTerm = searchInput.value.toLowerCase().trim();
    
    dataRows.forEach((row) => {
        const eventName = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
        const eventType = row.querySelector('td:nth-child(7)').textContent.toLowerCase();
        const descRow = row.nextElementSibling;
        
        if (eventName.includes(searchTerm) || eventType.includes(searchTerm)) {
            row.style.display = '';
            if (descRow && descRow.classList.contains('desc-row')) {
                descRow.style.display = '';
            }
        } else {
            row.style.display = 'none';
            if (descRow && descRow.classList.contains('desc-row')) {
                descRow.style.display = 'none';
            }
        }
    });
}

searchBtn.addEventListener('click', searchEvents);

searchInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
        searchEvents();
    }
});

searchInput.addEventListener('input', (e) => {
    if (e.target.value === '') {
        dataRows.forEach((row) => {
            row.style.display = '';
            const descRow = row.nextElementSibling;
            if (descRow && descRow.classList.contains('desc-row')) {
                descRow.style.display = '';
            }
        });
    }
});


// ========================================
// DELETE BUTTON FUNCTIONALITY
// ========================================
const deleteButtons = document.querySelectorAll('.delete');

deleteButtons.forEach((btn) => {
    btn.addEventListener('click', (e) => {
        e.stopPropagation(); // Prevent row click
        
        const row = e.target.closest('.data-row');
        const eventName = row.querySelector('td:nth-child(4)').textContent;
        
        if (confirm(`Are you sure you want to delete "${eventName}"?`)) {
            const descRow = row.nextElementSibling;
            row.remove();
            if (descRow && descRow.classList.contains('desc-row')) {
                descRow.remove();
            }
            alert('Event deleted successfully!');
        }
    });
});

// Delete buttons for History
const deleteHistoryButtons = document.querySelectorAll('.delete-history');

deleteHistoryButtons.forEach((btn) => {
    btn.addEventListener('click', (e) => {
        e.stopPropagation(); // Prevent row click
        
        const row = e.target.closest('.history-data-row');
        const eventName = row.querySelector('td:nth-child(4)').textContent;
        
        if (confirm(`Are you sure you want to permanently delete "${eventName}" from history?`)) {
            const descRow = row.nextElementSibling;
            row.remove();
            if (descRow && descRow.classList.contains('history-desc-row')) {
                descRow.remove();
            }
            alert('History record deleted successfully!');
        }
    });
});


// ========================================
// EDIT BUTTON FUNCTIONALITY
// ========================================
const editButtons = document.querySelectorAll('.edit');

editButtons.forEach((btn) => {
    btn.addEventListener('click', (e) => {
        e.stopPropagation(); // Prevent row click
        
        const row = e.target.closest('.data-row');
        
        const date = row.querySelector('td:nth-child(2)').textContent;
        const eventName = row.querySelector('td:nth-child(4)').textContent;
        const fee = row.querySelector('td:nth-child(5)').textContent;
        const status = row.querySelector('td:nth-child(6)').textContent;
        const type = row.querySelector('td:nth-child(7)').textContent;
        
        document.getElementById('dateInput').value = date;
        document.getElementById('nameInput').value = eventName;
        document.getElementById('feeInput').value = fee;
        document.getElementById('statusInput').value = status;
        document.getElementById('typeInput').value = type;
        
        document.getElementById('modalTitle').textContent = 'Edit Event';
        
        eventModal.style.display = 'flex';
        formStep1.classList.add('active');
        formStep2.classList.remove('active');
    });
});