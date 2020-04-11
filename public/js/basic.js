let input = document.getElementById('place_location');
input.addEventListener('keydown', function (event) {
    if (event.keyCode === 13) {
        event.preventDefault();
    }
});

const URL = 'https://autocomplete.geocoder.ls.hereapi.com/6.2/suggest.json';
const APIKEY = 'knEa6xpWyfBx1iRl1C7RRA6potNpUUYZORhYd4l1Tnk';

autocomplete({
    input: input,
    fetch: function (text, update) {
        text = text.toLowerCase();

        let response = getJSON(
            URL + '?apiKey=' + APIKEY + '&country=DEU,AUT&resultType=city&query=' + text,
            function (err, data) {
                let suggestions = [];
                for (let i = 0; i < data.suggestions.length; i++) {
                    let suggestion = {};
                    suggestion.label = data.suggestions[i].address.city;
                    suggestion.value = data.suggestions[i].address.city;
                    suggestions.push(suggestion);
                }
                update(suggestions);
            });
    },
    onSelect: function (item) {
        input.value = item.label;
    }
});

let getJSON = function (url, callback) {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.responseType = 'json';
    xhr.onload = function () {
        let status = xhr.status;
        if (status === 200) {
            callback(null, xhr.response);
        } else {
            callback(status, xhr.response);
        }
    };
    xhr.send();
};