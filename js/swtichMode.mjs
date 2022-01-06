let modeBtn = document.querySelector('.mode img');
let header = document.querySelector('header');
let containers = document.querySelectorAll('.switchMode');
let legend = document.querySelector('legend');
let switchColor = document.querySelectorAll('.switchColor');
function switchToLight() {
    document.body.style.backgroundColor = '#FFF';
    if (legend) {
        legend.style.color = '#000'
    }
    if (switchColor) {
        switchColor.forEach(item => {
            item.style.color = '#000';
        });
    }
    header.style.backgroundColor = '#C8102E';
    containers.forEach((container) => {
        container.style.backgroundColor = '#C8102E';
    })
    modeBtn.src = './images/lightTorch.png';
    modeBtn.style.position.top = '5px';
}

function switchToDark() {
    document.body.style.backgroundColor = "rgb(41, 37, 37)";
    if (legend) {
        legend.style.color = '#FFF'
    }
    switchColor.forEach(item => {
        item.style.color = '#FFF';
    });
    header.style.backgroundColor = '#333';
    containers.forEach((container) => {
        container.style.backgroundColor = '#333';
    })
    // containers.map(item => item.style.backgroundColor = '#333');
    modeBtn.src = './images/darkTorch.png';
}

if (localStorage.getItem('switched') === 'True') {
    switchToDark();
} else {
    switchToLight();
}

modeBtn.addEventListener('click', () => {
    if (localStorage.getItem('switched') === 'False') {
        switchToDark();
        localStorage.setItem('switched', 'True');
    } else {
        switchToLight();
        localStorage.setItem('switched', 'False');
    }
})