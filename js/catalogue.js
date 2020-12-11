$(document).ready(function () {
    loaditems();
});

var data_all;
const lightbox = document.createElement("div");
lightbox.id = "lightbox";
document.body.appendChild(lightbox);
const images = document.querySelectorAll("main img");
images.forEach(image => {
    image.addEventListener("click", e => {
        lightbox.classList.add("active");
        const img = document.createElement("img");
        img.src = image.src;
        while (lightbox.firstChild) {
            lightbox.removeChild(lightbox.firstChild);
        }
        lightbox.append(img);
    });
});


function loaditems() {
    $.getJSON("json/Items.json", function (data) {
        data_all = data;
    });
}
lightbox.addEventListener("click", e => {
    if (e.target !== e.currentTarget)
        return;
    lightbox.classList.remove("active");
});

function quantitychange(type, i) {
    var quantity_text = document.getElementById('quantity');
    if (quantity_text.value === "")
        var number = 0;
    else
        var number = parseInt(quantity_text.value);
    console.log("here...");
    switch (type) {
        case '-':
            if (quantity_text.value > 0) {
                quantity_text.value = number - 1;
                number -= 1;
                break;
            } else {
                break;
            }
        case '+':
            if (quantity_text.value < 99) {
                quantity_text.value = number + 1;
                number += 1;
                break;
            } else {
                break;
            }
        default:
            break;
    }
    document.getElementById("updatecart").innerHTML = "Add to Cart $" + (calculateprice(i) * number).toFixed(2);
}

function updatecart(cake) {
    var total = document.getElementById('updatecart');
    var price = parseFloat((total.innerHTML).match(/[\d\.]+/));

    //add to cart codes here
    var quantity = document.getElementById('quantity');
    quantity = quantity.value;
    var cakeId = cake;
    var imgurl = data_all[cakeId].imgurl;
    var dimension = data_all[cakeId].dimension;
    var name = data_all[cakeId].name;
    var price = "$" + calculateprice(cake);

    $.ajax({
        type: 'post',
        url: 'insertCart.php',
        data: {cakeId: cakeId,
            imgurl: imgurl,
            dimension: dimension,
            price: price,
            name: name,
            quantity: quantity
        }
    });
    //end Reset Numbers
    var quantity = document.getElementById('quantity');
    total.innerHTML = "Add to Cart $0";
    quantity.value = 0;
    alert('cakes added to cart');
    lightbox.classList.remove("active");
}

function refreshitems(type) {
    document.getElementById('container_placeholder').innerHTML = "";
    var header = document.getElementById("jumbo_header");
    switch (type) {
        case "Cake":
        {
            header.innerHTML = "Cakes";
            break;
        }
        case "Wedding Cake":
        {
            header.innerHTML = "Wedding Cakes";
            break;
        }
        case "Ice-cream Cake":
        {
            header.innerHTML = "Ice-cream Cakes";
            break;
        }
        case "All":
        {
            header.innerHTML = "All Cakes";
            break;
        }
    }
    additems(type);
}

function additems(type) {
    var items = [];
    if (type === "All") {
        $.each(data_all, function (key, val) {
            if (val.availability === "Yes")
                items.push("<li id='" + key + "' class='list-group-item list-catalogue' name='" + key + "'>" +
                        "<img src=" + val.imgurl + " alt='" + val.name + "' name='" + key +
                        "'/>" + wrapPrice(key) + "</li>");
        });
    } else {
        $.each(data_all, function (key, val) {
            if (val.type === type && val.availability === "Yes")
                items.push("<li id='" + key + "' class='list-group-item list-catalogue' name='" + key + "'>" +
                        "<img src=" + val.imgurl + " alt='" + val.name + "' name='" + key +
                        "'/></li>");
        });
    }
    console.log(items);
    console.log(data_all);
    $("<ul/>", {
        "class": "list-group flex-md-row",
        "id": "productlist",
        html: items.join("")
    }).appendTo("#container_placeholder");

    var parent = document.getElementById("productlist");
    parent.addEventListener('click', function (event) {
        lightbox.classList.add("active");
        var linebreak = document.createElement("br");
        var str = event.target.getAttribute("name");
        const product = document.createElement("Div");
        const container_img = document.createElement("Div");
        const container_details = document.createElement("Div");
        const container_header = document.createElement("Div");
        const container_row = document.createElement("Div");
        const dimension_label = document.createElement("Div");
        const dimension_info = document.createElement("Div");
        const divider = document.createElement("Div");
        const divider2 = document.createElement("Div");
        const warning_label = document.createElement("Div");
        const warning_info = document.createElement("Div");
        const header = document.createElement("h1");
        const description = document.createElement("h5");
        const section_info = document.createElement("Section");
        const section_quantity = document.createElement("Section");
        const label_quantity = document.createElement("label");
        const button_add = document.createElement("Button");
        const button_remove = document.createElement("Button");
        const button_close = document.createElement("Button");
        const price_label = document.createElement("Div");
        const price_per = document.createElement("p");
        const total_price = document.createElement("p");
        const button_updatecart = document.createElement("Button");
        const textbox_quantity = document.createElement("input");
        $(section_quantity).attr({
            "class": "form-group col-md",
            "id": "quantity_inputs"
        });
        $(button_add).attr({
            "class": "form-group"
        });
        $(button_add).attr({
            "class": "btn button_forms btn-info",
            "onclick": "quantitychange('+','" + str + "')"
        });
        $(button_remove).attr({
            "class": "btn button_forms btn-info",
            "onclick": "quantitychange('-','" + str + "')"
        });
        $(button_updatecart).attr({
            "id": "updatecart",
            "class": "btn button_forms btn-info",
            "onclick": "updatecart('" + str + "')"
        });
        button_add.innerHTML = "+";
        button_remove.innerHTML = "-";
        button_updatecart.innerHTML = "Add to Cart $0";
        $(label_quantity).attr({
            "for": "quantity"
        });
        label_quantity.innerHTML = "Quantity:";
        $(textbox_quantity).attr({
            "id": "quantity",
            "name": "quantity",
            "type": "number",
            "class": "item_quantity",
            "placeholder": "0",
            "min": "0",
            "max": "99",
            "autocomplete": "off"
        });
        $(section_info).attr({
            "class": "container",
            "id": "information"
        });
        $(button_close).attr({
            "type": "button",
            "class": "btn button_forms btn-info btn-close"
        });
        button_close.innerHTML = "x";
        button_close.addEventListener("click", e => {
            lightbox.classList.remove("active");
        });
        product.setAttribute("id", "product");
        product.setAttribute("class", "row");
        container_img.setAttribute("id", "container_img");
        container_img.setAttribute("class", "col-md");
        container_header.setAttribute("id", "container_header");
        container_header.setAttribute("class", "col-md");
        container_details.setAttribute("id", "container_details");
        container_details.setAttribute("class", "col-md");
        container_row.setAttribute("class", "row");
        divider.setAttribute("class", "w-100 info_divider");
        divider2.setAttribute("class", "w-100 info_divider");
        dimension_label.setAttribute("class", "col");
        dimension_info.setAttribute("class", "col");
        warning_label.setAttribute("class", "col");
        warning_info.setAttribute("class", "col");
        price_label.setAttribute("class", "col");
        price_per.setAttribute("class", "col");


        var img = document.createElement("img");
        header.innerHTML = data_all[str].name;
        description.innerHTML = data_all[str].description;
        dimension_label.innerHTML = "dimensions:";
        dimension_info.innerHTML = data_all[str].dimension;
        warning_label.innerHTML = "contains:";
        warning_info.innerHTML = data_all[str].warning;
        price_label.innerHTML = "Current Price:";
        price_per.innerHTML = "$" + calculateprice(str).toFixed(2);


        img.src = data_all[str].imgurl;
        img.id = data_all[str].description;
        while (lightbox.firstChild) {
            lightbox.removeChild(lightbox.firstChild);
        }
        container_header.append(header);
        container_header.append(linebreak);
        container_header.append(description);
        container_header.append(linebreak);
        container_details.append(container_header);
        section_info.append(container_row);
        container_row.append(dimension_label);
        container_row.append(dimension_info);
        container_row.append(divider);
        container_row.append(warning_label);
        container_row.append(warning_info);
        container_row.append(divider2);
        container_row.append(price_label);
        container_row.append(price_per);
        container_details.append(section_info);
        container_details.append(section_quantity);
        section_quantity.append(label_quantity);
        section_quantity.append(linebreak);
        section_quantity.append(button_remove);
        section_quantity.append(textbox_quantity);
        section_quantity.append(button_add);
        section_quantity.append(button_updatecart);
        container_img.append(img);
        product.append(button_close);
        product.append(container_img);
        product.append(container_details);
        lightbox.append(product);
        var quantity = document.getElementById("quantity");
        quantity.addEventListener('change', function (event) {
            quantitychange("change", str);
        });
    });
}

function calculateprice(i) {
    var price = data_all[i].price;
    price = parseFloat(price.match(/[\d\.]+/));
    var discount = data_all[i].discount;
    var final = price;
    var no_discount = ["", "0", "$0", "0%", "zero"];
    if (!no_discount.includes(data_all[i].discount)) {
        if (discount.includes("%")) {
            discount = parseFloat(discount.match(/[\d\.]+/));
            final *= ((100 - discount) / 100);
        } else {
            discount = parseFloat(discount.match(/[\d\.]+/));
            final -= discount;
        }
    }
    return final;
}

function wrapPrice(i) {
    var price = data_all[i].price;
    price = parseFloat(price.match(/[\d\.]+/));
    var discount = data_all[i].discount;
    var final = calculateprice(i);
    var final_string;
    if (price === final) {
        final_string = "<p class='catalogue_price'>$" + price.toFixed(2) + "</p>";
    } else {
        final_string = "<p class='catalogue_price'>$" + final.toFixed(2) + " <del>$" + price.toFixed(2) + "</del></p>";
    }
    return final_string;
}