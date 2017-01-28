function checkAll(check) {
    var checkboxes = document.getElementsByClassName("permissions");

    for (var i in checkboxes) {
        var $checkbox = checkboxes[i];
        $checkbox.checked = check;
    }
};

function checkAllChilds($checkboxElement) {

    var childsCheckboxes = $("div#childs-" + $checkboxElement.value.replace(".", "-")).find("input[type='checkbox']");

    $.each(childsCheckboxes, function(i, $checkbox) {
        $checkbox.checked = $checkboxElement.checked;
    });
};

function checkChild($checkboxElement, parentName) {
    var $checkboxesContainer = $($checkboxElement).parent().parent().parent();
    var checkboxes = $checkboxesContainer.find("input[type='checkbox']");
    var checkParent = true;

    for (var i in checkboxes) {
        var checkbox = checkboxes[i];

        if (checkbox.checked === false) {
            checkParent = false;
            break;
        }

    }

    document.getElementById(parentName).checked = checkParent;
};