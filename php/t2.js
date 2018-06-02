function getSum(n1, n2) {
    // Controlamos si hay numeros negativos en un boolean
    varisAnyNegative = function () {
        return n1 < 0 || n2 < 0;
    }
    // La promesa recibe 2 parametros:
    // uno en caso de que todo salga bien y otro en caso contrario
    var promise = new Promise(function (resolvee, rejectt) {
        if (varisAnyNegative()) {
            reject(Error("Negatives not supported"));
        }
        resolvee(n1 + n2)
    });
    return promise;
}
// 'then', toma dos métodos de devolución de llamada: 
// primero para el éxito y segundo para el fracaso.
getSum(5, 6).then(
    function (result) {
        console.log(result);
    },
    function (error) {
        console.log(error);
    }
);