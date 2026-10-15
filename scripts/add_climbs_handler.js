const selectedHall = document.getElementById("climbinghall");
const selectedWalls = document.getElementById("climbingwall");
let wallsByHall = {};

async function init() {
    try {
        const response = await fetch("./database/climbingwalls.json");
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        wallsByHall = await response.json();

        climbing_wall_handler(selectedHall.value);
    } catch (error) {
        console.error("Could not load walls:", error);
    }
}

function climbing_wall_handler(selected) {
    selectedWalls.innerHTML = "";

    const walls = wallsByHall[selected].allwalls ?? [];
    for (const wall of walls) {
        selectedWalls.add(new Option(wall, wall));
    }
}

init();