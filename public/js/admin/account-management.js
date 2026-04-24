document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // DATA
    // ==========================================
    let staffList = [
        { id: 1, firstName: 'Joana Mae', lastName: 'Peras',  role: 'Leader', team: 'Team A', status: 'active',   username: 'joana001', password: 'TEMP123' },
        { id: 2, firstName: 'Jinky',     lastName: 'Holans', role: 'Member', team: 'Team A', status: 'inactive', username: 'jinky002', password: 'TEMP456' }
    ];

    let teams = [
        { id: 1, teamName: 'Team A', leader: 'Joana Mae Peras', members: ['Jinky Holans'] }
    ];

    let editingStaffId = null;
    let editingTeamId  = null;
    let tempMembers    = [];

    // ==========================================
    // STAFF TABLE
    // ==========================================
    function renderStaffTable() {
        const tbody = document.getElementById('staff-tbody');
        if (!tbody) return;

        tbody.innerHTML = '';

        const search = document.querySelector('.search-input');
        const query  = search ? search.value.toLowerCase() : '';

        const filtered = staffList.filter(s =>
            (s.firstName + ' ' + s.lastName).toLowerCase().includes(query)
        );

        if (!filtered.length) {
            tbody.innerHTML = `<tr><td colspan="5" style="text-align:center; color:#aaa; padding:20px;">No staff found</td></tr>`;
            return;
        }

        filtered.forEach(staff => {
            const row = document.createElement('tr');

            const statusLabel = staff.status === 'active' ? 'Active' : 'Inactive';
            const statusClass = staff.status === 'active' ? 'active' : 'inactive';
            const nextAction  = staff.status === 'active' ? 'deactivate' : 'activate';

            row.innerHTML = `
                <td>${staff.firstName} ${staff.lastName}</td>
                <td>${staff.role}</td>
                <td>${staff.team}</td>
                <td>
                    <span
                        class="status ${statusClass}"
                        style="cursor:pointer; user-select:none;"
                        title="Click to ${nextAction} this account"
                        onclick="toggleStatus(${staff.id})"
                    >${statusLabel}</span>
                </td>
                <td>
                    <button class="btn-action edit"   onclick="openEditStaff(${staff.id})">Edit</button>
                    <button class="btn-action delete" onclick="deleteStaff(${staff.id})">Delete</button>
                </td>`;
            tbody.appendChild(row);
        });
    }

    // ==========================================
    // TOGGLE STATUS
    // ==========================================
    window.toggleStatus = function (id) {
        const staff = staffList.find(s => s.id === id);
        if (!staff) return;

        const fullName    = `${staff.firstName} ${staff.lastName}`;
        const isActive    = staff.status === 'active';
        const newStatus   = isActive ? 'inactive' : 'active';
        const actionLabel = isActive ? 'Deactivate' : 'Activate';
        const accentColor = isActive ? '#e74c3c' : '#27ae60';
        const icon        = isActive ? '🔒' : '✅';

        showStatusConfirm(
            `${actionLabel} Account`,
            `Are you sure you want to set <strong>${fullName}</strong>'s account to <strong>${newStatus}</strong>?`,
            accentColor,
            icon,
            function () {
                staff.status = newStatus;
                renderStaffTable();
            }
        );
    };

    // ==========================================
    // CUSTOM CONFIRM MODAL
    // ==========================================
    function showStatusConfirm(title, message, accentColor, icon, onConfirm) {
        const existing = document.getElementById('statusConfirmModal');
        if (existing) existing.remove();

        const overlay = document.createElement('div');
        overlay.id = 'statusConfirmModal';
        overlay.style.cssText = `
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.5);
            display: flex; align-items: center; justify-content: center;
            z-index: 99999;
        `;

        overlay.innerHTML = `
            <div style="
                background: #fff; border-radius: 12px;
                padding: 30px 28px 22px; width: 320px;
                box-shadow: 0 10px 40px rgba(0,0,0,0.2);
                font-family: sans-serif; text-align: center;
            ">
                <div style="font-size:36px; margin-bottom:12px;">${icon}</div>
                <div style="font-size:16px; font-weight:700; color:#1a1a2e; margin-bottom:10px;">${title}</div>
                <div style="font-size:13px; color:#555; line-height:1.6; margin-bottom:22px;">${message}</div>
                <div style="display:flex; gap:10px; justify-content:center;">
                    <button id="scCancel" style="
                        padding: 9px 24px; border-radius: 7px;
                        border: none; background: #eee; color: #444;
                        font-size: 13px; font-weight: 600; cursor: pointer;
                    ">Cancel</button>
                    <button id="scConfirm" style="
                        padding: 9px 24px; border-radius: 7px;
                        border: none; background: ${accentColor}; color: #fff;
                        font-size: 13px; font-weight: 600; cursor: pointer;
                    ">Confirm</button>
                </div>
            </div>
        `;

        document.body.appendChild(overlay);

        document.getElementById('scConfirm').onclick = function () {
            onConfirm();
            overlay.remove();
        };
        document.getElementById('scCancel').onclick = function () {
            overlay.remove();
        };
        overlay.onclick = function (e) {
            if (e.target === overlay) overlay.remove();
        };
    }

    // ==========================================
    // TEAM LIST
    // ==========================================
    function renderTeamList() {
        const list = document.getElementById('team-list');
        if (!list) return;

        list.innerHTML = '';

        if (!teams.length) {
            list.innerHTML = `<div style="color:#aaa; font-size:13px; padding:10px;">No teams yet.</div>`;
            return;
        }

        teams.forEach(team => {
            const item = document.createElement('div');
            item.className = 'team-item';
            item.innerHTML = `
                <span class="team-name">${team.teamName}</span>
                <span class="team-role">Leader: ${team.leader}</span>
                <span class="team-role">Members: ${team.members.join(', ') || 'None'}</span>
                <div style="margin-top:8px; display:flex; gap:6px;">
                    <button class="btn-action edit"   onclick="openEditTeam(${team.id})">Edit</button>
                    <button class="btn-action delete" onclick="deleteTeam(${team.id})">Delete</button>
                </div>`;
            list.appendChild(item);
        });
    }

    // ==========================================
    // OPEN CREATE ACCOUNT
    // ==========================================
    window.openCreateAccount = function () {
        editingStaffId = null;

        document.getElementById('acc_first_name').value = '';
        document.getElementById('acc_last_name').value  = '';
        document.getElementById('acc_contact').value    = '';
        document.getElementById('acc_birthday').value   = '';
        document.getElementById('acc_age').value        = '';
        document.getElementById('gen_username').textContent = '-';
        document.getElementById('gen_password').textContent = '-';
        document.querySelectorAll('input[name="acc_sex"]').forEach(r => r.checked = false);

        document.getElementById('modal-account-title').textContent = 'Create New Account';
        document.getElementById('createAccountModal').classList.remove('hidden');
    };

    window.closeCreateAccount = function () {
        document.getElementById('createAccountModal').classList.add('hidden');
    };

    // ==========================================
    // OPEN EDIT STAFF
    // ==========================================
    window.openEditStaff = function (id) {
        const staff = staffList.find(s => s.id === id);
        if (!staff) return;

        editingStaffId = id;

        document.getElementById('acc_first_name').value = staff.firstName;
        document.getElementById('acc_last_name').value  = staff.lastName;
        document.getElementById('acc_contact').value    = staff.contact  ?? '';
        document.getElementById('acc_birthday').value   = staff.birthday ?? '';
        document.getElementById('acc_age').value        = staff.age      ?? '';
        document.getElementById('gen_username').textContent = staff.username ?? '-';
        document.getElementById('gen_password').textContent = staff.password ?? '-';

        if (staff.sex) {
            const radio = document.querySelector(`input[name="acc_sex"][value="${staff.sex}"]`);
            if (radio) radio.checked = true;
        }

        document.getElementById('modal-account-title').textContent = 'Edit Account';
        document.getElementById('createAccountModal').classList.remove('hidden');
    };

    // ==========================================
    // GENERATE ACCOUNT
    // ==========================================
    window.generateAccount = function () {
        const first = document.getElementById('acc_first_name').value.trim();
        const last  = document.getElementById('acc_last_name').value.trim();

        if (!first || !last) {
            alert('Please enter the staff name first before generating an account.');
            return;
        }

        const username = first.toLowerCase().replace(/\s/g, '') + Math.floor(Math.random() * 1000);
        const password = Math.random().toString(36).substring(2, 8).toUpperCase();

        document.getElementById('gen_username').textContent = username;
        document.getElementById('gen_password').textContent = password;
    };

    // ==========================================
    // CONFIRM ACCOUNT (Create or Update)
    // ==========================================
    window.confirmAccount = function () {
        const firstName = document.getElementById('acc_first_name').value.trim();
        const lastName  = document.getElementById('acc_last_name').value.trim();
        const contact   = document.getElementById('acc_contact').value.trim();
        const birthday  = document.getElementById('acc_birthday').value;
        const age       = document.getElementById('acc_age').value;
        const username  = document.getElementById('gen_username').textContent;
        const password  = document.getElementById('gen_password').textContent;
        const sexRadio  = document.querySelector('input[name="acc_sex"]:checked');
        const sex       = sexRadio ? sexRadio.value : '';

        if (!firstName || !lastName) {
            alert('Please fill in the staff name.');
            return;
        }

        if (editingStaffId) {
            const idx = staffList.findIndex(s => s.id === editingStaffId);
            if (idx !== -1) {
                staffList[idx] = { ...staffList[idx], firstName, lastName, contact, birthday, age, sex, username, password };
            }
        } else {
            staffList.push({
                id: Date.now(),
                firstName, lastName, contact, birthday, age, sex,
                role:     'Member',
                team:     '-',
                status:   'active',
                username: username !== '-' ? username : '',
                password: password !== '-' ? password : '',
            });
        }

        renderStaffTable();
        closeCreateAccount();
    };

    // ==========================================
    // DELETE STAFF
    // ==========================================
    window.deleteStaff = function (id) {
        if (!confirm('Are you sure you want to delete this staff?')) return;
        staffList = staffList.filter(s => s.id !== id);
        renderStaffTable();
    };

    // ==========================================
    // OPEN CREATE TEAM
    // ==========================================
    window.openCreateTeam = function () {
        editingTeamId = null;
        tempMembers   = [];

        document.getElementById('team_name').value   = '';
        document.getElementById('team_leader').value = '';
        document.getElementById('team_member').value = '';
        document.getElementById('modal-team-title').textContent = 'Create Team';

        document.getElementById('createTeamModal').classList.remove('hidden');
        renderMemberList();
    };

    window.closeCreateTeam = function () {
        document.getElementById('createTeamModal').classList.add('hidden');
    };

    // ==========================================
    // OPEN EDIT TEAM
    // ==========================================
    window.openEditTeam = function (id) {
        const team = teams.find(t => t.id === id);
        if (!team) return;

        editingTeamId = id;
        tempMembers   = [...team.members];

        document.getElementById('team_name').value   = team.teamName;
        document.getElementById('team_leader').value = team.leader;
        document.getElementById('team_member').value = '';
        document.getElementById('modal-team-title').textContent = 'Edit Team';

        document.getElementById('createTeamModal').classList.remove('hidden');
        renderMemberList();
    };

    // ==========================================
    // ADD MEMBER TO TEMP LIST
    // ==========================================
    window.addMemberToList = function () {
        const input = document.getElementById('team_member');
        const name  = input.value.trim();
        if (!name) return;
        if (tempMembers.includes(name)) { alert('Member already added.'); return; }
        tempMembers.push(name);
        input.value = '';
        renderMemberList();
    };

    // ==========================================
    // CONFIRM TEAM
    // ==========================================
    window.confirmTeam = function () {
        const teamName = document.getElementById('team_name').value.trim();
        const leader   = document.getElementById('team_leader').value.trim();

        if (!teamName || !leader) {
            alert('Please fill in Team Name and Team Leader.');
            return;
        }

        if (editingTeamId) {
            const idx = teams.findIndex(t => t.id === editingTeamId);
            if (idx !== -1) {
                teams[idx] = { ...teams[idx], teamName, leader, members: tempMembers };
            }
        } else {
            teams.push({ id: Date.now(), teamName, leader, members: tempMembers });
        }

        renderTeamList();
        closeCreateTeam();
    };

    // ==========================================
    // DELETE TEAM
    // ==========================================
    window.deleteTeam = function (id) {
        if (!confirm('Are you sure you want to delete this team?')) return;
        teams = teams.filter(t => t.id !== id);
        renderTeamList();
    };

    // ==========================================
    // MEMBER LIST RENDER
    // ==========================================
    function renderMemberList() {
        const list = document.getElementById('member-list');
        if (!list) return;

        if (!tempMembers.length) {
            list.innerHTML = `<div class="member-slot"></div>
                              <div class="member-slot"></div>
                              <div class="member-slot"></div>`;
            return;
        }

        list.innerHTML = tempMembers.map((m, i) => `
            <div class="member-slot" style="display:flex; align-items:center; justify-content:space-between; padding:0 10px; background:#c5d5e8;">
                <span style="font-size:13px; font-family:var(--font);">${m}</span>
                <button onclick="removeMember(${i})" style="background:var(--red); color:white; border:none; border-radius:4px; padding:2px 8px; font-size:11px; cursor:pointer;">✕</button>
            </div>`
        ).join('');
    }

    window.removeMember = function (index) {
        tempMembers.splice(index, 1);
        renderMemberList();
    };

    // ==========================================
    // SEARCH
    // ==========================================
    const searchInput = document.querySelector('.search-input');
    if (searchInput) searchInput.addEventListener('input', renderStaffTable);

    // ==========================================
    // INIT
    // ==========================================
    renderStaffTable();
    renderTeamList();
});