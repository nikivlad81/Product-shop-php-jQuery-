$(document).ready(function (){

    const jsonUrl = '/json/shop';
    let categoryId = getUrlVars()[1];

    $('#home').removeClass('active')
    $('#shop').addClass('active')

    $('.btn').on('click', function(){
        $('.btn').removeClass('active').addClass('inactive');
        $(this).removeClass('inactive').addClass('active');
        categoryId = $(this).attr('id');
        window.history.replaceState({}, 'category', '/shop?category=' + categoryId + '&sort=' + getUrlVars()[2]);
        ajaxReq(categoryId);
    });

    function ajaxReq (categoryId) {
        $("#content").empty();

        $.ajax({
            url: jsonUrl,
            cached: false,
            success: function (json) {
                $.each(json, function (key, value) {
                    if (value[3] === categoryId) {
                        $('#content').append('<div class="card" style="width: 18rem;">' +
                            '<div class="card-body" id="card">' +
                            '<h4 class="card-title">' + value[1] + '</h4>' +
                            'Date: <b><span class="card-date">' + value[4] + '</span></b><br><br>' +
                            'Price: $<b><span class="card-text" style="color: limegreen">' + value[2] + '</span></b><br><br>' +
                            '<button type="button" id="' + value[0] + '" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#staticBackdrop' + value[0] + '">Buy</button>' +
                            '</div></div>' +
                            '<div class="modal fade" id="staticBackdrop' + value[0] + '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">' +
                            '<div class="modal-dialog">' +
                            '<div class="modal-content">' +
                            '<div class="modal-header">' +
                            '<h1 class="modal-title fs-5" id="staticBackdropLabel">' + value[1] + '</h1>' +
                            '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>' +
                            '</div>' +
                            '<div class="modal-body">' + value[6] + '<br><br><br>Price: $' + value[2] + ' </div>' +
                            '<div class="modal-footer">' +
                            '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>' +
                            '<button type="button" class="btn btn-primary">Add to card</button>' +
                            '</div></div></div></div>');
                    }
                });
            }
        });
    }

    function sortingByPrice () {
        const elements = document.querySelectorAll('.card');
        const sorted = [...elements].sort((a, b) => {
            const priceElA = a.querySelector(".card-text");
            const priceElB = b.querySelector(".card-text");
            const getPrice = (el) => parseFloat(el.innerHTML.replace(/ /g, ""));
            return getPrice(priceElA) - getPrice(priceElB);
        });
        const resultEl = document.querySelector("#content");
        resultEl.innerHTML = null;
        sorted.forEach(el => resultEl.appendChild(el));
    }

    function sortingByAlphabetically () {
        const elements = document.querySelectorAll('.card');
        const sorted = [...elements].sort((a, b) => {
            const priceElA = a.querySelector(".card-title");
            const priceElB = b.querySelector(".card-title");
            const getPrice = (el) => el.innerHTML.replace(/ /g, "");
            if (getPrice(priceElA) > getPrice(priceElB)) {
                return 1;
            } else if (getPrice(priceElB) > getPrice(priceElA)) {
                return -1;
            } else {
                return 0;
            }

        });
        const resultEl = document.querySelector("#content");
        resultEl.innerHTML = null;
        sorted.forEach(el => resultEl.appendChild(el));
    }

    function sortingByNewest () {
        const elements = document.querySelectorAll('.card');
        const sorted = [...elements].sort((a, b) => {
            const priceElA = a.querySelector(".card-date");
            const priceElB = b.querySelector(".card-date");
            const getPrice = (el) => el.innerHTML.replace(/ /g, "");
            if (getPrice(priceElA) > getPrice(priceElB)) {
                return 1;
            } else if (getPrice(priceElB) > getPrice(priceElA)) {
                return -1;
            } else {
                return 0;
            }
        });
        const resultEl = document.querySelector("#content");
        resultEl.innerHTML = null;
        sorted.forEach(el => resultEl.appendChild(el));
    }

    function startSort () {
        if (getUrlVars()[2] === 'sortingByAlphabetically') {
            sortingByAlphabetically();
        }
        if (getUrlVars()[2] === 'sortingByNewest') {
            sortingByNewest();
        }
        if (getUrlVars()[2] === 'sortingByPrice') {
            sortingByPrice();
        }
    }

    document.querySelector('#sorting').addEventListener("change", function() {
        if (this.value === "sortingByAlphabetically") {
            window.history.replaceState({}, 'category', '/shop?category=' + categoryId + '&sort=' + this.value);
            sortingByAlphabetically();
        }
        if (this.value === "sortingByPrice") {
            window.history.replaceState({}, 'category', '/shop?category=' + categoryId + '&sort=' + this.value);
            sortingByPrice();
        }
        if (this.value === "sortingByNewest") {
            window.history.replaceState({}, 'category', '/shop?category=' + categoryId + '&sort=' + this.value);
            sortingByNewest();
        }

    });

    function getUrlVars() {
        return window.location.href.slice(window.location.href.indexOf('?')).split(/[&?]{1}[\w\d]+=/);
    }

    function checkParametrs () {
        if (getUrlVars()[1] === undefined && getUrlVars()[2] === undefined) {
            window.history.replaceState({}, 'category', '/shop?category=1&sort=sortingByPrice');
        }

        if (getUrlVars()[1] === undefined) {
            window.history.replaceState({}, 'category', '/shop?category=1&sort=' + getUrlVars()[2]);
        }

        if (getUrlVars()[2] === undefined) {
            window.history.replaceState({}, 'category', '/shop?category=' + getUrlVars()[1] + '&sort=sortingByPrice');
        }
    }

    function startActiveCatAndSort () {
        $('#' + getUrlVars()[1]).addClass('active');
        $("select option[value=" + getUrlVars()[2] + "]").attr('selected', 'true');
    }

    setTimeout(function () { startSort() }, 100);
    ajaxReq (getUrlVars()[1]);
    startActiveCatAndSort();
    checkParametrs();

});
