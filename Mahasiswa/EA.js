    const tabEvent = document.getElementById("tabEvent");
    const tabHistory = document.getElementById("tabHistory");
    const eventSection = document.getElementById("eventSection");
    const historySection = document.getElementById("historySection");
    const tableActions = document.getElementById("tableActions");
    const historyFilterBar = document.getElementById("historyFilterBar");

    if (!tabEvent || !tabHistory) {
        console.error("❌ Tabs not found. Check your ID in HTML.");
        return;
    }

    function showEventTab() {
        if (eventSection) eventSection.style.display = "block";
        if (historySection) historySection.style.display = "none";
        if (tableActions) tableActions.style.display = "block";
        if (historyFilterBar) historyFilterBar.style.display = "none";
        tabEvent.classList.add("active");
        tabHistory.classList.remove("active");
    }

    function showHistoryTab() {
        if (eventSection) eventSection.style.display = "none";
        if (historySection) historySection.style.display = "block";
        if (tableActions) tableActions.style.display = "none";
        if (historyFilterBar) historyFilterBar.style.display = "block";
        tabHistory.classList.add("active");
        tabEvent.classList.remove("active");
    }

    tabEvent.addEventListener("click", (e) => {
        e.preventDefault();
        console.log("📘 Event tab clicked");
        showEventTab();
    });

    tabHistory.addEventListener("click", (e) => {
        e.preventDefault();
        console.log("📗 History tab clicked");
        showHistoryTab();
    });

    showEventTab(); // default tampilkan event


    // ======================
    // USER DROPDOWN
    // ======================
    const userIcon = document.getElementById("userIcon");
    const logoutMenu = document.getElementById("logoutMenu");

    if (userIcon && logoutMenu) {
        userIcon.addEventListener("click", (e) => {
            e.stopPropagation();
            logoutMenu.classList.toggle("show");
        });

        document.addEventListener("click", (e) => {
            if (!userIcon.contains(e.target) && !logoutMenu.contains(e.target)) {
                logoutMenu.classList.remove("show");
            }
        });
    }


    // ======================
    // MODAL LOGIC
    // ======================
    const addEventBtn = document.getElementById("add-Event-Btn");
    const eventModal = document.getElementById("eventModal");
    const cancelBtn = document.getElementById("cancelBtn");
    const nextBtn = document.getElementById("nextBtn");
    const backBtn = document.getElementById("backBtn");
    const formStep1 = document.getElementById("formStep1");
    const formStep2 = document.getElementById("formStep2");

    if (!addEventBtn) {
        console.error("❌ Add Event button not found. Check id='add-Event-Btn'.");
        return;
    }

    // Buka modal
    addEventBtn.addEventListener("click", () => {
        console.log("➕ Add Event clicked");
        if (eventModal) eventModal.style.display = "flex";
        if (formStep1) formStep1.classList.add("active");
        if (formStep2) formStep2.classList.remove("active");
    });

    // Tutup modal
    cancelBtn?.addEventListener("click", () => {
        eventModal.style.display = "none";
    });

    // Step 1 -> Step 2
    nextBtn?.addEventListener("click", () => {
        formStep1.classList.remove("active");
        formStep2.classList.add("active");
    });

    // Step 2 -> Step 1
    backBtn?.addEventListener("click", () => {
        formStep2.classList.remove("active");
        formStep1.classList.add("active");
    });

    // Klik luar modal = tutup
    eventModal?.addEventListener("click", (e) => {
        if (e.target === eventModal) {
            eventModal.style.display = "none";
        }
    });

});
