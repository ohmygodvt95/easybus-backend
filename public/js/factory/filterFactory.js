app.factory('Filter', function ($http, $q) {
    return {
        get: function (report) {
            var deferred = $q.defer();
            var promise = $http.get(app.baseURL + '/api/filter/' + report.id).then(function (response) {
                deferred.resolve(response.data);
            });
            return deferred.promise;
        }
    };
});