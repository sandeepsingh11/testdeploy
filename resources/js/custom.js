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
    loadSpecialData();
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

function loadSpecialData() {
    $.getJSON('/storage/540/WeaponInfo_Special.json', function(specialJson) {
        $.each(specialJson, function(idx, specialweapon) {
            if (specialweapon["Id"] != 15 && specialweapon["Id"] != 16 && specialweapon["Id"] != 13 && specialweapon["Id"] <= 18 ) {

                var special_internal_name = specialweapon["Name"];

                if (specialweapon["Name"].includes("Launcher")) {
                    special_internal_name = "Bomb" + specialweapon["Name"].replace("Launcher", "") + "Launcher";
                }

                // get special stats
                $.getJSON("/storage/540/WeaponBullet/" + special_internal_name  + ".json", function(bulletJson) {
                    specialweapon["Name"] = special_internal_name;
                    allSpecialData[special_internal_name] = [specialweapon, bulletJson["param"]];
                })
            }
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
                        // calc bomb defense up values
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

                        
                        // calc cold-blooded values
                        $.getJSON('/storage/540/Player/Player_Spec_MarkingTime_Reduction.json', function(data) {
                            var pointSensorHML = getHML(data['MarkingTime_Reduction'], 'MarkingTime_ShortRt');
                            var inkMineHML = getHML(data['MarkingTime_Reduction'], 'MarkingTime_ShortRt_Trap');
                            var silFarHML = getHML(data['MarkingTime_Reduction'], 'Silhouette_DistFar');
                            var silNearHML = getHML(data['MarkingTime_Reduction'], 'Silhouette_DistNear');

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
                        });
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
                    else if (skillObj.skillName == 'SpecialIncrease_Up') {
                        var weapon = allWeaponData['Shooter_Short_00']; // Shooter_Short_00, Shooter_BlasterShort_00, Roller_Compact_00, Twins_Short_00
                        // var specialData = allSpecialData[weapon[0].Special];

                        var chargeUpHML = getHML(res[draggedSkillName], 'SpecialRt_Charge');
                        var chargeUpVal = calculateAbilityEffect(skillObj.main, skillObj.subs, chargeUpHML[0], chargeUpHML[1], chargeUpHML[2], skillObj.skillName);

                        var chargeUpObj = {
                            Effect: Math.ceil(weapon[0]["SpecialCost"] / chargeUpVal)
                        };
                        console.log(chargeUpObj);


                        return chargeUpObj;
                    }
                    else if (skillObj.skillName == 'SpecialTime_Up') {
                        var weapon = allWeaponData['Twins_Short_00']; // Shooter_Short_00, Shooter_BlasterShort_00, Roller_Compact_00, Twins_Short_00

                        // get special data
                        var specialName = weapon[0].Special;
                        if (weapon[0].Special.includes("Launcher")) {
                            specialName = "Bomb" + weapon[0].Special.replace("Launcher", "") + "Launcher";
                        }
                        var specialData = allSpecialData[specialName];


                        // prep special values
                        if (specialData[0]["Name"] == "SuperLanding") {
                            specialData[1]["mBurst_Landing_AddHeight"] = 0.0;
                            specialData[1]["mBurst_Landing_AddHeight_SJ"] = 0.0;
                        }

                        if ((specialData[0]["Name"] == "SuperBubble") || (specialData[0]["Name"] == "Jetpack")) {
                            specialData[1]["mBombCoreRadiusRate"] = 1.0;
                        }

                        var keys = {
                            "mBurst_PaintR": "Paint Radius",
                            "mTargetInCircleRadius": "Circle Radius",
                            "mEnergyAbsorbFrm": "Armor Wind Up Time",
                            "mPaintGauge_SpecialFrm": "Special Duration Time",
                            "mBurst_SplashPaintR": "Splash Paint Radius",
                            "mBurst_SplashVelL": "Splash Velocity L",
                            "mBurst_SplashVelH": "Splash Velocity H",
                            "mBurst_Landing_AddHeight": "Additional High",
                            "mBurst_Landing_AddHeight_SJ": "Additional High (Super Jump)",
                            "mRainAreaFrame": "Rain Duration",
                            "mBurst_Radius_Far": "Explosion Radius (Far)",
                            "mBurst_Radius_Middle": "Explosion Radius (Middle)",
                            "mBurst_Radius_Near": "Explosion Radius (Near)",
                            "mHP": "HP",
                            "mBombCoreRadiusRate": "Core Radius Rate",
                            "mCollisionPlayerRadiusMax": "Explosion Effect Radius",
                            "mChargeRtAutoIncr": "Booyah Charge Speed"
                        }

                        var frameKeys = ["mRainAreaFrame", "mEnergyAbsorbFrm", "mPaintGauge_SpecialFrm"];


                        // calc if current property from 'key' var exists in specialData
                        $.each(keys, function(name, translation) {
                            if (name in specialData[1] || name + "_Low" in specialData[1]) {
                                if (name + "H" in specialData[1] || name + "High" in specialData[1] || name + "_High" in specialData[1]) {
                                    var specialPUHML = getHML(specialData[1], name);
                                    var specialPUVal = calculateAbilityEffect(skillObj.main, skillObj.subs, specialPUHML[0], specialPUHML[1], specialPUHML[2], skillObj.skillName);

                                    var eff = 0;
                                    if (name == "mHP") {
                                        eff = Math.floor(specialPUVal * 1) / 10;
                                    } else if (frameKeys.includes(name)) {
                                        eff = Math.ceil(specialPUVal * 1);
                                    } else {
                                        eff = (specialPUVal * 1).toFixed(5);
                                    }

                                    var specialPUObj = {
                                        Effect: eff,
                                    }
                                    console.log(specialPUObj);


                                    return specialPUObj;
                                }
                            }
                        });
                    }
                    else if (skillObj.skillName == 'MarkingTime_Reduction') {
                        var weapon = allWeaponData['Shooter_BlasterShort_00']; // Shooter_Short_00, Shooter_BlasterShort_00, Roller_Compact_00, Twins_Short_00

                        var keys = {
                            'mBulletDamageMaxDist': 'Bullet Damage Max Distance',
                            'mBulletDamageMinDist': 'Bullet Damage Min Distance',
                            'mCanopyHP': 'Canopy HP',
                            'mCanopyNakedFrame': 'Canopy Recovery Time',
                            'mCollisionRadiusFarRate': 'Collision Radius Far',
                            'mCollisionRadiusMiddleRate': 'Collision Radius Middle',
                            'mCollisionRadiusNearRate': 'Collision Radius Near',
                            'mCoreDamageRate': 'Core Damage Rate',
                            'mCorePaintWidthHalfRate': 'Core Paint Width Half Rate',
                            'mDamageMaxMaxChargeRate': 'Damage Max Charge Rate',
                            'mDamageRate': 'Damage',
                            'mDashSpeed': 'Dash Speed',
                            'mDegBias': 'Degree Bias',
                            'mDegJumpBiasInterpolateRate': 'Jump Bias Interpolation Rate',
                            'mDegJumpBias': 'Degree Jump Bias',
                            'mDegJumpRandom': 'Degree Jump Random',
                            'mDegRandom': 'Degree Random',
                            'mDropSplashPaintRadiusRate': 'Drop Splash Paint Radius Rate',
                            'mFirstGroupBulletBoundPaintRadiusRate': 'Group 1 Bullet Paint Radius Rate (Outer)',
                            'mFirstGroupBulletDamageRate': 'Group 1 Bullet Damage Rate',
                            'mFirstGroupBulletFirstPaintRRate': 'Group 1 Bullet Paint Radius Rate',
                            'mFirstGroupBurst_PaintRRate': 'Group 1 Bullet PaintR Rate',
                            'mFirstGroupSplashPaintRadiusRate': 'Group 1 Bullet Splash Paint Radius Rate',
                            'mFirstSecondMaxChargeShootingFrameTimes': 'Splatling Max Charge Frame',
                            'mFullChargeDamageRate': 'Full Charge Damage',
                            'mFullChargeDistance': 'Full Charge Distance',
                            'mInitVelRate': 'Init Velocity Rate',
                            'mInkConsumeCoreMaxSpeed': 'Ink Consume Max Speed',
                            'mInkConsumeCoreMinSpeed': 'Ink Consume Min Speed',
                            'mKnockBackRadiusRate': 'Knock Back Radius',
                            'mMaxDistance': 'Max Distance',
                            'mMinMaxChargeDamageRate': 'Max Shooting Damage',
                            'mMoveSpeed': 'Move Speed',
                            'mSecondGroupBulletBoundPaintRadiusRate': 'Group 2 Bullet Paint Radius Rate (Outer)',
                            'mSecondGroupBulletDamageRate': 'Group 2 Bullet Damage Rate',
                            'mSecondGroupBulletFirstPaintRRate': 'Group 2 Bullet Paint Radius Rate',
                            'mSecondGroupBurst_PaintRRate': 'Group 2 Bullet PaintR Rate',
                            'mSecondGroupSplashPaintRadiusRate': 'Group 2 Bullet Splash Paint Radius Rate',
                            'mSideStepOneMuzzleDamageRate': 'Side Step One Muzzle Damage',
                            'mSphereSplashDropPaintRadiusRate': 'Sphere Splash Drop Paint Radius',
                            'mSplashDamageInsideRate': 'Splash Damage Inside Rate',
                            'mSplashDamageOutsideRate': 'Splash Damage Outside Rate',
                            'mSplashPaintRadiusRate': 'Paint Radius Rate',
                            'mSplashPaintRadius': 'Paint Radius',
                            'mThirdGroupBulletBoundPaintRadiusRate': 'Group 3 Bullet Paint Radius Rate (Outer)',
                            'mThirdGroupBulletDamageRate': 'Group 3 Bullet Damage Rate',
                            'mThirdGroupBulletFirstPaintRRate': 'Group 3 Bullet Paint Radius Rate',
                            'mThirdGroupBurst_PaintRRate': 'Group 3 Bullet PaintR Rate',
                            'mThirdGroupSplashPaintRadiusRate': 'Group 3 Bullet Splash Paint Radius Rate'
                        }
                        var dmgKeys = ["mDamageRate", "mMinMaxChargeDamageRate", "mFullChargeDamageRate", "mDamageMaxMaxChargeRate", "mCoreDamageRate", "mSideStepOneMuzzleDamageRate"];
                        var rates = ["mCollisionRadiusFarRate", "mCollisionRadiusMiddleRate", "mCollisionRadiusNearRate", "mKnockBackRadiusRate", "mSphereSplashDropPaintRadiusRate"];

                        $.each(keys, function(name, translation) {
                            if (name + "_MWPUG_High" in weapon[1] || "Stand_" + name + "_MWPUG_High" in weapon[1] || "Jump_" + name + "_MWPUG_High" in weapon[1]) {
                                var mainPUHML = getHML_MWPUG(weapon[1], name);
                                
                                if (mainPUHML[0] != mainPUHML[1]) {
                                    var mainPUVal = calculateAbilityEffect(skillObj.main, skillObj.subs, mainPUHML[0], mainPUHML[1], mainPUHML[2], skillObj.skillName);
                                    var eff = 0;

                                    if (name == "mCanopyHP") {
                                        eff = Math.floor(mainPUVal * 1) / 10;
                                    } 
                                    else if (name == "mCanopyNakedFrame") {
                                        eff = Math.ceil(mainPUVal * 1);
                                    } 
                                    else if (name == "mFirstSecondMaxChargeShootingFrameTimes") {
                                        var f1 = weapon[1]["mFirstPeriodMaxChargeShootingFrame"];
                                        var f2 = weapon[1]["mSecondPeriodMaxChargeShootingFrame"];

                                        eff = Math.ceil(mainPUVal * (f1 + f2));
                                    } 
                                    else if (dmgKeys.includes(name)) {
                                        var dmg = 0;
                                        var dmg_max = 0;
                                        
                                        if (name == "mDamageRate") {
                                            dmg = weapon[1]["mDamageMax"];
                                            dmg_max = weapon[1]["mDamage_MWPUG_Max"];
                                        }
                                        if (name == "mDamageMaxMaxChargeRate") {
                                            dmg = weapon[1]["mDamageMaxMaxCharge"];
                                            dmg_max = weapon[1]["mDamageMaxMaxCharge_MWPUG_Max"];
                                        }
                                        if (name == "mMinMaxChargeDamageRate") {
                                            dmg = weapon[1]["mMaxChargeDamage"];
                                            dmg_max = weapon[1]["mMinMaxChargeDamage_MWPUG_Max"];
                                        }
                                        if (name == "mFullChargeDamageRate") {
                                            dmg = weapon[1]["mFullChargeDamage"];
                                            dmg_max = weapon[1]["mFullChargeDamage_MWPUG_Max"];
                                        }
                                        if (name == "mCoreDamageRate") {
                                            dmg = weapon[1]["mCoreDamage"];
                                            dmg_max = weapon[1]["mCoreDamage_MWPUG_Max"];
                                        }
                                        if (name == "mSideStepOneMuzzleDamageRate") {
                                            dmg = weapon[1]["mSideStepOneMuzzleDamageMax"];
                                            dmg_max = weapon[1]["mSideStepOneMuzzleDamage_MWPUG_Max"];
                                        }

                                        eff = Math.floor(mainPUVal * dmg);
                                        if (eff > dmg_max) {
                                            eff = dmg_max;
                                        }
                                        eff = eff / 10;
                                    } 
                                    else if (rates.includes(name)) {
                                        if (name == "mCollisionRadiusFarRate") {
                                            radius = weapon[1]["mCollisionRadiusFar"];
                                            radius_max = weapon[1]["mCollisionRadiusFar_MWPUG_Max"];
                                        }
                                        if (name == "mCollisionRadiusMiddleRate") {
                                            radius = weapon[1]["mCollisionRadiusMiddle"];
                                            radius_max = weapon[1]["mCollisionRadiusMiddle_MWPUG_Max"];
                                        }
                                        if (name == "mCollisionRadiusNearRate") {
                                            radius = weapon[1]["mCollisionRadiusNear"];
                                            radius_max = weapon[1]["mCollisionRadiusNear_MWPUG_Max"];
                                        }
                                        if(name == "mKnockBackRadiusRate") {
                                            radius = weapon[1]["mKnockBackRadius"];
                                            radius_max = weapon[1]["mKnockBackRadius_MWPUG_Max"];
                                        }
                                        if (name == "mSphereSplashDropPaintRadius") {
                                            radius = weapon[1]["mSphereSplashDropPaintRadius"];
                                            radius_max = 999;
                                        }
                                        
                                        // console.log(eff + ', ' + mainPUVal + ', ' + radius + ', ' + radius_max);
                                        eff = (mainPUVal * radius).toFixed(5);
                                        if (eff > radius_max) {
                                            eff = radius_max;
                                        }
                                    
                                    } 
                                    else {
                                        eff = (mainPUVal * 1).toFixed(5);
                                    }

                                    var mainPUObj = {
                                        Effect: eff
                                    }
                                    console.log(mainPUObj);


                                    return mainPUObj;
                                }
                            }
                        });
                    }
                    else if (skillObj.skillName == 'BombDistance_Up') {
                        var weapon = allWeaponData['Shooter_BlasterShort_00']; // Shooter_Short_00, Shooter_BlasterShort_00, Roller_Compact_00, Twins_Short_00
                        var subName = weapon[0].Sub;
                        var subData = allSubData[subName];

                        var bru = ["Bomb_Splash", "Bomb_Suction", "Bomb_Quick", "PointSensor", "PoisonFog", "Bomb_Robo", "Bomb_Tako", "Bomb_Piyo"]
                        
                        
                        if (bru.includes(subName)) {
                            // case 1: bomblike object + tako + piyo + point sensors
                            // Player_Spec_BombDistance_Up
                            $.getJSON('/storage/540/Player/Player_Spec_BombDistance_Up.json', function(data) {
                                var calculatedData = [];
                                
                                if (subName == "Bomb_Piyo") {
                                    calculatedData = getHML(data['BombDistance_Up'], "BombThrow_VelZ_BombPiyo");
                                } 
                                else if (subName == "Bomb_Tako") {
                                    calculatedData = getHML(data['BombDistance_Up'], "BombThrow_VelZ_BombTako");
                                } 
                                else if (subName == "PointSensor") {
                                    calculatedData = getHML(data['BombDistance_Up'], "BombThrow_VelZ_PointSensor");
                                } 
                                else {
                                    calculatedData = getHML(data['BombDistance_Up'], "BombThrow_VelZ");
                                }

                                var result = calculateAbilityEffect(skillObj.main, skillObj.subs, calculatedData[0], calculatedData[1], calculatedData[2], skillObj.skillName);
                                var resultObj = {
                                    Effect: (result * 1).toFixed(5)
                                }
                                console.log(resultObj);


                                // special case: PointSensor, MarkingFrame
                                if ("PointSensor" == subName) {
                                    $.getJSON('/storage/540/WeaponBullet/BombPointSensor.json', function(data2) {
                                        var calculatedData = getHML(data2["param"], "mMarkingFrame");

                                        var result = calculateAbilityEffect(skillObj.main, skillObj.subs, calculatedData[0], calculatedData[1], calculatedData[2], skillObj.skillName);
                                        var resultObj = {
                                            Effect: Math.ceil(result)
                                        }
                                        console.log(resultObj);
                                    });
                                }
                            });
                        }

                        if ("Bomb_Curling" == subName) {
                            // case 2: Bomb_Curling, param file "InitVelAndBaseSpeed"
                            $.getJSON('/storage/540/WeaponBullet/BombCurling.json', function(data) {
                                var calculatedData = getHML(data["param"], "mInitVelAndBaseSpeed");
                                var result = calculateAbilityEffect(skillObj.main, skillObj.subs, calculatedData[0], calculatedData[1], calculatedData[2], skillObj.skillName);

                                var resultObj = {
                                    Effect: (result * 1).toFixed(5)
                                }
                                console.log(resultObj);
                            });
                        }

                        if ("TimerTrap" == subName) {
                            // case 3: TimerTrap, BombCoreRadiusRate, MarkingFrame, PlayerColRadius
                            $.getJSON('/storage/540/WeaponBullet/Trap.json', function(data) {
                                var calculatedData = [getHML(data["param"], "mBombCoreRadiusRate"), getHML(data["param"], "mPlayerColRadius"), getHML(data["param"], "mMarkingFrame")];
                                for (var c = 0; c < 3 ; c++) {
                                    var result = calculateAbilityEffect(skillObj.main, skillObj.subs, calculatedData[c][0], calculatedData[c][1], calculatedData[c][2], skillObj.skillName);

                                    var eff = 0;
                                    if (c < 2) {
                                        eff = (result * 1).toFixed(5);
                                    } 
                                    else {
                                        eff = Math.ceil(result * 1);
                                    }

                                    var resultObj = {
                                        Effect: eff
                                    }
                                    console.log(resultObj);
                                }
                            });
                        }

                        if ("Sprinkler" == subName) {
                            // case 4: Sprinkler, Period_First, Second
                            $.getJSON('/storage/540/WeaponBullet/Sprinkler.json', function(data) {
                                var calculatedData = [getHML(data["param"], "mPeriod_First"), getHML(data["param"], "mPeriod_Second")];
                                for (var c = 0; c < 2 ; c++) {
                                    var result = calculateAbilityEffect(skillObj.main, skillObj.subs, calculatedData[c][0], calculatedData[c][1], calculatedData[c][2], skillObj.skillName);

                                    var resultObj = {
                                        Effect: Math.ceil(result * 1)
                                    }
                                    console.log(resultObj);
                                }
                            });
                        }

                        if ("Shield" == subName) {
                            // case 5: Shield, MaxHp
                            $.getJSON('/storage/540/WeaponBullet/Shield.json', function(data) {
                                var calculatedData = getHML(data["param"], "mMaxHp");
                                var result = calculateAbilityEffect(skillObj.main, skillObj.subs, calculatedData[0], calculatedData[1], calculatedData[2], skillObj.skillName);

                                var resultObj = {
                                    Effect: Math.floor(result * 1) / 10.0
                                }
                                console.log(resultObj);
                            });
                        }

                        if ("Flag" == subName) {
                            // case 6: Flag, SubRt_Effect_JumpTime_Save
                            $.getJSON('/storage/540/Player/Player_Spec_JumpTime_Save.json', function(data) {
                                $.getJSON('/storage/540/WeaponBullet/JumpBeacon.json', function(data2) {
                                    var multiplier = getHML(data2["param"], "mSubRt_Effect_ActualCnt");
                                    var varData = data["JumpTime_Save"];
                                    var calculatedData = [getHML(varData, "DokanWarp_TameFrm"), getHML(varData, "DokanWarp_MoveFrm")];

                                    var totalAPs = getAPs(skillObj.main, skillObj.subs);
                                    var slope = (((multiplier[1] - multiplier[2]) / multiplier[0]) - (17.8 / multiplier[0])) / ((17.8 / multiplier[0]) * ((17.8 / multiplier[0]) + -1.0));
                                    var percentage = (totalAPs / multiplier[0]) * (((totalAPs / multiplier[0]) * slope) + (1.0 - slope));
                                    var newAP = Math.floor(multiplier[2] + ((multiplier[0] - multiplier[2]) * percentage));
                                    var newMainSubAPs = getMainSubPoints(newAP);
                                    // console.log(newAP);
                                    // console.log(newMainSubAPs);

                                    for (var c = 0; c < 2 ; c++) {
                                        var result = calculateAbilityEffect(newMainSubAPs[0], newMainSubAPs[1], calculatedData[c][0], calculatedData[c][1], calculatedData[c][2], skillObj.skillName);

                                        var resultObj = {
                                            Effect: Math.ceil(result)
                                        }
                                        console.log(resultObj);
                                    }
                                });
                            });
                        }
                    }
                    else if (skillObj.skillName == 'HumanMove_Up') {
                        var weapon = allWeaponData['Twins_Short_00']; // Shooter_Short_00, Shooter_BlasterShort_00, Roller_Compact_00, Twins_Short_00
                        var baseSpeed = [1, weapon[1]["mMoveSpeed"]];
                        var calculatedData;

                        
                        if (weapon[0]["MoveVelLv"] == "Low") {
                            calculatedData = getHML(res[draggedSkillName], "MoveVel_Human_BigWeapon");
                        } 
                        else if (weapon[0]["MoveVelLv"] == "High") {
                            calculatedData = getHML(res[draggedSkillName], "MoveVel_Human_ShortWeapon");
                        } 
                        else {
                            calculatedData = getHML(res[draggedSkillName], "MoveVel_Human");
                        }

                        var calculatedDataWeapon = getHML(res[draggedSkillName], "MoveVelRt_Human_Shot" + (weapon[0]["ShotMoveVelType"] || ""));


                        // run speed
                        var runSpeedVal = calculateAbilityEffect(skillObj.main, skillObj.subs, calculatedData[0], calculatedData[1], calculatedData[2], skillObj.skillName);
                        var runSpeedObj = {
                            Effect: (runSpeedVal * baseSpeed[0]).toFixed(5)
                        }
                        console.log(runSpeedObj);


                        // run speed shooting
                        var runSpeedShootingVal = calculateAbilityEffect(skillObj.main, skillObj.subs, calculatedDataWeapon[0], calculatedDataWeapon[1], calculatedDataWeapon[2], skillObj.skillName);
                        var runSpeedShootingObj = {
                            Effect: (runSpeedShootingVal * baseSpeed[1]).toFixed(5)
                        }
                        console.log(runSpeedShootingObj);
                    }
                    else if (skillObj.skillName == 'SquidMove_Up') {
                        var weapon = allWeaponData['Umbrella_Wide_00']; // Shooter_Short_00, Shooter_BlasterShort_00, Roller_Compact_00, Twins_Short_00
                        var calculatedData;


                        if (weapon[0]["MoveVelLv"] == "Low") {
                            calculatedData = getHML(res[draggedSkillName], "MoveVel_Stealth_BigWeapon");
                        } 
                        else if (weapon[0]["MoveVelLv"] == "High") {
                            calculatedData = getHML(res[draggedSkillName], "MoveVel_Stealth_ShortWeapon");
                        } 
                        else {
                            calculatedData = getHML(res[draggedSkillName], "MoveVel_Stealth");
                        }


                        // swim speed
                        var swimSpeedVal = calculateAbilityEffect(skillObj.main, skillObj.subs, calculatedData[0], calculatedData[1], calculatedData[2], skillObj.skillName);
                        var swimSpeedObj = {
                            Effect: (swimSpeedVal).toFixed(5)
                        }
                        console.log(swimSpeedObj);


                        // swim speed - ninja
                        var swimSpeedNinjaVal = calculateAbilityEffect(skillObj.main, skillObj.subs, calculatedData[0], calculatedData[1], calculatedData[2], skillObj.skillName, true);
                        var swimSpeedNinjaObj = {
                            Effect: (swimSpeedNinjaVal).toFixed(5)
                        }
                        console.log(swimSpeedNinjaObj);
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


// convert AP to main and sub points
function getMainSubPoints(ap) {
    var main = 0;
    var sub = 0;

    while (ap >= 10) {
        main++;
        ap -= 10;
    }

    sub = ap / 3;

    return [main, sub];
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

function getHML_MWPUG(data, key) {
    var high = 0;
    var mid = 0;
    var low = 0;

    if (data[key + "_MWPUG_High"] === 0 || data[key + "_MWPUG_High"] === 0.0 ||
        data["Stand_" + key + "_MWPUG_High"] === 0 || data["Jump_" + key + "_MWPUG_High"] === 0 ||
        data["Stand_" + key + "_MWPUG_High"] === 0.0 || data["Jump_" + key + "_MWPUG_High"] === 0.0) {
        high = 0.0;
    } 
    else {
        high = data[key + "_MWPUG_High"] || data["Stand_" + key + "_MWPUG_High"] || data["Jump_" + key + "_MWPUG_High"];
    }

    if (data[key + "_MWPUG_Mid"] === 0 || data[key + "_MWPUG_Mid"] === 0.0 ||
        data["Stand_" + key + "_MWPUG_Mid"] === 0 || data["Jump_" + key + "_MWPUG_Mid"] === 0 ||
        data["Stand_" + key + "_MWPUG_Mid"] === 0.0 || data["Jump_" + key + "_MWPUG_Mid"] === 0.0) {
        mid = 0.0;
    } 
    else {
        mid = data[key + "_MWPUG_Mid"] || data["Stand_" + key + "_MWPUG_Mid"] || data["Jump_" + key + "_MWPUG_Mid"];
    }

    if (data[key] === 0 || data[key] === 0.0 ||
        data["Stand_" + key] === 0 || data["Jump_" + key] === 0 ||
        data["Stand_" + key] === 0.0 || data["Jump_" + key] === 0.0) {
        low = 0.0;
    } 
    else {
        low = data[key] || data["Stand_" + key] || data["Jump_" + key] || 1.0;
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
function calculateAbilityEffect(numOfMains, numOfSubs, high, mid, low, abilityName, ninjaSquid = false) {
    var APs = getAPs(numOfMains, numOfSubs);
    var percentage = getPercentage(APs);
    if (ninjaSquid) percentage *= 0.8;
    var slope = getSlope(high, mid, low);
    var lerpN = getLerpN(percentage / 100, slope);
    var result = getResult(high, low, lerpN);
    if (ninjaSquid) result *= 0.9;

    console.log(`AP: ${APs}, p: ${percentage}, s: ${slope}, lerpN: ${lerpN} h:${high} m:${mid} l:${low}`);
    return result;
}