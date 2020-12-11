var data_all;
var sortby = "date";
var sortorder = "asc";
var selected = [];

$(document).ready(function () {
    loaditems();
});

function loaditems() {

    $.getJSON("json/Items.json", function (data) {
        data_all = data;
        //Run function to sort & add list
        sort_items();
        document.getElementById("item_header").addEventListener('click', event => {
            var id_clicked = event.target.getAttribute("id");
            var header_element = document.getElementById(id_clicked);
            //change font and header before sorting
            if (event.target.id !== "select_all" && event.target.id !== "edit" && event.target.id !== "selectall" && event.target.id !== "") {
                switch (header_element.innerHTML.slice(-5)) {
                    case "desc)":
                        //set to asc
                        header_element.innerHTML = header_element.innerHTML.slice(0, -6);
                        header_element.innerHTML = header_element.innerHTML + "(asc)";
                        sortby = id_clicked;
                        sortorder = "asc";
                        break;
                    case "(asc)":
                        //set to desc 
                        header_element.innerHTML = header_element.innerHTML.slice(0, -5);
                        header_element.innerHTML = header_element.innerHTML + "(desc)";
                        sortby = id_clicked;
                        sortorder = "desc";
                        break;
                    default:
                        //remove previously filtered
                        var old_header = document.getElementById(sortby);
                        if (old_header.innerHTML.slice(-5) === "(asc)") {
                            old_header.innerHTML = old_header.innerHTML.slice(0, -5);
                        } else
                        if (old_header.innerHTML.slice(-6) === "(desc)") {
                            old_header.innerHTML = old_header.innerHTML.slice(0, -6);
                        }
                        //set to asc
                        header_element.innerHTML = header_element.innerHTML + "(asc)";
                        sortby = id_clicked;
                        sortorder = "asc";
                        break;
                }
                sort_items();
            }
        });
    });
    //create event listeners for selecting all
    document.getElementById("select_all").addEventListener('change', (event) => {
        var checkboxes = document.querySelectorAll(".checkbox_item");
        var bool;
        if (event.target.checked) {
            bool = true;
        } else {
            bool = false;
        }
        selected = [];
        for (var checkbox of checkboxes) {
            checkbox.checked = bool;
            if (bool)
                selected.push(checkbox.value);
            else
                selected = [];
        }
    });

}

//function to sort items
function sort_items() {
    var items = [];
    var sorted;
    if (sortby === "date") {
        var sorted = [];
        var key_list = [];
        switch (sortorder) {
            case "asc":
                key_list = (Object.keys(data_all).sort(function (a, b) {
                    return parseInt(a) - parseInt(b);
                }));
                break;
            case "desc":
                key_list = (Object.keys(data_all).sort(function (a, b) {
                    return parseInt(b) - parseInt(a);
                }));
                break;
        }
        $.each(key_list, function (key, val) {
            items.push(add_item(key, data_all[val]));
        });
    } else {
        switch (sortorder) {
            case "asc":
                sorted = Object.values(data_all).sort(function (a, b) {
                    return a[sortby].localeCompare(b[sortby]);
                });
                break;
            case "desc":
                sorted = Object.values(data_all).sort(function (a, b) {
                    return b[sortby].localeCompare(a[sortby]);
                });
                break;
        }
        $.each(sorted, function (key, val) {
            items.push(add_item(key, val));
        });
    }
    //remove
    $('#table_body').remove();
    //then add
    $("<tbody/>", {
        "id": "table_body",
        html: items.join("")
    }).appendTo("#item_table");
    var classname = document.querySelectorAll("input[type=checkbox]");
    selected = [];
    classname.forEach(function (item) {
        item.addEventListener('change', function () {
            if (item.value !== "all")
                if (item.checked) {
                    selected.push(item.value);
                } else {
                    selected.pop(item.value);
                    document.getElementById('select_all').checked = false;
                }
        });
    });
}

//functions to add items after sorting
function add_item(key, val) {
    var img_str = "<img src='" + val.imgurl + "' class=mini_thumbnail alt='" + val.name + " thumbnail'/>";
    var check_box = "<label for='checkbox_"+ Object.keys(data_all)[key] +"'></label><input id='checkbox_" + Object.keys(data_all)[key] + "' name='checkbox_" + Object.keys(data_all)[key] + "' type='checkbox' class='checkbox_item' value='" + Object.keys(data_all)[key] + "'/>";
    var button_edit = "<a href='m.edititem.php?cakeid=" + Object.keys(data_all)[key] + "' class='btn btn-dark'>edit</a>";
    return ("<tr><td>" + img_str + "</td><td>" + val.name + "</td><td>" +
            val.price + "</td><td>" + val.discount + "</td><td>" +
            check_box + "</td><td>" + button_edit + "</td></tr>");
}
const lightbox = document.createElement("div");
lightbox.id = "lightbox";
document.body.appendChild(lightbox);
lightbox.addEventListener("click", e => {
    if (e.target !== e.currentTarget)
        return;
    closepopup();
});

function toggle(type) {
    if (selected.length > 0) {
        while (lightbox.firstChild) {
            lightbox.removeChild(lightbox.firstChild);
        }
        lightbox.classList.add("active");
        const br = document.createElement("br");
        const hidden = document.createElement("Div");
        const container = document.createElement("Div");
        const title = document.createElement("h2");
        const warning = document.createElement("h6");
        const description = document.createElement("p");
        const form = document.createElement("form");
        const label = document.createElement("label");
        const hidden_input = document.createElement("input");
        const input = document.createElement("input");
        const dropdown = document.createElement("select");
        const btn_cancel = document.createElement("a");
        const btn_submit = document.createElement("input");
        container.setAttribute("id", "prompt");
        $(hidden).attr({
            'id': 'hidden_form_container',
            'style': 'display:none;'
        });
        $(hidden_input).attr({
            'type': 'text',
            'class': 'form-control',
            'name': 'idarray'
        });
        hidden_input.value = selected.toString();
        console.log(hidden_input.value);
        $(form).attr({
            'action': 'process_multipleitem.php',
            'method': 'post',
            'id': 'editform'
        });
        $(btn_cancel).attr({
            'onclick': 'closepopup()',
            'class': 'btn btn-dark',
            'id': 'btnc'
        });

        $(btn_submit).attr({
            'type': 'submit',
            'name': 'submit',
            'class': 'float-right  btn btn-primary',
            'value': type,
            'id': 'submitb'
        });
        btn_cancel.innerHTML = "Cancel";
        $(dropdown).attr({
            'class':'form-control',
            'id':'iavailability',
            'name':'iavailability'
        });
        //dropdown.innerHTML = "<option>Available</option><option>Not Available</option>";
        dropdown.innerHTML = "<option value='Available'>Available</option><option value='Not Available'>Not Available</option>";
        container.append(title);
        hidden.append(hidden_input);
        switch (type) {
            case "Price":
                {
                    title.innerHTML = "Set Price";
                    description.innerHTML = "updating price of " + selected.length + " item(s).";
                    $(label).attr({
                        'for': 'iprice'
                    });
                    label.innerHTML = "Price:";
                    dropdown.style.display = "none";
                    $(input).attr({
                        'type': 'number',
                        'class': 'form-control',
                        'name': 'iprice',
                        'id': 'iprice',
                        'placeholder': 'e.g. 10.5',
                        'minlength': '1',
                        'maxlength': '7',
                        'required': true,
                        'step':'0.01'
                    });
                }
                break;
            case "Discount":
                {
                    title.innerHTML = "Set Discount";
                    description.innerHTML = "updating price of " + selected.length + " item(s).";
                    $(label).attr({
                        'for': 'iprice'
                    });
                    label.innerHTML = "Discount:";
                    dropdown.style.display = "none";
                    $(input).attr({
                        'type': 'text',
                        'class': 'form-control',
                        'name': 'idiscount',
                        'id': 'idiscount',
                        'placeholder': 'e.g. 99% or $99'
                    });
                }
                break;
            case "Delete":
                title.innerHTML = "Deletion";
                label.style.display = "none";
                input.style.display = "none";
                dropdown.style.display = "none";
                warning.innerHTML = "WARNING: Item availability can be set to disabled. <br>However, deleting is permanent and is not reversible.";
                description.innerHTML = "Confirm deletion of " + selected.length + "item(s)?";
                btn_submit.setAttribute("class",'float-right btn btn-danger');
                break;
            case "Availability":
                title.innerHTML = "Availability";
                description.innerHTML = "updating availability of " + selected.length + " item(s).";
                input.style.display = "none";
                label.innerHTML = "Availability:";
//                    $(dropdown).attr({
//                    'type': 'number',
//                    'class': 'form-control',
//                    'name': 'iprice',
//                    'id': 'iprice',
//                    'placeholder': 'e.g. 10.5',
//                    'minlength': '1',
//                    'maxlength': '7',
//                    'required': true
//                    });
                break;
        }
        form.append(warning);
        form.append(description);
        form.append(label);
        form.append(dropdown);
        form.append(input);
        form.append(hidden);
        form.append(br);
        form.append(btn_cancel);
        form.append(btn_submit);
        container.append(form);
        lightbox.append(container);
    } else {
        alert("No items selected");
    }
}

function closepopup() {
    lightbox.classList.remove("active");
}