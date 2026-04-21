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
            row.innerHTML = `
                <td>${staff.firstName} ${staff.lastName}</td>
                <td>${staff.role}</td>
                <td>${staff.team}</td>
                <td><span class="status ${staff.status}">
                    ${staff.status === 'active' ? 'Active' : 'Inactive'}
                </span></td>
                <td>
                    <button class="btn-action edit"   onclick="openEditStaff(${staff.id})">Edit</button>
                    <button class="btn-action delete" onclick="deleteStaff(${staff.id})">Delete</button>
                </td>`;
            tbody.appendChild(row);
        });
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

        // Reset fields
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
    }

    window.closeCreateAccount = function () {
        document.getElementById('createAccountModal').classList.add('hidden');
    }

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
    }

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
    }

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
            // UPDATE existing
            const idx = staffList.findIndex(s => s.id === editingStaffId);
            if (idx !== -1) {
                staffList[idx] = { ...staffList[idx], firstName, lastName, contact, birthday, age, sex, username, password };
            }
        } else {
            // CREATE new
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
    }

    // ==========================================
    // DELETE STAFF
    // ==========================================
    window.deleteStaff = function (id) {
        if (!confirm('Are you sure you want to delete this staff?')) return;
        staffList = staffList.filter(s => s.id !== id);
        renderStaffTable();
    }

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
    }

    window.closeCreateTeam = function () {
        document.getElementById('createTeamModal').classList.add('hidden');
    }

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
    }

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
    }

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
    }

    // ==========================================
    // DELETE TEAM
    // ==========================================
    window.deleteTeam = function (id) {
        if (!confirm('Are you sure you want to delete this team?')) return;
        teams = teams.filter(t => t.id !== id);
        renderTeamList();
    }

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
    }

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