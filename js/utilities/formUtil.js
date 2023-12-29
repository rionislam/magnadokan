const formUtil = {
    validateFullname: (fullname) => {
        fullname.reportValidity();
        if (!fullname.checkValidity()) {
            fullname.classList.add('invalid');
            if (formUtil.isInputEmpty(fullname)) {
                fullname.setCustomValidity('Full Name can\'t be empty!');
            }else if (!/^[a-zA-Z\s]+$/.test(fullname.value)) {
                fullname.setCustomValidity('Invalid characters! Use only letters and spaces.');
            } else {
                fullname.setCustomValidity('');
                fullname.classList.remove('invalid');
            }
            return false;
        } 
        fullname.setCustomValidity('');
        fullname.classList.remove('invalid');
        return true;

    },

    validateUsername: (username) => {
        username.reportValidity();
        if (!username.checkValidity()) {
            username.classList.add('invalid');
            if (formUtil.isInputEmpty(username)) {
                username.setCustomValidity('Username can\'t be empty!');
            }else if (username.value.length < 5) {
                username.setCustomValidity('Username must be at least 5 characters long!');
            } else if (!/^[a-zA-Z0-9_\-]+$/.test(username.value)) {
                username.setCustomValidity('Invalid characters! Use only letters, numbers, underscores, or hyphens.');
            } else {
                username.setCustomValidity('');
                username.classList.remove('invalid');
            }
            return false;
        } 
        username.setCustomValidity('');
        username.classList.remove('invalid');
        return true;
        
    },

    validateEmail: (email) => {
        email.reportValidity();
        if (!email.checkValidity()) {
            email.classList.add('invalid');
            if (formUtil.isInputEmpty(email)) {
                email.setCustomValidity('Full name can\'t be empty!');
            } else if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                email.setCustomValidity('Invalid email address!');
            } else {
                email.setCustomValidity('');
                email.classList.remove('invalid');
            }
            return false;
        }

        email.setCustomValidity('');
        email.classList.remove('invalid');
        return true;
    },

    validatePassword: (password) => {
        password.reportValidity();
        if (!password.checkValidity()) {
            password.classList.add('invalid');
            if (formUtil.isInputEmpty(password) ) {
                password.setCustomValidity('Password can\'t be empty!');
            } else if (password.value.length < 6) {
                password.setCustomValidity('Password must be at least 6 characters long!');
            } else {
                password.setCustomValidity('');
                password.classList.remove('invalid');
            }
            return false;
        }
        password.setCustomValidity('');
        password.classList.remove('invalid');
        return true;
    },

    validateConfirmPassword: (confirmPassword, password) => {
        if (formUtil.isInputEmpty(confirmPassword)) {
            confirmPassword.setCustomValidity('Confirm Password can\'t be empty!');
        } else if (confirmPassword.value !== password.value) {
            confirmPassword.setCustomValidity('Passwords do not match.');
        } else {
            confirmPassword.setCustomValidity('');
        }

        confirmPassword.reportValidity();

        if (confirmPassword.checkValidity()) {
            confirmPassword.classList.remove('invalid');
        } else {
            confirmPassword.classList.add('invalid');
        }

        return confirmPassword.checkValidity();
    },

    isInputEmpty: (input) => {
        if (input.value.trim() === '') {
            return true;
        } else {
            return false;
         }
    }
};

export default formUtil;