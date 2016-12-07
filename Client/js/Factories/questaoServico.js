app.factory('questaoServico', function ($http, api) {

    function getAll() {
        return $http({
            method: 'GET',
            url: api('questoes')
        });
    }

    function getById(id) {
        return $http({
            method: 'GET',
            url: api('questoes/' + id)
        });
    }

    return {
        getAll: getAll,
        getById: getById
    }
    
});