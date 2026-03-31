<link rel="stylesheet" type="text/css" href="loading-bar.css"/>
<script type="text/javascript" src="loading-bar.js"></script>
<script>
let animationTargets = {};
let animationFrames = {};

window.onload = function() {
    for (let i = 1; i <= 7; i++) {
        window['bar_' + i] = new ldBar("#circle_" + i);
        animationTargets[i] = 0;

        animationTargets[i] = 100;
        window['bar_' + i].set(100);
    }
};

function animateBar(index) {
    cancelAnimationFrame(animationFrames[index]);

    const bar = window['bar_' + index];
    const current = bar.value || 0;
    const target = animationTargets[index];

    const diff = target - current;

    if (Math.abs(diff) < 0.1) {
        bar.set(target);
        return;
    }

    const next = current + diff * 0.07; // 0.15 = iets te snel

    bar.set(next);

    animationFrames[index] = requestAnimationFrame(() => animateBar(index));
}

function updateCircle(inputElement, weekIndex) {
    let value = inputElement.value;

    if (value === "") {
        animationTargets[weekIndex] = 100;
        animateBar(weekIndex);
        return;
    }

    value = parseInt(value) || 0;
    animationTargets[weekIndex] = value;
    animateBar(weekIndex);
}
</script>

<form style="padding: 20px;">
    <label>Maandag:</label>
    <input type="number" onkeyup="updateCircle(this, 1)">

    <label>Dinsdag:</label>
    <input type="number" onkeyup="updateCircle(this, 2)">

    <label>Woensdag:</label>
    <input type="number" onkeyup="updateCircle(this, 3)">

    <label>Donderdag:</label>
    <input type="number" onkeyup="updateCircle(this, 4)">

    <label>Vrijdag:</label>
    <input type="number" onkeyup="updateCircle(this, 5)">

    <label>Zaterdag:</label>
    <input type="number" onkeyup="updateCircle(this, 6)">

    <label>Zondag:</label>
    <input type="number" onkeyup="updateCircle(this, 7)">
</form>

<?php
progress_bar_circle();
?>