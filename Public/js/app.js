/**
 * Created by xzjs on 15/12/24.
 */
var wifiapp = angular.module('wifi', []);

//查询线路下公交车的服务
wifiapp.factory('Buses', function ($http, $q) {
    return {
        query: function (line_id) {
            var config = {
                params: {
                    'line_id': line_id
                }
            };
            var defered = $q.defer();
            $http.get("{:U('Line/get_buses')}", config).then(
                function successCallback(response) {
                    defered.resolve(response.data);
                },
                function errCallback(response) {
                    defered.reject(response);
                }
            );
            return defered.promise;
        }
    }
});

//查询所有线路的服务
wifiapp.factory('Lines',function($http,$q){
    return {
        query: function () {
            var config = {
            };
            var defered = $q.defer();
            $http.get("{:U('Line/select')}", config).then(
                function successCallback(response) {
                    defered.resolve(response.data);
                },
                function errCallback(response) {
                    defered.reject(response);
                }
            );
            return defered.promise;
        }
    }
});