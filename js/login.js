let showPassBtn = document.getElementById('showPass');
let pass = document.getElementById('regPass');
let hided = true;
showPassBtn.addEventListener('change', () => {
    if (hided) {
        pass.type = 'text';
        hided = false;
    } else {
        pass.type = 'password';
        hided = true;
    }
})
