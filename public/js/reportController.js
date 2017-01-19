var app = angular.module('EasyBus', []);
app.baseURL = $('base').attr('href');

app.factory('Province', function($http, $q) {
	return {
		get: function() {
			var deferred = $q.defer();
			var promise = $http.get(app.baseURL + '/api/province').then(function(response) {
				deferred.resolve(response.data);
			});
			return deferred.promise;
		}
	};
});

app.factory('Busline', function($http, $q) {
	return {
		get: function(provinceID) {
			var deferred = $q.defer();
			var promise = $http.get(app.baseURL + '/api/busline?provinceID=' + provinceID).then(function(response) {
				deferred.resolve(response.data);
			});
			return deferred.promise;
		}
	};
});

app.factory('Report', function($http, $q) {
	return {
		getUrl: function(URL) {
			var deferred = $q.defer();
			var promise = $http.get(URL).then(function(response) {
				deferred.resolve(response.data);
			});
			return deferred.promise;
		}
	};
});

app.controller('ReportController', function($scope, $http, $timeout, Province, Busline, Report){

	$scope.static = {
		provinces: [],
		buslines: []
	};

	/**
	 * init view
	 * @return void
	 */
	$scope.init = function(){

		Province.get().then(function(response) {
			$scope.static.provinces = response;
		});

		Report.getUrl(app.baseURL + '/api/report').then(function(response) {
			$scope.reports = response;
		});
	};
	/**
	 * Next page
	 * @return {Function} [description]
	 */
	$scope.next = function() {
		if($scope.reports.next_page_url){
			Report.getUrl($scope.reports.next_page_url).then(function(response) {
				$scope.reports = response;
			});
		}
	};
	/**
	 * Prev page
	 * @return {[type]} [description]
	 */
	$scope.prev = function() {
		if($scope.reports.prev_page_url){
			Report.getUrl($scope.reports.prev_page_url).then(function(response) {
				$scope.reports = response;
			});
		}
	};
	// init run
	$scope.init();
});

// app.controller('ReportController', function($scope, $http, report) {
// 	var mapOptions = {
// 		zoom: 16,
// 		center: new google.maps.LatLng(21.0031415, 105.834901)
// 	};
// 	$scope.map = new google.maps.Map(document.getElementById('map'), mapOptions);
// 	$scope.markers = [];
// 	$scope.path = [];
// 	$scope.pathLine = null;
// 	$scope.currentMarkers = [];
// 	$scope.currentPath = [];
// 	$scope.currentPathLine = null;
// 	$scope.toggle = true;
// 	$scope.toggleDetail = false;
// 	$scope.targetReport = null;

// 	function setMapOnAll(map, markers) {
// 		for (var i = 0; i < markers.length; i++) {
// 			markers[i].setMap(map);
// 		}
// 	}

// 	function clearMarkers(markers) {
// 		setMapOnAll(null, markers);
// 	}

// 	function deleteMarkers(markers) {
// 		clearMarkers(markers);
// 		markers = [];
// 	}

// 	function clearPath(pathLine) {
// 		pathLine.setMap(null);
// 		pathLine = null;
// 	}
// 	$scope.reports = report.getReports().then(function(data) {
// 		$scope.reports = data;
// 	});
// 	$scope.actions = null;
// 	$scope.goBack = function() {
// 		$scope.toggle = true;
// 		$scope.toggleDetail = false;
// 	};
// 	$scope.busLinePreview = function(data) {
// 		deleteMarkers($scope.currentMarkers);
// 		$scope.currentPath = [];
// 		if ($scope.currentPathLine !== null) $scope.currentPathLine.setMap(null);
// 		for (var i = 0; i < data.length; i++) {
// 			var latLng = data[i].location.split("|");
// 			var marker = new google.maps.Marker({
// 				position: {
// 					lat: parseFloat(latLng[1]),
// 					lng: parseFloat(latLng[0])
// 				},
// 				title: data[i].address_name,
// 				map: $scope.map
// 			});
// 			$scope.currentMarkers.push(marker);
// 			$scope.currentPath.push(marker.position);
// 		}
// 		$scope.currentPathLine = new google.maps.Polyline({
// 			path: $scope.currentPath,
// 			strokeColor: '#3E7CF7',
// 			strokeOpacity: 0.8,
// 			strokeWeight: 10,
// 			map: $scope.map
// 		});
// 	};
// 	$scope.previewReport = function(report) {
// 		$scope.targetReport = report;
// 		$scope.busLinePreview(report.busline.routeList);
// 		$scope.toggle = false;
// 		deleteMarkers($scope.markers);
// 		$scope.path = [];
// 		if ($scope.pathLine !== null) $scope.pathLine.setMap(null);
// 		$scope.actions = report.stringdata.list_bus_stop;
// 		for (var i = 0; i < report.stringdata.list_bus_stop.length; i++) {
// 			var latLng = report.stringdata.list_bus_stop[i].new_location.split("|");
// 			var label = 'N';
// 			switch (report.stringdata.list_bus_stop[i].report_type) {
// 				case "add":
// 					label = '+';
// 					break;
// 				case "delete":
// 					label = '-';
// 					break;
// 				case "modify":
// 					label = 'M';
// 					break;
// 			}
// 			var marker = new google.maps.Marker({
// 				label: label,
// 				position: {
// 					lat: parseFloat(latLng[0]),
// 					lng: parseFloat(latLng[1])
// 				},
// 				title: report.stringdata.list_bus_stop[i].new_address_name,
// 				map: $scope.map
// 			});
// 			$scope.markers.push(marker);
// 			if (label != "-") $scope.path.push(marker.position);

// 		}
// 		$scope.pathLine = new google.maps.Polyline({
// 			path: $scope.path,
// 			strokeColor: '#FF0000',
// 			strokeOpacity: 1.0,
// 			strokeWeight: 2,
// 			map: $scope.map
// 		});
// 		$scope.map.setCenter($scope.path[0]);
// 	};
// 	$scope.detail = function(e){
// 		$scope.toggleDetail = true;
// 		$scope.targetDetail = e;
// 		var latLng = e.new_location.split("|");
// 		var center = new google.maps.LatLng(parseFloat(latLng[0]), parseFloat(latLng[1]));
// 		$scope.map.setCenter(center);
// 	};

// 	function clearMap() {
// 		clearMarkers($scope.markers);
// 		clearMarkers($scope.currentMarkers);
// 		clearPath($scope.pathLine);
// 		clearPath($scope.currentPathLine);
// 		$scope.goBack();
// 	}
// 	$scope.deleteBusStop = function(e) {
// 		report.deleteBusStop(e, $scope.targetReport.stringdata).then(function(data) {
// 			$scope.reports = report.getReports().then(function(data) {
// 				$scope.reports = data;
// 				clearMap();
// 			});
// 		});
// 	};

// 	$scope.storeBusStop = function(e) {
// 		console.log(e);
// 		report.addBusStop(e, $scope.targetReport.stringdata).then(function(data) {
// 			$scope.reports = report.getReports().then(function(data) {
// 				$scope.reports = data;
// 				clearMap();
// 			});
// 		});
// 	};
// });