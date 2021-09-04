// ==================== HANDLE DRAG AND DROP ==================== //

const { forEach } = require("lodash");

// global vars
var source = '';
var draggedSkillName = '';
var draggedSkillId = -1;
var draggedSkillType = '';
var allWeaponData = [];
var allSpecialData = [];
var allSubData = [];



// load inital data
window.addEventListener('load', function() {
    loadData();
 });

function loadData() {
    loadWeaponData();
    // loadSpecialData();
    loadSubData();
}

function loadWeaponData() {
    $.getJSON('/storage/540/WeaponInfo_Main.json', function(weaponJson) {
        $.each(weaponJson, function(idx, weapon) {
            // get weapon name
            var weaponNameSplit = weapon["Name"].split("_");
            var weaponName = weaponNameSplit[0] + weaponNameSplit[1];
            if (weaponName.includes("Blaster")) {
                weaponName = weaponName.substring(7);
            }

            
            // get weapon stats
            $.getJSON('/storage/540/WeaponBullet/' + weaponName + '.json', function(bulletJson) {
                if (weaponName.includes("Spinner") || weaponName.includes("Twins")) {
                    $.getJSON('/storage/540/WeaponBullet/' + weaponName + '_2.json', function(data) {
                        allWeaponData[weapon["Name"]] = [weapon, Object.assign({}, bulletJson['param'], data['param'])];
                    });
                }
                else if (weaponName.includes("Blaster")) {
                    $.getJSON('/storage/540/WeaponBullet/' + weaponName + '_Burst.json', function(data) {
                        allWeaponData[weapon["Name"]] = [weapon, Object.assign({}, bulletJson['param'], data['param'])];
                    });
                }
                else if (weaponName.includes("Roller")) {
                    $.getJSON('/storage/540/WeaponBullet/' + weaponName + '_Stand.json', function(data) {
                        $.getJSON('/storage/540/WeaponBullet/' + weaponName + '_Jump.json', function(data2) {
                            var dataObj = {};
                            $.each(bulletJson['param'], function(key, val) {
                                dataObj[key] = val;
                            });
                            $.each(data['param'], function(key, val) {
                                dataObj['Stand_' + key] = val;
                            });
                            $.each(data2['param'], function(key, val) {
                                dataObj['Jump_' + key] = val;
                            });
                            
                            allWeaponData[weapon["Name"]] = [weapon, dataObj];
                        });
                    });
                }
                else {
                    allWeaponData[weapon["Name"]] = [weapon, bulletJson['param']];
                }
            });
        });
    });
}

function loadSubData() {
    $.getJSON('/storage/540/WeaponInfo_Sub.json', function(subJson) {
        $.each(subJson, function(index, subweapon) {
            if (subweapon["Id"] < 100) {
                var subname = subweapon["Name"];
                var subInternalName = subname;

                if (subname.includes("Bomb_")) {
                    subInternalName = subname.replace("Bomb_", "Bomb")
                }
                if (subname == "TimerTrap") {
                    subInternalName = "Trap";
                }
                if (subname.includes("Poison") || subname.includes("Point")) {
                    subInternalName = "Bomb" + subname;
                }
                if (subname == "Flag") {
                    subInternalName = "JumpBeacon";
                }


                // get sub stats
                $.getJSON('/storage/540/WeaponBullet/' + subInternalName + '.json', function(bulletJson) {
                    allSubData[subweapon["Name"]] = [subweapon, bulletJson["param"]];
                });
            }
        });
    });
}




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

    
                // get all inputted skill names
                var inputtedSkillNames = getInputtedSkillNames();

                // map number of main and subs to each inputted skill
                var mainAndSubs = getMainAndSubs(inputtedSkillNames);

                // calculate ability effect for each inputted skill
                mainAndSubs.forEach(skillObj => {
                    console.log(skillObj.skillName);

                    if (skillObj.skillName == 'RespawnTime_Save') {
                        var aroudHML = getHML(res[draggedSkillName], 'Dying_AroudFrm');
                        var chaseHML = getHML(res[draggedSkillName], 'Dying_ChaseFrm');

                        
                        var aroudVal = calculateAbilityEffect(skillObj.main, skillObj.subs, aroudHML[0], aroudHML[1], aroudHML[2], skillObj.skillName);
                        var chaseVal = calculateAbilityEffect(skillObj.main, skillObj.subs, chaseHML[0], chaseHML[1], chaseHML[2], skillObj.skillName);

                        var deathCamObj = {
                            Frames: Math.ceil(aroudVal),
                            Seconds: (Math.ceil(aroudVal) / 60).toFixed(2)
                        };
                        var dyingObj = {
                            Frames: Math.ceil(chaseVal),
                            Seconds: (Math.ceil(chaseVal) / 60).toFixed(2)
                        };
                        console.log(deathCamObj);
                        console.log(dyingObj);
                    }
                    else if (skillObj.skillName == 'OpInkEffect_Reduction') {
                        var jumpHML = getHML(res[draggedSkillName], 'OpInk_JumpGnd');
                        var velShotHML = getHML(res[draggedSkillName], 'OpInk_VelGnd_Shot');
                        var velHML = getHML(res[draggedSkillName], 'OpInk_VelGnd');
                        var damageLimitHML = getHML(res[draggedSkillName], 'OpInk_Damage_Lmt');
                        var damageHML = getHML(res[draggedSkillName], 'OpInk_Damage');
                        var armorHML = getHML(res[draggedSkillName], 'OpInk_Armor_HP');

                        var jumpVal = calculateAbilityEffect(skillObj.main, skillObj.subs, jumpHML[0], jumpHML[1], jumpHML[2], skillObj.skillName);
                        var velShotVal = calculateAbilityEffect(skillObj.main, skillObj.subs, velShotHML[0], velShotHML[1], velShotHML[2], skillObj.skillName);
                        var velVal = calculateAbilityEffect(skillObj.main, skillObj.subs, velHML[0], velHML[1], velHML[2], skillObj.skillName);
                        var damageLimitVal = calculateAbilityEffect(skillObj.main, skillObj.subs, damageLimitHML[0], damageLimitHML[1], damageLimitHML[2], skillObj.skillName);
                        var damageVal = calculateAbilityEffect(skillObj.main, skillObj.subs, damageHML[0], damageHML[1], damageHML[2], skillObj.skillName);
                        var armorVal = calculateAbilityEffect(skillObj.main, skillObj.subs, armorHML[0], armorHML[1], armorHML[2], skillObj.skillName);

                        var jumpObj = {
                            Effect: jumpVal.toFixed(4)
                        };
                        var velShotObj = {
                            Effect: velShotVal.toFixed(4)
                        };
                        var velObj = {
                            Effect: velVal.toFixed(4)
                        };
                        var damageLimitObj = {
                            Effect: damageLimitVal.toFixed(4)
                        };
                        var damageObj = {
                            Effect: damageVal.toFixed(4)
                        };
                        var armorObj = {
                            Effect: Math.ceil(armorVal)
                        };
                        console.log(jumpObj);
                        console.log(velShotObj);
                        console.log(velObj);
                        console.log(damageLimitObj);
                        console.log(damageObj);
                        console.log(armorObj); 
                    }
                    else if (skillObj.skillName == 'MarkingTime_Reduction') {
                        var pointSensorHML = getHML(res[draggedSkillName], 'MarkingTime_ShortRt');
                        var inkMineHML = getHML(res[draggedSkillName], 'MarkingTime_ShortRt_Trap');
                        var silFarHML = getHML(res[draggedSkillName], 'Silhouette_DistFar');
                        var silNearHML = getHML(res[draggedSkillName], 'Silhouette_DistNear');

                        var pointSensorVal = calculateAbilityEffect(skillObj.main, skillObj.subs, pointSensorHML[0], pointSensorHML[1], pointSensorHML[2], skillObj.skillName);
                        var inkMineVal = calculateAbilityEffect(skillObj.main, skillObj.subs, inkMineHML[0], inkMineHML[1], inkMineHML[2], skillObj.skillName);
                        var silFarVal = calculateAbilityEffect(skillObj.main, skillObj.subs, silFarHML[0], silFarHML[1], silFarHML[2], skillObj.skillName);
                        var silNearVal = calculateAbilityEffect(skillObj.main, skillObj.subs, silNearHML[0], silNearHML[1], silNearHML[2], skillObj.skillName);

                        var pointSensorObj = {
                            Effect: pointSensorVal.toFixed(4)
                        };
                        var inkMineObj = {
                            Effect: inkMineVal.toFixed(4)
                        };
                        var silFarObj = {
                            Effect: silFarVal.toFixed(4)
                        };
                        var silNearObj = {
                            Effect: silNearVal.toFixed(4)
                        };
                        console.log(pointSensorObj);
                        console.log(inkMineObj);
                        console.log(silFarObj);
                        console.log(silNearObj);
                    }
                    else if (skillObj.skillName == 'JumpTime_Save') {
                        var prepareHML = getHML(res[draggedSkillName], 'DokanWarp_TameFrm');
                        var superJumpHML = getHML(res[draggedSkillName], 'DokanWarp_MoveFrm');

                        var prepareVal = calculateAbilityEffect(skillObj.main, skillObj.subs, prepareHML[0], prepareHML[1], prepareHML[2], skillObj.skillName);
                        var superJumpVal = calculateAbilityEffect(skillObj.main, skillObj.subs, superJumpHML[0], superJumpHML[1], superJumpHML[2], skillObj.skillName);

                        var prepareObj = {
                            Frames: Math.ceil(prepareVal),
                            Seconds: (Math.ceil(prepareVal) / 60).toFixed(2)
                        };
                        var superJumpObj = {
                            Frames: Math.ceil(superJumpVal),
                            Seconds: (Math.ceil(superJumpVal) / 60).toFixed(2)
                        };
                        console.log(prepareObj);
                        console.log(superJumpObj);
                    }
                    else if (skillObj.skillName == 'InkRecovery_Up') {
                        var squidFormHML = getHML(res[draggedSkillName], 'RecoverFullFrm_Ink');
                        var humanFormHML = getHML(res[draggedSkillName], 'RecoverNrmlFrm_Ink');

                        var squidFormVal = calculateAbilityEffect(skillObj.main, skillObj.subs, squidFormHML[0], squidFormHML[1], squidFormHML[2], skillObj.skillName);
                        var humanFormVal = calculateAbilityEffect(skillObj.main, skillObj.subs, humanFormHML[0], humanFormHML[1], humanFormHML[2], skillObj.skillName);

                        var squidFormObj = {
                            Frames: Math.ceil(squidFormVal),
                            Seconds: (Math.ceil(squidFormVal) / 60).toFixed(2)
                        };
                        var humanFormObj = {
                            Frames: Math.ceil(humanFormVal),
                            Seconds: (Math.ceil(humanFormVal) / 60).toFixed(2)
                        };
                        console.log(squidFormObj);
                        console.log(humanFormObj);
                    }
                    else if (skillObj.skillName == 'BombDamage_Reduction') {
                        var specialDamageHML = getHML(res[draggedSkillName], 'BurstDamageRt_Special');
                        var subNearHML = getHML(res[draggedSkillName], 'BurstDamageRt_SubH');
                        var subFarHML = getHML(res[draggedSkillName], 'BurstDamageRt_SubL');

                        var specialDamageVal = calculateAbilityEffect(skillObj.main, skillObj.subs, specialDamageHML[0], specialDamageHML[1], specialDamageHML[2], skillObj.skillName);
                        var subNearVal = calculateAbilityEffect(skillObj.main, skillObj.subs, subNearHML[0], subNearHML[1], subNearHML[2], skillObj.skillName);
                        var subFarVal = calculateAbilityEffect(skillObj.main, skillObj.subs, subFarHML[0], subFarHML[1], subFarHML[2], skillObj.skillName);

                        var specialDamageObj = {
                            Effect: specialDamageVal.toFixed(4)
                        };
                        var subNearObj = {
                            Effect: subNearVal.toFixed(4)
                        };
                        var subFarObj = {
                            Effect: subFarVal.toFixed(4)
                        };
                        console.log(specialDamageObj);
                        console.log(subNearObj);
                        console.log(subFarObj);
                    }
                    else if (skillObj.skillName == 'MainInk_Save') {
                        // console.log(allWeaponData);
                        var weapon = allWeaponData['Twins_Short_00']; // Shooter_Short_00, Shooter_BlasterShort_00, Roller_Compact_00, Twins_Short_00
                        var weaponName = weapon[0]["Name"];
                        // console.log(weaponName);


                        // get ink consume val
                        var inkConsume = 0
                        if (weaponName.includes('Roller')) {
                            inkConsume = weapon[1].Stand_mInkConsumeSplash;
                        }
                        else {
                            if (weaponName.includes('Charger')) {
                                inkConsume = weapon[1].mFullChargeInkConsume || weapon[1].mInkConsume;
                            }
                            else {
                                inkConsume = weapon[1].mInkConsume;
                            }
                        }


                        // prep values to calc
                        var key = '';
                        if (weapon[0].InkSaverLv == 'Low') key = 'ConsumeRt_Main_Low';
                        else if (weapon[0].InkSaverLv == 'High') key = 'ConsumeRt_Main_High';
                        else key = 'ConsumeRt_Main';

                        // calc
                        var consumeRateHML = getHML(res[draggedSkillName], key);
                        var consumeRateVal = calculateAbilityEffect(skillObj.main, skillObj.subs, consumeRateHML[0], consumeRateHML[1], consumeRateHML[2], skillObj.skillName);

                        var inkTankSize = weapon[1].mInkMagazineRatio || 1.0;



                        var consumeRateObj = {
                            Effect: (consumeRateVal * inkConsume).toFixed(5),
                            MaxShots: Math.floor(inkTankSize / (consumeRateVal * inkConsume))
                        };
                        // console.log(consumeRateVal + ', ' + inkConsume + ', ' + inkTankSize);
                        console.log(consumeRateObj);


                        return consumeRateObj;
                    }
                    else if (skillObj.skillName == 'SubInk_Save') {
                        var weapon = allWeaponData['Roller_Compact_00']; // Shooter_Short_00, Shooter_BlasterShort_00, Roller_Compact_00, Twins_Short_00


                        // prep sub info
                        var subData = allSubData[weapon[0].Sub];
                        var inkConsume = subData[1].mInkConsume;
                        var key;
                        // console.log(subData[0].Name);

                        if ('ConsumeRt_Sub_A_Low' in res[draggedSkillName]) {
                            key = "ConsumeRt_Sub_" + subData[0].InkSaverType;
                        }
                        else {
                            if (subData[0].InkSaverLv == "Middle") {
                                key = "ConsumeRt_Sub";
                            }
                            else {
                                key = "ConsumeRt_Sub_" + subData[0].InkSaverLv;
                            }
                        }

                        var consumeRateHML = getHML(res[draggedSkillName], key);
                        var consumeRateVal = calculateAbilityEffect(skillObj.main, skillObj.subs, consumeRateHML[0], consumeRateHML[1], consumeRateHML[2], skillObj.skillName);

                        var consumeRateObj = {
                            Effect: (consumeRateVal * inkConsume).toFixed(5)
                        };
                        console.log(consumeRateObj);


                        return consumeRateObj;
                    }
                    else {
                        var hml = getHML(res[draggedSkillName], 'SpecialRt_Restart');

                        var val = calculateAbilityEffect(skillObj.main, skillObj.subs, hml[0], hml[1], hml[2], skillObj.skillName);
                        // console.log(val);
                    }
                });



            }
        };
        xhttp.open("GET", "/storage/540/Player/Player_Spec_" + draggedSkillName + ".json", true);
        xhttp.send();
    
        // $.getJSON("/storage/Player/Player_Spec_RespawnSpecialGauge_Save.json", function(data) {
        //     console.log(data);
        // });
    }

}





// get weapon stats info
function getWeaponStats(weaponName) {
    var weaponData = null;

    // weapon stats info
    // use $.ajax for synchronous calls
    $.ajax({
        url: "/storage/540/WeaponBullet/" + weaponName + ".json",
        dataType: 'json',
        async: false,
        success: function(bulletJson) {

            if (weaponName.includes("Spinner") || weaponName.includes("Twins")) {
                $.ajax({
                    url: "/storage/540/WeaponBullet/" + weaponName + "_2.json",
                    dataType: 'json',
                    async: false,
                    success: function(data) {
                        weaponData = Object.assign({}, bulletJson['param'], data['param']);
                        return weaponData;
                    }
                });
            }
            else if (weaponName.includes("Blaster")) {
                $.ajax({
                    url: "/storage/540/WeaponBullet/" + weaponName + "_Burst.json",
                    dataType: 'json',
                    async: false,
                    success: function(data) {
                        weaponData = Object.assign({}, bulletJson['param'], data['param']);
                        return weaponData;
                    }
                });
            }
            else if (weaponName.includes("Roller")) {
                $.ajax({
                    url: "/storage/540/WeaponBullet/" + weaponName + "_Stand.json",
                    dataType: 'json',
                    async: false,
                    success: function(data) {
                        $.ajax({
                            url: "/storage/540/WeaponBullet/" + weaponName + "_Jump.json",
                            dataType: 'json',
                            async: false,
                            success: function(data2) {
                                var dataObj = {};
                                $.each(bulletJson['param'], function(key, val) {
                                    dataObj[key] = val;
                                });
                                $.each(data['param'], function(key, val) {
                                    dataObj['Stand_' + key] = val;
                                });
                                $.each(data2['param'], function(key, val) {
                                    dataObj['Jump_' + key] = val;
                                });
                                
                                weaponData = dataObj;
                                return weaponData;
                            }
                        });
                    }
                });
            }
            else {
                weaponData = bulletJson['param'];
                return weaponData;
            }


            return weaponData;
        }
    });


    return weaponData;
}



// get sub stats info
function getSubStats() {
    var subData = [];

    // sub stats info
    // use $.ajax for synchronous calls
    $.ajax({
        url: "/storage/540/WeaponInfo_Sub.json",
        dataType: 'json',
        async: false,
        success: function(subJson) {
            $.each(subJson, function(index, subweapon) {
                if (subweapon["Id"] < 100) {
                    var subname = subweapon["Name"];
                    var subInternalName = subname;

                    if (subname.includes("Bomb_")) {
                        subInternalName = subname.replace("Bomb_", "Bomb")
                    }
                    if (subname == "TimerTrap") {
                        subInternalName = "Trap";
                    }
                    if (subname.includes("Poison") || subname.includes("Point")) {
                        subInternalName = "Bomb" + subname;
                    }
                    if (subname == "Flag") {
                        subInternalName = "JumpBeacon";
                    }

                    $.ajax({
                        url: "/storage/540/WeaponBullet/" + subInternalName + ".json",
                        dataType: 'json',
                        async: false,
                        success: function(bulletJson) {
                            subData[subweapon["Name"]] = [subweapon, bulletJson["param"]];
                            return subData;
                        }
                    });
                }
            });


            return subData;
        }
    });


    return subData;
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
        return Math.pow( Math.E, -1 * (Math.log(percentage) * Math.log(slope) / Math.log(2)) );
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
    var lerpN = getLerpN(percentage / 100, slope);
    var result = getResult(high, low, lerpN);

    console.log(`AP: ${APs}, p: ${percentage}, s: ${slope}, lerpN: ${lerpN} h:${high} m:${mid} l:${low}`);
    return result;
}