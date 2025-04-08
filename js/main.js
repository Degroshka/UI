// Form submission handlers
document.addEventListener('DOMContentLoaded', function() {
    // Add Group Form
    const addGroupForm = document.getElementById('addGroupForm');
    if (addGroupForm) {
        addGroupForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const groupName = document.getElementById('groupName').value;
            // Here you would typically send this to a PHP backend
            alert(`Группа "${groupName}" будет добавлена в систему`);
            addGroupForm.reset();
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
            
            // Here you would typically send this to a PHP backend
            alert(`Преподаватель "${teacherName}" будет добавлен в систему`);
            addTeacherForm.reset();
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

    // Delete buttons
    document.querySelectorAll('.btn-danger').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Вы уверены, что хотите удалить этот элемент?')) {
                // Here you would typically send this to a PHP backend
                const row = this.closest('tr');
                row.remove();
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
}); 