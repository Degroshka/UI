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
            
            // Here you would typically send this to a PHP backend
            alert('Поиск будет выполнен с указанными параметрами');
        });
    }

    // Delete Group Button
    document.querySelectorAll('.delete-group').forEach(button => {
        button.addEventListener('click', function() {
            const groupId = this.dataset.id;
            if (confirm('Вы уверены, что хотите удалить эту группу?')) {
                fetch('/api/groups.php', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: groupId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert('Ошибка: ' + data.error);
                    } else {
                        alert('Группа успешно удалена');
                        loadGroups();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Произошла ошибка при удалении группы');
                });
            }
        });
    });

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
                    return response.json().then(err => {
                        throw new Error(err.error || 'Failed to load groups');
                    });
                }
                return response.json();
            })
            .then(groups => {
                const tbody = document.querySelector('#groupsTable tbody');
                if (tbody) {
                    tbody.innerHTML = '';
                    if (Array.isArray(groups)) {
                        groups.forEach(group => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${group.name}</td>
                                <td>${group.description || ''}</td>
                                <td>
                                    <button class="btn btn-danger delete-group" data-id="${group.id}">Удалить</button>
                                </td>
                            `;
                            tbody.appendChild(tr);
                        });
                    } else {
                        console.error('Received data is not an array:', groups);
                        tbody.innerHTML = '<tr><td colspan="3">No groups found</td></tr>';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const tbody = document.querySelector('#groupsTable tbody');
                if (tbody) {
                    tbody.innerHTML = `<tr><td colspan="3">Error: ${error.message}</td></tr>`;
                }
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
                                <td>
                                    <button class="btn btn-danger delete-teacher" data-id="${teacher.id}">Удалить</button>
                                </td>
                            `;
                            tbody.appendChild(tr);
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

    // Delete Teacher Button
    document.querySelectorAll('.delete-teacher').forEach(button => {
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
        // Load dropdowns data
        Promise.all([
            fetch('/api/subjects.php').then(res => res.json()),
            fetch('/api/teachers.php').then(res => res.json()),
            fetch('/api/groups.php').then(res => res.json())
        ]).then(([subjects, teachers, groups]) => {
            // Populate subjects dropdown
            const subjectSelect = document.getElementById('subject');
            subjects.forEach(subject => {
                const option = document.createElement('option');
                option.value = subject.id;
                option.textContent = subject.name;
                subjectSelect.appendChild(option);
            });

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
            const subjectId = document.getElementById('subject').value;
            const teacherId = document.getElementById('teacher').value;
            const groupId = document.getElementById('group').value;
            const room = document.getElementById('room').value;
            const date = document.getElementById('date').value;
            const startTime = document.getElementById('startTime').value;
            const endTime = document.getElementById('endTime').value;
            const type = document.getElementById('type').value;
            
            fetch('/api/schedule.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    subject_id: subjectId,
                    teacher_id: teacherId,
                    group_id: groupId,
                    room: room,
                    date: date,
                    start_time: startTime,
                    end_time: endTime,
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
                                <td>${entry.start_time} - ${entry.end_time}</td>
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
}); 