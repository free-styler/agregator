ymaps.ready(init);

function init () {
    var myMap = new ymaps.Map('map', {
            center: [53.505234, 49.396548],
            zoom: 12
        }, {
            searchControlProvider: 'yandex#search'
        })
        // Создаем собственный макет с информацией о выбранном геообъекте.
    var customItemContentLayout = ymaps.templateLayoutFactory.createClass(
        // Флаг "raw" означает, что данные вставляют "как есть" без экранирования html.
        '<h2 class=ballon_header>{{ properties.balloonContentHeader|raw }}</h2>' +
        '<div class=ballon_body>{{ properties.balloonContentBody|raw }}</div>' +
        '<div class=ballon_footer>{{ properties.balloonContentFooter|raw }}</div>'
    );

        objectManager = new ymaps.ObjectManager({
            // Чтобы метки начали кластеризоваться, выставляем опцию.
            clusterize: true,
            // ObjectManager принимает те же опции, что и кластеризатор.
            gridSize: 32,
            clusterDisableClickZoom: true,
            clusterBalloonContentLayout: 'cluster#balloonAccordion',
            // Устанавливаем собственный макет.
            clusterBalloonItemContentLayout: customItemContentLayout,

            clusterBalloonWidth: 300,
            clusterBalloonHeight: 200
        });

    // Чтобы задать опции одиночным объектам и кластерам,
    // обратимся к дочерним коллекциям ObjectManager.
    objectManager.objects.options.set('preset', 'islands#greenDotIcon');
    objectManager.clusters.options.set('preset', 'islands#greenClusterIcons');
    myMap.geoObjects.add(objectManager);

    $.ajax({
        url: "/organizations/json"
    }).done(function(data) {
        objectManager.add(data);
    });

}

$(document).ready(function(){
    $('.nextpage').click(function(){
        $.post($(this).attr('href'),{},function(data){
            $('.orgsList ul').append(data);
        });
        return false;
    });

    $('.with-mobile').on('change',function () {
        if ($(this).is(':checked')) $.post('/with-mobile',{},function (data) {
            $('.orgsList ul').html(data);
        })
        else $.post('/without-mobile',{},function (data) {
            $('.orgsList ul').html(data);
        })
    })
})
