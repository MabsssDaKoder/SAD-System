// ═══════════════════════════════════════════════════
//  WashDepot — branch.js  (Branch Management)
//  Place in: public/js/staff/branch.js
// ═══════════════════════════════════════════════════

// Active branch data (set when info modal opens)
let activeBranch = null;

// ── Modal 1: Branch Information ───────────────────────
function openBranchInfo(id, name, address, contact1, contact2, leader) {
    activeBranch = { id, name, address, contact1, contact2, leader };

    document.getElementById('info-branch').textContent  = name;
    document.getElementById('info-address').textContent = address;
    document.getElementById('info-contact').textContent = contact2
        ? `${contact1} / ${contact2}`
        : contact1;
    document.getElementById('info-leader').textContent  = leader;

    document.getElementById('branchInfoModal').classList.remove('hidden');
}

function closeBranchInfo() {
    document.getElementById('branchInfoModal').classList.add('hidden');
}

// ── Modal 2: Edit Branch ──────────────────────────────
function openEditBranch() {
    if (!activeBranch) return;

    // Pre-fill from activeBranch
    document.getElementById('edit-branch-id').value  = activeBranch.id;
    document.getElementById('edit-name').value        = activeBranch.name;
    document.getElementById('edit-address').value     = activeBranch.address;
    document.getElementById('edit-contact1').value    = activeBranch.contact1;
    document.getElementById('edit-contact2').value    = activeBranch.contact2;

    // Reset leader selector
    document.getElementById('leaderSelectedName').textContent = activeBranch.leader || 'Select Branch Leader...';
    document.getElementById('edit-leader-id').value           = '';

    // Clear active state on options
    document.querySelectorAll('.leader-option').forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.name === activeBranch.leader) {
            btn.classList.add('active');
            document.getElementById('leaderSelectedName').classList.add('selected');
        }
    });

    // Close info modal, open edit modal
    closeBranchInfo();
    document.getElementById('editBranchModal').classList.remove('hidden');
}

function closeEditBranch() {
    document.getElementById('editBranchModal').classList.add('hidden');
    document.getElementById('leaderDropdown').classList.add('hidden');
}

// ── Leader dropdown toggle ────────────────────────────
function toggleLeaderDropdown() {
    document.getElementById('leaderDropdown').classList.toggle('hidden');
}

function selectLeader(id, name) {
    document.getElementById('edit-leader-id').value          = id;
    document.getElementById('leaderSelectedName').textContent = name;
    document.getElementById('leaderSelectedName').classList.add('selected');

    // Highlight selected
    document.querySelectorAll('.leader-option').forEach(btn => {
        btn.classList.toggle('active', parseInt(btn.dataset.id) === id);
    });

    document.getElementById('leaderDropdown').classList.add('hidden');
}

// ── Submit Edit Branch ────────────────────────────────
async function submitEditBranch(e) {
    e.preventDefault();

    const id   = document.getElementById('edit-branch-id').value;
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    const payload = {
        name:              document.getElementById('edit-name').value,
        address:           document.getElementById('edit-address').value,
        contact_number:    document.getElementById('edit-contact1').value,
        contact_number_2:  document.getElementById('edit-contact2').value,
        branch_leader_id:  document.getElementById('edit-leader-id').value,
    };

    try {
        const res = await fetch(`/staff/branches/${id}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
            },
            body: JSON.stringify(payload),
        });

        if (res.ok) {
            closeEditBranch();
            // Reload page to reflect updated branch data
            window.location.reload();
        } else {
            alert('Failed to update branch. Please try again.');
        }
    } catch (err) {
        console.error('Edit branch failed:', err);
        alert('An error occurred. Please try again.');
    }
}

// ── Close dropdown when clicking outside ──────────────
document.addEventListener('click', function (e) {
    const box = document.getElementById('leaderDropdown');
    const trigger = document.getElementById('leaderSelectTrigger');
    if (box && !box.classList.contains('hidden')) {
        if (!box.contains(e.target) && !trigger.contains(e.target)) {
            box.classList.add('hidden');
        }
    }
});
function openCreateBranchModal() {
    document.getElementById("createBranchModal").classList.remove("hidden");
}

function closeCreateBranchModal() {
    document.getElementById("createBranchModal").classList.add("hidden");
}

function submitCreateBranch(e) {
    e.preventDefault();

    const newBranch = {
        name: document.getElementById("new-name").value,
        address: document.getElementById("new-address").value,
        contact1: document.getElementById("new-contact1").value,
        contact2: document.getElementById("new-contact2").value,
        open: document.getElementById("new-open").value,
        close: document.getElementById("new-close").value
    };

    console.log("New Branch:", newBranch);

    alert("Branch Created (UI only)");

    closeCreateBranchModal();
}