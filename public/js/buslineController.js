app.controller(
    'BuslineController',
    function ($scope, $http, $timeout, Province, Busline, Report, Filter, BusStop, $location) {

        var mapOptions = {
            zoom: 16,
            center: new google.maps.LatLng(21.0031415, 105.834901)
        };

        /**
         *  set visiable marker on map
         * @param map
         * @param markers
         */
        function setMapOnAll(map, markers) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }

        /**
         *  hidden marker on map
         * @param markers
         */
        function clearMarkers(markers) {
            setMapOnAll(null, markers);
        }

        /**
         *  delete markers on map
         * @param markers
         */
        function deleteMarkers(markers) {
            clearMarkers(markers);
            markers = [];
        }

        /**
         *  clear pathLine
         * @param pathLine
         */
        function clearPath(pathLine) {
            pathLine.setMap(null);
            pathLine = null;
        }

        /**
         *  clear map
         */
        function clearMap() {
            if(!$scope.pathLine)return;
            deleteMarkers($scope.markers);
            clearPath($scope.pathLine);
        }

        /**
         *  init goole map v3
         */
        function initMap() {
            $scope.map = new google.maps.Map(document.getElementById('map'), mapOptions);
            $scope.markers = [];
            $scope.path = [];
            $scope.pathLine = null;
        }

        /**
         *  get busline info
         */
        function showBusline() {
            Busline.show($('.busline').val(), $('.route').val()).then(function (response) {
                $scope.busline = response;
                busLinePreview($scope.busline.throughStops)
            });
        }

        /**
         *  get reports
         */
        function showReports() {
            $scope.reports = [];
            var list = JSON.parse($('.reports').val());
            for (var i = 0; i < list.length; i++) {
                Report.show(list[i]).then(function (response) {
                    $scope.reports.push(response);
                });
            }
        }

        /**
         * Show busline on map
         * @param data
         */
        function busLinePreview(data) {
            console.log(data);
            clearMap();
            for (var i = 0; i < data.length; i++) {
                var latLng = data[i].location.split("|");
                var marker = new google.maps.Marker({
                    position: {
                        lat: parseFloat(latLng[1]),
                        lng: parseFloat(latLng[0])
                    },
                    title: data[i].code + ' | ' + data[i].address_name,
                    map: $scope.map,
                    clickable: true,
                    info: new google.maps.InfoWindow({
                        content: data[i].address_name
                    }),
                    icon: data[i].code == $('.target').val() ? '/images/bus-del.png' : '/images/bus.png'
                });

                // marker.info.open($scope.map, marker);

                $scope.markers.push(marker);
                if(data[i].code != $('.target').val()){
                    $scope.path.push(marker.position);
                }

            }

            $scope.pathLine = new google.maps.Polyline({
                path: $scope.path,
                strokeColor: '#3E7CF7',
                strokeOpacity: 0.8,
                strokeWeight: 10,
                map: $scope.map
            });
        }

        $scope.addMarker = function (station) {
            console.log(station);
            var latLng = station.new_location.split("|");
            var marker = new google.maps.Marker({
                position: {
                    lat: parseFloat(latLng[0]),
                    lng: parseFloat(latLng[1])
                },
                title: station.code + ' | ' + station.new_address_name,
                map: $scope.map,
                clickable: true,
                info: new google.maps.InfoWindow({
                    content: station.new_address_name
                }),
                icon:'/images/bus-del.png'
            });
            $scope.markers.push(marker);
            $scope.map.setCenter({
                lat: parseFloat(latLng[0]),
                lng: parseFloat(latLng[1])
            });
        };

        $scope.addOne = function (report) {
            var data = {
                action: 'add',
                reports: $('.reports').val(),
                target: report.id,
                route: $('.route').val()
            };
            Busline.update($scope.busline.busLine.code, JSON.stringify(data)).then(function () {
                alert('Thêm mới busStop thành công!');
                $location.path('/');
            });
        };

        $scope.addAverage = function () {
            var data = {
                action: 'add',
                reports: $('.reports').val(),
                target: 'all',
                route: $('.route').val(),
                new_address_name: $scope.new_address_name
            };
            Busline.update($scope.busline.busLine.code, JSON.stringify(data)).then(function () {
                alert('Thêm mới busStop thành công bằng tính trung bình!');
                $location.path('/');
            });
        };
        /**
         * focus location on map
         * @param busStopCode
         */
        $scope.focus = function (busStopCode) {
            BusStop.show(busStopCode).then(function (response) {
                var latLng = response.location.split("|");
                $scope.map.setCenter({
                    lat: parseFloat(latLng[1]),
                    lng: parseFloat(latLng[0])
                });
            });
        };
        /**
         * delete
         */
        $scope.delete = function () {
            Busline.update($scope.busline.busLine.code,{
                action: 'delete',
                reports: $('.reports').val(),
                target: $('.target').val(),
                route: $('.route').val()
            }).then(function () {
                alert("Xóa thành công điểm bus");
                $location.path('/');
            });
        };
        /**
         * init data
         */
        $scope.init = function () {
            initMap();
            showBusline();
            showReports();
        };
        /*Run*/
        $scope.init();
    });
