// Initialize and add the map
function initMap()
{
    if ($('#map').length === 0) return;

    let lat = $('#lat').val();
    let lon = $('#lon').val();

    const coor = { lat: parseFloat(lat), lng: parseFloat(lon) };
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: coor,
    });

    const marker = new google.maps.Marker({
        position: coor,
        map: map,
        draggable: true,
    });

    google.maps.event.addListener(marker, 'dragend', function (evt) {
        $('#new_lat').val(evt.latLng.lat().toFixed(6));
        $('#new_lon').val(evt.latLng.lng().toFixed(6));
    });

}

function saveCoordinate()
{
    $('#lat').val($('#new_lat').val());
    $('#lon').val($('#new_lon').val());
}

window.initMap = initMap;
