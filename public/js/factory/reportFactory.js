app.factory('Report', function ($http, $q) {
    return {
        getUrl: function (URL) {
            var deferred = $q.defer();
            var promise = $http.get(URL).then(function (response) {
                deferred.resolve(response.data);
            });
            return deferred.promise;
        },
        show: function (reportId) {
            var deferred = $q.defer();
            var promise = $http.get('/api/report/' + reportId).then(function (response) {
                deferred.resolve(response.data);
            });
            return deferred.promise;
        }
    };
});