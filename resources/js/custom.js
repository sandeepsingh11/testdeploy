// ==================== HANDLE DRAG AND DROP ==================== //

// global vars
var copyNum = 1;
var source = '';



// on dragstart handler
function dragStartHandler(e) {
    e.dataTransfer.effectAllowed = "copyMove";
    
    var skillId = e.target.dataset.skillId;
    source = e.target.parentElement.dataset.source;

    e.dataTransfer.setData('text/plain', e.target.id);
}



// on dragover handler
function dragOverHandler(e) {
    e.preventDefault();
    
    if (source == 'bank') {
        e.dataTransfer.dropEffect = "copy";
    }
    else if (source == 'slot') {
        e.dataTransfer.dropEffect = "move";
    }
}



// on drop handler
function dropHandler(e) {
    e.preventDefault();

    const droppedEleId = e.dataTransfer.getData("text/plain");
    
    if (source == 'bank') {
        // clone image if dragging from source (bank)

        // clone to make new dropped element
        var newNode = document.getElementById(droppedEleId).cloneNode(true);
        newNode.id = droppedEleId + '-copy-' + copyNum++;
        newNode.addEventListener('dragstart', (e) => {
            dragStartHandler(e);
        });
    }
    else {
        // move image (not clone) if dragging from gear slot
        var newNode = document.getElementById(droppedEleId);
    }



    // if image exists already, delete it first, then append
    if (e.target.children.length > 0) {
        e.target.children[0].remove();
    }

    e.target.appendChild(newNode);



    setSkillId(e.target.id);
}



// set the skill's id from the dropped image
function setSkillId(skillTypeId) {
    var slotEle = document.getElementById(skillTypeId);
    var droppedEle = slotEle.children[0];

    // get skil; id
    var skillId = droppedEle.getAttribute('data-skill-id');

    // set id to input value
    document.getElementById('hidden-' + skillTypeId).value = skillId;
}



// assign dragstart listener on draggable elements
var draggableEle = document.getElementsByClassName('draggable');
for (let i = 0; i < draggableEle.length; i++) {
    draggableEle[i].addEventListener('dragstart', (e) => {
        dragStartHandler(e);
    });
}



// assign dragover, drop listeners on drag-into elements
var dragIntoEle = document.getElementsByClassName('drag-into');
for (let i = 0; i < dragIntoEle.length; i++) {
    dragIntoEle[i].addEventListener('dragover', (e) => {
        dragOverHandler(e);
    });

    dragIntoEle[i].addEventListener('drop', (e) => {
        dropHandler(e);
    });
}