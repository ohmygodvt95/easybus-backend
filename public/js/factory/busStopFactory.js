app.factory('BusStop', function ($http, $q) {
    return {
        show: function (id) {
            var deferred = $q.defer();
            var promise = $http.get(app.baseURL + '/api/busstop/' + id).then(function (response) {
                deferred.resolve(response.data);
            });
            return deferred.promise;
        }
    };
});