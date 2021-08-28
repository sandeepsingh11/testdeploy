// ==================== HANDLE DRAG AND DROP ==================== //

// global vars
var source = '';
var draggedSkillName = '';
var draggedSkillId = -1;
var draggedSkillType = '';



// on dragstart handler
function dragStartHandler(e) {
    e.dataTransfer.effectAllowed = "copyMove";
    
    
    // set draggable info
    e.dataTransfer.setData("text/uri-list", e.target.src);
    e.dataTransfer.setData("text/plain", e.target.src);
    draggedSkillName = e.target.dataset.skillName;
    draggedSkillId = e.target.dataset.skillId;
    draggedSkillType = e.target.dataset.skillType;
    source = e.target.parentElement.dataset.source;
}



// on dragover handler
function dragOverHandler(e) {
    e.preventDefault();
    
    // if (source == 'bank') {
    //     e.dataTransfer.dropEffect = "copy";
    // }
    // else if (source == 'slot') {
    //     e.dataTransfer.dropEffect = "move";
    // }
}



// on drop handler
function dropHandler(e) {
    e.preventDefault();

    
    // skill types of 'Main' must be dropped in the 'Main' skill slot
    if (draggedSkillType === 'Main') {
        
        if (e.target.parentNode.id !== 'skill-main') {

            // illegal drop
            return;
        }
    }

    // get dropped image url
    var droppedImageUrl = e.dataTransfer.getData("text/plain");
        
        
    // update newly dropped image values
    e.target.src = droppedImageUrl;
    e.target.alt = draggedSkillName;
    e.target.dataset.skillId = draggedSkillId;
    e.target.dataset.skillName = draggedSkillName;


    // set the dropped skill's id to the hidden input field
    document.getElementById('hidden-' + e.target.parentNode.id).value = draggedSkillId;
    
    

    var highMidLowFiles = [
        'BombDamage_Reduction',
        'BombDistance_Up',
        'HumanMove_Up',
        'InkRecovery_Up',
        'JumpTime_Save',
        'MainInk_Save',
        'MarkingTime_Reduction',
        'OpInkEffect_Reduction',
        'RespawnSpecialGauge_Save',
        'RespawnTime_Save',
        'SpecialIncrease_Up',
        'SpecialTime_Up',
        'SquidMove_Up',
        'SubInk_Save'
    ];

    if (highMidLowFiles.indexOf(draggedSkillName) != -1) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // console.log(this);
                var res = JSON.parse(this.response);
                // console.log(res[draggedSkillName]);
                
                var hml = getHML(res[draggedSkillName], 'SpecialRt_Restart');
    
                // get all inputted skill names
                var inputtedSkillNames = getInputtedSkillNames();

                // map number of main and subs to each inputted skill
                var mainAndSubs = getMainAndSubs(inputtedSkillNames);

                // calculate ability effect for each inputted skill
                mainAndSubs.forEach(skillObj => {
                    var val = calculateAbilityEffect(skillObj.main, skillObj.subs, hml[0], hml[1], hml[2], skillObj.skillName);
                    // console.log(val);
                });



            }
        };
        xhttp.open("GET", "/storage/Player/Player_Spec_" + draggedSkillName + ".json", true);
        xhttp.send();
    
        // $.getJSON("/storage/Player/Player_Spec_RespawnSpecialGauge_Save.json", function(data) {
        //     console.log(data);
        // });
    }

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





// get all current skill names
function getInputtedSkillNames() {
    var mainSkillEle = document.getElementById('skill-main');
    var sub1Ele = document.getElementById('skill-sub-1');
    var sub2Ele = document.getElementById('skill-sub-2');
    var sub3Ele = document.getElementById('skill-sub-3');

    var mainSkillName = mainSkillEle.children[0].dataset.skillName;
    var sub1SkillName = sub1Ele.children[0].dataset.skillName;
    var sub2SkillName = sub2Ele.children[0].dataset.skillName;
    var sub3SkillName = sub3Ele.children[0].dataset.skillName;

    return [mainSkillName, sub1SkillName, sub2SkillName, sub3SkillName];
}


// get and map number of main and subs to the inputted skill names
function getMainAndSubs(skillNames) {
    
    // mainAndSubs structure:
    // [
    //     'skill name': {
    //         'skillName' : 'skill name',
    //         'main': 1,
    //         'subs': 0
    //     },
    //     'skill name 2': {
    //         'skillName' : 'skill name 2',
    //         'main': 0,
    //         'subs': 3
    //     }
    // ]


    // array of skill objects
    var mainAndSubs = [];

    for (var i = 0; i < skillNames.length; i++) {
        
        if (skillNames[i] != 'unknown') {
            var skillNameExists = false;
            
            // check if the current skill name exists
            for (var j = 0; j < mainAndSubs.length; j++) {
                if (skillNames[i] == mainAndSubs[j].skillName) {
                    skillNameExists = true;
                    break;  
                } 
            }


            // if skill name does not exist, add it
            if (!skillNameExists) {

                var skillObj = {
                    'skillName': skillNames[i],
                    'main': 0,
                    'subs': 0
                };
    
                
                // set 'main' count
                skillObj.main = (i == 0) ? 1 : 0;
    
                // set 'subs' count
                var numOfSubs = 0;
                if (skillNames[1] == skillNames[i]) numOfSubs++;
                if (skillNames[2] == skillNames[i]) numOfSubs++;
                if (skillNames[3] == skillNames[i]) numOfSubs++;
    
                skillObj.subs = numOfSubs;
    
    
    
                mainAndSubs.push(skillObj);
            }
        }
    }

    return mainAndSubs;
}




// get high, mid, and low values
function getHML(data, key) {
    var high = 0
    var mid = 0
    var low = 0

    if ((key + "_High") in data) {
        high = data[key + "_High"]
        mid = data[key + "_Mid"]
        low = data[key + "_Low"] || data[key] || 0.0
    } else if ((key + "High") in data) {
        high = data[key + "High"]
        mid = data[key + "Mid"]
        low = data[key + "Low"] || data[key] || 1.0
    } else {
        high = data[key + "H"]
        mid = data[key + "M"]
        low = data[key + "L"] || data[key] || 1.0
    }

    return [high, mid, low]
}

// main, sub to AP points
function getAPs(numOfMains, numOfSubs) {
    return (10 * numOfMains) + (3 * numOfSubs);
}

// percent difference
function getPercentage(AP) {
    return Math.min( (3.3 * AP) - (0.027 * Math.pow(AP, 2)), 100 );
}

// slope
function getSlope(high, mid, low) {
    if (mid == low) return 0;

    return (mid - low) / (high - low);
}

// lerpN
function getLerpN(percentage, slope) {
    if (slope.toFixed(3) == 0.5) {
        return percentage;
    }
    if (percentage == 0.0) {
        return percentage;
    }
    if (percentage == 1.0) {
        return percentage;
    }
    if (slope != 0.5) {
        return Math.pow( Math.E, -1 * (Math.log(percentage / 100) * Math.log(slope) / Math.log(2)) );
    }
}

// result
function getResult(high, low, lerpN) {
    return low + (high - low) * lerpN;
}

// get the value of an ability's effect value with the current gear's skills
function calculateAbilityEffect(numOfMains, numOfSubs, high, mid, low, abilityName) {
    var APs = getAPs(numOfMains, numOfSubs);
    var percentage = getPercentage(APs);
    var slope = getSlope(high, mid, low);
    var lerpN = getLerpN(percentage, slope);
    var result = getResult(high, low, lerpN);

    console.log(`AP: ${APs}, p: ${percentage}, s: ${slope}, lerpN: ${lerpN}`);
    return result;
}