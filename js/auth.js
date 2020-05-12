function getJwt() {
    return sessionStorage.getItem('jwt');
}

function isSuperAdmin() {
    const USER = isUser();
    return +USER.role >= 3
}

function isAdmin() {
    const USER = isUser();
    return +USER.role >= 2;
}

function isUser() {
    let USER = undefined;
    try {
        USER = JSON.parse(sessionStorage.getItem('user'));
    } catch (e) {
        location.href = 'login.php';
    }
    if(!USER) {
        location.href = '../index.php';
    }
    return USER;
}

