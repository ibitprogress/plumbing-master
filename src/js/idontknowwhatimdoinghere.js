var featureCount = parseInt($("#_featureCount").val());
var removeIs = false;
var options = [];
var optionsRemove = [];

function createAddFunction() {
    $(".newfeatureoption"+featureCount).on("click", function(){
        var _feature = $(this).attr("data-feature");
        options[_feature-1] = options[_feature-1] + 1;
        $("[name=optionscount]").val(options);
        var optionInput = '<span class="optionmain optionmain'+options[_feature-1]+'"><input class="featureinput featureinputoption" name="feature'+_feature+'option'+options[_feature-1]+'"></input></span>';
        $(".featureoptionmain"+_feature).append(optionInput);
        checkOptionsCount(_feature);
    });
}

function _createAddFunction(_featureCount) {
    $(".newfeatureoption"+_featureCount).on("click", function(){
        var _feature = $(this).attr("data-feature");
        options[_feature-1] = options[_feature-1] + 1;
        $("[name=optionscount]").val(options);
        var optionInput = '<span class="optionmain optionmain'+options[_feature-1]+'"><input class="featureinput featureinputoption" name="feature'+_feature+'option'+options[_feature-1]+'"></input></span>';
        $(".featureoptionmain"+_feature).append(optionInput);
        checkOptionsCount(_feature);
    });
}

function createRemoveFunction() {
    $(".featureremove").on("click", function(){
        $(".featuremain"+featureCount).remove();
        options.pop();
        $("[name=optionscount]").val(options);
        featureCount -= 1;
        $("[name=featurescount]").val(featureCount);
        checkFeatureCount();
    });
}

function _createRemoveFunction(_featureCount) {
    $(".featureremove").on("click", function(){
        $(".featuremain"+_featureCount).remove();
        options.pop();
        $("[name=optionscount]").val(options);
        featureCount -= 1;
        $("[name=featurescount]").val(featureCount);
        checkFeatureCount();
    });
}

function createRemoveOptionFunction(feature) {
    $(".featureremoveoption"+feature).on("click", function(){
        var ___feature = $(this).attr("data-feature");
        var ___option = options[___feature-1];
        $("[name=feature"+___feature+"option"+___option+"]").remove();
        options[feature-1] = options[feature-1] - 1;
        $("[name=optionscount]").val(options);
        checkOptionsCount(___feature);
    });
}

function checkOptionsCount(feature) {
    var _count = options[feature-1];
    var _removeIs = optionsRemove[feature-1];
    if (_count > 0 && _removeIs == false) {
        $(".featureactions"+feature).append('<i class="fa fa-trash-o featureremoveoption featureremoveoption'+feature+'" data-feature="'+feature+'" aria-hidden="true"></i>');
        optionsRemove[feature-1] = true;
        createRemoveOptionFunction(feature);
    } else if (_count == 0 && _removeIs == true) {
        $(".featureremoveoption"+feature).remove();
        optionsRemove[feature-1] = false;
    }
}

function checkFeatureCount() {
    if (featureCount > 0 && removeIs == false) {
        $(".featureplus").append('<i class="fa fa-trash-o featureremove" aria-hidden="true"></i>');
        removeIs = true;
        createRemoveFunction();
    } else if (featureCount == 0 && removeIs == true) {
        $(".featureplus").css("margin-left", "70px");
        $(".featureremove").remove();
        removeIs = false;
    }
}

$("#newfeature").on("click", function(){
    $(".featureplus").css("margin-left", "60px");
    featureCount += 1;
    $("[name=featurescount]").val(featureCount);
    options.push(0);
    $("[name=optionscount]").val(options);
    optionsRemove.push(false);
    var featureInput = '<span class="featuremain'+featureCount+' featuremainspan">'+
        '<input type="text" name="feature'+featureCount+'" class="featureinput">'+
        '<span class="featureactions featureactions'+featureCount+'"><i class="fa fa-plus-circle newfeatureoption newfeatureoption'+featureCount+'" data-feature="'+featureCount+'" aria-hidden="true"></i></span>'+
        '<div class="featureoptionmain featureoptionmain'+featureCount+'"></div></span>';
    $(".featuremain").append(featureInput);
    checkFeatureCount();
    createAddFunction()
});

for (i = 1; i <= featureCount; i++){
    _createAddFunction(i);
    _createRemoveFunction(i);
    createRemoveOptionFunction(i);
    let _options = parseInt($("#_feature"+i+"OptionsCount").val());
    options[i-1] = _options;
    optionsRemove[i-1] = true;
}
checkFeatureCount();