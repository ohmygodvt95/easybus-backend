app.factory('Province', function ($http, $q) {
    return {
        get: function () {
            var deferred = $q.defer();
            var promise = $http.get(app.baseURL + '/api/province').then(function (response) {
                deferred.resolve(response.data);
            });
            return deferred.promise;
        }
    };
});