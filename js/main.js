// Form submission handlers
document.addEventListener('DOMContentLoaded', function() {
    // Add Group Form
    const addGroupForm = document.getElementById('addGroupForm');
    if (addGroupForm) {
        addGroupForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const groupName = document.getElementById('groupName').value;
            const groupDescription = document.getElementById('groupDescription').value;
            
            fetch('/api/groups.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    name: groupName,
                    description: groupDescription
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert('Ошибка: ' + data.error);
                } else {
                    alert('Группа успешно добавлена');
                    addGroupForm.reset();
                    // Refresh the groups list
                    loadGroups();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Произошла ошибка при добавлении группы');
            });
        });
    }

    // Add Class Form
    const addClassForm = document.getElementById('addClassForm');
    if (addClassForm) {
        addClassForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const subject = document.getElementById('subject').value;
            const teacher = document.getElementById('teacher').value;
            const group = document.getElementById('group').value;
            const date = document.getElementById('date').value;
            const time = document.getElementById('time').value;
            const room = document.getElementById('room').value;
            const type = document.getElementById('type').value;
            
            // Here you would typically send this to a PHP backend
            alert(`Занятие "${subject}" будет добавлено в расписание`);
            addClassForm.reset();
        });
    }

    // Add Teacher Form
    const addTeacherForm = document.getElementById('addTeacherForm');
    if (addTeacherForm) {
        addTeacherForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const teacherName = document.getElementById('teacherName').value;
            const department = document.getElementById('department').value;
            const position = document.getElementById('position').value;
            const email = document.getElementById('email').value;
            
            fetch('/api/teachers.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    name: teacherName,
                    department: department,
                    position: position,
                    email: email
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert('Ошибка: ' + data.error);
                } else {
                    alert('Преподаватель успешно добавлен');
            addTeacherForm.reset();
                    loadTeachers();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Произошла ошибка при добавлении преподавателя');
            });
        });
    }

    // Search Form
    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const subject = document.getElementById('searchSubject').value;
            const teacher = document.getElementById('searchTeacher').value;
            const group = document.getElementById('searchGroup').value;
            const dateFrom = document.getElementById('searchDateFrom').value;
            const dateTo = document.getElementById('searchDateTo').value;
            const type = document.getElementById('searchType').value;
            const timeInterval = document.getElementById('searchTimeInterval').value;
            // Если все поля пустые, просто делаем GET-запрос (всё расписание)
            if (!subject && !teacher && !group && !dateFrom && !dateTo && !type && !timeInterval) {
                fetch('/api/schedule.php')
                .then(response => response.json())
                .then(results => {
                    const tbody = document.querySelector('#searchResultsTable tbody');
                    if (tbody) {
                        tbody.innerHTML = '';
                        if (Array.isArray(results) && results.length > 0) {
                            results.forEach(entry => {
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                    <td>${entry.date}</td>
                                    <td>${formatTime(entry.start_time)} - ${formatTime(entry.end_time)}</td>
                                    <td>${entry.subject_name}</td>
                                    <td>${entry.teacher_name}</td>
                                    <td>${entry.group_name}</td>
                                    <td>${entry.room}</td>
                                    <td>${entry.type}</td>
                                `;
                                tbody.appendChild(tr);
                            });
                    } else {
                            tbody.innerHTML = '<tr><td colspan="7">Нет результатов</td></tr>';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    const tbody = document.querySelector('#searchResultsTable tbody');
                    if (tbody) {
                        tbody.innerHTML = `<tr><td colspan="7">Ошибка: ${error.message}</td></tr>`;
                    }
                });
                return;
            }
            fetch('/api/schedule.php?action=search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    subject,
                    teacher,
                    group,
                    date_from: dateFrom,
                    date_to: dateTo,
                    type,
                    time_interval: timeInterval
                })
            })
            .then(response => response.json())
            .then(results => {
                const tbody = document.querySelector('#searchResultsTable tbody');
                if (tbody) {
                    tbody.innerHTML = '';
                    if (Array.isArray(results) && results.length > 0) {
                        results.forEach(entry => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${entry.date}</td>
                                <td>${formatTime(entry.start_time)} - ${formatTime(entry.end_time)}</td>
                                <td>${entry.subject_name}</td>
                                <td>${entry.teacher_name}</td>
                                <td>${entry.group_name}</td>
                                <td>${entry.room}</td>
                                <td>${entry.type}</td>
                            `;
                            tbody.appendChild(tr);
                        });
                    } else {
                        tbody.innerHTML = '<tr><td colspan="7">Нет результатов</td></tr>';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const tbody = document.querySelector('#searchResultsTable tbody');
                if (tbody) {
                    tbody.innerHTML = `<tr><td colspan="7">Ошибка: ${error.message}</td></tr>`;
                }
            });
        });
    }

    // Edit buttons
    document.querySelectorAll('.btn-warning').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            // Here you would typically populate a form with the row's data
            alert('Редактирование элемента');
        });
    });

    // Function to load groups
    function loadGroups() {
        fetch('/api/groups.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text().then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                        console.error('Response text:', text);
                        throw new Error('Invalid JSON response');
                    }
                });
            })
            .then(groups => {
                const tbody = document.querySelector('#groupsTable tbody');
                tbody.innerHTML = '';
                
                if (!Array.isArray(groups)) {
                    console.error('Expected array but got:', groups);
                    tbody.innerHTML = '<tr><td colspan="3" class="text-center">Ошибка загрузки данных</td></tr>';
                    return;
                }
                
                groups.forEach(group => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${group.name}</td>
                        <td>${group.description || ''}</td>
                        ${isAdmin ? `
                        <td>
                            <button class="btn btn-sm btn-danger" onclick="deleteGroup(${group.id})">Удалить</button>
                        </td>
                        ` : ''}
                    `;
                    tbody.appendChild(tr);
                });
            })
            .catch(error => {
                console.error('Error loading groups:', error);
                const tbody = document.querySelector('#groupsTable tbody');
                tbody.innerHTML = '<tr><td colspan="3" class="text-center">Ошибка загрузки данных</td></tr>';
            });
    }

    // Function to load teachers
    function loadTeachers() {
        fetch('/api/teachers.php')
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.error || 'Failed to load teachers');
                    });
                }
                return response.json();
            })
            .then(teachers => {
                const tbody = document.querySelector('#teachersTable tbody');
                if (tbody) {
                    tbody.innerHTML = '';
                    if (Array.isArray(teachers)) {
                        teachers.forEach(teacher => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${teacher.name}</td>
                                <td>${teacher.department || ''}</td>
                                <td>${teacher.position || ''}</td>
                                <td>${teacher.email || ''}</td>
                                ${isAdmin ? `
                                <td>
                                    <button class="btn btn-sm btn-danger delete-teacher" data-id="${teacher.id}">Удалить</button>
                                    <button class="btn btn-sm btn-primary create-user" data-id="${teacher.id}" data-name="${teacher.name}">Создать пользователя</button>
                                </td>
                                ` : ''}
                            `;
                            tbody.appendChild(tr);
                        });
                        // Навешиваем обработчики после отрисовки
                        tbody.querySelectorAll('.delete-teacher').forEach(button => {
                            button.addEventListener('click', function() {
                                const teacherId = this.dataset.id;
                                if (confirm('Вы уверены, что хотите удалить этого преподавателя?')) {
                                    fetch('/api/teachers.php', {
                                        method: 'DELETE',
                                        headers: {
                                            'Content-Type': 'application/json',
                                        },
                                        body: JSON.stringify({ id: teacherId })
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.error) {
                                            alert('Ошибка: ' + data.error);
                                        } else {
                                            alert('Преподаватель успешно удален');
                                            loadTeachers();
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert('Произошла ошибка при удалении преподавателя');
                                    });
                                }
                            });
                        });
                        // Обработчики для кнопок создания пользователя
                        tbody.querySelectorAll('.create-user').forEach(button => {
                            button.addEventListener('click', function() {
                                const teacherId = this.dataset.id;
                                const teacherName = this.dataset.name;
                                // Берём фамилию (первое слово)
                                const surname = teacherName.split(' ')[0];
                                // Транслитерация фамилии
                                const login = translit(surname.toLowerCase());
                                // Генерация временного пароля
                                const tempPassword = generatePassword(8);
                                
                                if (confirm(`Создать пользователя для преподавателя ${teacherName}?`)) {
                                    fetch('/api/users.php', {
                                        method: 'POST',
                                        headers: { 'Content-Type': 'application/json' },
                                        body: JSON.stringify({
                                            username: login,
                                            password: tempPassword,
                                            full_name: teacherName,
                                            role: 'teacher'
                                        })
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.success) {
                                            alert(`Пользователь создан!\nЛогин: ${login}\nВременный пароль: ${tempPassword}`);
                                        } else {
                                            alert('Ошибка: ' + (data.error || 'Не удалось создать пользователя'));
                                        }
                                    })
                                    .catch(err => {
                                        alert('Ошибка: ' + err);
                                    });
                                }
                            });
                        });
                    } else {
                        console.error('Received data is not an array:', teachers);
                        tbody.innerHTML = '<tr><td colspan="5">No teachers found</td></tr>';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const tbody = document.querySelector('#teachersTable tbody');
                if (tbody) {
                    tbody.innerHTML = `<tr><td colspan="5">Error: ${error.message}</td></tr>`;
                }
            });
    }

    // Load groups on page load
    if (document.getElementById('groupsTable')) {
        loadGroups();
    }

    // Load teachers on page load
    if (document.getElementById('teachersTable')) {
        loadTeachers();
    }

    // Add Schedule Form
    const addScheduleForm = document.getElementById('addScheduleForm');
    if (addScheduleForm) {
        // Load teachers and groups for dropdowns
        Promise.all([
            fetch('/api/teachers.php').then(res => res.json()),
            fetch('/api/groups.php').then(res => res.json())
        ]).then(([teachers, groups]) => {
            // Populate teachers dropdown
            const teacherSelect = document.getElementById('teacher');
            teachers.forEach(teacher => {
                const option = document.createElement('option');
                option.value = teacher.id;
                option.textContent = teacher.name;
                teacherSelect.appendChild(option);
            });

            // Populate groups dropdown
            const groupSelect = document.getElementById('group');
            groups.forEach(group => {
                const option = document.createElement('option');
                option.value = group.id;
                option.textContent = group.name;
                groupSelect.appendChild(option);
            });
        });

        addScheduleForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const subjectName = document.getElementById('subject').value;
            const teacherId = document.getElementById('teacher').value;
            const groupId = document.getElementById('group').value;
            const room = document.getElementById('room').value;
            const date = document.getElementById('date').value;
            const timeInterval = document.getElementById('timeInterval').value;
            const type = document.getElementById('type').value;
            
            fetch('/api/schedule.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    subject: subjectName,
                    teacher_id: teacherId,
                    group_id: groupId,
                    room: room,
                    date: date,
                    time_interval: timeInterval,
                    type: type
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert('Ошибка: ' + data.error);
                } else {
                    alert('Занятие успешно добавлено');
                    addScheduleForm.reset();
                    loadSchedule();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Произошла ошибка при добавлении занятия');
            });
        });
    }

    // Function to load schedule
    function loadSchedule() {
        fetch('/api/schedule.php')
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.error || 'Failed to load schedule');
                    });
                }
                return response.json();
            })
            .then(schedule => {
                const tbody = document.querySelector('#scheduleTable tbody');
                if (tbody) {
                    tbody.innerHTML = '';
                    if (Array.isArray(schedule)) {
                        schedule.forEach(entry => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${entry.date}</td>
                                <td>${formatTime(entry.start_time)} - ${formatTime(entry.end_time)}</td>
                                <td>${entry.subject_name}</td>
                                <td>${entry.teacher_name}</td>
                                <td>${entry.group_name}</td>
                                <td>${entry.room}</td>
                                <td>${entry.type}</td>
                                <td>
                                    <button class="btn btn-danger delete-schedule" data-id="${entry.id}">Удалить</button>
                                </td>
                            `;
                            tbody.appendChild(tr);
                        });
                    } else {
                        console.error('Received data is not an array:', schedule);
                        tbody.innerHTML = '<tr><td colspan="8">No schedule entries found</td></tr>';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const tbody = document.querySelector('#scheduleTable tbody');
                if (tbody) {
                    tbody.innerHTML = `<tr><td colspan="8">Error: ${error.message}</td></tr>`;
                }
            });
    }

    // Delete Schedule Button
    document.querySelectorAll('.delete-schedule').forEach(button => {
        button.addEventListener('click', function() {
            const scheduleId = this.dataset.id;
            if (confirm('Вы уверены, что хотите удалить это занятие?')) {
                fetch('/api/schedule.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: scheduleId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert('Ошибка: ' + data.error);
                    } else {
                        alert('Занятие успешно удалено');
                        loadSchedule();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Произошла ошибка при удалении занятия');
                });
            }
        });
    });

    // Load schedule on page load
    if (document.getElementById('scheduleTable')) {
        loadSchedule();
    }

    // Автозаполнение выпадающих списков поиска
    if (document.getElementById('searchForm')) {
        fetch('/api/groups.php')
            .then(res => res.json())
            .then(groups => {
                const select = document.getElementById('searchGroup');
                if (select && Array.isArray(groups)) {
                    groups.forEach(g => {
                        const option = document.createElement('option');
                        option.value = g.name;
                        option.textContent = g.name;
                        select.appendChild(option);
                    });
                }
            });
        fetch('/api/teachers.php')
            .then(res => res.json())
            .then(teachers => {
                const select = document.getElementById('searchTeacher');
                if (select && Array.isArray(teachers)) {
                    teachers.forEach(t => {
                        const option = document.createElement('option');
                        option.value = t.name;
                        option.textContent = t.name;
                        select.appendChild(option);
                    });
                }
            });
        fetch('/api/subjects.php')
            .then(res => res.json())
            .then(subjects => {
                const select = document.getElementById('searchSubject');
                if (select && Array.isArray(subjects)) {
                    subjects.forEach(s => {
                        const option = document.createElement('option');
                        option.value = s.name;
                        option.textContent = s.name;
                        select.appendChild(option);
                    });
                }
            });
    }

    // Форма создания пользователя-студента
    const addStudentUserForm = document.getElementById('addStudentUserForm');
    if (addStudentUserForm) {
        addStudentUserForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const fullName = document.getElementById('studentFullName').value.trim();
            if (!fullName) return;
            // Берём фамилию (первое слово)
            const surname = fullName.split(' ')[0];
            // Транслитерация фамилии
            const login = translit(surname.toLowerCase());
            // Генерация временного пароля
            const tempPassword = generatePassword(8);
            fetch('/api/users.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    username: login,
                    password: tempPassword,
                    full_name: fullName,
                    role: 'student'
                })
            })
            .then(res => res.json())
            .then(data => {
                const resultDiv = document.getElementById('studentUserResult');
                if (data.success) {
                    resultDiv.innerHTML = `<div class='alert alert-success'>Пользователь создан!<br>Логин: <b>${login}</b><br>Временный пароль: <b>${tempPassword}</b></div>`;
                    addStudentUserForm.reset();
                } else {
                    resultDiv.innerHTML = `<div class='alert alert-danger'>Ошибка: ${data.error || 'Не удалось создать пользователя'}</div>`;
                }
            })
            .catch(err => {
                document.getElementById('studentUserResult').innerHTML = `<div class='alert alert-danger'>Ошибка: ${err}</div>`;
            });
        });
    }

    // Форма создания пользователя-преподавателя
    const addTeacherUserForm = document.getElementById('addTeacherUserForm');
    if (addTeacherUserForm) {
        addTeacherUserForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const fullName = document.getElementById('teacherFullName').value.trim();
            if (!fullName) return;
            // Берём фамилию (первое слово)
            const surname = fullName.split(' ')[0];
            // Транслитерация фамилии
            const login = translit(surname.toLowerCase());
            // Генерация временного пароля
            const tempPassword = generatePassword(8);
            fetch('/api/users.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    username: login,
                    password: tempPassword,
                    full_name: fullName,
                    role: 'teacher'
                })
            })
            .then(res => res.json())
            .then(data => {
                const resultDiv = document.getElementById('teacherUserResult');
                if (data.success) {
                    resultDiv.innerHTML = `<div class='alert alert-success'>Пользователь создан!<br>Логин: <b>${login}</b><br>Временный пароль: <b>${tempPassword}</b></div>`;
                    addTeacherUserForm.reset();
                } else {
                    resultDiv.innerHTML = `<div class='alert alert-danger'>Ошибка: ${data.error || 'Не удалось создать пользователя'}</div>`;
                }
            })
            .catch(err => {
                document.getElementById('teacherUserResult').innerHTML = `<div class='alert alert-danger'>Ошибка: ${err}</div>`;
            });
        });
    }
});

function formatTime(t) {
    if (!t) return '';
    return t.slice(0,5);
}

// Функция транслитерации
function translit(text) {
    const map = {
        а:'a',б:'b',в:'v',г:'g',д:'d',е:'e',ё:'e',ж:'zh',з:'z',и:'i',й:'y',к:'k',л:'l',м:'m',н:'n',о:'o',п:'p',р:'r',с:'s',т:'t',у:'u',ф:'f',х:'h',ц:'ts',ч:'ch',ш:'sh',щ:'sch',ъ:'',ы:'y',ь:'',э:'e',ю:'yu',я:'ya',
        А:'A',Б:'B',В:'V',Г:'G',Д:'D',Е:'E',Ё:'E',Ж:'Zh',З:'Z',И:'I',Й:'Y',К:'K',Л:'L',М:'M',Н:'N',О:'O',П:'P',Р:'R',С:'S',Т:'T',У:'U',Ф:'F',Х:'H',Ц:'Ts',Ч:'Ch',Ш:'Sh',Щ:'Sch',Ъ:'',Ы:'Y',Ь:'',Э:'E',Ю:'Yu',Я:'Ya'
    };
    return text.split('').map(c => map[c] || c).join('');
}

// Функция генерации пароля
function generatePassword(length) {
    const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let pass = '';
    for (let i = 0; i < length; i++) {
        pass += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    return pass;
} 