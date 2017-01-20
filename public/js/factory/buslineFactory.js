app.factory('Busline', function ($http, $q) {
    return {
        get: function (provinceID) {
            var deferred = $q.defer();
            var promise = $http.get(app.baseURL + '/api/busline?provinceID=' + provinceID).then(function (response) {
                deferred.resolve(response.data);
            });
            return deferred.promise;
        },
        show: function (buslineId, route) {
            var deferred = $q.defer();
            var promise = $http.get(app.baseURL + '/api/busline/' + buslineId + '?route=' + route).then(function (response) {
                deferred.resolve(response.data);
            });
            return deferred.promise;
        },
        update: function (buslineId, data) {
            var deferred = $q.defer();
            var promise = $http.put(app.baseURL + '/api/busline/' + buslineId, data).then(function (response) {
                deferred.resolve(response.data);
            });
            return deferred.promise;
        }
    };
});