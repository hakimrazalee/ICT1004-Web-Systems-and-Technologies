$(document).ready(function () {
    populatepage();

});

function populatepage() {
    $.getJSON("json/Items.json", function (data) {
        var cakeid = get('cakeid');
        var imgurl = data[cakeid]['imgurl'];
        var itemname = data[cakeid]['name'];
        var type = data[cakeid]['type'];
        var price = data[cakeid]['price'];
        var discount = data[cakeid]['discount'];
        var warning = data[cakeid]['warning'];
        var description = data[cakeid]['description'];
        var dimension = data[cakeid]['dimension'];
        var unit = "";
        var availability = data[cakeid]['availability'];
        
        document.getElementById("cakeid").value = cakeid;
        document.getElementById("cakeimg").src = imgurl;
        document.getElementById("iname").value = itemname;
        selectdropdown("itype", type);
        document.getElementById("iwarning").value = warning;
        document.getElementById("idescription").value = description;
        document.getElementById("iprice").value = parseFloat(price.slice(1));
        document.getElementById("idiscount").value = discount;
        if (dimension.slice(-4) === "inch") {
            document.getElementById("idimension").value = dimension.slice(0, -5);
            unit = "inch";
        } else {
            document.getElementById("idimension").value = dimension.slice(0, -3);
            unit = "cm";
        }
        selectdropdown('sizeunit', unit);

        if (availability === "Yes") {
            document.getElementById("inlineRadio1").checked = true;
            document.getElementById("inlineRadio2").checked = false;
        } else {
            document.getElementById("inlineRadio1").checked = false;
            document.getElementById("inlineRadio2").checked = true;
        }

    });
}


//function returns value from HTTP GET request
function get(name) {
    if (name = (new RegExp('[?&]' + encodeURIComponent(name) + '=([^&]*)')).exec(location.search))
        return decodeURIComponent(name[1]);
}

function selectdropdown(id, valueToSelect) {    
    let element = document.getElementById(id);
    element.value = valueToSelect;
}